'use strict'

var env = {};

// Import variables if present (from env.js)
if(window){  
  Object.assign(env, window.__env);
}

angular.module('webapp', [
    // external
    'angularUtils.directives.dirPagination',
    'ngResource',
    'ngRoute',

    // mine    
    'logViewer',

]).constant('__env', env);

