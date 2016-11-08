var Util = require('lib/Util');
var BaseModel = require('model/BaseModel');

// create the category model that inherits from the BaseModel
var RecipeModel = new BaseModel('Recipe.php');

/**
 * 
 * Gets all of the recipes based upon the criteria
 * 
 * @param {Object} criteria
 * @param {Function} callback
 */
RecipeModel.getAll = function(criteria, callback) {
	crtieria = criteria || {};
	this.GET(criteria, callback);
};

/**
 * Inserts a recipe
 * 
 * @param {Object} recipe
 * @param {Function} callback
 */
RecipeModel.insert = function(recipe, callback) {
	// prep array for PHP
	recipe.instructions = JSON.stringify(recipe.instructions);
	recipe.ingredients = JSON.stringify(recipe.ingredients);
	recipe.categories = JSON.stringify(recipe.categories);
	
	this.POST(recipe, callback);
};

module.exports = RecipeModel;

