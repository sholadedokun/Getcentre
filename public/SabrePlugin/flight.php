<?php
    ob_start('ob_gzhandler');
    error_reporting(E_ERROR);
    require_once 'rwdGate.php';     
    define(AFFILIATE_ID, '6884d31fbc8d2b');
    define(FLIGHT_WIDGET, 100974864);
    $rwdgate = new rwdGate(AFFILIATE_ID);
    $widgets =  array(FLIGHT_WIDGET, SLIDING_WIDGET); 
    $rwdgate->fetch($widgets);
    if ($rwdgate->isRawResult()){
        $rwdgate->printRawResult(); 
        die();
    }
?>
<!DOCTYPE HTML>
<html>
<?php echo $rwdgate->getSection('HEAD'); ?>
<?php $list = $rwdgate->getSectionsList(); ?>
<head>
    
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="Traveler - Premium template for travel companies">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mystyles.css">
    <script src="js/modernizr.js"></script>


</head>

<body>
    <div class="global-wrap">
        <!-- TOP AREA -->
        <div class="top-area show-onload">
            <div class="bg-holder full">
                <div class="bg-front bg-front-mob-rel">
                    <div class="container">
                        <div class="search-tabs search-tabs-bg search-tabs-abs mt50">
                            <div class="tabbable">                                
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-2">
                                             <?php
                    if (in_array(FLIGHT_WIDGET, $list ))     {         
                        echo $rwdgate->getSection(FLIGHT_WIDGET);     
                    }  
                ?>
                <?php echo $rwdgate->getSection('BODY'); ?>
                <?php echo $rwdgate->getSection('FOOTER'); ?>                                       
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-img hidden-lg" style="background-image:url(img/2048x1365.png);"></div>
                <div class="bg-mask hidden-lg"></div>
            </div>
        </div>
        <!-- END TOP AREA  -->

        <div class="gap"></div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/slimmenu.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-timepicker.js"></script>
        <script src="js/nicescroll.js"></script>
        <script src="js/dropit.js"></script>
        <script src="js/ionrangeslider.js"></script>
        <script src="js/icheck.js"></script>
        <script src="js/fotorama.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script src="js/typeahead.js"></script>
        <script src="js/card-payment.js"></script>
        <script src="js/magnific.js"></script>
        <script src="js/owl-carousel.js"></script>
        <script src="js/fitvids.js"></script>
        <script src="js/tweet.js"></script>
        <script src="js/countdown.js"></script>
        <script src="js/gridrotator.js"></script>
        <script src="js/custom.js"></script>
    </div>
</body>

</html>


