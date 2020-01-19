window.onload = function () {
	var latLng2 = new google.maps.LatLng(25.6942417,-100.3523567,20.33);
	var stylez = [{
			featureType: "all",
			elementType: "all",
			stylers: [{
					saturation: -100
			}]
	}];
	var myOptions = {
			zoom: 15,
			center: latLng2,
			panControl: false,
			mapTypeControlOptions: {
					mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.TERRAIN, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID, 'grayscale'],
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
			},
			zoomControlOptions: {
					style: google.maps.ZoomControlStyle.SMALL,
					position: google.maps.ControlPosition.TOP_LEFT
			},
			mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	map2 = new google.maps.Map(document.getElementById("googleMap"), myOptions);
	var mapType = new google.maps.StyledMapType(stylez, {
			name: "Escala grises"
	});
	map2.mapTypes.set('grayscale', mapType);
	map2.setMapTypeId('grayscale');
	var marker2 = new google.maps.Marker({
			position: latLng2,
			map: map2
	});

	google.maps.event.addListener(marker2, 'click', function () {
			infowindow2.open(map2, marker2);
	});

}

