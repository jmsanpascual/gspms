(function() {
    'use strict';

    angular
        .module('notification', [
            'ngResource',
            'project.service',
            'program.service',
            'projectStatus.service',
            'dynamicElement',
            'user.service',
            'datatables',
            'common.service',
            'ui.bootstrap',
            'project.activites.controller',
            'budget.request.controller',
            'items.controller',
            'resourcePersonService',
            'project.attachment',
            'upload',
            'toast',
            'project-related',
        ]);
})();
