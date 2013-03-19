var NoteModel = Backbone.Model.extend(
	{
		url: function () {			
			if (this.isNew()) {
				return BASE_URL + 'api/note'; 
			} else {
				return BASE_URL + 'api/note/id/' + this.get('id');
			}
		},
	}
);

var UserNoteModel = Backbone.Model.extend(
	{
		url: function () {			
			return BASE_URL + 'api/user/note';
		},
	}
);