/**
* File reader function src : http://odetocode.com/blogs/scott/archive/2013/07/03/
* building-a-filereader-service-for-angularjs-the-service.aspx
* Modified by TMJP Web Development Team - 5/16/2016
* Allowed multiple file rendering
*/
(function(){
	angular.module('upload')
	.factory('fileReader', fileReader);

	fileReader.$inject =['$q'];

	function fileReader($q) {
        var onLoad = function(reader, deferred, scope, ctr) {
            return function () {
                scope.$evalAsync(function () {
                    deferred.resolve({data : reader.result, ctr : ctr});
                });
            };
        };
        var onError = function (reader, deferred, scope) {
            return function () {
                scope.$evalAsync(function () {
                    deferred.reject(reader.result);
                });
            };
        };

        var onProgress = function(reader, scope, ctr) {
            return function (event) {

                scope.$broadcast("fileProgress",
                    {
                        total: event.total,
                        loaded: event.loaded,
                        ctr : ctr
                    });
            };
        };

        var getReader = function(deferred, scope, ctr) {
            var reader = new FileReader();
            reader.onload = onLoad(reader, deferred, scope, ctr);
            reader.onerror = onError(reader, deferred, scope);
            reader.onprogress = onProgress(reader, scope, ctr);
            return reader;
        };

        var readAsDataURL = function (file, scope, ctr) {

            var deferred = $q.defer();

            var reader = getReader(deferred, scope, ctr);
            reader.readAsDataURL(file);

            return deferred.promise;
        };

        return {
            readAsDataUrl: readAsDataURL
        };
	}
})();