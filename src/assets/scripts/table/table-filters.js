var pls_filter 		= $('#pls_filter');

// Генератор фильтров
function table_filter_generator(grid, activeFilters) {
	var filters 		= grid.filters;
    var tmp_group_title = Handlebars.compile ( $('#table-filter-group-title-template').html() );

    pls_filter.append(tmp_group_title({'group_title': 'Filter'}));
	
	$.each(filters.groups, function(key, group) {
		
		var result = table_filter_group(filters, key, group, activeFilters);
		pls_filter.append(result);

	});

	var tmp_buttons = Handlebars.compile ( $('#table-filter-buttons-template').html() );
	pls_filter.append(tmp_buttons());

	selectpickerInit();
	datepickerInit();
}


// Filter group
function table_filter_group(filters, key, group, activeFilters) {
	var result = "";

	$.each(filters.fields, function(key, field) {
		if (field.group === group.group_name) {
			result += table_filter_field(field, activeFilters[field.name]);
		}
	});

	return result;
}


// Filter field
function table_filter_field(field, active_value) {
	var result;
	var attr = field.attr;
	var all_attr = "";

	// attributes
	if ( checkAttr(attr) ) {
		$.each(attr, function(name, value) {
			all_attr = all_attr+name+'="'+value+'" ';
		});
	}

	if (active_value) {
		field.value = active_value;
		field.selected = active_value;
	}

	var field_data = {'field': field, 'all_attr': all_attr};

	switch(field.field) {

		// input
		case "input":
			var tmp_field_input = Handlebars.compile ( $('#table-filter-input-template').html() );
    		result = tmp_field_input(field_data);
			break;

		// range
		case "range":
			var tmp_field_range = Handlebars.compile ( $('#table-filter-range-template').html() );
    		result = tmp_field_range(field_data);
			break;

		// select
		case "select":
			var tmp_field_select = Handlebars.compile ( $('#table-filter-select-template').html() );
    		result = tmp_field_select(field_data);
			break;

		// switcher
		case "switcher":
			var tmp_field_switcher = Handlebars.compile ( $('#table-filter-switcher-template').html() );
    		result = tmp_field_switcher(field_data);
			break;
	}

	var tmp_field_wrap = Handlebars.compile ( $('#table-filter-field-wrap-template').html() );
    return tmp_field_wrap({'title': field.title, 'field': result});
}


/* Отправляем фильтры вместе с другими данными на серевер через POST и добавляем в GET
data - данные для отправки на сервер
activePreset - активный пресет
*/
function table_ajax_data(data, activePreset, only_url) {
    var filter_data = pls_filter.serializeArray();
    var url_data	= get_filter_values();
    var filter 		= {};

    // add selectpickers value to filter data
    pls_filter.find('.pls_selectpicker').each(function() {
    	var select = $(this);
    	var value = select.data('value');
    	var name = select.attr('name');

    	if (value) {
    		var index;
            filter_data.some(function (elem, i) {
                return elem.name === name && ~(index = i);
            });

            if (!index) {
            	filter_data.push({'name': name, 'value': value});
            }
    	}
    });

    // preset
    if (activePreset && activePreset != 'all') {
    	filter['preset'] = activePreset;
    }

    // create filter data
    $.each(filter_data, function(key, val) {
        if (val.value) {
            data[val.name] = val.value;

            // for url
            var name = val.name.substr(val.name.lastIndexOf("[") + 1).split(']')[0];
            filter[name] = val.value;
        }
    });

    // pagination
    filter['start'] = data.start;

    // create URI
    var forURI = window.location.pathname;
    if (!$.isEmptyObject(filter)) {
    	forURI = '?'+decodeURIComponent($.param(filter));
    }

    // push to url
    history.pushState('data', '', forURI);

    if (only_url) {
    	return window.location.pathname+forURI;
    }
    else {
    	return data;
    }

}


// Получаем value для фильтров из GET
function get_filter_values(k) {
    var p={};

    location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s,k,v) {
        p[k] = decodeURIComponent(v);
    });

    return k?p[k]:p;
}


// INIT
$(document).ready(function() {

	// Очищаем фильтр
	$("body").on("click", "[data-filter-clear]", function(e) {
		history.pushState('data', '', window.location.pathname);

		pls_filter.find('input:text, textarea').val('');
		pls_filter.find('select').val('').selectpicker('refresh');
    	pls_filter.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

    	pls_filter.submit();
	});

	// При нажатии кнопки ENTER перезагружаем datatable
	$("body").on("keypress", "#pls_filter", function(e) {
        if(e && e.keyCode == 13) {
            pls_datatable.ajax.reload();
        	return false;
        }
    });

    // Вместо submit перезагружаем datatable
	$("body").on("submit", "#pls_filter", function(e) {
        pls_datatable.ajax.reload();
        return false;
    });

    // Применяем preset
	$("body").on("click", "[data-preset]", function(e) {
		e.preventDefault();
        var self = $(this);
        var preset = self.data('preset');

        window.location.href = table_ajax_data({}, preset, true);
    });
    
});