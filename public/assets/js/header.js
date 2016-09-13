var header = (function() {
	var menuItems	= document.getElementsByClassName('menu-item'),
			menu			= document.getElementById('menu');

	function activeMenu(n) {
		for (var i = 0; i < menuItems.length; i += 1) {
			if (i !== n) {
				menuItems[i].className = 'menu-item';
			}
		}

		if (menuItems[n].className === 'menu-item') {
			menuItems[n].className = 'menu-item active';
		}
	}

	function changeMenu() {
		var scrollBarPos = scroll.currentYPosition();

		if (scrollBarPos >= 1) {
			if (menu.className !== 'navbar navbar-inverse navbar-fixed-top bg') {
				menu.className = 'navbar navbar-inverse navbar-fixed-top bg';
			}
		} else {
			if (menu.className === 'navbar navbar-inverse navbar-fixed-top bg') {
				menu.className = 'navbar navbar-inverse navbar-fixed-top';

				for (var i = 0; i < menuItems.length; i += 1) {
					menuItems[i].className = 'menu-item';
				}
			}
		}

		if (scrollBarPos >= scroll.elmTopYPosition('about') && scrollBarPos < scroll.elmBottomYPosition('about') ) {
			activeMenu(0);
		} else if (scrollBarPos >= scroll.elmTopYPosition('student') && scrollBarPos < scroll.elmBottomYPosition('student') ) {
			activeMenu(1);
		} else if (scrollBarPos >= scroll.elmTopYPosition('teacher') && scrollBarPos < scroll.elmBottomYPosition('teacher') ) {
			activeMenu(2);
		} else if (scrollBarPos >= scroll.elmTopYPosition('contact') && scrollBarPos < scroll.elmBottomYPosition('contact') ) {
			activeMenu(3);
		}
	}

	return {
		update: changeMenu
	}
}());
