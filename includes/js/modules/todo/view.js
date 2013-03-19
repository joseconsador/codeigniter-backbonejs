var TodoInputView = Backbone.View.extend({
	el: $('#todo-form'),
	events: {		
		'keyup input'  : 'checkKeyPress',
		'submit' : 'preventSubmit',
		'click #todo-submit' : 'saveTodo'
	},	
	checkKeyPress: function(e) {
		if (e.keyCode == 13) {
			this.saveTodo();
		}
	},
	preventSubmit: function(e) {
		e.preventDefault();
	},
	saveTodo: function() {
		var that = this;
		this.model.set('description', this.$el.find('input[name="description"]').val());
		this.model.set('target_date', this.$el.find('input[name="target_date"]').val());

		this.model.save('', '', {
			success: function() {
				that.$el.val('');
				that.setModel(new TodoModel());
				that.trigger('add');
			},
			error: function(model, xhr) {
				console.log(xhr);
			}
		});
	},
	setModel: function(model) {
		this.model = model;

		this.$el.find('input[name="description"]').val(this.model.get('description'));
		tdate = new Date(this.model.get('target_date'));

		if (!isValidDate(tdate)) {
			tdate = null;
		}

		$('#dpicker_target').datepicker("setDate", tdate);
	}
});

var TodoListView = Backbone.View.extend({
	el: $('#todo-container'),
	initialize: function() {
		this.collection.on('reset', this.renderAll, this);
	},
	renderAll: function() {
		this.$el.empty();
		_.each(this.collection.models, this.renderOne, this);
	},
	renderOne: function(item) {
		todo = new TodoItemView({model: item});

		this.$el.append(todo.render().el);
		item.on('sync', function() {
			this.collection.fetch();
		}, this);

		item.on('edit', function() {
			this.options.inputView.setModel(item);
		}, this);

		item.on('delete', function() {
			this.options.inputView.setModel(new TodoModel);
		}, this);		
	}
});

var TodoItemView = Backbone.View.extend({
	template: $('#todo-item-template').html(),
	render: function() {
        var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
	},	
	events: {
		'change .completed-toggler' : 'toggleStatus',
		'click .todo-delete' : 'delete',
		'click .todo-edit' : 'edit'
	},
	toggleStatus: function(e) {
		this.model.set('completed', $(e.target).is(':checked'));
		this.model.set('action', 'toggle_status');
		this.model.save('', {patch: true});
		this.model.unset('action');
	},
	delete: function(e) {
		this.model.destroy();
		this.model.trigger('delete');
		this.remove();
	},
	edit: function() {
		this.model.trigger('edit');
	}
});