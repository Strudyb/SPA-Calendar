function jacqueline_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof JACQUELINE_STORAGE['googlemap_init_obj'] == 'undefined') jacqueline_googlemap_init_styles();
	JACQUELINE_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		JACQUELINE_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: JACQUELINE_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		jacqueline_googlemap_create(id);

	} catch (e) {
		
		dcl(JACQUELINE_STORAGE['strings']['googlemap_not_avail']);

	};
}

function jacqueline_googlemap_create(id) {
	"use strict";

	// Create map
	JACQUELINE_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(JACQUELINE_STORAGE['googlemap_init_obj'][id].dom, JACQUELINE_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in JACQUELINE_STORAGE['googlemap_init_obj'][id].markers)
		JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	jacqueline_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (JACQUELINE_STORAGE['googlemap_init_obj'][id].map)
			JACQUELINE_STORAGE['googlemap_init_obj'][id].map.setCenter(JACQUELINE_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function jacqueline_googlemap_add_markers(id) {
	"use strict";
	for (var i in JACQUELINE_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (JACQUELINE_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (JACQUELINE_STORAGE['googlemap_init_obj'].geocoder == '') JACQUELINE_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			JACQUELINE_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			JACQUELINE_STORAGE['googlemap_init_obj'].geocoder.geocode({address: JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = JACQUELINE_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					JACQUELINE_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						jacqueline_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(JACQUELINE_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: JACQUELINE_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].title;
			JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (JACQUELINE_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				JACQUELINE_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				JACQUELINE_STORAGE['googlemap_init_obj'][id].map.setCenter(JACQUELINE_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in JACQUELINE_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								JACQUELINE_STORAGE['googlemap_init_obj'][id].map,
								JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			JACQUELINE_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function jacqueline_googlemap_refresh() {
	"use strict";
	for (id in JACQUELINE_STORAGE['googlemap_init_obj']) {
		jacqueline_googlemap_create(id);
	}
}

function jacqueline_googlemap_init_styles() {
	// Init Google map
	JACQUELINE_STORAGE['googlemap_init_obj'] = {};
	JACQUELINE_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.jacqueline_theme_googlemap_styles!==undefined)
		JACQUELINE_STORAGE['googlemap_styles'] = jacqueline_theme_googlemap_styles(JACQUELINE_STORAGE['googlemap_styles']);
}