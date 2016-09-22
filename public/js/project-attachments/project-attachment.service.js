(function() {
    'use strict';

    angular
        .module('project.attachment')
        .factory('ProjectAttachment', ProjectAttachment);

    ProjectAttachment.$inject = ['$resource'];

    /* @ngInject */
    function ProjectAttachment($resource) {
        return $resource('../project-attachments');
    }
})();
