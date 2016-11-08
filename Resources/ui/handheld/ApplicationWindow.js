// models
var UserModel = require('model/UserModel');
var RecipeModel = require('model/RecipeModel');
var CategoryModel = require('model/CategoryModel');
var MeasurementModel = require('model/MeasurementModel');

// views
var RecipeTableView = require('ui/common/RecipeTableView');
var MenuView = require('ui/common/MenuView');
// var PopupView = require('ui/common/PopupView');

// constants
var SEARCH_LIMIT = Ti.App.Properties.getInt('search_limit');

/**
 * Application window for all handheld devices
 */
function ApplicationWindow() {
	var self = Ti.UI.createWindow({
		title : 'Recipes',
	});

	var menuButton,
	    menuView,
	    view,
	    recipeTableView,
	    refreshButton;

	// we need to add the refresh button for the android

	if (Util.isAndroid()) {
		// fired when window is opened
		self.addEventListener('open', function(openEvent) {
			var activity = openEvent.source.getActivity();
			var actionBar = activity.actionBar;

			// Menu Item Specific Code
			activity.onCreateOptionsMenu = function(onCreateEvent) {
				var menu = onCreateEvent.menu;

				// Menu Item 1
				menuButton = menu.add({
					title : 'Menu',
					icon : '/images/button/button-menu@2x.png',
					showAsAction : Ti.Android.SHOW_AS_ACTION_ALWAYS,
					_toggle : true,
				});
				menuButton.addEventListener('click', displayMenu);

				refreshButton = menu.add({
					title : 'Refresh',
					icon : '/images/buttons/button-refresh.png',
					showAsAction : Ti.Android.SHOW_AS_ACTION_ALWAYS,
					_toggle : true,
				});
				refreshButton.addEventListener('click', reloadTableEvent);
			};
		});
	} else {
		// just need to add the refresh button since the reload
		// is built into the table view
		menuButton = Ti.UI.createButton({
			image : '/images/buttons/button-menu.png',
			_toggle : true
		});
		self.setLeftNavButton(menuButton);
	}

	// Object used for seraching, note: the RecipeModel documentation
	var searchCriteria = {
		limit : SEARCH_LIMIT,
		offset : 0,
		sortBy : null,
		filterBy : null,
		search : null,
	};

	/**
	 * Table View Row Detail Click Event
	 *
	 * @param {Object} e
	 */
	function rowClickEvent(e) {
		Ti.App.fireEvent('openWindow', {
			window : 'ui/common/RecipeDetailWindow',
			arg : e.recipe
		});
	};

	/**
	 * Handles the animation to display and hide the menu
	 * @param {Object|Boolean} e
	 */
	var displayMenu = function(e) {
		var toggle;
		// check if we are passed a boolean or an object
		if (e.source) {
			if (e.source._toggle === undefined) {
				e.source._toggle = true;
			}
			toggle = e.source._toggle;
		} else {
			toggle = e;
		}

		if (!toggle) {
			view.animate({
				curve : Ti.UI.ANIMATION_CURVE_EASE_IN_OUT,
				left : 0,
				duration : 250 // 1/4 second
			});
			menuButton._toggle = true;
		} else {
			view.animate({
				curve : Ti.UI.ANIMATION_CURVE_EASE_IN_OUT,
				left : 150,
				duration : 250 // 1/4 second
			});
			menuButton._toggle = false;
		}
	};

	if (!Util.isAndroid()) {
		menuButton.addEventListener('click', displayMenu);
	}

	/**
	 * Event for the menu row click
	 * @param {Object} e
	 *
	 */
	var menuRowClickEvent = function(e) {
		displayMenu(false);
		// TODO create row click events, wait until
		// after we have created our popupview
	};

	var reloadTableEvent = function(e) {
		if (!Util.isAndroid()) {
			recipeTableView.scrollToTop();
		}
		// reset the offset otherwise the table will be empty
		searchCriteria.offset = 0;

		recipeTableView._lock = false;
		recipeTableView._endReloading();
		reloadRecipes(searchCriteria);
	};

	var recipeBottomEvent = function(e) {
		searchCriteria.offset += searchCriteria.limit;
		RecipeModel.getAll(searchCriteria, function(results) {
			// time
			setTimeout(function() {
				var isEnd = false;
				if (results.length < searchCriteria.limit) {
					isEnd = true;
				}
				recipeTableView._addRecipes(results, isEnd);
			}, 1000);
		});
	};

	view = Ti.UI.createView({
		width : '100%'
	});
	menuView = new MenuView(menuRowClickEvent);

	self.add(menuView);
	self.add(view);

	// table view with the recipes
	recipeTableView = new RecipeTableView(null, rowClickEvent, recipeBottomEvent);
	view.add(recipeTableView);

	/**
	 * Reloads the recipes
	 * @param {SearchCriteria}
	 */
	var reloadRecipes = function(criteria) {
		RecipeModel.getAll(criteria, function(result) {
			if (result === null) {
				result = [];
			}
			recipeTableView._reloadData(result);
		});
	};

	// initial loading of the recipes
	reloadRecipes(searchCriteria);

	// handles the click event for the Recipe Table row to view the recipe details
	// self.addEventListener('RecipeTableviewRow:clickEvent', rowClickEvent);

	// Handles the click event for the menu items
	// self.addEventListener('MenuView:rowClickEvent', menuRowClickEvent);

	// fetches new data when the bottom of the table is reached
	// self.addEventListener('RecipeTableView:bottom', recipeBottomEvent);

	// reloads the table when the menu is pulled down
	// feature is for ios only
	self.addEventListener('RecipeTableView:reloadTable', reloadTableEvent);

	// If the user is not logged in, send them to the login window
	/*
	if (UserModel.getUser() === null) {
	setTimeout(function() {
	Ti.App.fireEvent('openWindow', {
	window: '/ui/common/LoginWindow',
	});
	}, 250);
	}
	*/

	// when the window displays we should reload the menu to make sure the
	// proper items are displayed
	self.addEventListener('focus', function(e) {
		menuView._reloadData();
	});

	return self;
};

module.exports = ApplicationWindow; 