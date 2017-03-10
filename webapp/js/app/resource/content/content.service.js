'use strict';

angular.module('content').factory(
    'Content', function($resource){
            var url = 'http://localhost:8080/log?file=:file'
            return $resource(url, {}, {
                query: {
                    method: "JSONP",
                    params: { file: 'sample.log'},
                    cache: true,
                    // transformResponse
                    // interceptor
                },
                get: {
                    method: "GET",
                    // params: {"id": @id},
                    cache: true,
                }
            })
    }
);

