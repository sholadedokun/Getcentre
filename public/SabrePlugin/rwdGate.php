<?php

/**
 * Created by PhpStorm.
 * User: zbyszekb
 * Date: 2015-06-16
 * Time: 12:43
 * Updated: 2015-08-10 by danielf
 * Updated: 2015-08-17 by danielf Fixed step recognition. Fixed curl exception check.
 * Updated: 2015-08-28 by danielf Cookies support added.
 * Updated: 2015-10-05 by danielf Sections parse regular expression removed and explode used instead. Fixed full gate (removed widgets sending together with full parts)
 * Updated: 2015-10-06 by danielf fixed json_encode assoc param. Its now properly set to TRUE.
 * Updated: 2015-10-09 by danielf header with prefix added.
 * Updated: 2015-10-22 by danielf fixed syntax in section matching.
 * Updated: 2015-10-27 by danielf removed warning while setting cookies.
 * Updated: 2016-03-03 by piotrst redirect on 302 response code.
 * Updated: 2016-04-29 by zbyszekb cleaning output buffer
 * Updated: 2016-06-01 by zbyszekb fix gate schema for correct redirect url on some cURL versions / server configs.
 */

class rwdGate
{
  /**
   * @var string
   */
  private $domainName = 'vcms.eu';

  /**
   * @var string affiliateId
   */
  private $affiliateId = null;

  /**
   * @var resource
   */
  private $curlHandle = null;

  /**
   * @var array
   */
  private $sections = array();

  /**
   * @var string
   */
  private $gatePrefix = '';

  /**
   * @var bool
   */
  private $isRawResult = false;

  /**
   * @var string
   */
  private $result = '';

  /**
   * @var array
   */
  public $resultHeaders = array();

  /**
   * @var array
   */
  public $cookies= array();

  /**
   * Initialize RWD Gate library.
   *
   * @param string $domainName RWD Domain.
   * @param string $gatePrefix Prefix of non-existing directory for mod_rewrite Url processing.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($_affiliateId, $gatePrefix = 'RWD')
  {
    if (empty($_affiliateId))
    {
      throw new InvalidArgumentException('$_affiliateId is empty!');
    }
    if (empty($gatePrefix))
    {
      throw new InvalidArgumentException('$gatePrefix is empty!');
    }
    $this->affiliateId = $_affiliateId;
    $this->gatePrefix = $gatePrefix;
  }

  public function __destruct()
  {
    if ($this->curlHandle)
    {
      curl_close($this->curlHandle);
    }
  }

  private function curlInit()
  {
    if (!$this->curlHandle)
    {
      $this->curlHandle = curl_init();
    }
  }

  /**
   * @throws ErrorException
   */
  public function fetch($_widgets = array())
  {
    $this->curlInit();
    $this->result        = '';
    $this->resultHeaders = array();

    $url = explode('/' . $this->gatePrefix . '/', $_SERVER['REQUEST_URI']);

    if (isset($url[1])){
      $rwdUrl = 'http://' . $this->domainName . '/' . $url[1];
    }
    else
    {
      if(empty($_widgets)){
        $rwdUrl = 'http://' . $this->domainName . '/?' . http_build_query($_GET);
      }
      else{
        $rwdUrl = 'http://' . $this->domainName . '/gate/recParts/'.implode(',', $_widgets).'/';
      }
    }

    $gateScheme = '';
    if (isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME']))
    {
      $gateScheme = $_SERVER['REQUEST_SCHEME'] . ':';
    }
    $gateUrl = $gateScheme . '//' . $_SERVER['HTTP_HOST'] . rtrim($url[0], '/') . '/' . $this->gatePrefix . '/';

    $headers = array('Gate-URL: ' . $gateUrl, 'Gate-AffiliateId: '.$this->affiliateId, 'Gate-Prefix: '.$this->gatePrefix);


    $curOptions = array(
      CURLOPT_URL => $rwdUrl,
      CURLOPT_HTTPHEADER     => $headers,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_ENCODING       => 'gzip',
      CURLOPT_HEADERFUNCTION => array($this, 'curlHeaderReader')
    );


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      $curOptions[CURLOPT_POSTFIELDS] = http_build_query($_POST);
    }

    if ($cookie = $this->buildCookie()){
      $curOptions[CURLOPT_COOKIE] = $cookie;
    }

    curl_setopt_array($this->curlHandle, $curOptions);

    $res = curl_exec($this->curlHandle);

    if (curl_errno($this->curlHandle)) {
      throw new ErrorException(curl_error($this->curlHandle));
    }

    if (curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE) == 302)
    {
      //usunięcie podwójnego adresu gate'a w przekierowaniach
      $trimmedUrl = trim($gateUrl,'/');
      $url = curl_getinfo($this->curlHandle, CURLINFO_REDIRECT_URL);
      if (empty($url))
      {
        // PHP < 5.3.7 - nie ma stałej CURLINFO_REDIRECT_URL.
        $url = trim($this->resultHeaders['Location']);
      }
      if (strstr($url, $trimmedUrl))
      {
        $urlParts = explode($trimmedUrl, $url);
        $url = array_shift($urlParts) . $trimmedUrl . array_pop($urlParts);
      }
      header('location:' . $url);
      die();
    }

