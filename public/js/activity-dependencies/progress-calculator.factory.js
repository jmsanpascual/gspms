(function() {
    'use strict';

    angular
        .module('activityDependencies')
        .factory('ProgressCalculator', ProgressCalculator);

    ProgressCalculator.$inject = [];

    /* @ngInject */
    function ProgressCalculator() {
        var approvedActivityId = 2,
            factory = {
                calculatePhasesPercentages: calculatePhasesPercentages
            };

        return factory;

        function calculatePhasesPercentages(activities, phasesReference, percentageReference) {
            var activitiesLen = activities.length,
                subTaskPercentage = 0,
                approvedTaskCount = 0,
                phasesLengths,
                phases  = {
                    1: {
                        approvedTaskCount: 0,
                        subTaskPercentage: 0
                    },
                    2: {
                        approvedTaskCount: 0,
                        subTaskPercentage: 0
                    },
                    3: {
                         approvedTaskCount: 0,
                         subTaskPercentage: 0
                    },
                };

            // Immediately stop the operation when there's no activities
            if (activitiesLen <= 0) return;
            else phasesLengths = _getPhasesLength(activities, activitiesLen);

            for (var i = 0; i < activitiesLen; i++) {
                var activity = activities[i];

                // We will only count the approved activities percentages
                if (activity.status_id == approvedActivityId) {
                    var phase = phases[activity.phase_id],
                        tasks = activity.tasks,
                        tasksLen = tasks.length;

                    if (!phase) continue;

                     // Reset counts on every activity
                    approvedTaskCount = 0;
                    phase.approvedTaskCount = 0;

                    // Count the task done for each activity
                    for (var x = 0;  x < tasksLen; x++) {
                        if (tasks[x].done) {
                            approvedTaskCount++;
                            phase.approvedTaskCount++;
                        }
                    }

                    if (phase.approvedTaskCount > 0 && approvedTaskCount > 0) {
                        // Formula to get only the sub task percentage
                        subTaskPercentage += (Math.round((approvedTaskCount / tasksLen) * 100));
                        phase.subTaskPercentage += (Math.round((phase.approvedTaskCount / tasksLen) * 100));
                    }
                }
            }

            // Update the total percentageReference
            percentageReference.value = Math.round((subTaskPercentage / activitiesLen));

            // phasesReference is an array declared outside this function
            var phasesReferenceLen = phasesReference.length;

            // phases and phasesLengths are both objects declared inside this function
            for (var i = 1; i <= phasesReferenceLen; i++) {
                var phase = phases[i],
                    phaseReference = phasesReference[i - 1];

                if (phaseReference.id == i) {
                    // Get the total percentage of this phase
                    phaseReference.percent = (phase.subTaskPercentage / phasesLengths[i]);
                    // Divide the total precentage of this phase to the total phases count
                    phaseReference.percent = (phaseReference.percent / phasesReferenceLen).toFixed(2);
                }
            }
        }

        // Gets the total length of the phases
        function _getPhasesLength(activities, activitiesLen) {
            var phasesLen = { 1: 0, 2: 0, 3: 0 };

            for (var i = 0; i < activitiesLen; i++) {
                var activity = activities[i],
                    phaseId = activity.phase_id;

                phasesLen[phaseId]++;
            }

            return phasesLen;
        }
    }
})();


//   var activitiesLen = result.proj_activities.length,
//       subTaskPercentage = 0,
//       approvedTaskCount = 0;
//
//   for (var i = 0; i < activitiesLen; i++) {
//
//       if (result.proj_activities[i].status_id == approvedActivityId) {
//             var tasks = result.proj_activities[i].tasks,
//                 tasksLen = tasks.length;
//
//             approvedTaskCount = 0;
//
//             for (var x = 0;  x < tasksLen; x++) {
//                 if (tasks[x].done) {
//                     approvedTaskCount++;
//                 }
//             }
//
//             if (approvedTaskCount > 0)
//                 subTaskPercentage += (Math.round((approvedTaskCount / tasksLen) * 100));
//       }
//   }
//
//   if (activitiesLen > 0) {
//       $timeout(function () {
//           vm.percentage = Math.round((subTaskPercentage / activitiesLen));
//       }, 500);
//   }
