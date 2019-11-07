// Modal templater
// function modalTemplaterInit() {

// 	$('body').on('click', '[data-modal-id]', function(e) {
// 		e.preventDefault();
// 		var self = $(this);
// 		var modalID = self.data('modalId');
// 		var link = self.data('link');
// 		var linkType = self.data('linkType');
// 		var itemGet = self.data('itemGet');
// 		var module = self.data('module');
// 		var moduleType = self.data('moduleType');
// 		var cardNum = self.data('cardNum');
// 		var cardLimit = self.data('cardLimit');
// 		var cardWrap = self.data('cardWrap');
// 		var modalMap = self.data('modalMap');
// 		var modalData = {};

// 		if (checkAttr(link)) {
// 			var formData = getModalFormData(self, linkType, module, moduleType);

// 			// create or get
// 			$.ajax({
// 				type: "POST",
// 				url: link,
// 				data: formData,
//                 dataType: "json",
//                 mimeType: "multipart/form-data",
//                 contentType: false,
//                 processData: false,
// 				success: function (data) {

// 					if (data.success) {

// 						modalData['form_type'] 			= linkType;
// 						modalData['module'] 			= module;
// 						modalData['module_type'] 		= moduleType;
// 						modalData['card_num'] 			= cardNum;
// 						modalData['card_limit'] 		= cardLimit;
// 						modalData['card_wrap'] 			= cardWrap;

// 						if (linkType == "update") {

// 							$.each(data.data, function(key, value) {
// 								modalData[key] 			= value;
// 							});

// 							modalData['update'] 		= 1;
// 							modalData['pass_disabled']	= 'disabled';
// 							modalData['pass_class']		= 'hide';
// 						}
// 						else if (linkType == "create") {
// 							$.each(data, function(key, value) {
// 								modalData[key] 			= value;
// 							});

// 							modalData['pass_disabled']	= '';
// 							modalData['pass_class']		= 'no-arrow';
// 						}

// 						var template = Handlebars.compile ( $(modalID+"-template").html() );

// 						$("body").append(template(modalData));

// 						// show modal
// 						$(modalID).modal({
// 							'show': true,
// 							'keyboard': false,
// 							'backdrop': 'static'
// 						}).on('shown.bs.modal', function (e) {
// 						 	selectpickerInit();
// 							datepickerInit();
// 							timepickerInit();
// 							uploaderGenerator();
// 							formValidateInit( $(modalID).find('[data-validate="true"]') );
// 							validateRules(modalID);
// 							if (checkAttr(modalMap)) {
// 								initMapPicker();
// 							}
// 							if (moduleType == 'location') {
// 								var location_id;
// 								if (linkType == 'update') {
// 									location_id = data.data.location_id;
// 								}
// 								else {
// 									location_id = data.location_id;
// 								}
// 								getLocationOpeningHours(location_id);
// 							}
// 						});

// 					}
// 				},
// 			});
// 		}


// 	});

// }


// Modal templater
function modalTemplaterAltInit() {

	$('body').on('click', '[data-modal-id]', function(e) {
		e.preventDefault();
		var self = $(this);
		var modalID = self.data('modalId');
		var link = self.data('link');
		var linkType = self.data('linkType');
		var itemGet = self.data('itemGet');
		var module = self.data('module');
		var moduleType = self.data('moduleType');
		var cardNum = self.data('cardNum');
		var cardLimit = self.data('cardLimit');
		var cardWrap = self.data('cardWrap');
		var modalMap = self.data('modalMap');
		var modalEditor = self.data('modalEditor');
		var modalData = {};

		if (checkAttr(link)) {
			var formData = getModalFormData(self, linkType, module, moduleType);

			$.ajax({
		        type: 'POST',
		        url: link,
				data: formData,
		        dataType: "html",
		        mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
		        success: function (data) {
		        	if (data) {
		        		$('body').append(data);

		        		// show modal
						$(modalID).modal({
							'show': true,
							'keyboard': false,
							'backdrop': 'static'
						}).on('shown.bs.modal', function (e) {
						 	selectpickerInit();
							datepickerInit();
							timepickerInit();
							uploaderGenerator();
							formValidateInit( $(modalID).find('[data-validate="true"]') );
							validateRules(modalID);
							scrollbarInit();

							if (checkAttr(modalMap)) {
								initMapPicker();
							}
							if (checkAttr(modalEditor)) {
								editorInit();
							}

							$(this).addClass('inited');

						});
		        	}
		        },
		    });

		}


	});

}


