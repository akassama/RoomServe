// Add new tag
function add_tag() {
	$('body').on('click', '[data-tag-create] button', function(e) {
		e.preventDefault();
		var button 			= $(this);
		var form 			= button.closest('div');
		var input 			= form.find('input');

		create_tag(input);
	});

	$('body').on('keypress', '[data-tag-create] input', function(e) {
		if(e && e.keyCode == 13) {
            create_tag($(this));
        	return false;
        }
	});
}

// Create new tag
function create_tag(input) {
	var value 			= input.val();
	var wrap			= input.closest('.pls_js-tags-wrap').find('.pls_list');
	var link 			= input.closest('div').data('tagCreate');
	var groupID			= input.data('tagGroup');
	var lang			= input.data('lang');
	var tagData 		= [];


	if (value) {
		$.ajax({
			type: "POST",
			url: link,
			data: {'name' : value, 'parent_id' : groupID, 'lang': lang},
	        dataType: "json",
			success: function (data) {
				if (data.success) {
					tagData['tag'] 		= value;
					tagData['id'] 		= data.tag_id;
					tagData['lang'] 	= lang;

					var template = Handlebars.compile ( $('#tag-template').html() );
					wrap.prepend(template(tagData));

					input.val('');
				}
				else {
					form_message.html(data.message.text);
				}
			},
		});
	}
	
}


// Edit tag
function edit_tag() {
	$('body').on('click', '[data-tag-edit]', function(e) {
		e.preventDefault();
		var self 		= $(this);
		var link 		= self.data('tagEdit');
		var tag 		= self.closest('.pls_list-item');
		var lang		= self.data('lang');
		var tagData 	= [];

		$.ajax({
			type: "POST",
			url: link,
			data: {'lang': lang},
	        dataType: "json",
			success: function (data) {
				if (data.success) {
					tagData['name'] 	= data.data.name;
					tagData['tag_id'] 	= data.data.tag_id;
					tagData['link'] 	= link;
					tagData['lang']		= lang;

					var template = Handlebars.compile ( $('#tag-edit-template').html() );
					tag.prepend(template(tagData));

					tag.find('input').focus();
				}
				else {
					form_message.html(data.message.text);
				}
			},
		});
	});

	$('body').on('click', '[data-tag-update] button', function(e) {
		e.preventDefault();
		var button 			= $(this);
		var form 			= button.closest('[data-tag-update]');
		var input 			= form.find('input');

		update_tag(input);
	});

	$('body').on('keypress', '[data-tag-update] input', function(e) {
		if(e && e.keyCode == 13) {
            update_tag($(this));
        	return false;
        }
	});
}

// Update tag
function update_tag(input) {
	var value 			= input.val();
	var tagID 			= input.attr('name');
	var tag				= input.closest('.pls_list-item');
	var form 			= tag.find('[data-tag-update]');
	var lang			= form.data('lang');
	var link			= form.data('tagUpdate');

	$.ajax({
		type: "POST",
		url: link,
		data: {'name' : value, 'tag_id': tagID, 'lang': lang},
        dataType: "json",
		success: function (data) {
			if (data.success) {
				tag.find('.left').text(data.data.name);
				form.remove();
			}
			else {
				form_message.html(data.message.text);
			}
		},
	});
}


// Get tags
function get_tags() {
	$('body').on('change', '[data-categories] input[type=radio]', function(e) {
		var cat 		= $(this);
		var catID		= cat.val();
		var cat_wrap 	= cat.closest('[data-categories]');
		var link		= cat_wrap.data('categories');
		var checked 	= cat_wrap.data('value');
		var lang 		= cat_wrap.data('lang');
		var tags_wrap 	= $("."+cat_wrap.data('tagsWrap'));

		$.getJSON(link+'/'+catID+'/'+lang, function( data ) {
			if (data.success) {
				var tags = "";

				if (data.data) {
					$.each(data.data, function(key, group) {


						// checked tags
						if (checkAttr(checked)) {
							$.each(checked, function(key, tag_id) {
								
								var obj_index;
					            group.tags.some(function (elem, i) {
					                if (elem.tag_id === tag_id) {
					                	elem.checked = 'checked';
					                }
					            });

							});
						}

						// tags group data
						var tagsData = [];
							tagsData['group_name'] 	= group.name;
							tagsData['tags'] 		= group.tags;

						// create tags group
						var template = Handlebars.compile ( $('#tags-group-template').html() );
						tags += template(tagsData);
					});
				}

				// append to tags groups
				tags_wrap.html(tags);
				
			}
			else {
				form_message.html(data.message.text);
			}
		});
	});
}


// INIT
$(document).on('ready', function() {
	add_tag();
	edit_tag();
	get_tags();
});