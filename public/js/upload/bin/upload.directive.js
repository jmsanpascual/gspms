(function(){
	angular.module('upload')
	.directive('changeFile', changeFile)
	.directive('tmjupload', tmjupload);

	changeFile.$inject = ['$parse'];
	tmjupload.$inject = ['$compile'];

	function changeFile($parse){
		return {
			restrict: 'A',
			link: function(scope,element,attrs, upload)
			{
				element.bind('change', function(){
					var multipleFlag = attrs.multiple;
					var file = element[0].files;
					if(!multipleFlag && file != undefined &&
						file.length > 1)
					{
						alert('Multiple files not allowed');
						return false;
					}

					if(attrs.changeFile != '' && attrs.changeFile != undefined)
					{
						scope.$eval(attrs.changeFile, {file: file}); //execute the function
					}

					// show image in specified target
					if(attrs.target != '' && attrs.target != undefined)
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

	function tmjupload($compile){
	  	// function controller(){

	  	// }
		return {
			restrict: 'E',
			link: function(scope, element, attrs, uf){
				element.bind('click', function(e){
					element[0].lastChild.click();
				});
				// uf.multiple = attrs.multiple || 'false';
				attrs.target = attrs.target || '';
				attrs.changedFile = attrs.changedFile || '';
				attrs.fileModel = attrs.fileModel || '';

				var str = [
					'<input type="file" ',
					// if multiple add attribute
					(attrs.multiple != undefined) ? 'multiple': '',
			      	' target = "' + attrs.target + '" id=tmjUploadDir"',
					' style = "display: none" change-file = "' + attrs.fileChange + '"',
					' file-model = "' + attrs.fileModel + '">'
				].join('');

				str = angular.element(str);
				str = $compile(str)(scope);
				element.append(str);
			},
			// controller : controller,
			// controllerAs : 'uf',
			// transclude:true,
			// template : function(scope){
					// var str = [
					// 	'<ng-transclude></ng-transclude><input type="file" ',
					// 	// if multiple add attribute
					// 	(scope.multiple) ? 'multiple': '',
				 //      	' target = "{{uf.target}}" id=tmjUploadDir"',
					// 	' style = "display: none" change-file = "{{uf.changedFile}}"',
					// 	' file-model = "{{uf.fileModel}}">'
					// ]
					// return str.join('');
			// }
		}
	}
})();
