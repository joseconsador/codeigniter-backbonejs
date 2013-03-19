// --------------------------------------------------------------------
// 
var EditRefView = Backbone.View.extend({
	departments: null,
	divisions: null,
	positions: null,
	companies: null,
	fetched: false,
	el: '#company-information',
	initialize: function() {
		this.$el.find('h3:first').after('<div class="pull-right button-container"><a href="#" class="edit">Edit</a></div>');
		
		actions = '<button type="button" class="btn cancel actions">Cancel</button>&nbsp;';
		actions += '<button type="button" class="btn actions btn-primary" data-loading-text="Saving...">Save</button>';

		this.$el.find('.button-container').append(actions);
		this.$el.find('.actions').hide();
	},
	events: {
		"click a.edit" : "edit",
		"click .btn-primary" : "save",
		"change select" : "change",
		"click .cancel" : "cancel"
	},
	cancel: function() {
		this.$el.find('.static').show();
		this.$el.find('select').remove();
		this.$el.find('.actions').hide();
		this.$el.find('a.edit').show();
	},
	change: function(e) { 		
    	change = {};
    	change[$(e.target).attr('id')] = $(e.target).val();    	    	
    	this.model.set(change);
	},
	save: function(e) {
		$(e.target).attr('disabled', true).text('Saving...');
		var that = this;
		this.model.save('', '', {
			success: function () {
				$(e.target).removeAttr('disabled').text('Save');
				that.$el.find('#company').text(that.model.get('company'));
				that.$el.find('#department').text(that.model.get('department'));
				that.$el.find('#division').text(that.model.get('division'));
				that.$el.find('#position').text(that.model.get('position'));				
				that.$el.find('.message-container').html('<span class="label label-success">Changes saved.</span>');
				that.cancel();
			}
		});
	},
	edit: function(e) {
		e.preventDefault();
		var that = this;

		if (this.fetched == false) {
			this.model.fetch({success: function () {
				that.toggleButtons($(e.target));
				that.fetched = true;
			}});
		} else {
			that.toggleButtons($(e.target));
		}
	},
	toggleButtons: function(target) {
		this.$el.find('.static').hide();

		this.fetchOptions();
		target.hide();
		this.$el.find('.actions').show();			
	},
	renderCompanyDropdown: function() {
		company_options = $('<select></select>').attr('id', 'company_id');
		company_options.append($('<option></option>').val('').text('Select...'));

		$(this.companies).each(function(index, company) {
			company_options.append($('<option></option>').val(company.company_id).text(company.company));
		});

		company_options.val(this.model.get('company_id'));
		
		$('#company').after(company_options);
	},
	renderDepartmentDropdown: function() {
		department_options = $('<select></select>').attr('id', 'department_id');
		department_options.append($('<option></option>').val('').text('Select...'));

		$(this.departments).each(function(index, department) {
			department_options.append($('<option></option>').val(department.department_id).text(department.department));
		});

		department_options.val(this.model.get('department_id'));

		$('#department').after(department_options);
	},	
	renderDivisionsDropdown: function() {
		division_options = $('<select></select>').attr('id', 'division_id');
		division_options.append($('<option></option>').val('').text('Select...'));

		$(this.divisions).each(function(index, division) {
			division_options.append($('<option></option>').val(division.division_id).text(division.division));
		});

		division_options.val(this.model.get('division_id'));

		$('#division').after(division_options);
	},	
	renderPositionDropdown: function() {
		position_options = $('<select></select>').attr('id', 'position_id');
		position_options.append($('<option></option>').val('').text('Select...'));

		$(this.positions).each(function(index, position) {
			position_options.append($('<option></option>').val(position.position_id).text(position.position));
		});

		position_options.val(this.model.get('position_id'));

		$('#position').after(position_options);
	},	
	fetchOptions: function() {
		// Get companies
		if (this.companies == null) {
			var that = this;
			$.ajax({
				url: BASE_URL + 'api/companies',
				success: function(response) {
					that.companies = response.data;
					that.renderCompanyDropdown();
				}
			});
		} else {
			this.renderCompanyDropdown();
		}

		// Get departments
		if (this.departments == null) {
			var that = this;
			$.ajax({
				url: BASE_URL + 'api/departments',
				success: function(response) {
					that.departments = response.data;
					that.renderDepartmentDropdown();
				}
			});
		} else {
			this.renderDepartmentDropdown();
		}

		// Get divisions
		if (this.divisions == null) {
			var that = this;
			$.ajax({
				url: BASE_URL + 'api/divisions',
				success: function(response) {
					that.divisions = response.data;
					that.renderDivisionsDropdown();
				}
			});
		} else {
			this.renderDivisionsDropdown();
		}

		// Get positions
		if (this.positions == null) {
			var that = this;
			$.ajax({
				url: BASE_URL + 'api/positions',
				success: function(response) {
					that.positions = response.data;
					that.renderPositionDropdown();
				}
			});
		} else {
			this.renderPositionDropdown();
		}
	}
});

