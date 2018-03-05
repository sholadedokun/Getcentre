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





function Twins(a, b) {
    let totalElements=a.length;
    let results=[];
    a.map((item, index)=>{
        if (item.length==0 || b[index].length==0)
            results[index]='No' //if the elements in A and B are empty
        else if(item == b[index]) //if the elements in A and B are the same
            results[index]='No'
        else{
            //if there is a character that is not present in either;
            for(let i=0; i<item.length; i++){
                //test for Characters in A not present in B
                if(b[index].indexOf(item[i])<0){
                    results[index]='No';
                    return;
                }
                //test for Characters in B not present in A
                if(item.indexOf(b[index][i])<0){
                    results[index]='No';
                    return;
                }
            }
            swap=(arrayTemp, posA,posB)=>{
                console.log(posA, posB)
                let temp= arrayTemp[posA];
                arrayTemp[posA]=arrayTemp[posB];
                arrayTemp[posB]=temp;
                return arrayTemp.join("")
            }
            function recursiveSwapAndMatch(newInd){
                if(newInd<item.length){

                    for(let i=newInd; i<item.length; i++){
                        //swap A once @even
                        let nextEven=2*(i==0?1:i);
                    let firstSwap= swap(item.split(''), newInd, nextEven);
                    console.log(1,firstSwap, b[index])
                    if(firstSwap!=b[index]){
//                         console.log(1,firstSwap, b[index])
                        //swap A once @Odd
                        let secondSwap= swap(item.split(''), newInd+1, nextEven+1 );
                        console.log(2,secondSwap, b[index])
                        if( secondSwap !=b[index]){

                            //now let swap in both direction
                            let bothSwap = swap(firstSwap.split(''), newInd+1, nextEven+1);
                            console.log(3,bothSwap, b[index])
                            if(bothSwap!=b[index]){
                                if(i>=item.length)
                                return recursiveSwapAndMatch(newInd+2)
                                }
                            else{
                                results[index]='Yes';
                                return;
                            }
                        }
                        else{
                             results[index]='Yes';
                             return;
                            }
                    }
                    else{
                     results[index]='Yes';
                     return;
                    }
                 }

                }
                return results[index]='No'
            }
            recursiveSwapAndMatch(0);

        }

    })
    return results;

}
