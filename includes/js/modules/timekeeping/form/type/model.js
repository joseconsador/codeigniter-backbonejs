// --------------------------------------------------------------------
// 
var FormType = Backbone.Model.extend({	
	idAttribute: 'form_id',	
    defaults: {
        form: '',
        form_code: '',
        annual_allocation: 5,
        paid: 0,
        convertible: 0,
        prorate: 0,
        accumulation: 0,
        accumulation_type: 0,
        employment_type_id: 0,
        tenure: 0,
        track: 1,
        gender: 'all',
        civil_status_id: 0,
        employment_status_id: 0
    },
    url: function () {
    	if (this.isNew()) {
        	return BASE_URL + 'api/formtype';
    	} else {
    		return BASE_URL + 'api/formtype/id/' + this.id;
    	}
    }
});

var FormTypeCollection = Backbone.Collection.extend({model: FormType});