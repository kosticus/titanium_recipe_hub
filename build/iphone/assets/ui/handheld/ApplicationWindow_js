function ApplicationWindow() {
	var recipe = {
		recipe_id: 1,
		title: 'Recipe Title',
		description: 'Recipe Description',
		author_id: 1,
		prep_time: 10,
		cook_time: 15,
		serving_size: 4,
		categories: [{
			category_id: 1,
			category_name: 'Breakfast',
		}],
		rating: {
			avg: 5.9,
			count: 10,
		},
	};
	
	var self = Ti.UI.createWindow({
		title: 'Recipes',
		backgroundColor: 'White',
	});
	
	var RecipeView = require('ui/common/RecipeView');
	var recipeView = new RecipeView(recipe);

	self.add(recipeView);
	
	return self;
};

module.exports = ApplicationWindow;
