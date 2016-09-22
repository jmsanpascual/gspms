(function(){
	angular.module('upload', [])
	.controller('uploadCtrl', uploadCtrl)
	.directive('changeFile', changeFile)
	.directive('tmjupload', tmjupload)
	.factory('fileReader', fileReader);

	changeFile.$inject = ['$parse'];
	fileReader.$inject =['$q'];
	tmjupload.$inject = ['$compile'];
	uploadCtrl.$inject = ['$scope', 'fileReader', '$compile', '$parse'];

	function changeFile($parse){
		return {
			restrict: 'A',
			link: function(scope,element,attrs, upload)
			{
				var multipleFlag = attrs.multiple;
				element.bind('change', function(){
					var file = element[0].files;
					if(!multipleFlag && file != undefined &&
						file.length > 1)
					{
						alert('Multiple files not allowed');
						return false;
					}


					if(attrs.changeFile != '' && attrs.changeFile != undefined)
					{
						scope.$eval(attrs.changeFile); //execute the function
					}

					// show image in specified target
					if(attrs.target != undefined)
		      		{
				        var upload_file;
				        if(file.length > 0)
				           upload_file = file;

				        upload.uploadImg(attrs, upload_file);
				    	return;
				    }

					if(attrs.fileModel != '' && attrs.fileModel != undefined)
					{
						var model = $parse(attrs.fileModel);
						scope.$evalAsync(model.assign(scope, file));
					}
				});
			},
			controller : 'uploadCtrl',
			controllerAs : 'upload',
		}
	}

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

	function uploadCtrl($scope, fileReader, $compile, $parse) {
		var vm = this;
		var ctr = 0;
		vm.result = {};
		vm.progress = {};

		/**
		*	Progress bar of uploaded file
		*/
		$scope.$on('fileProgress', function(e, result){
			// if(vm.progress[result.ctr] == undefined) {
			//
			// }
			vm.progress[result.ctr] = (result.loaded / result.total) * 100;
		});

		var file_list = {};
		var model;
		vm.uploadMultipleImg = function (attrs, file)
		{
			console.log('attach', attrs);
			console.log(file);
			console.log(angular.element(document.querySelector(attrs.target)));
			angular.forEach(file, function(val,key){
				if(val.type != undefined)
				{
					file_list[ctr] = val; // push the file in array
					var str = vm.uploadTemplate(val, true, ctr); // upload first the template
					console.log('string');
					console.log(str);
					angular.element(document.querySelector(attrs.target)).append(str);

					fileReader.readAsDataUrl(val, $scope, ctr).then(function(result){
						vm.result[result.ctr] = result.data;
					});

					ctr++;
				}
			});

			// store to model the list of image
			model = $parse(attrs.fileModel);
			syncToModel();
		}

		function syncToModel(){
			$scope.$evalAsync(model.assign($scope, file_list));
		}

		$scope.removePic = function(element, ctr)
		{
			if(!confirm('Are you sure you want to remove this?'))
				return;
			// remove it in file list
			delete file_list[ctr];
			angular.element(element).parent().remove();
			syncToModel();
		}

		// if image is uploaded return base 64 of file
		vm.uploadImg = function(attrs, file)
		{

			console.log('upload img', attrs);
			console.log(file);
			// var file = vm.file;
			if(attrs.multiple != undefined && attrs.multiple == true)
			{
				vm.uploadMultipleImg(attrs, file);
				return;
			}

			if(angular.element(document.querySelector(attrs.target)).attr('src') != undefined)
			{
				fileReader.readAsDataUrl(file[0], $scope, 0).then(function(result){
					// if src is defined means in img
					angular.element(document.querySelector(attrs.target)).attr('src', result.data);

				});
			}
			// else means in div so create a new img src
			else
			{
				if(!file)
					return;

				// load first the template to see the animation
				var str = vm.uploadTemplate(file[0], false);
				angular.element(document.querySelector('.pic-container')).remove();
				angular.element(document.querySelector(attrs.target)).append(str);
				fileReader.readAsDataUrl(file[0], $scope, 0).then(function(result){
					vm.result[result.ctr] = result.data;
				});
			}
		}
		//draw the template
		vm.uploadTemplate = function(file, multiple, ctr)
		{
			if(!file)
				return;

			var ctr = (ctr != undefined) ? ctr : 0;
			var closeBtn = (multiple) ? '<button type="button" class="close pull pic-container-close" '
						+ 'onclick="angular.element(this).scope().removePic(this, '+ ctr +')">&times;</button>' : '';
 	    	var str = [
        		'<div class = "pic-container">' + closeBtn,
        		'<div class = "col-lg-3 col-md-3 col-sm-3 col-xs-3"><img class = "pic-container-img img-responsive" ',
        		'src = "{{upload.result['+ctr+']}}"></img></div><div class = "col-lg-9 col-md-9 col-sm-9 col-xs-9 ',
        		'pic-container-right"><span>' + file.name + '</span><div class="progress"><div class="progress-bar" ',
        		'role="progressbar" aria-valuenow="{{ upload.progress['+ctr+'] }}" aria-valuemin="0" aria-valuemax="100" ',
        		'style="width:{{upload.progress['+ctr+']}}%;">{{upload.progress['+ctr+']}} %</div></div></div></div>'
			].join('');

        	str = $compile(str)($scope);
        	return str;
		}
	}

	function tmjupload($compile){
	  	function controller(){

	  	}
		return {
			restrict: 'E',
			link: function(scope, element, attrs, uf){
				element.bind('click', function(e){
					element[0].lastChild.click();
				});
				// scope.multiple = attrs.multiple || '';
				uf.target = attrs.target || '';
				uf.changedFile = attrs.changedFile || '';
				uf.fileModel = attrs.fileModel || '';
			},
			controller : controller,
			controllerAs : 'uf',
			transclude:true,
			template : function(scope, attrs){
				return [
					'<ng-transclude></ng-transclude><input type="file" ',
					// if multiple add attribute
			      	(attrs.multiple) ? "multiple" : "",
			      	' target = "{{uf.target}}" id=tmjUploadDir"',
					' style = "display: none" change-file = "{{uf.changedFile}}"',
					' file-model = "{{uf.fileModel}}">'
				].join('');

			}
		}
	}
})();
