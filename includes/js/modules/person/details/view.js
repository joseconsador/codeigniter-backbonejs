// --------------------------------------------------------------------
// 
var EditPersonDetailView = Backbone.View.extend({
	fetched: false,
	el: '#person-details',
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
		this.$el.find('input,select').remove();
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
				that.$el.find('.message-container').html('<span class="label label-success">Changes saved.</span>');

				//----- Maiden_name ----//
				$('#span-maiden-name').text(model.get('maiden_name'));
				
				//----- Place of birth ----//
				$('#span-birth-place').text(model.get('birth_place'));

				//----- Gender ----//
				$('#span-gender').text(model.get('gender'));

				//----- Nationality ----//
				$('#span-nationality').text(model.get('nationality'));

				//----- Height ----//
				$('#span-height').text(model.get('height'));

				//----- Weight ----//
				$('#span-weight').text(model.get('weight'));

				//----- Blood_type ----//
				$('#span-blood-type').text(model.get('blood_type'));

				//----- Birth Date ----//
				_birth_date = new Date(model.get('birth_date'));
				birth_date = monthNames[_birth_date.getMonth()] + ' ' + _birth_date.getDate() + ', ' + _birth_date.getUTCFullYear();
				$('#span-birth-date').text(birth_date);

				//----- Civil_status ----//
				$('#span-civil-status').text(model.get('civil_status'));				
				
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
			this.toggleButtons($(e.target));
		}
	}, 
	toggleButtons: function(button) {
		this.$el.find('.static').hide();
		button.hide();
		this.$el.find('.actions').show();
		this.toggleInput();
	},
	toggleInput: function() {
		//----- Nick_name ----//
		nick_name = $('<input type="text"></input>')
			.attr('id', 'nick_name').val(this.model.get('nick_name'));

		$('#span-nick-name').after(nick_name);

		//----- Maiden_name ----//
		maiden_name = $('<input type="text"></input>')
			.attr('id', 'maiden_name').val(this.model.get('maiden_name'));

		$('#span-maiden-name').after(maiden_name);

		//----- Place of birth ----//
		birth_place = $('<input type="text"></input>')
			.attr('id', 'birth_place').val(this.model.get('birth_place'));

		$('#span-birth-place').after(birth_place);

		//----- Gender ----//
		gender = $('<select></select>').attr('id', 'gender');		

		gender.append($('<option></option>').val('Male').text('Male'));
		gender.append($('<option></option>').val('Female').text('Female'));

		gender.val(this.model.get('gender'));

		$('#span-gender').after(gender);		

		//----- Nationality ----//
		nationality = $('<input type="text"></input>')
			.attr('id', 'nationality').val(this.model.get('nationality'));

		$('#span-nationality').after(nationality);

		//----- Height ----//
		height = $('<input type="text"></input>')
			.attr('id', 'height').val(this.model.get('height'));

		$('#span-height').after(height);				

		//----- Weight ----//
		weight = $('<input type="text"></input>')
			.attr('id', 'weight').val(this.model.get('weight'));

		$('#span-weight').after(weight);

		//----- Blood_type ----//
		blood_type = $('<input type="text"></input>')
			.attr('id', 'blood_type').val(this.model.get('blood_type'));

		$('#span-blood-type').after(blood_type);

		//----- Birth Date ----//
		birth_date = '<input type="hidden" id="birth_date" />'+
                '<input type="text" class="input-medium datepicker" rel="birth_date" />';

		$('#span-birth-date').after(birth_date);

		$('#birth_date').val(this.model.get('birth_date'));

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

		//----- Civil_status ----//
		var statuses;
        $.ajax({
        	async: false,
            url: BASE_URL + 'api/admin_options/options?option_group=CIVIL-STATUS',
            success: function(response) {
                statuses = response.data;                
            }
        });
		
		civil_status = $('<select></select>').attr('id', 'civil_status_id');

		$.each(statuses, function(index, status) {
			civil_status.append($('<option></option>').val(status.option_id).text(status.option));
		});

		civil_status.val(this.model.get('civil_status_id'));

		$('#span-civil-status').after(civil_status);		
	}	
});