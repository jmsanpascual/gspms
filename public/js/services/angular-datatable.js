'use strict'

var dtTable = angular.module('dtTable.services', []);

dtTable.service('dtTableService', function($scope , $compile{
	this.generateRows = function(data)
	{
		var str = '';
		// EXPECTING DATA TO BE MULTIPLE ARRAY
		angular.forEach(data, function(val, key)
		{
			str += '<tr>';
			angular.forEach(val, function(v,k){
				str += '<td>' + v + '</td>'				
			});
			str += '</tr>';
		});
		return str;
	}

	this.generatePagination = function(totalRecord, options)
	{
		var str = '<div class ="dtPagination pagination">';
        str += '<div class = " form-inline form-group col-md-4">';
        str += '<label class = "control-label" style = "margin-right: 10px;">View</label>';
        str += '<select class = "form-control"  style = "width: 100px;">';
        	// generate the options of view
		var option = (options) ? options : [10, 20, 50, 100, 150];
		for(var key in option)
		{
			str += '<option value = "' + option[key] + '" {{ currSelected }}>' + option[key] + '</option>';
			if(option[key] > totalRecord) // stop the generation of views 
				break;
		}
		str += '<option>All</option></select></div>';

        str += '<div class="col-md-6 pull-left" style = "margin-left: -20px;">';
        str += '<button dtPrev class="btn btn-default pull-left">&lt;&lt;</button>';
        str += '<div class="col-md-2">';
        str += '<input type="text" dtPage value="{{ currPage }}" style="text-align: center;" class="form-control">';
        str += '</div><button dtNext class="btn btn-default">&gt;&gt;</button>';
        
        str += 'showing {{ currPage }} of  pages'
        
      	str +='</div></div>';

      	str = $compile(str);
	}
});

