'use strict';

angular.module('webapp').
    config(
        function(
          $locationProvider,
          $resourceProvider,
          $routeProvider
          ){

          $locationProvider.html5Mode({
              enabled:true,
              requireBase: false
            })

          $resourceProvider.defaults.stripTrailingSlashes = true;

          $routeProvider.
              when("/", {
                template: "<log-viewer></log-viewer>"
              }).
              otherwise({
                  template: "Not Found"
              })
});