// Get form data
function getModalFormData(self, linkType, module, moduleType) {
	var ID = self.data('id');
	var parentID = self.data('parentId');
	var formData = new FormData();

	formData.append( 'form_type', self.data('linkType') );

	if (module == "partner") {
		formData.append('user[user_id]', ID);
		formData.append('user[partner_id]', parentID);
	}
	else if (module == "member") {
		formData.append('user[user_id]', ID);
		formData.append('user[parent_id]', parentID);
		formData.append('user[type]', moduleType);
	}
	else if (module == "venue") {
		if (moduleType == "offer") {
			formData.append('offer[venue_id]', parentID);
			formData.append('offer[offer_id]', ID);
			formData.append('offer[module]', module);
			formData.append('offer[module_type]', moduleType);
		}
		else if (moduleType == "location") {
			formData.append('location[venue_id]', parentID);
			formData.append('location[location_id]', ID);
			formData.append('location[module]', module);
			formData.append('location[module_type]', moduleType);
		}
	}

	return formData;
}

// Modal - remove button
function modalRemoveInit() {
	$('body').on('click', '[data-remove-modal="true"]', function(e) {
		e.preventDefault();

		modalRemove( $(this).closest('.modal') );
	});
}

// Modal - remove
function modalRemove(modal) {
	modal.modal('hide').on('hidden.bs.modal', function (e) {
		$(this).remove();
	});
}

// Card - create
function cardCreate(form, data, card, cardWrap, cardNum, cardLimit, module, moduleType) {
	var cardData = {};
	var status_input = $(form).find('input[data-status]:checked');
	var status = status_input.val();
	var ID;

	cardData['card_num'] = cardNum;
	cardData['status_class'] = status_input.data('status');
	$.each(data, function(key, value) {
		cardData[key] = value;
	});

	if (module == "partner") {
		ID = data.user_id;
	}
	else if (module == "member") {
		ID = data.user_id;
	}
	else if (module == "venue") {
		if (moduleType == "offer") {
			ID = data.offer_id;
		}
		else if (moduleType == "location") {
			ID = data.location_id;
			status = 1;
		}
	}

	var template = Handlebars.compile ( $(card).html() );
	$(cardWrap).children().last().before(template(cardData));
	$(cardWrap).after('<input type="hidden" name="form['+moduleType+']['+ID+'][status]" value="'+status+'" />');
}

// Card - update
function cardUpdate(form, data, card, module, moduleType) {
	if (module == "partner" || module == "member") {
		var card = $('[data-modal-id][data-id='+data.user_id+']');

		var cardPhoto = data.photo?card.data('photoLink')+data.photo:'';
		var cardStatus = $(form).find('input[data-status]:checked').data('status');

		card.find(".name").text(data.first_name+" "+data.last_name);
		card.find(".picture").css("background-image", "url("+cardPhoto+")");
		card.find(".status").removeAttr("class").addClass("status status-"+cardStatus);
		card.find(".des").text(data.user_group_name);
	}
	else if (moduleType == "location") {
		var card = $('[data-modal-id][data-id='+data.location_id+']');

		card.find(".name").text(data.mini_address);
	}
	else if (moduleType == "offer") {
		var card = $('[data-modal-id][data-id='+data.offer_id+']');

		card.find(".name").text(data.name);
	}
}

// Card - remove
function cardRemove(id) {
	$("[data-modal-id][data-id="+id+"]").remove();
}


// INIT
$(document).on('ready', function() {
	// modalTemplaterInit();
	modalTemplaterAltInit();
	modalRemoveInit();;
});
