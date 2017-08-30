
getcentre.service('currSearch', function(){
    var curr_Search =  {service:'Flights', url:'server/flight_autocomplete.php', dep:'', des:''}
    return{
         getSearch:function() {
           return curr_Search;
         },
         setSearch:function(ns,nu) {
            curr_Search.service =  ns;
            curr_Search.url= nu;

         },
         setDep:function(dep){curr_Search.dep=dep},
         setDes:function(des){curr_Search.des=des}
    }
})
getcentre.service('searchDatas', function(){
    var savedData = {}
    return{
        data:function() {
            return savedData;
        }
    }
})

getcentre.service('searchObject', function(){
    var search =  {
		  Flights:{
			name:'Flights',
			typeBreak:[
				{
					name:'One Way',
					value:'OW',
					ref:'oneWay'
				},
				{
					name:'Return Ticket',
					value:'NF',
					ref:'retTic'
				},
				{
					name:'Multiple Destinations',
					value:'MF',
					ref:'mulTi'
				}
			],
			types:{
			  	oneWay:{
					0:{name:'From', value:{name:''}, type:'place'},
					1:{name:'To', value:{name:''}, type:'place'},
					2:{name:'Depture Date', value:{}, type:'date', subType:'fromdate'},
                    3:{name:'guests', type:'occupancy', subtypes:
                                                    [
                                                        {name:'Adult', value:1},
                                                        {name:'Child', value:0, ages:[]}
                                                    ]
                    }
				},
				retTic:{
					0:{name:'From', value:{name:''}, type:'place'},
					1:{name:'To', value:{name:''}, type:'place'},
                    '1a':'',
                    3:{name:'guests', type:'occupancy', subtypes:
                                                    [
                                                        {name:'Adult', value:1},
                                                        {name:'Child', value:0, ages:[]}
                                                    ]
                    },
					4:{name:'Depture Date', value:{}, type:'date', subType:'fromdate'},
					5:{name:'Return Date', value:{fTravelDays:7}, type:'date', subType:'todate'}

				},
				mulTi:{
					multCities:[
						[
							{name:'From', value:{name:''}, type:'place'},
							{name:'To', value:{name:''}, type:'place'},
							{name:'Depture Date', type:'date', subType:'fromdate', value:{}}
						]
					],
                    q1:{name:'guests', value:1, type:'occupancy', subtypes:
                                                    [
                                                        {name:'Adult', value:1},
                                                        {name:'Child', value:0, ages:[]}
                                                    ]
                    }
				}
			},
			others:[
				{
					name:'Ticket Class',
					value:'all',
					type:'select',
					options:[
						{name:'All Classes', value:'all'},
						{name:'First Class Premium',value:'P'},
						{name:'First',value:'F'},
						{name:'Business',value:'C'},
						{name:'Economy Premium',value:'S'},
						{name:'Economy',value:'Y'}
					]
				}
			],
			current:'retTic'
		  },
		  Hotels:{
			  name:'Hotels',
			  types:{
				  	regular:{
						0:{name:'Destination', value:{name:''}, type:'place'},
                        1:{name:'CheckIn Date', type:'date', subType:'fromdate', value:{}},
                        2:{name:'CheckOut Date', type:'date', subType:'todate', value:{}},
                        3:{name:'Room', type:'room', value:1},
                        occupancy:[
                            [
                                {name:'Adult', value:1, type:'guest'},
                                {name:'Child', value:0, type:'guest',ages:[]}
                            ]
                        ]
					}
				},
				guestBreak:[{Adult:{},Child:{}}]
		  },
		  Tours:{
			  name:'Tours',
			  types:{
				  regular:{
					  to:{}, depDate:{}, retDate:{}
				  }
			  },
			  guestBreak:[{Adult:{},Child:{}}]
		  },
		  Transfers:{},
          Insurance:{
            types:{
                regular:{

                    4:{name:'Date from', value:{}},
                    5:{name:'Date to', value:{}},
                    days:{
                        3:{
                            rate1:{
                                range:3000,
                                range2:4500,
                                range3:6000
                            },
                            rate2:{
                                range:4200,
                                range2:6300,
                                range3:8400
                            }
                        },
                        6:{
                            rate1:{
                                range:3900,
                                range2:5850,
                                range3:7800
                            },
                            rate2:{
                                range:4940,
                                range2:7410,
                                range3:9880
                            }
                        },
                        15:{
                            rate1:{
                                range:5850,
                                range2:8775,
                                range3:11700
                            },
                            rate2:{
                                range:7410,
                                range2:11115,
                                range3:14820
                            }
                        },
                        31:{
                            rate1:{
                                range:9100,
                                range2:13650,
                                range3:18200
                            },
                            rate2:{
                                range:11440,
                                range2:17160,
                                range3:22880
                            }
                        },
                        61:{
                            rate1:{
                                range:16200,
                                range2:24300,
                                range3:32400
                            },
                            rate2:{
                                range:20280,
                                range2:20280,
                                range3:40560
                            }
                        },
                        92:{
                            rate1:{
                                range:23000,
                                range2:34500,
                                range3:46000
                            },
                            rate2:{
                                range:33840,
                                range2:50760,
                                range3:67680
                            }
                        },
                        180:{
                            rate1:{
                                range:25200,
                                range2:37800,
                                range3:50400
                            },
                            rate2:{
                                range:44280,
                                range2:66420,
                                range3:88560
                            }
                        },
                        annual:{
                            rate1:{
                                range:30800,
                                range2:46200,
                                range3:61600
                            },
                            rate2:{
                                range:60000,
                                range2:90000,
                                range3:120000
                            }
                        }
                    }
                }
            }

          }
	  }
    return{
         data:function() {
           return search;
         }
    }
})

