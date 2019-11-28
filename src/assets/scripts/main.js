// INIT
$(document).ready(function() {
	scrollbarInit();
	tooltipInit();
	selectpickerInit();
	datepickerInit();
	timepickerInit()
	showBlockInit();
	removeItem();
	stickyInit();
	openingHours();
	pincodeInit();
	disabledForm();
	customDropdown();
	actionAlert();
	getPartnerLoyaltySchemes();
	backButtonInit();
	cancelationModal();

	$('[data-inside-click]').bind('click', function (e) { 
		e.stopPropagation();
	});
});

$(document).on('ready', function() {
	swipeboxInit();
});