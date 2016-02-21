(function (angular, undefined) {
    angular.module('GrIvASoft')
    .factory('ajaxRequest', ['$http', function($http) {
        var url = '';
        var ajaxRequest = {};
        var popup;

        function serializeData(data) { 
            // If this is not an object, defer to native stringification.
            if (!angular.isObject(data)) { 
                return((data == null) ? "" : data.toString()); 
            }
            
            var buffer = [];
            
            // Serialize each key in the object.
            for (var name in data) { 
                if (!data.hasOwnProperty(name)) { 
                    continue; 
                }
                
                var value = data[name];
                
                buffer.push(
                    encodeURIComponent(name) + "=" + encodeURIComponent((value == null) ? "" : value)
                ); 
            }
            
            // Serialize the buffer and clean it up for transportation.
            var source = buffer.join("&").replace(/%20/g, "+"); 
            return(source); 
        }
        
        ajaxRequest.setUrl = function(path) {
                url = path;
            };  
        
        ajaxRequest.go = function(parameters, headers) {
            return $http({
                url: url,
                method: 'POST',
                headers: angular.extend(
                    {},
                    headers ? headers : {},
                    { 'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8' }
                ),
                data: serializeData(parameters)
            });
        };
        
        return ajaxRequest;
    }]);
})(angular);