//currenncy service
getcentre.service('currencyData', function(){
    var currencyData =
    [
        {baseCurrency:
            {currTo:'NGN', currFrom:'', symbol:'&#8358;'}
        }
        ,
        {currencyList:
            [{curr:'NGN', rate:1, symbol:'&#8358;'},
             {curr:'USD', rate:'', symbol:'$'},
             {curr:'GBP', rate:'', symbol:'&pound;'},
             {curr:'EUR', rate:'', symbol:'&euro;'}
            ]
        }

    ]
    return{
         data:function() {
           return currencyData;
         },
         settransfer:function(data) {
            currencyData[0]=data;
         },
         settraveler:function(data, index){
            currencyData[1]=data;
         }
    }
})

//flight
getcentre.service('travelPackD',function(){
    var savedData=[]
    return{
         data:function() {
           return savedData;
         },
         setData:function(data) {
            savedData.push(data);
         },
         deleteData:function(){
            savedData=[];
        },
        saveData:function(data){
            savedData=data;
        }
    }
})
getcentre.service('userData', function(){
    var userData =  [{status:'Register'}, {}]
    return{
         data:function() {
           return userData;
         },
         setData:function(data) {
            userData.splice(1, 1, data);
         },
         saveData:function(data) {
            userData=data;
         },
         addData:function(data, index){
            userData[index].push(data);
         }
    }
})
getcentre.service('sendmailRS', ['$http','$q',  function($http, $q){
  return {
      sendmail:
          function(userE, leadGuest, searchD){
              return $q(
                  function(resolve, reject) {
                      hdata={userE:userE, leadGuest:leadGuest, searchD:searchD};
                      $http({method:'Post', url:'server/booking_email.php', data:hdata})
                      .success(
                          function(responseData, status, headers, config) {
                              resolve(responseData[0]);
                          },
                          function(err) {
                              reject('Can\'t send mail');
                          }
                      );
                  }
              )
          }
      }
}]);
getcentre.service('hotelData', function(){
    var hotelData =  []
    return{
         data:function() {
           return hotelData;
         },
         setData:function(data) {
             while(hotelData.length > 0) {
                hotelData.pop();
            }
            hotelData.push(data);
         },
         addData:function(data){
            hotelData.push(data);
         }
    }
})
getcentre.service('purchaseData', function(){
    var purchaseData =  []
    return{
         data:function() {
           return purchaseData;
         },
         setData:function(data) {
            purchaseData.push(data);
         }
    }
})
getcentre.service('hotelData', function(){
    var hotelData =  []
    return{
         data:function() {
           return hotelData;
         },
         setData:function(data) {
             while(hotelData.length > 0) {
                hotelData.pop();
            }
            hotelData.push(data);
         },
         addData:function(data){
            hotelData.push(data);
         }
    }
})
getcentre.service('tourData', function(){
    var tourData =  []
    return{
         data:function() {
         return tourData;
         },
         setData:function(data) {
            tourData.push(data);
         },
         addData:function(data, index){
            tourData[index].push(data);
         }
    }
})
getcentre.factory('serviceAddRs', ['$resource',
function($resource){
  return $resource('server/serviceAdd_httpRQ.php', {}, {
    query: {method:'POST',
              params:{
              },
              isArray:true
          }
  });
}]);
