(function() {
    'use strict';

    angular
        .module('project.attachment')
        .factory('ProjectAttachmentManager', ProjectAttachmentManager);

    ProjectAttachmentManager.$inject = [];

    /* @ngInject */
    function ProjectAttachmentManager() {
        var files = [];
        var service = {
            get: getFiles,
            set: setFiles
        };

        return service;

        function getFiles() {
            return files;
        }

        function setFiles(data) {
            files = data;
        }
    }
})();
