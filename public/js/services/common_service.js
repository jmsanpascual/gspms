'use strict'

var common = angular.module('common.service', []);

common.service('defaultModal', function($uibModal, $log){

    this.delConfirm = function(config, overwrite){

        if(config != undefined)
        {
            config.title = 'Delete';
            config.action = 'delete';
            config.name = config.deleteName || '';
            config.item = config.deletedKey || '';

            delete config.deleteName;
            delete config.deletedKey;
        }
        var modalInstance = this.showConfirm(config, overwrite);

        return modalInstance;
    }

    this.addConfirm = function(config, overwrite)
    {
        if(config != undefined)
        {
            config.title = 'Add';
            config.action = 'add';
        }

        var modalInstance = this.showConfirm(config, overwrite);

        return modalInstance;
    }

    this.showConfirm = function(config, overwrite){

        if(config == undefined)
            console.log('No config receive yet.');
        // if(config.deletedKey == undefined)
        //     console.log('No config delete key yet.');

        // Declare the model instance
        var templateUrl = '/gspms/public/js/templates/confirm.html';
        var staticController = 'confirmModalInstanceCtrl';
        var staticVar = ['size', 'templateUrl', 'controller'];
        var resolveAttr = {};

        // if not overwrite place the default URL and controller for delete
        if(overwrite == undefined)
        {
            config.templateUrl = templateUrl;
            config.controller = staticController;
        }

        // all attr not in static var will be put in resolve
        for(var key in config)
        {
            // if not in static var
            if(staticVar.indexOf(key) < 0)
            {
                resolveAttr[key] = config[key];
            }
        }

        // overwrite resolve
        config.resolve = {
             attr : function () {
                return resolveAttr;
            },
        };

        // delete config.deleteKey;

        var modalInstance = $uibModal.open(config);

        return modalInstance;
    }

    this.showModal = function(config, instanceCtrl){
        if(config == undefined)
            console.log('No config receive yet.');
        // if(config.deletedKey == undefined)
        //     console.log('No config delete key yet.');

        // Declare the model instance
        // var templateUrl = 'js/templates/defaultModal.html';
        config.controller = (instanceCtrl != undefined) ? instanceCtrl : 'defaultModalInstanceCtrl';
        var staticVar = ['size', 'templateUrl', 'controller'];
        var resolveAttr = {};

        // all attr not in static var will be put in resolve
        for(var key in config)
        {
            // if not in static var
            if(staticVar.indexOf(key) < 0)
            {
                resolveAttr[key] = config[key];
            }
        }
        console.log('attr');
        console.log(resolveAttr);
        // overwrite resolve
        config.resolve = {
             attr : function(){
                return resolveAttr;
            },
        };

        // delete config.deleteKey;

        var modalInstance = $uibModal.open(config);

        return modalInstance;
    };
});


/**
*   Convert normal object/ array data to Form Data for submission of form with files
*   @param data = the object/ array data to be submitted
*   <!-- optional (also used by itself(recursion))-->
*   @param formData = contain the current form data to be appended
*   @param otherKey = contain the existing key to be used
*/

common.service('formDataAPI', function(){
    this.build = function(data, formData, otherKey)
    {

        if(!data)
            return;
        var fd = (formData) ? formData : new FormData();
        var temp; // identifier

        for(var key in data)
        {
            // use to prevent prototypes to be included in loop (eg. obj.length)
            if(!data.hasOwnProperty(key))
                continue;


            if(typeof data[key] == 'object') // array or object
            {
                //recursion call itself change the data
                fd = this.build(data[key], fd, key);
            }
            // if other key exist means multi array
            var field = (!otherKey) ? key : otherKey + '['+ key +']';
            fd.append(field, data[key]);
        }

        return fd;
    }
});

