/*
Helper scripts
*/



// Random ID
function randomID() {
	return Math.random().toString(36).substr(2, 8);
}


// Scroll to top
function scrollToTop() {
	$("html, body").animate({ scrollTop: 0 }, "slow");
}

// Check attribute
function checkAttr(attr, falseCheck) {
	falseCheck = (falseCheck != undefined)?falseCheck:true;

	if (falseCheck) {
		if (typeof attr !== typeof undefined && attr !== false) {
			if (attr !== "") {
				return true;
			}
		}
	}
	else {
		if (typeof attr !== typeof undefined) {
			if (attr !== "") {
				return true;
			}
		}
	}

	return false;
}

// Show block
function showBlockInit() {
	$('body').on('click', '[data-show]', function(e) {
		e.preventDefault();
		var btn = $(this);
		var block = $(btn.data('show'));
		var textClose = btn.data('textClose');
		var textOpen = btn.data('textOpen');
		var classClose = btn.data('classClose');
		var classOpen = btn.data('classOpen');

		if (btn.hasClass('active')) {
			block.addClass('hide').find('input, textarea, select').prop('disabled', true);
			btn.removeClass('active ' + classClose).addClass(classOpen).text(textOpen);
		}
		else {
			block.removeClass('hide').find('input, textarea, select').prop('disabled', false);
			btn.removeClass(classOpen).addClass('active ' + classClose).text(textClose);
		}
	})
}


// Remove item
function removeItem() {
	$('body').on('click', '[data-remove]', function(e) {
		e.preventDefault();
		var btn = $(this);
		var url = btn.data('remove');
		var redirect = btn.data('redirect');
		var type = btn.data('type');

		// check url
		if (checkAttr(url)) {

			// check redirect
			if (checkAttr(redirect)) { url = url+"?redirect=1"; }
			else { url = url+"?redirect=0"; }

			remove_alert(btn, url, type);
		}
	});
}


// Opening hours
function openingHours() {
	$('body').on('click', '.pls_opening-hours input[type=checkbox]', function(e) {
		var checkbox 		= $(this);
		var wrap 			= checkbox.closest('li');

		if (checkbox.is(':checked')) {
			wrap.addClass('active');
			wrap.find('input').prop('disabled', false);
		}
		else {
			wrap.removeClass('active');
			wrap.find('input[type=text]').prop('disabled', true);
		}
	});

	// global opening hours on/off
	$('body').on('click', '[data-opening-hours=all] input[type=checkbox]', function() {
		var self = $(this);
		var wrap = self.closest('.pls_opening-hours-wrap');
		var status = self.prop('checked');

		wrap.find('[data-opening-hours]:not([data-opening-hours=all])').each(function(v, k) {
			var day = $(this).find('input[type=checkbox]');
			if (day.prop('checked') !== status) {
				day.click();
			}
		});
	});

	// global opening hours open/close time
	$('body').on('change', '[data-opening-hours=all] input[type=text]', function() {
		var self = $(this);
		var wrap = self.closest('.pls_opening-hours-wrap');
		var elem = self.closest('li');
		var open = elem.find('.open-time').val();
		var close = elem.find('.close-time').val();

		wrap.find('[data-opening-hours]').each(function(v, k) {
			var hours = $(this);

			if ( !hours.data('openingHoursChanged') ) {
				if (self.hasClass('open-time')) {
					hours.find('.open-time').val(open);
				}
				if (self.hasClass('close-time')) {
					hours.find('.close-time').val(close);
				}
			}
		});
	});
}


// Get location opening hours
function getLocationOpeningHours(location_id) {

	$.ajax({
        type: 'POST',
        url: '/locations/get_opening_hours/'+(checkAttr(location_id)?location_id:''),
        dataType: "html",
        success: function (html) {
            $('.modal[data-id='+location_id+'] #modal-opening-hours').html(html);
            timepickerInit();
        },
    });

}


// Disabled form
function disabledForm() {
	$('.pls_disabled').find("input, textarea, select, .pls_selectpicker").prop("disabled", true);
}


// Custom dropdown
function customDropdown() {
	$('body').on('click', '[data-custom-dropdown-toggle]', function(e) {
		e.preventDefault();
		var self = $(this);
		var ID = self.data('customDropdownToggle');
		var menu = $('[data-custom-dropdown-menu='+ID+']');
		var wrap = menu.closest('.pls_filter-dropdown');

		if (wrap.hasClass('pls_open')) {
			wrap.removeClass('pls_open');
		}
		else {
			wrap.addClass('pls_open');
		}
	});
	
	$(".pls_filter-dropdown").bind( "clickoutside", function(e) {
		var self = $(this);
		self.removeClass('pls_open');
	});
}