// --------------------------------------------------------------------
// 

var EmploymentEditView = Backbone.View.extend({	
	el: '#employment-information',
	employmentTypes: null,
	employmentStatuses: null,
	initialize: function() {
		this.$el.find('h3:first').after('<div class="pull-right button-container"><a href="#" class="edit">Edit</a></div>');
		
		actions = '<button type="button" class="btn cancel actions">Cancel</button>&nbsp;';
		actions += '<button type="button" class="btn actions btn-primary" data-loading-text="Saving...">Save</button>';

		this.$el.find('.button-container').append(actions);
		this.$el.find('.actions').hide();
	},
	events: {
		"click a.edit" : "edit",
		"click .btn-primary" : "save",
		"change input,select" : "change",
		"click .cancel" : "cancel"
	},
	cancel: function() {
		this.$el.find('.static').show();
		this.$el.find('select,input').remove();
		this.$el.find('.actions').hide();
		this.$el.find('a.edit').show();
	},
	change: function(e) { 		
    	change = {};
    	change[$(e.target).attr('id')] = $(e.target).val();    	    	
    	this.model.set(change);
	},
	save: function(e) {
		$(e.target).attr('disabled', true).text('Saving...');
		var that = this;
		this.model.save('', '', {
			success: function (model) {
				$(e.target).removeAttr('disabled').text('Save');
				that.$el.find('#employment_status').text(that.model.get('employment_status'));
				
				hire_date = new Date(model.get('hire_date'));				
				regular_date = new Date(model.get('regular_date'));

				that.$el.find('#span_regular_date').text(window.monthNames[regular_date.getMonth()] + ' ' + regular_date.getUTCFullYear());
				that.$el.find('#span_hire_date').text(window.monthNames[hire_date.getMonth()] + ' ' + hire_date.getUTCFullYear());
				that.$el.find('abbr.timeago').attr('title', model.get('hire_date'));
				that.$el.find('abbr.timeago').text(hire_date);

				that.$el.find('abbr.timeago').timeago();
				that.$el.find('.message-container').html('<span class="label label-success">Changes saved.</span>');
				that.cancel();
			}
		});
	},
	edit: function(e) {
		e.preventDefault();
		var that = this;		
		this.model.fetch({success: function () {
			if (that.employmentStatuses == null) {				
				$.ajax({
					url: BASE_URL + 'api/admin_options/masters?option_group=EMPLOYMENT-STATUS',
					success: function(response) {
						that.employmentStatuses = response.data;
						that.renderStatusDropdown();
					}
				});
			} else {
				that.renderStatusDropdown();
			}

			hire_date = '<input type="hidden" id="hire_date" />'+
                '<input type="text" class="input-medium datepicker" rel="hire_date" />';

			$('#span_hire_date').after(hire_date);
	        $('#hire_date').val(that.model.get('hire_date'));

			regular_date = '<input type="hidden" id="regular_date" />' + 
                '<input type="text" class="input-medium datepicker" rel="regular_date" />';

            $('#span_regular_date').after(regular_date);
            $('#regular_date').val(that.model.get('regular_date'));            

	        $('.datepicker').each(function(index, e) {
	            var alt = "#" + $(e).attr('rel');
	            $(e).datepicker({
	                altField : alt,
	                altFormat: "yy-mm-dd",
	                onSelect: function(dateText, inst) {
	                    $(alt).trigger('change');
	                }
	            });

	            $(e).datepicker("setDate", new Date($(alt).val()));
	        });
			
			that.$el.find('.static').hide();
			$(e.target).hide();
			that.$el.find('.actions').show();
		}});
	},
	renderStatusDropdown: function() {
		status_options = $('<select></select>').attr('id', 'status_id');
		status_options.append($('<option></option>').val('').text('Select...'));

		$(this.employmentStatuses).each(function(index, status) {
			status_options.append($('<option></option>').val(status.option_id).text(status.option));
		});

		status_options.val(this.model.get('status_id'));

		$('#employment_status').after(status_options);		
	}
});