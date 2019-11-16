var pls_datatable;
var pls_filter = $('#pls_filter');

function list_generator(url, get_grid, module, type) {
	var table = $(".datatable"),
		tableView = $(".pls_table-view-dropdown .dropdown-menu"),
		columnDefs = [],
		columns = [],
		activeFilters = get_filter_values();

	// get list config
	$.getJSON(get_grid, function( grid ) {
		if (grid) {
			table.append("<thead><tr></tr></thead>");
			var thead = table.find("thead > tr");
			var th_template = Handlebars.compile ( $('#table-thead-column-template').html() );

			tableView.append("<ul></ul>");
			tableView = tableView.find("ul");

			// generate datatable
			$.each(grid.columns, function(key, column) {
				var visible = true;
				if (column.visible != undefined) {
					visible = column.visible;

					if ($.type(visible) === 'string') {
						visible = visible=='false'?false:true;
					}
				}

				thead.append(th_template(column));
				columns.push(table_column_generator(column, visible));
				columnDefs.push(table_column_defs_generator(grid, column));
				tableView.append(table_view_manager_generator(column, visible));
			});

			// check active preset
			var activePreset = activeFilters.preset?activeFilters.preset:'all';

			// generate filter
			if (grid.filters && grid.options.filter) {
				table_filter_generator(grid, activeFilters);
			}
			else {
				pls_filter.remove();
			}

			// csv
			if (!grid.options.csv.csv_export) {
				$("#pls_table-export").closest('li').remove();
			}

			// quick stats
			if (grid.options.quick_stats && grid.quick_stats) {
				table_quick_stats(grid.quick_stats, activePreset);
			}

			// datatable init
			table_init(grid.options, table, columns, columnDefs, url, module, activePreset, activeFilters);
		}
		else {
			table_empty(true);
		}

	});

}


// Генерация переключателя столбцов
function table_view_manager_generator(column, visible) {
	return `<li>
	  			<label class="pls_checkbox table-view-checkbox">
		        	<input type="checkbox" name="`+column.name+`" value="1" `+(visible?"checked":"")+`><div></div><span>`+column.title+`</span>
		      	</label>
		  	</li>`;
}

// Генератор столбцов
function table_column_generator(column, visible) {
	var orderable = column.orderable==false?false:true;
	if (column.type == 'actions') {
		orderable = false;
	}

	return 	{
				"data": 			column.formatted?column.formatted:column.name,
				"name": 			column.order_name?column.order_name:column.name,
				"class": 			"col-"+column.name+" "+(column.class?column.class:""),
				"orderable": 		orderable,
				"visible": 			visible,
			};
}

// Генератор внешнего вида столбцов
function table_column_defs_generator(grid, column) {
	return 	{
		        "render": function ( data, type, row ) {
		            return table_column_defs_options(grid, column, data, row);
		        },
		        "targets": "col-"+column.name,
		    };
}

// Параметры для внешнего вида столбцов
function table_column_defs_options(grid, column, data, row) {
	var result = data;

	switch(column.type) {

		// actions
	    case "actions":
	       	result = table_actions(grid, column, row, data);
	        break;

	    // label
	    case "label":
	        result = data?table_labels(column, data):'';
	        break;

	    // photo
	    case "photo":
	        result = table_photos(column, data);
	        break;

	    // link
	    case "link":
	        result = data?table_links(column, row, data):'';
	        break;
	}

	return result;
}