// Get partner loyalty schemes
function getPartnerLoyaltySchemes() {

	$('select[data-get-loyalty-schemes]').on('change', function(e) {
		var self 		= $(this);
		var wrap 		= $('#pls_loyalty-schemes-wrap');
		var offer_id 	= self.data('getLoyaltySchemes');
		var venue_id 	= self.val();
		venue_id 		= venue_id?venue_id:self.data('value');

		if (venue_id) {
			$.ajax({
	        	type: 'POST',
		        url: '/admin/offers/get_partner_loyalty_schemes/',
		        data: {'venue_id': venue_id, 'offer_id': offer_id},
		        dataType: "html",
		        success: function (html) {
		           wrap.html(html);
		        },
		    });
		}

    }).change();

}


// Counter
function counterInit() {
	$('[data-counter=true]').each(function () {
		var self = $(this);
		var type = self.data('counterType');
		var zero = '';

		if (type == 'currency') {
			zero = true;
		}

	    self.prop('Counter',0).animate({
	        Counter: self.text()
	    }, {
	        duration: 1000,
	        easing: 'swing',
	        step: function (now) {
	            self.text(numberFormatExpress( Math.ceil(now), zero ));
	        }
	    });
	});
}


// Number format
function numberFormatExpress(x, zero) {
    return isNaN(x)?"":x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (zero?'.00':'');
}


// Back button
function backButtonInit() {
	$('[data-back=true]').on('click', function(e) {
		e.preventDefault();

		window.history.back();
	});
}


// Color to RGB
function colorToRgb(color) {
    return chroma(color).rgb().toString();
}


// Cancelation modal
function cancelationModal() {
	$('#pls_cancellation-modal').on('show.bs.modal', function (event) {
		var modal = $(this);
	  	var button = $(event.relatedTarget); // Button that triggered the modal
	  	var url = button.data('cancellationUrl');
	  	var ID = button.data('cancellationId');
	  	var prev_modal = button.closest('.modal');
	  	var form = modal.find('form');
	  	
	  	form.attr('action', url);
	  	modal.find('input[name="form[id]"]').val(ID);

	  	formValidateInit(form);

	  	if (prev_modal.length) {
	  		$('#'+prev_modal.attr('id')).modal('hide');
	  	}
	});
}


// Add new offer modal
function addNewOfferModal(partner_id) {
	$('body').on('click', '[data-new-offer]', function(e) {
		e.preventDefault();

		if (partner_id) {
			$.getJSON('/partner/'+partner_id+'/venues/check_venue_availability', function(result) {
				if (result) {
					addNewOfferToExistVenue(partner_id);
				}
				else {
					swal({
				        text: "Before you will add an offer you need to add the Venue/Brand to the system. Would you like to Continue?",
				        showCancelButton: true,
				        confirmButtonText: 'Yes',
				        cancelButtonText: 'No',
				        confirmButtonClass: 'pls_button color-success ico-color-white ico-check',
				        cancelButtonClass: 'pls_button color-grey',
				        buttonsStyling: false,
				        reverseButtons: true
				    }).then((result) => {
				    	if (result.value) {
				    		window.location.href = '/partner/'+partner_id+'/venues/create';
				    	}
				    });
				}
			});
		}
		else {
			addNewOfferToExistVenue(false);
		}

		
	 	
	});
}

//Alert - add new offer to exist venue
function addNewOfferToExistVenue(partner_id) {
	var venues_list = '/admin/venues/get_ajax_venues/0?draft=1';

	if (partner_id) {
		venues_list = '/partner/'+partner_id+'/venues/get_ajax_partner_venues';
	}

	swal({
        html: 'Select the venue that you would you like to add the offer? </br></br> <select name="venues" data-venues-list data-search="true" data-url="'+venues_list+'" class="pls_selectpicker"></select>',
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'pls_button color-success ico-color-white ico-check',
        cancelButtonClass: 'pls_button color-grey',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
    	if (result.value) {
    		var venue = $('select[data-venues-list]').val();

	    	if (venue) {
	    		if (partner_id) {
	    			window.location.href = '/partner/'+partner_id+'/venues/update/'+venue+'?offer=new';
	    		}
	    		else {
	    			window.location.href = '/admin/venues/update/'+venue+'?offer=new';
	    		}
	    	}
	    	else {
	    		addNewOfferToExistVenue();
	    	}
    	}
    });
    selectpickerInit();
}

