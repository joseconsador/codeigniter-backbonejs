// Supported options : 
// {
// 	name: <string>,
// 	id: <int>,
// 	max_points: <int>,
// 	num_options: <int>
// }
var StarRating = function(options) {
	this.options = options;

	this.points_per = Math.ceil(this.options.max_points / this.options.num_options);

	this.render = function() {
		var stars = '';
		var ctr = 1;

		while (ctr <= this.options.num_options) {
			points = this.points_per * ctr;			

			input = $('<input type="radio" />');
			input.attr({
				name: this.options.name + this.options.id,
				class: 'star ' + this.options.name,
				value: points
			});

			if (points == this.options.default) {
				input.attr('checked', 'checked');
			}

			stars += input[0].outerHTML;
			ctr++;
		}        

		return stars;
	};
};