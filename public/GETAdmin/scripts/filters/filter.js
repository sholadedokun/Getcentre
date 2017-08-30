angular.module('getcentreAdmin')
/*
    we use this filter in our dashboard view to seperate the todolist into different bucket

*/
.filter('taskStatus', function () {
    //all the 'tasks' that we are trying to filter and the 'status'/parameter we are trying to filtere them with
    return function( tasks, status) {

    //filtered todolist that we will be return to view;
    var filtered = [];
    angular.forEach(tasks, function(task) {
      if(status == task.status) {
        //if the todo's status is same as the the status we want we push/add it to our filtered list
        filtered.push(task);
      }
    });

    //we return the filtered list;
    return filtered;

  };
});
