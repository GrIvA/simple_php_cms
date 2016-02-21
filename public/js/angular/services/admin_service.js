var angular_admin = angular.module('main', ['ngRoute', 'AxelSoft', 'GrIvASoft']);
angular_admin.factory('adminService', ['ajaxRequest', 'batchLog',
    function (ajaxRequest, batchLog, $rootScope) {
        "use strict";
        var context = {};

        function setKey(key, value) {
            context[key] = value;
        }

        function getKey(key) {
            return context[key] ? context[key] : '';
        };

        function getSessionId() {
            var id = document.cookie.match(/PHPSESSID=([^;]*)/i);
            if (!!id) { return id.pop(); }
            else { return 0; }
        }

        function store() {
            var sessionID = getSessionId();
            if (context.sessionID != sessionID) {
                console.log('ERROR session: was ' + context.sessionID + ', now: ' + sessionID);
                context.sessionID = sessionID;
            }
            sessionStorage.setItem('admin_context', JSON.stringify(context));
        }

        function clearStorage(params) {
            var untouchables = ['sessionID'];
            var temp = {};
                                
            (params instanceof Array) && Array.prototype.push.apply(untouchables, params);
                                
            for (var i = 0; i < untouchables.length; i++) {
                temp[untouchables[i]] = getKey(untouchables[[i]]);
            }
            context = temp;
            store();
        }

        function retrieve() {
            var storage = sessionStorage.getItem('admin_context'),
                sessionID = getSessionId();
                                        
            context = storage ? JSON.parse(storage) : {};
                                        
            if (context.sessionID != sessionID) {
                clearStorage();
            }
        }


        // --- public ---
        var service = {};

        service.retrieve = function() { retrieve(); }
        
        //ajax request
        service.setAjax = function(pathKey, headers){
            var path = getKey(pathKey);
            if (path.length) {
                ajaxRequest.setUrl(path);
            }
            return !!path.length;
        };
        
        service.getAjax = function (params, successCallback, errorCallback) {
            var result = {status: 0};
            batchLog(params, 'AJAX request');
            
            angular.extend(params, {format: 'json'});
            
            ajaxRequest.go(params, {})
            .success(function (response, status, headers, config) {
                batchLog(response, 'SUCCESS ajax result');
                result.response = response; 
                (successCallback && successCallback(response));
            })
            .error(function(response, status, headers, config) {
                batchLog(response, 'ERROR ajax result');
                result.response = response;
                errorCallback && errorCallback(response);
            });
            return true;
        };
        // ---

        service.setKey = function(key, value) {
            setKey(key, value);
            store();
            return true;
        };



        return service;
    }
])
