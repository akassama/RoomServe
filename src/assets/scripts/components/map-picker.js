var map;
var position;
var marker;
var lat_input;
var lng_input;
var full_address;
var country_inputs;
var city_input;
var area_input;
var street_input;

function initMapPicker() {
	lat_input 			= $('input[name="form[latitude]"]');
	lng_input 			= $('input[name="form[longitude]"]');
	full_address		= $('input[name="form[full_address]"]');
	country_input 		= $('input[name="form[country]"]');
	city_input 			= $('input[name="form[city]"]');
	area_input 			= $('input[name="form[area]"]');
	street_input 		= $('input[name="form[street]"]');

	// Options
	var options = {
		map: 'pls_map-picker',
		position: {
			lat: 25.207642,
			lng: 55.270637
		},
		zoom: 12,
		icon: {
		    url: '/assets/icons/admin/others/other-map-pin.svg',
		    scaledSize: new google.maps.Size(32, 32),
		},
		marker_visible: false,
		marker_title: 'Drag this Marker'
	}

	// Get position
	if (lat_input.val() && lng_input.val() && lat_input.val() != 0 && lng_input.val() != 0) {
		options.position = {
			lat: parseFloat(lat_input.val()),
			lng: parseFloat(lng_input.val())
		}
		options.marker_visible = true;
	}

	// Map init
  	map = new google.maps.Map(document.getElementsByClassName(options.map)[0], {
    	zoom: options.zoom,
	    center: options.position,
	    disableDoubleClickZoom: true,
	    mapTypeControl: false,
	    streetViewControl: false
  	});

  	// Convert position for marker
  	position = new google.maps.LatLng(options.position);

  	// Create marker
  	marker = new google.maps.Marker({
		position: position,
		map: map,
		title: options.marker_title,
		icon: options.icon,
		draggable: true,
		visible: options.marker_visible
	});

  	// Set position on doubleclick 
  	map.addListener('dblclick', function(e) {
  		searchAddress({"location": e.latLng});
    });

    // Set position on marker move 
  	marker.addListener('dragend', function(e) {
  		searchAddress({"location": marker.position});
    });
}

// Get address part
function getAddressParts(obj) {

    var address = [];

    obj.address_components.forEach( function(el) {
        address[el.types[0]] = el.short_name;
    });

    return address;

}

// Geocode
function searchAddress(search) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode(search, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			// map.setZoom(12);
			setMarkerPosition(marker, results[0].geometry.location, results, lat_input, lng_input);

			// console.log(results);
		}
	});
}

// Update position
function setMarkerPosition(marker, position, address, lat_input, lng_input) {
	map.setCenter(position);
	marker.setPosition(position);
  	marker.setVisible(true);

  	lat_input.val( position.lat() );
  	lng_input.val( position.lng() );

  	var addressParts =  getAddressParts(address[0]);

  	// full_address
  	if (!full_address.val() || full_address.hasClass('from_map')) {
  		full_address.val(address[0].formatted_address).addClass('from_map');
  	}

	// country
	country_input.val(addressParts.country);

    // the city
    city_input.val(addressParts.locality);

    // the area
    area_input.val(addressParts.political);

    // the street
    street_input.val(addressParts.route);
}

$(document).on('ready', function() {
	$("body").on("keypress", ".pls_map-picker-search input", function(e) {
		if (e.which == 13) {
			$(".pls_map-picker-search button").trigger("click");
			e.preventDefault();
		}
	});

	$("body").on("click", ".pls_map-picker-search button", function(e) {
		e.preventDefault();
		var value = $(this).closest('div').find('input').val();

		searchAddress({"address": value});
	});

	$("body").on("keypress", "input[name='form[full_address]']", function() {
		$(this).removeClass('from_map');
	});
});