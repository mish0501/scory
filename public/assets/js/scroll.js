var scroll = (function() {
	var scrollItems = document.getElementsByClassName('scroll-effect');

	function currentYPosition() {
		// Firefox, Chrome, Opera, Safari
		if (self.pageYOffset) return self.pageYOffset;
		// Internet Explorer 6 - standards mode
		if (document.documentElement && document.documentElement.scrollTop)
			return document.documentElement.scrollTop;
		// Internet Explorer 6, 7 and 8
		if (document.body.scrollTop) return document.body.scrollTop;
		return 0;
	}

	function elmTopYPosition(eID) {
		var elm = document.getElementById(eID);
		var y = elm.offsetTop - 50;
		var node = elm;
		while (node.offsetParent && node.offsetParent != document.body) {
			node = node.offsetParent;
			y += node.offsetTop;
		} return y;
	}

	function elmBottomYPosition(eID) {
		var elmHeight = document.getElementById(eID).offsetHeight,
			elmTop = elmTopYPosition(eID);

		return elmTop + elmHeight
	}

	function scrollToId (eID) {
		var startY = currentYPosition();
		var stopY = elmTopYPosition(eID);
		var distance = stopY > startY ? stopY - startY : startY - stopY;

		if (distance < 100) {
			scrollTo(0, stopY); return;
		}

		var speed = Math.round(distance / 100);

		if (speed >= 20) speed = 20;
		var step = Math.round(distance / 25);
		var leapY = stopY > startY ? startY + step : startY - step;
		var timer = 0;

		if (stopY > startY) {
			for ( var i=startY; i<stopY; i+=step ) {
				setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
				leapY += step; if (leapY > stopY) leapY = stopY; timer++;
			} return false;
		}

		for ( var i=startY; i>stopY; i-=step ) {
			setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
			leapY -= step; if (leapY < stopY) leapY = stopY; timer++;
		} return false;
	}

	function scrollEffect() {
		for(var z = 0; z < scrollItems.length; z += 1){
			var elem = scrollItems[z];
			elem.onclick = function(e){
				e.preventDefault();
				scroll.toID(this.getAttribute("data-scroll"));
			};
		}
	}

	return {
		scrollEffect: scrollEffect,
		toID: scrollToId,
		elmTopYPosition: elmTopYPosition,
		elmBottomYPosition: elmBottomYPosition,
		currentYPosition: currentYPosition
	};
}());
