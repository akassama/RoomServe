// Selectpicker init
function selectpickerInit(all) {
	all = (all != undefined)?all:false;

	var not = "";
	if (!all) {
		not = ":not(.inited)";
	}

	$('.pls_selectpicker'+not).selectpicker({
		liveSearch: true,
		// container: 'body'
	}).on('changed.bs.select', function (e) {
	  $(this).selectpicker('toggle');
	});;

	$('.pls_selectpicker[data-url]:not(.inited):not([data-sub=true])').each(function(index, value) {
        selectpickerRemote($(this));
    });

    $('.pls_selectpicker[data-id]').each(function(index, value) {
       	$(this).prop('disabled', true);
    });

    $('.pls_selectpicker[data-dependent]').on('change', function() {
		dependentSelectpicker($(this));
    });
}


// Selectpicker - remote
function selectpickerRemote(select, url) {
	var url 		= url || select.data('url');
	var value 		= select.data('value');
	var empty 		= select.data('empty');
	var title		= select.data('title');
	var search 		= select.data('search');
	var disabled	= select.data('disabled');
	var dependent   = select.data('dependent');
	var options 	= "";

	select.empty().prop("disabled", true).selectpicker('refresh');

	// check url
	if (checkAttr(url)) {

		// get data
		$.getJSON(url, function(data) {

			// check data
	    	if (data.length) {

	    		// add empty option
	    		options += '<option value="">'+(checkAttr(title)?title:'Please choose')+'</option>';

	    		// create options
			    $.each(data, function(i, opt) {
			        options += '<option value="' + opt.key + '">' + opt.val + '</option>';
			    });

			    // live search
			    if (checkAttr(search)) {
			    	select.addClass('with-search');
			    }

			    // append options
			    select.empty().append(options).removeAttr("disabled");

			    // init select
			    select.selectpicker('refresh').addClass("inited");

			    // set default value
			    if ( checkAttr(value) ) {
			    	select.val(value).selectpicker('refresh');
			    }

			    // disabled
			    if (checkAttr(disabled)) {
			    	select.prop('disabled', true);
			    }

			    // dependent
			    if (checkAttr(dependent)) {
			    	dependentSelectpicker(select);
			    }

	    	}

	    });
	}
}


// Dependent selects
function dependentSelectpicker(select) {
	var dependent_id = select.data('dependent');
	var value = select.val();

	if (checkAttr(dependent_id)) {
		var dependent_select = $(".pls_selectpicker[data-id="+dependent_id+"]");
		var url = dependent_select.data("url");
		var sub = dependent_select.data("sub");

		if (checkAttr(url)) {
			if (checkAttr(sub)) {
				if (value) {
					selectpickerRemote(dependent_select, url + value);
				}
				else {
					dependent_select.empty().prop("disabled", true).selectpicker('refresh');
				}
			}
			else {
				selectpickerRemote(dependent_select, url + value);
			}
		}
		
	}
}