    if (isset($url[1]) || empty($_widgets))
    {
      $this->result = $res;
      $this->parseResult();
    }
    else
    {
      if($this->isRawResult()){
        $this->printRawResult($res);
      }

      $this->sections = json_decode($res, true);
    }
  }

  /**
   * @param $name
   *
   * @return bool|string
   */
  public function getSection($name)
  {
    if (!isset($this->sections[$name]))
    {
      return false;
    }

    return $this->sections[$name];
  }

  /**
   * Get available sections list from result.
   *
   * @return array
   */
  public function getSectionsList()
  {
    return array_keys($this->sections);
  }

  /**
   * @return bool
   */
  public function isRawResult()
  {
    $rawHeaders = array('text/css', 'application/javascript; charset=UTF-8', 'application/javascript');
    if(in_array(trim($this->resultHeaders['Content-Type']), $rawHeaders))
    {
      return true;
    }

    //old fallback
    return $this->isRawResult;
  }


  /**
   * Print raw Image/Javascript/CSS/fonts data fetched in request.
   */
  public function printRawResult($_content = null)
  {
    if (ob_get_length())
    {
      // Jeśli jest aktywne buforowanie wyjścia, to kasujemy ewentualną zawartość - zapobiegnie wysłaniu UTF8 BOM doklejonygo do plików źródłowych w części przypadków.
      ob_clean();
    }
    $allowSourceHeaders = array(
        'Content-Type',
        'Last-Modified',
        'Cache-Control',
        'Pragma',
        'Expires'
    );
    foreach (array_intersect_key($this->resultHeaders, array_flip($allowSourceHeaders)) as $headerKey => $headerValue)
    {
      header($headerKey . ':' . $headerValue);
    }

    if($_content === null)
    {
      $_content = $this->result;
    }
    echo $_content;
  }

  /**
   * @param resource $curl
   * @param string   $headerLine
   *
   * @return int
   */
  private function curlHeaderReader($curl, $headerLine)
  {
    if (stripos($headerLine, ':') !== false)
    {
      list($headerKey, $headerValue) = explode(':', $headerLine, 2);

      if($headerKey == 'Set-Cookie')
      {
        $cookies = explode('; ', $headerValue);

        foreach($cookies as $cookie)
        {
          //this if is mainly for httponly cookie
          $cookie = explode('=', $cookie);
          if(count($cookie)  < 2)
          {
            continue;
          }

          list($cookieName, $cookieValue) = $cookie;
          setcookie(trim($cookieName), trim($cookieValue), 0);
          $this->cookies[trim($cookieName)] = trim($cookieValue);
        }
      }

      $this->resultHeaders[$headerKey] = $headerValue;
    }
    return strlen($headerLine);
  }

  /**
   * Remove all cookies - use carefully
   */
  public function noCookies()
  {
    foreach($_COOKIE as $name => $val)
    {
      setcookie($name, '', 1, '/');
      unset($_COOKIE[$name]);
    }
  }

  /**
   * Build cookie for curl
   */
  private function buildCookie()
  {
    if(empty($_COOKIE))
    {
      return false;
    }
    $cookies = array();
    foreach($_COOKIE as $name => $val)
    {
      $cookies[] = $name.'='.$val;
    }
    return implode('; ', $cookies);
  }

  /**
   * Parsing of result from RWD.
   */
  private function parseResult()
  {
    if (substr($this->result, 0, 3) === "\xEF\xBB\xBF")
    {
      // Remove utf8 BOM, if present.
      $this->result = substr($this->result, 3);
    }

    $this->sections = $this->parseSections($this->result);
    if (empty($this->sections))
    {
      $this->isRawResult = true;
      return;
    }

    $nestedSections = array();
    foreach ($this->sections as $section)
    {
      $nestedSections += $this->parseSections($section);
    }
    $this->sections += $nestedSections;
  }

  /**
   * @param string $content
   *
   * @return array
   */
  private function parseSections($content)
  {
    $sections = array();
    $content = explode('<!--[RWD_PART:', $content);

    array_shift($content);  //drop starting trash
    foreach($content as $section)
    {
      list($sectionName, $sectionBody) = explode(']-->', $section, 2);
      list($sectionBody, )  = explode('<!--[/RWD_PART:'.$sectionName.']-->', $sectionBody, 2);
      $sections[$sectionName] = $sectionBody;
    }

    return $sections;
  }

  public function setUrl($_url)
  {
    $this->domainName = $_url;
  }

  public function isIndex()
  {
    return in_array('STEP', $this->getSectionsList()) ? !(int)$this->getSection('STEP') : false;
  }
}