// used by service
common.controller('defaultModalInstanceCtrl', function ($scope, $uibModalInstance, attr, $http, formDataAPI) {
    console.log('attr');
    console.log(attr);
    $scope.submitData = (attr != undefined) ? attr : {};
    var changeClose = false;
    var postData;
    $scope.save = function (formData, withFile) {
        console.log('formdata',formData);
        var data = (formData == undefined) ? $scope.submitData : $scope.submitData[formData];

        if (data.resource) {
            $uibModalInstance.close(data);
            return;
        }

        var config = {};

        if(withFile) {
            data = formDataAPI.build(data);
            config = {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            };
        }

        $http.post($scope.submitData.saveUrl, data, config).then(function(result){
            result = result.data;
            if(result.status)
            {
                if(attr.keepOpen == undefined)
                {
                    $uibModalInstance.close(result);
                }
                else
                {
                    console.log(result[formData]);
                    $scope.submitData[formData] = result[formData];
                    if(result.saveUrl != undefined)
                        $scope.submitData['saveUrl'] = result.saveUrl; // make the url update

                    changeClose = true; // if keepOpen true
                    postData = $scope.submitData[formData];
                }
                // alert(result.msg);
            }
            else
            {
                alert(result.msg);
            }
        },function(e){
            console.log(e);
            alert('Error. Internal server.');
        });
    };

    $scope.closeSubmit = function()
    {
        $uibModalInstance.close($scope.submitData);
    }

    $scope.close = function () {
        if(!changeClose)
            $uibModalInstance.dismiss('cancel');
        else
            $uibModalInstance.close(postData);
    };
});

common.controller('confirmModalInstanceCtrl', function ($scope, $uibModalInstance, attr) {
    $scope.attr = attr;
    $scope.ok = function () {
        // console.log(deleteAttr.deleteKey);
        // console.log(deleteAttr.deleteName);
        $uibModalInstance.close(attr.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

//request default

common.service('reqDef', function($http){
    this.get = function(url, config){
        return $http.get(url, config).then(function(result){
            return result.data;
        });
    };

    this.post = function(url, data, config){
        return $http.post(url, data, config).then(function(result){
            return result.data;
        });
    };

    this.delete = function(url,config){
        return $http.delete(url,config).then(function(result){
            return result.data;
        });
    }
});

common.service('displayNotif', function($timeout){
    var toastElement = angular.element(document.querySelector('.toast'));
    toastElement.css('display','none');

    this.show = function(msg){
        toastElement.css('display', 'block');
        toastElement.html(msg);
        console.log('show');
        // $scope.showToast = true;
        $timeout(function(){console.log('hide'); toastElement.css('display','none');}, 3000);
    }
});

common.service('tmjLoading', function($timeout){
    var loadInterval;

    this.show = function()
    {
        console.log('show loading');
        var addHtml = '<div class = "tmjLoading" style = "position:absolute; top: 0px; left:0px; height:100%; width: 100%; background-color:transparent; z-index: 9999;"></div>';
        addHtml += '<div class = "tmjLoading" style = "position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); z-index: 10000; padding: 10px; opacity: 0.8;';
        addHtml += 'background-color: #E8E8E8; text-align:center; vertical-align: middle;"><i class="fa fa-refresh loading"></i> Loading, please wait ... </div>';

        var html = angular.element(document.querySelector('html'));
        html.append(addHtml);
        this.disableKeys();
        // html.focus();
    }

    this.hide = function(){
        console.log('hide loading');
        // remove the prepend element with class tmjLoading
        angular.element(document.getElementsByClassName('tmjLoading')).remove();
        this.enableKeys();
    }

    //disable all input textand textarea to disable the user from typing
    this.disableKeys = function()
    {
        var element = document.querySelectorAll('textarea, input[type="text"]');
        angular.element(element).attr('disabled', true);

    }

    this.enableKeys = function()
    {
        var element = document.querySelectorAll('textarea, input[type="text"]');
        angular.element(element).attr('disabled', false);
    }
});
