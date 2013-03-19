var AboutModel = Backbone.Model.extend({
    defaults: {
        user_id: '',
        about_me: '',
        talent: '',
        movies: '',
        music: '',
        website: '',
        photo: ''
    },
    url: function () {
        return BASE_URL + 'api/user/id/' + this.get('user_id') + '/about';
    },
    validate: function (attrs) {
        // Return error message
    }
});

var AboutView = Backbone.View.extend({
    el: $('#about-tab'),
    initialize: function () {
        this.$el.find('#cancel-btn').hide();
    },
    events: {
        "click #edit-btn": "toggleInput",
        "click #cancel-btn": "toggleDisplay",
        "click #save-btn": "saveAbout",
    },
    toggleInput: function (e) {
        e.preventDefault();
        this.$el.find('.ab').each(function(index, elem) {
            var val;
            if ($(elem).attr('id') != 'website') {
                val = $(elem).html();
            } else {
                val = $('#website a').text();
            }

            var input;
            if ($(elem).hasClass('ab-txtarea')) {
                input = $('<textarea class="span" rows="5"></textarea>');
            } else if ($(elem).hasClass('ab-input')) {
                input = $('<input type="text"></input>');
            }

            input.attr('name', $(elem).attr('id')).val(val);
            $(elem).html(input);
        });

        this.$el.find('#edit-btn').hide();
        this.$el.find('#save-btn').show();
        this.$el.find('#cancel-btn').show();
    },
    toggleDisplay: function (e) {
        e.preventDefault();

        this.$el.find('.ab input, .ab textarea').each(function(index, elem) {
            if ($(elem).parent('p').attr('id') != 'website') {
                val = $(elem).val();
            } else {
                val = $('<a></a>').attr('href', $(elem).val()).attr('target', '_blank').text($(elem).val());
            }

            $(elem).parent('p').html(val);
        });

        this.$el.find('#edit-btn').show();
        this.$el.find('#save-btn').hide();
        this.$el.find('#cancel-btn').hide();
    },
    saveAbout: function (e) {
        var that = this;
        var d = Array;
        $.map($('.ab input, .ab textarea').serializeArray(), function(n, i) {
            d[n['name']] = n['value'];
        });
        this.options.model.save(d, {
            success: function (model, response) {
                alert = new AlertView({type: 'success', message: 'Update success.'});
                alert.render();
                $('#cancel-btn').trigger('click');
            },
            error: function (model, response) {
                alert = new AlertView({type: 'error', message: response});
                alert.render();
            },
        });
    }
});

var AlertView = Backbone.View.extend({
    el: $('#alert-div'),    
    template: $('#alertTemplate').html(),
    render: function () {
        var tmpl = _.template(this.template);
        var p = Array;
        p['type'] = this.options.type;
        p['message'] = this.options.message;
        this.$el.html(tmpl(p));

        return this;
    }
});