angular.module('getcentreAdmin')
.directive('draggable', function() {
    return function(scope, element) {
        var el = element[0];
        el.draggable = true;
        el.addEventListener(
            'dragstart',
            function(e) {
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('Text', this.id);
                this.classList.add('editMode');
                return false;
            },
            false
        );

        el.addEventListener(
            'dragend',
            function(e) {
                this.classList.remove('editMode');
                return false;
            },
            false
        );
    }
})
.directive('bucket', function() {
    return {
        scope: {
            drop: '&' // parent
        },
        link: function(scope, element) {
            // again we need the native object
            var el = element[0];
            el.addEventListener(
                'dragover',
                function(e) {
                    e.dataTransfer.dropEffect = 'move';
                    // allows us to drop
                    if (e.preventDefault) e.preventDefault();
                    this.classList.add('bucketEditMode');
                    return false;
                },
                false
            );

            el.addEventListener(
                'dragenter',
                function(e) {
                    this.classList.add('bucketEditMode');
                    return false;
                },
                false
            );

            el.addEventListener(
                'dragleave',
                function(e) {
                    this.classList.remove('bucketEditMode');
                    return false;
                },
                false
            );
            el.addEventListener(
                'drop',
                function(e) {
                    // Stops some browsers from redirecting.
                    if (e.stopPropagation) e.stopPropagation();
                    if(e.preventDefault) { e.preventDefault(); }

                    this.classList.remove('bucketEditMode');
                    bucketId=this.id;
                    var todoList = document.getElementById(e.dataTransfer.getData('Text'));
                    //get current TodoList bucket, we will compare this to the bucket dropped into;
                    var currentTodoListParent=todoList.parentNode.id;
                    //if the buckets are different, then we will drop the todoList in the new bucket;
                    if(currentTodoListParent != bucketId){
                        this.appendChild(todoList);
                        scope.$apply(function(scope) {
                            var fn = scope.drop();
                            fn(bucketId, todoList.id);
                        });
                    }

                    return false;
                },
                false
            );
        }
    }
});
