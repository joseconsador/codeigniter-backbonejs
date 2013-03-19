// --------------------------------------------------------------------
// 
var sep = '####';
var LogView = Backbone.View.extend({	
	el: $('table.calendar-container'),
	initialize: function() {
		var that = this;
		$('#range-form .btn-primary').attr('disabled', true);
		this.collection.on('reset', this.renderCalendar, this);
		this.$el.hide();

		$('#rangeA').daterangepicker();
		// Limits the datepicker options on mobile upto PREVIOUS MONTH only 
		$('.ui-daterangepicker-specificDate, .ui-daterangepicker-allDatesBefore, .ui-daterangepicker-allDatesAfter, .ui-daterangepicker-dateRange').addClass('visible-desktop');
		$('#range-form .btn-primary').click(
			function(e) {
				e.preventDefault();
				dates = that.getDates();
				if ($('#employee-id').val() > 0) {
					id = $('#employee-id').val();
				} else {
					id = 0;
				}

				that.collection.employee_id = id;
				that.collection.from = Math.round(dates['min'].getTime() / 1000);
				that.collection.to   = Math.round(dates['max'].getTime() / 1000);
				that.collection.pager();	
			}
		);		
	},
	enableButton: function() {
		$('#range-form .btn-primary').removeAttr('disabled');
	},
	initTypeahead: function() {
		_.each(this.employeeCollection.models, function(model) {
			$('#employee-search').append($('<option></option>').val(model.get('employee_id')).text(model.get('full_name')));
		});
		var that = this;
		$('#employee-search').typeahead({
            source: function (query, process) {
            	var data = new Array();
            	_.each(that.employeeCollection.models, function(model) {
            		data.push(model.get('employee_id') + sep + model.get('full_name'));
            	});

            	process(data);
            }, 
            highlighter: function(item) {
            	$('#range-form .btn-primary').attr('disabled', true);
		        var parts = item.split(sep);
		        parts.shift();

		        return parts.join(sep);
    		},
		  	updater: function(item) {
		        var parts = item.split(sep);		        
		        $('#employee-id').val(parts.shift());
		        $('#range-form .btn-primary').removeAttr('disabled');

		        return parts.join(sep);
		    },
            minLength: 1
        });
	},
	renderCalendar: function() {
		if (this.collection.length == 0) {			
			$('#notification-label').removeClass('hidden');
			$('#notification-label').text('No results at the moment.');
			this.$el.hide();
			return;
		}

		$('#notification-label').addClass('hidden');

		this.$el.show();

		this.$el.find('tbody').empty();

		dates = this.getDates();
		currPrintDate = dates['min'];
		
		prevMonth = null;
		while(currPrintDate.valueOf() <= dates['max'].valueOf()) {
			month = currPrintDate.getMonth();

			if (month != prevMonth) {
				this.$el.find('tbody').append('<tr><td colspan="8"><strong>' + monthNames[month] + '</strong></td></tr>');
			}

			sqlDate = currPrintDate.getFullYear() + '-' + pad((currPrintDate.getMonth() + 1), 2) + '-' + pad(currPrintDate.getDate(), 2);
			models = this.collection.where({date: sqlDate});			
			if (models[0] == undefined) {
				model = new TimelogModel({date: sqlDate});
			} else {
				model = models[0];
			}

			row = new LogRow({model:model});

			this.$el.find('tbody').append(row.render().el);

			prevMonth = month;

			currPrintDate = new Date(currPrintDate.getFullYear(), currPrintDate.getMonth(), currPrintDate.getDate() + 1);			
		}
	},
	getDates: function() {
		var range = $('#rangeA').val().split(' - ');
		var dates = {};

		if (range == '') {
			currDate = new Date();
			dates['min'] = new Date(currDate.getFullYear(), currDate.getMonth(), 1);
			dates['max'] = new Date(currDate.getFullYear(), currDate.getMonth() + 1, 0);
		} else if($(range).size() == 1) {
			date = range[0];
			dates['min'] = dates['max'] = new Date(range[0]);			
		} else if($(range).size() == 2) {			
			dates['min'] = new Date(range[0]);
			dates['max'] = new Date(range[1]);
		}

		return dates;
	}
});

// --------------------------------------------------------------------
// 

var LogRow = Backbone.View.extend({
	tagName: 'tr',
	template: $('#timelog-row-template').html(),	
    render: function () {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
    }		
});

// --------------------------------------------------------------------
// The following function will pad a number with leading zeroes so the 
// resulting string is "length" length
// --------------------------------------------------------------------
function pad(number, length) {
   
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
   
    return str;

}