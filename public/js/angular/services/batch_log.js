(function (angular, undefined) {
    angular.module('GrIvASoft', [])
    .factory('batchLog', ['$interval', '$log', '$filter', function($interval, $log, $filter) {
        var messageQueue = [];

        function log() {
            var host = window.location.hostname;
            //TODO: add check debug mode
            if (messageQueue.length) {
                $log.log('['+host+']: ', $filter('json')(messageQueue));
            }
            messageQueue = [];
        }
        
        // start periodic checking
        $interval(log, 5000);
            
        return function(data, title) {
            var obj = {};
            obj[(typeof title === 'undefined') ? 'batchLog message' : title] = data;
            messageQueue.push(obj);
        };
    }]);
})(angular);