// Table actions
function table_actions(grid, column, row, data) {
	var result;
	var actions_num = 0;

	if (grid.actions != undefined) {
		result = '<div class="dropdown"><a href="#" class="dropdown-toggle pls_actions-button" id="cell-'+data+'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+column.title+'</a>';
		result = result+'<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cell-'+data+'"><div class="dropdown-standart-menu with-ico">';

		$.each(grid.actions, function(action_key, action) {
			var link = action.link;
			var attr = action.attr;
			var allAttr = "";
			var access = true;
			var query = action.js_query;

			// query
			if (checkAttr(query)) {
				var q_access = 0;
				$.each(query.value, function(k, v) {

					switch(query.operator) {
						// !=
					    case "!=":
					    	if (row[query.row] != v) {
					    		q_access++;
					    	}
					        break;

					    // >
					    case ">":
					        if (row[query.row] > v) {
					    		q_access++;
					    	}
					        break;

					    // <
					    case "<":
					        if (row[query.row] < v) {
					    		q_access++;
					    	}
					        break;

					    // ==
					    default:
					        if (row[query.row] == v) {
					    		q_access++;
					    	}
					        break;
					}

				});

				access = false;
				if (q_access) {
					access = true;
				}
			}

			if (access) {
				// attributes
				if ( checkAttr(attr) ) {
					$.each(attr, function(name, value) {
						allAttr = allAttr+name+'="'+value+'" ';
					})
				}

				// keys
				if (checkAttr(action.keys)) {
					$.each(action.keys, function(key, key_id) {
	    				link = link.replace( new RegExp( '{{'+key_id+'}}', 'g' ), row[key_id] );
	    				allAttr = allAttr.replace( new RegExp( '{{'+key_id+'}}', 'g' ), row[key_id] );
	    			});
				}

				result += '<a href="'+link+'" class="'+action.class+'" '+allAttr+'>'+action.title+'</a>';

				actions_num++;
			}

		});

		if (actions_num) {
			result += '</div></div></div>';
		}
		else {
			result = '';
		}
	}
	else {
		result = '';
	}
	return result;
}

// Table labels
function table_labels(column, data) {
	if (column.values[data]) {
		return '<div class="pls_label pls_label-'+column.values[data].label_type+'">'+column.values[data].title+'</div>';
	}
	else if (column.label_type) {
		return '<div class="pls_label pls_label-'+column.label_type+'">'+column.values[data].title+'</div>';
	}
	else {
		return data;
	}
}

// Table photos
function table_photos(column, data) {
	var photo_class = "";

	if (checkAttr(column.photo_class)) {
		photo_class = column.photo_class;
	}

	if (column.photo_link && data) {
		return '<div class="pls_table_photo '+photo_class+'" style="background-image: url('+column.photo_link+data+');"></div>';
	}
	else {
		return '<div class="pls_table_photo '+photo_class+'"></div>';
	}
}

// Table links
function table_links(column, row, data) {
	var link 			= column.link_url;
	var attr 			= column.attr;
	var link_type 		= column.link_type;
	var allAttr 		= "";

	// attributes
	if ( checkAttr(attr) ) {
		$.each(attr, function(name, value) {
			allAttr = allAttr+name+'="'+value+'" ';
		});
	}

	// keys
	if (checkAttr(column.keys)) {
		$.each(column.keys, function(key, key_id) {
			link = link.replace( new RegExp( '{{'+key_id+'}}', 'g' ), row[key_id] );
			allAttr = allAttr.replace( new RegExp( '{{'+key_id+'}}', 'g' ), row[key_id] );
		});
	}

	// email
	if (checkAttr(link_type)) {
		if (link_type == 'email') {
			link = 'mailto:'+data;
		}
	}

	return '<a href="'+link+'" '+allAttr+'>'+data+'</a>';
}

// Table export
function table_export(url) {
    $("body").on("click", "#pls_table-export", function(e) {
    	var order = pls_datatable.order();
        var names = pls_datatable.settings().init().columns;
        var data = {};

        data = pls_datatable.page.info();
        data['order'] = {};
        data['order'][0] = {};
        data['order'][0]['column'] = order[0][0];
        data['order'][0]['direction'] = order[0][1];
        data['csv'] = true;
        data['columns'] = {};

        var filter_data = pls_filter.serializeArray();
        $.each(filter_data, function(key, val) {
        	if (val.value) {
        		data[val.name] = val.value;
        	}
        });

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (result) {
                $.fileDownload(result);
            },
        });

        return false;
    });
}

