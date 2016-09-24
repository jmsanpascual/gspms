(function() {
    'use strict';

    angular
        .module('project.attachment')
        .factory('ProjectAttachment', ProjectAttachment);

    ProjectAttachment.$inject = ['$resource'];

    /* @ngInject */
    function ProjectAttachment($resource) {
        return $resource('../project-attachments/:id', {id : '@id'}, {
            'deleteFile' : {
                'url' : '../project-attachments/deleteFile/:id',
                'method' : 'DELETE',
                'params' : { 'id' : '@id'}
            }
        });
    }
})();
