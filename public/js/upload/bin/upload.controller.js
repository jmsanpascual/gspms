/**
* Default Templating for Upload
* By default we created a template for multiple or single upload with target div or img
* if you don't want to use the default template just dont put a target attribute
* instead you can call get the input and create another change and use the file reader
* library
*/
(function(){
	angular.module('upload')
	.controller('uploadCtrl', uploadCtrl);

	uploadCtrl.$inject = ['$scope', 'fileReader', '$compile', '$parse'];

	function uploadCtrl($scope, fileReader, $compile, $parse) {
		var vm = this;
		vm.result = {};
		vm.progress = {};

		/**
		*	Progress bar of uploaded file
		*/
		$scope.$on('fileProgress', function(e, result){
			if(vm.progress[result.ctr] == undefined)
				vm.progress[result.ctr] = 0;

			vm.progress[result.ctr] = (result.loaded / result.total) * 100;
		});

		var file_list = {};
		var model;
		var ctr = 0;

		vm.uploadMultipleImg = function (attrs, file)
		{
			angular.forEach(file, function(val,key){
				if(val.type != undefined)
				{
					file_list[ctr] = val; // push the file in array
					var str = vm.uploadTemplate(val, true, ctr); // upload first the template
					angular.element(document.querySelector(attrs.target)).append(str);

					fileReader.readAsDataUrl(val, $scope, ctr).then(function(result){
						vm.result[result.ctr] = angular.copy(result.data);
					});

					ctr++;
				}
			});

			// store to model the list of image
			model = $parse(attrs.fileModel);
			syncToModel();
		}

		function syncToModel(){
			// $scope.$evalAsync(model.assign($scope, file_list));
			$scope.$digest(model.assign($scope, file_list));

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

			if(attrs.multiple != undefined && attrs.multiple == true)
			{
				vm.uploadMultipleImg(attrs, file);
				return;
			}

			// if single upload
			file_list = file[0];
			// if target is an image element update src
			if(attrs.target && angular.element(document.querySelector(attrs.target)).attr('src') != undefined)
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

			model = $parse(attrs.fileModel);
			syncToModel();

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
})();
