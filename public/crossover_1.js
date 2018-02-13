function Rearrange(elements) {
    function splitElement(element){

        //cut out exact number of values needed and convert each to Integer
        let unOrderedList=element.map(number=>parseInt(number))
        //let convert all values to binary, safe to use toString(2) since there is no negative value
        let binaryUnOrderedList= unOrderedList.map(num=>
            { //keeping the dec for future refencing
                return {bin:num.toString(2), dec:num}
            })

        //total of the 1's in the list
        let valuesOf1sInList=binaryUnOrderedList.map((value, index)=>
            {
                return {
                    total:(value.bin.match(/1/g)||[]).length,
                    dec:value.dec
                }
        }).sort((a, b)=>{ //sort the listOf1's by their total
         return a.total - b.total;
        })

        //let do bubbleSort on the value we are given
        return bubbleSort(valuesOf1sInList).map(item=>item.dec)

    }
    function bubbleSort(arr){
      var sorted = false
      while (!sorted){
        sorted = true;
        arr.forEach(function (element, index, array){
          if(array[index+1]){
              if (element.dec > array[index+1].dec && element.total >= array[index+1].total) {
                array[index] = array[index+1]
                array[index+1] = element
                sorted = false;
              }
          }

        });
      }
      return arr;
    }

  return splitElement(elements);//it must return an array of integers.
}