// Table state save
function table_state_save(data, module) {
	var items = {};

	// get state
	$.each(data.columns, function(i, d) {
		var col = pls_datatable.column(i).header();
		var name = $(col).data('name');
		var item = {};

		item['visible'] = pls_datatable.column(i).visible();
		items[name] = item;
	});

	// get order
	var order = table_get_order(data.order[0][0], data.order[0][1]);

	// save state & order
	$.ajax({
		type: "POST",
	  	url: list_state_url,
	  	data: {'columns': items, 'order': order, 'module': module},
	  	dataType: "json",
	  	success: function () {}
	});
}

// Table - get order
function table_get_order(index, direction) {
	var order = {};
	var column = $('[data-column-index='+(index)+']');
	var name = column.data('orderName');

	if (!checkAttr(name)) {
		name = column.data('name');
	}

	// get order
	order['column'] = name;
	order['direction'] = direction;

	return order;
}


// Table view manager
function table_view_manager() {
    $('.table-view-checkbox input').on( 'change', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = pls_datatable.column('.col-'+$(this).attr('name'));

        // Toggle the visibility
        column.visible( ! column.visible() );
    });
}


// Table empty
function table_empty(empty) {
	var tableEmpty = $(".pls_table-empty");
	var table = $("[data-table-hide]");

	if (empty) {
		table.attr("data-table-hide", true).data("tableHide", true);
		tableEmpty.fadeIn(100);
	}
	else {
		table.attr("data-table-hide", false).data("tableHide", false).animate({opacity: 1,}, 100, function(){});
		tableEmpty.hide(100);
	}
}


// Table quick stats
function table_quick_stats(quick_stats, active_preset) {
	var wrap 	= $("#pls_table-quick-stats");
	var data 	= { 'stats': quick_stats, 'count': quick_stats.length, 'active_preset': active_preset };

	var quick_stats_template = Handlebars.compile ( $('#table-quick-stats-template').html() );
    wrap.html(quick_stats_template(data));
    tooltipInit();

	wrap.removeClass('hide');
}


// Table quick stats - refresh
function table_quick_stats_refresh(quick_stats) {
	$.each(quick_stats, function(key, stat) {
		$("#quick_stat-"+key).text(stat);
	});
	counterInit();
}


// Datatable init
function table_init(options, table, columns, columnDefs, url, module, activePreset, activeFilters) {
	var order = $('th[data-order-name="'+options.order.order_by+'"]').index();
	var order_dir = options.order.order_dir;
	if (order == -1) {
		order = $('th[data-name="'+options.order.order_by+'"]').index();
	}
	if (order == -1) {
		order = 1;
	}
	if (!checkAttr(order_dir)) {
		order_dir = "desc";
	}

	pls_datatable = table.DataTable({
		"columns": 			columns,
		"actions":			"Delete",
		"columnDefs": 		columnDefs,
		"order": 			[[order, order_dir]],
        "processing": 		true,
        "serverSide": 		true,
        "scrollX": 			true,
        "displayStart": 	activeFilters['start']?activeFilters['start']:0,
        "pageLength": 		20,
        "colReorder": 		true,
        // "responsive": 		true,
        "pagingType": 		"simple_numbers",
        "dom": 				'<"datatable-scroll"t><"datatable-footer"ip>',
        "stateSave": 		true,
		"stateSaveCallback": function(settings, data) {
			if (table.hasClass('inited')) {
				table_state_save(data, module);
			}
		},
        "ajax": {
							"url": url,
							"type": "POST",
							"data": function(data, src) {
								data.order[0] = table_get_order(data.order[0]['column'], data.order[0]['dir']);

								// filter data
								table_ajax_data(data, activePreset);
							},
				 			"dataSrc": function ( json ) {

				 				if (!table.hasClass("inited")) {

				 					if (activePreset == 'all') {
					 					activePreset = '';
					 				}

				 					if (json.recordsTotal > 0 || activePreset) {
					 					table_empty(false);
					 				}
					 				else {
					 					table_empty(true);
					 				}
					 				table.addClass("inited");
				 				}

				 				table_quick_stats_refresh(json.quick_stats);

								return json.data;
							},
							"error": function(error) {
								table_empty(true);
								console.log("Server error");
							}
        },
    });

    table_export(url);
    table_view_manager();
}
