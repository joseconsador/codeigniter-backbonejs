// --------------------------------------------------------------------
//

var AddMoreButton = Backbone.View.extend({
    template: $('#add-more-template').html(),
    events: {
        'click a': 'addMore'
    },
    addMore: function() {
        this.collection.push(new this.collection.model());
    },
    render: function () {
        var tmpl = _.template(this.template);               
        this.$el.html(tmpl());

        return this;
    }
});