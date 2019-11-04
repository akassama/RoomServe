/*
Базовые скрипты
*/

// Tooltip
function tooltipInit() {
	$('[data-tooltip]').tooltip();
}

// Scrollbar init
function scrollbarInit() {
	$('.scrollbar-inner').scrollbar();
}

// Swipebox init
function swipeboxInit() {
	$('.swipebox').swipebox();
}

// Datepicker init
function datepickerInit() {
	$('.pls_datepicker, .pls_daterange').datepicker({
	    startView: 2,
	    maxViewMode: 3,
	    format: "dd MM yyyy",
	    todayBtn: "linked",
	    autoclose: true,
	    todayHighlight: true,
	    
	}).on("changeDate", function(e) {
        $(e.target).valid();
    });
}

// Timepicker init
function timepickerInit() {
	$('.pls_timepicker').timepicker({
		'timeFormat': 'h:i A'
	});
}

// Sticky panel init
function stickyInit() {
	$(".pls_sticky-panel").sticky({topSpacing:0});
}

// Pin code init
function pincodeInit() {
	$('.pls_redeem-pin').pincodeInput({inputs:4, hidedigits:false});
}

// Equal height
function equalHeight(element) {
	$(element).matchHeight();
}