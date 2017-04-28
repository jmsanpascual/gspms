(function() {
    'use strict';

    angular
        .module('activityDependencies')
        .factory('ProgressCalculator', ProgressCalculator);

    ProgressCalculator.$inject = ['Milestone'];

    /* @ngInject */
    function ProgressCalculator(Milestone) {
        var projectStatus = [2, 4],
            factory = {
                calculatePhasesPercentages: calculatePhasesPercentages
            };

        return factory;

        function calculatePhasesPercentages(project, activities, phasesReference, percentageReference) {
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

                // We will only count the approved and completed activities percentages
                if (isInArray(activity.status_id, projectStatus)) {
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

            Milestone.getMilestone({ id: project.id }).then(function (milestone) {
                console.log('Milestone at Progress Calculator: ', milestone);

                // phases and phasesLengths are both objects declared inside this function
                for (var i = 1; i <= phasesReferenceLen; i++) {
                    var phase = phases[i],
                        phaseReference = phasesReference[i - 1];

                    if (phaseReference.id == i) {
                        // Get the total percentage of this phase
                        phaseReference.percent = (phase.subTaskPercentage / phasesLengths[i]);
                        // Divide the total precentage of this phase to the total phases count
                        phaseReference.percent = (phaseReference.percent / phasesReferenceLen).toFixed(2);
                        // Check if phase reference is not a number
                        phaseReference.percent = (isNaN(phaseReference.percent)) ? 0 : phaseReference.percent;
                        // Days Left before the project needs to be finished
                        phaseReference.daysLeft = getDateDifference(new Date(), milestone['phase_' + i]);
                    }
                }
            });
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

        function getDateDifference(newDate, oldDate) {
            oldDate = new Date(oldDate);
            var timeDiff = Math.abs(oldDate.getTime() - newDate.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            return diffDays;
        }

        function isInArray(value, array) {
           return array.indexOf(value) > -1;
        }
    }
})();
