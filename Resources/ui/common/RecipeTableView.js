var RecipeDetailsView = require('ui/common/RecipeView');
var RecipeModel = require('model/RecipeModel');
var Util = require('lib/Util');

/**
 * Table that holds all of the recipes
 * 
 * @param {Array} recipes
 * @param {Function} rowClickEvent
 * @param {Function} bottomEvent
 * 
 * @method _addRecipe(data, isEnd)
 * @method _ reloadData(data, callback)
 * 
 * @event RecipeTableView:reloadTable
 * @event RecipeTableViewRow:clickEvent
 * @event RecipeTableView:bottom { recipes: {Array}, rows: {Array} }
 * 
 */
function RecipeTableView(recipes, rowClickEvent, bottomEvent) {
	
	// recipe data
	var data = [];
	var lastRow = data.length;
	
	// create the table view
	var self = Ti.UI.createTableView({
		data: data,
		backgroundColor: 'White', // android defaults to transparent
		_lock: false,
	});
	
	// The following is used for the reloading feature
	var border = Ti.UI.createView({
		backgroundColor: '#576c89',
		height: 2,
		bottom: 0,
	});
	
	var tableHeader = Ti.UI.createView({
		backgroundColor: '#e2e7ed',
		width: 320,
		height: 60,
	});

	// fake it till ya make it... create a 2 pixel bottom border
	tableHeader.add(border);
	
	var arrow = Ti.UI.createView({
		backgroundImage: '/images/graphics/whiteArrow.png',
		width: 23,
		height: 60,
		bottom: 10,
		left: 20,
	});
	
	var statusLabel = Ti.UI.createLabel({
		bottom: 30,
		color: '#576c89',
		font: { fontSize: 13, fontWeight: 'bold', },
		height: 'auto',
		left: ;55,
		shadowColor: '#999',
		shadowOffset: { x: 0, y: 1 },
		text: 'Pull to reload',
		textAlign: 'center',
		width: 200,
	});
	
	var lastUpdatedLabel = Ti.UI.createLabel({
		text: 'Last Updated: ' + Util.formatDate(),
		left: 55,
		width: 275,
		bottom: 15,
		height: 'auto',
		color: '#576c89',
		textAlign: 'center',
		font: { fontSize: 12 },
		shadowColor: '#999',
		shadowOffset: { x: 0, y: 1 },
	});
	
	var actIndicator = Ti.UI.createActivityIndicator({
		left: 20,
		bottom: 13,
		with: 30,
		height: 30,
	});
	
	tableHeader.add(arrow);
	tableHeader.add(statusLabel);
	tableHeader.add(lastUpdatedLabel);
	tableHeader.add(actIndicator);
	
	// pull view
	self.headerPullView = tableHeader;

	var pulling = false;
	var reloading = false;
	var dataLoading = false;
	
	// function to start reload
	// calls back to the window, then the window will get the data
	// and set it with the ._endReloading function
	function beginReloading() {
		// just mock out the reload
		setTimeout(function() {
			self.fireEvent('RecipeTableView:reloadTable', {});
		}, 2000);
	};
	
	/**
	 * Function fired after the table view has been pulled to reload
	 */
	self._endReloading = function() {
		// contentinsets facilitates a margin, or inset, distance
		// between the contet and the container scroll view
		self.setContentInsets({ top: 0 }, { animated: true });
		// we are no longer reloadings
		reloading = false;
		// update the text with a timestamp of when it was last updated
		lastUpdatedLabel.text = 'Last Updated: ' + Util.formatDate();
		statusLabel.text = 'Pull down to refresh. . .';
		
		// hide the activity indicator
		actIndicator.hide();
		// show the arrow again
		arrow.show();
	};
	
	
}





