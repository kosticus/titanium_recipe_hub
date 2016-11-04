// this sets the background color of the master UIView (when there are no windows/tab groups on it)
Titanium.UI.setBackgroundColor('#000');
var Util = require('lib/Util');

// keep track of our window history
var history = [];

// create navigation group
var navInit, ApplicationWindow, currentWindow, self;

// get the application folder based on if the device is a tablet or handheld
if (Util.isTablet()) {
	ApplicationWindow = require('ui/tablet/ApplicationWindow');
	self = new ApplicationWindow();
} else {
	// check if the device is ios, android or mobile web
	ApplicationWindow = require('ui/handheld/ApplicationWindow');
	
	if (Util.isIPhone()) {
		navInit = Ti.UI.iOS.createNavigationWindow;
	} else if (Util.isAndroid()) {
		navInit = false;
	} else {
		navInit = Ti.UI.MobileWeb.createNavigationGroup;
	}
	
	var applicationWindow = new ApplicationWindow();
	// ios, blackberry, or mobileweb
	if (navInit !== false) {
		self = navInit({ window: applicationWindow });
	} else {
		// android
		self = applicationWindow;
	}
}

// handles the handheld navigation group, the tablet will be handled in its application window.js
if (!Util.isTablet()) {
	// set up global event listeners
	Ti.App.addEventListener('openWindow', function(e) {
		var NewWindow = require(e.window);
		var neWindow = new NewWindow(e.arg);
		
		// we don't use a navigation group with android
		if (Util.isAndroid()) {
			newWindow.open();
		} else {
			self.openWindow(newWindow, { animated: true });
		}
		
		history.push({
			window: newWindow,
			arg: e.arg,
		});
	});
	
	Ti.App.addEventListener('closeWindow', function(e) {
		currentWindow.history.pop();
		currentWindow.window.close();
	});
}

// initialize app
self.open();





