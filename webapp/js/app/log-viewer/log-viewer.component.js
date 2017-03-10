'use strict';

angular.module('logViewer').
    component('logViewer', {
        templateUrl: './templates/log-viewer.html',
        controller: function($scope, $http) {
			$scope.getFilename = function() {
                $scope.posts = null
				getContent($scope.file.content)
                $scope.file.content = null
			}

            $scope.items = ["HELLO", "YES", 1, 2, 3, 4, 5, 6 ]

			function getContent(file) {	
				$http.get(__env.apiUrl, { params: { file: file} }).then(successCallback, errorCallback);
				function successCallback(response, status, config, statusText){
					$scope.notFound = false

					var blogItems = response.data
					console.table(response.statusText)
					$scope.posts = blogItems
                    console.table(blogItems)

				}

				function errorCallback(response, status, config, statusText){
					$scope.notFound = true
                    $scope.errorData = response.data
                    $scope.errorCode = response.status
					console.log(response.data)
					console.log(response.status)
                    console.table(response)
				}
			}
			
        }

});
