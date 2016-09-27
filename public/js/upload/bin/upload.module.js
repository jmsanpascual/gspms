/**
* Angular Upload Library
* @author TMJ Web Development Team.
* @element
*	tmjupload(<tmjupload></tmjupload>) must be specified to work
* @attributes
* 	multiple : @attr = NULL (means single upload) | multiple (means multiple upload)
*	changeFile = "@func" : expression to call when file change (i.e changeFile = "test()" will call the $scope.test() function)
*	fileModel = "@model" : on what variable the file will be place
*	target = "@target" : @target = "<img>" element will append to its source | else will implement tmj template
*
* @copyright TMJ Philippines BPO Services Inc. 2016
*
*/
(function(){
	angular.module('upload', []);
})();