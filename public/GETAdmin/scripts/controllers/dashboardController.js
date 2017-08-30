angular.module('getcentreAdmin')
    .controller('dashboardController', ['$scope', 'appActions', 'data', '$http', '$uibModal', function ($scope, appActions, data, $http, $uibModal) {
        $scope.statusInfo='Please wait...';
        $scope.username=data.username;
        //hides the fields for adding the new Todo by default
        $scope.revealNewTodoFields= false;

        //default object for a creating a new todo.
        $scope.newTodo={title:'', description:'', status:'notCompleted'};

        //modules that loads all the user's todo, the template calls this function first through the ng-init.
        $scope.getAllTodos=function(){
            /* makes an API get request to retrieve all the user's todo list with the user's session ID
            notice the 'data' object was resolved and injected before the route change */
            $scope.getTodos=appActions.apiRequest('todos/').get({sessionId:data.sessionId});

            //get the response for the API request from the promise
            $scope.getTodos.$promise.then(function(allTodos){

                //all the user's todos retrieved and saved
                $scope.userTodos=allTodos.data;
            },
            //if an error occured
            function(err){
                // cfpLoadingBar.complete()
                // if(err.status=='401'){
                //     $scope.info="Wrong Username or Password... Please try again";
                // }
            })
        }

        //when a todo is moved into a different bucket
        $scope.updateTodoStatus=function(bucketId, todoListId){

            /*
            using the todo's Id find the todo from all the Todos($scope.userTodos)
            and save it in todoList
            */
            var todoList=$scope.findTodo(todoListId, $scope.userTodos);

            //after finding the todoList we need to change the it's status
            $scope.changeTodoStatus(todoList, bucketId)
        }

        //function to find the todolist from all the todos
        $scope.findTodo=function(todoListId, todos){
            // loop through all the todos
            for(var i=0; i<todos.length; i++){
                //if the current todo's id is == to the todo id we are looking for
                if(todos[i]._id==todoListId){
                    //we exit the loop and send/return the current todo;
                    return todos[i];
                }
            }
        }

        /* function  to change status of the todo from 'completed' to 'notCompleted' or vice versa...
           notice I set the bucketId to the status of the todo's it contains i.e 'completed' or 'notCompleted'
        */
        $scope.changeTodoStatus=function(todoList, bucketStatus){

            //I made a deep copy to avoid updates made here to reflect automatically reflect on the DOM.
            $scope.todoToUpdate = angular.copy(todoList);

            //set the new status
            $scope.todoToUpdate.status=bucketStatus;

            //calls the function to handle the API request for updating the todo;
            $scope.addOrUpdateTodo($scope.todoToUpdate);

        }

        $scope.addOrUpdateTodo=function(todoDetails){

            /* so that Mongo will not make a replica copy of the data,
            the object must have an 'id' key. */
            if(todoDetails._id){
                //so we replace _id with id;
                todoDetails.id=todoDetails._id;

            }

            //make the API request to Add or update a todoList
            $scope.addOrUpdateRequest=appActions.apiRequest('todo?sessionId='+data.sessionId).update(todoDetails);

            //retrieve responses from the API request promise
            $scope.addOrUpdateRequest.$promise.then(function(result){
                $scope.addedOrUpdatedTodo=result.data;
            },
            function(err){
                // cfpLoadingBar.complete()
                // if(err.status=='401'){
                //     $scope.info="Wrong Username or Password... Please try again";
                // }
            })
        }

        // to activate inline Editing we receive the todo Object from double click event from the view;

        /* this function is also called when the save button is called... this is to allow disabling editing and
            saving at the same time;
        */
        $scope.makeContentEditable=function(todo){

            //get the clicked Element
            clickedElement=document.getElementById(todo._id);
            console.log(clickedElement)
            //retrieve all children element  from the clickedElement
            childNode=clickedElement.childNodes;

            //child 1 and 3 represent the title and description respectively
            //if the first child Element doesn't have the ContentEditable attribute
            if (!childNode[1].isContentEditable) {
                //then enable editing and add classes
                clickedElement.classList.add('editMode');

                childNode[1].contentEditable = 'true';
                childNode[1].classList.add('editableField');

                childNode[5].contentEditable = 'true';
                childNode[5].classList.add('editableField');

                /* set the editing mode to be true... this is used in monitoring
                 and revealing the save button */
                todo.editMode=true;
            }
            else {
                // Disable Editing and remove classes

                clickedElement.classList.remove('editMode');
                childNode[1].contentEditable = 'false';
                childNode[1].classList.remove('editableField');
                childNode[5].contentEditable = 'false';
                childNode[5].classList.remove('editableField');

                //to remove editing Mode
                delete todo.editMode;

                // retrieve all new updates and save them in todo.
                todo.title=childNode[1].innerHTML;
                todo.description=childNode[5].innerHTML;

                //save changes to database
                $scope.addOrUpdateTodo(todo);
            }
        }

        //to create a new Todo and save it inot the database
        // $scope.addNewTodo=function(){
        //
        //     //add the todo to the database
        //     $scope.addOrUpdateTodo($scope.newTodo);
        //
        //     //refresh the todoList
        //     $scope.getAllTodos();
        //
        //     //hides the The field for adding new Todos...
        //     $scope.revealNewTodoFields=false
        //
        // }
        $scope.addNewTodo=function(){
            var modalInstance = $uibModal.open({
              templateUrl: './template/addNewTodo.html',
              controller: 'addNewTodoModalInstanceCtrl',
              size: 'sm',
              windowClass: 'modal-window',
            })
            modalInstance.result.then(function (data) {
                console.log(data)
                $scope.newTodo=data;
                //add the todo to the database
                $scope.addOrUpdateTodo($scope.newTodo);
                //refresh the todoList
                $scope.getAllTodos();
            }, function () {

            });
        }
        $scope.deleteTodo=function(todoToBeDeletedId){
            var payload={id:todoToBeDeletedId};

            //angular-resource doesn't support body in delete Method therefore, we will be using $http here;
            $http({
                //method to send to the API...
                method: 'DELETE',
                //url of the API with the sessionId
                url: "todo?sessionId="+data.sessionId,
                //request data
                data: payload,
                headers: {'Content-Type': 'application/json;charset=utf-8'}
            })
            //get the response from the API request
            .then(function(result){
                if(result.data.status=='success'){
                    //refresh the todoList
                    $scope.getAllTodos();
                }
                else{
                    alert(result.data.data)
                }
            },
            function(err){
                alert(err)
            })
        }
    }])
    .controller('addNewTodoModalInstanceCtrl', ['$scope', '$rootScope', '$uibModalInstance', function ($scope, $rootScope,  $uibModalInstance){
        console.log('here')
        $scope.newTodo={status:'notCompleted'}
        $scope.addNewTodo=function(){
            $uibModalInstance.close($scope.newTodo);
        }
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }])
