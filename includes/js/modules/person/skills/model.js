// --------------------------------------------------------------------
// 
var SkillModel = Backbone.Model.extend({
    defaults: {
        person_id: 0,
        skill_type_id: '',
        skill: '',
        proficiency_id: '',
        remarks: ''        
    },
	url: function() {
    	if (this.isNew()) {
    		return BASE_URL + 'api/skill';
    	} else {
    		return BASE_URL + 'api/skill/id/' + this.get('id');
    	}
    }	
});

// --------------------------------------------------------------------
// 

var SkillsCollection = Backbone.Collection.extend({
    model: SkillModel,
});