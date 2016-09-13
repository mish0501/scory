(function() {

	var menu 					= document.getElementById('menu'),
			scrollBarPos 	= scroll.currentYPosition();

	$('#navbar').on('show.bs.collapse', function () {
		if (scroll.currentYPosition() === 0) {
			if (menu.className !== 'navbar navbar-inverse navbar-fixed-top bg') {
				menu.className = 'navbar navbar-inverse navbar-fixed-top bg';
			}
		}
	});
	$('#navbar').on('hidden.bs.collapse', function () {
		if (scroll.currentYPosition() === 0) {
			if (menu.className === 'navbar navbar-inverse navbar-fixed-top bg') {
				menu.className = 'navbar navbar-inverse navbar-fixed-top';
			}
		}
	});

	$('.nav li.menu-item a').on('click', function() {
		$('#navbar').collapse('hide');
	});

	window.onscroll = function() {
		header.update();
	};

	scroll.scrollEffect();
}());
