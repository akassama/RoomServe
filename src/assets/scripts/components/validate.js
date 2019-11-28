
var page_loader = $(".pls_page-loader"),
	form_class = ".pls_validate",
	submitBtn = $(form_class + " button.pls_button[data-submit]"),
    form_message = $(".pls_form-message");


var delay = (function(){
  	var timer = 0;
  	return function(callback, ms){
    	clearTimeout (timer);
    	timer = setTimeout(callback, ms);
  	};
})();

function checkEmail(email) {
  	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  	return regex.test(email);
}

// Validate
function formValidate() {

    $("form").each(function() {
    	formValidateInit($(this));
    });

	validateRules();
}


// Validate init
function formValidateInit(form) {
	var validate = form.data("validate");

	if ( checkAttr(validate) ) {

		// Настройка валидации
		form.validate({
			ignore: '.ignore, .form-control',
			errorClass: 'pls_label-error',
			errorElement: "strong",
			successClass: 'pls_label-valid',
			validClass: "pls_label-valid",
			onfocusout: function (element) {
		        $(element).valid();
		    },
			highlight: function(element, errorClass, validClass) {
				$(element).addClass("pls_field-error").removeClass("pls_field-valid");
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass("pls_field-error").addClass("pls_field-valid");
			},
			invalidHandler: function(event, validator) {
			    var errors = validator.numberOfInvalids();
		  	},
			errorPlacement: function(label, element) {
				if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
					label.appendTo( element.parent().parent().parent() );
				}
				else {
					label.insertAfter(element);
				}
			},
			submitHandler: function() {
	            var formData = new FormData(form[0]);

	            $.ajax({
					type: "POST",
					url: form.attr("action"),
					data: formData,
	                dataType: "json",
	                mimeType: "multipart/form-data",
	                contentType: false,
	                processData: false,
					success: function(data){
						validateResult(data, form);
					},
					beforeSend : function() {
						page_loader.removeClass('close').addClass('active');
	            	}
				});

				scrollToTop();
				return false; // required to block normal submit since you used ajax
			},
		});

		// отключаем отправку формы при нажатии кнопки "Enter"
		// form.on('keypress', function(e) {
		// 	if(e && e.keyCode == 13) {
	 //        	return false;
	 //        }
		// });

	}
}


// Validate result
function validateResult(data, form) {
	var modal 			= form.data("validateModal");
	var card 			= form.data("card");
	var cardNum 		= form.data("cardNum");
	var cardLimit 		= form.data("cardLimit");
	var cardWrap 		= form.data("cardWrap");
	var module 			= form.data("module");
	var moduleType 		= form.data("moduleType");
	var formType 		= form.data("formType");

	// if redirect
	if (data.redirect) {
		window.location.href = data.redirect;
	}
	// else show message
	else {

		// check modal
		if ( checkAttr(modal) ) {

			if (data.success) {

				// remove modal
				modalRemove(form.closest(".modal"));

				// create card
				if ( formType == "create" && checkAttr(card) && checkAttr(cardWrap) ) {
					cardCreate(form, data.data, card, cardWrap, cardNum, cardLimit, module, moduleType);
				}

				// update card
				else if (formType == "update") {
					cardUpdate(form, data.data, card, module, moduleType);
				}

				// show message
				form_message.html(data.message.text);
			}
			else {
				var message = "";
				if (data.message) {
					message = data.message.text;
				}
				if (data.validation) {
					message = data.validation;
				}

				form.closest(".modal").find(".pls_form-message-modal").html(message);
			}
			
		}
		else {
			// show message
	    	var msg;
	    	if (data.message) {
	    		// check mail
				if (data.message.status == "success") {
					form.find("input[data-rule-email-exist]").each(function(index) {
						var input = $(this);

						input.data( "value", input.val() ).attr( "data-value", input.val() );
					});
				}
	    		
	    		msg = data.message.text;
	    	}
	    	if (data.validation) {
	    		msg = msg?msg+data.validation:data.validation;
	    	}
	    	form_message.html(msg);
		}

		page_loader.addClass('close').removeClass("active");
		scrollToTop();
	}
}


// Form validate rules
function validateRules(form) {
	form = form || '';

	ruleCheckMail(form);
	ruleEqualTo(form);
	rulePhotoUploader(form);
	ruleFileUploader(form);

}


// rule: check email
function ruleCheckMail(form) {
	form = form || "";

	$(form + ' [data-rule-email-exist=true]').rules("add", {
 		"onekeyup": false,
	  	"checkmail": true,
	  	"email": true,
	});

	var checkmailResult;
	var checkmailData;
	$.validator.addMethod("checkmail", function(value, element) {

		// delay(function() {

			var self = $(element);
			var mail = self.data("value");
			var remote = true;

			if (checkAttr(mail)) {
				mail = mail.split(';');
				$.each(mail, function(index, ml) {
					if (ml == $.trim(value)) {
						remote = false;
						return true;
					}
				});
				
			}

			if (remote && checkEmail(value) && value) {
				var url = "/admin/tools/check_email";
				if (typeof partner_id != 'undefined') {
					url = "/partner/"+partner_id+"/tools/check_email";
				}

				$.ajax({
			      	type: "POST",
			       	url: url,
			       	dataType: "json",
			       	async: false,
		     	 	data: { email: value,},
			   		success: function(data) {
				      	checkmailData = data;
				      	checkmailResult = data.status;
				   	}
		 		});
			}

			if (checkmailResult) {
				$.validator.messages.checkmail = "The email already exists";
				if (checkmailData.user) {
					var link;
					var group = checkmailData.role;

					switch(checkmailData.role) {
					    case "administrator":
					        link = "administrators/update/"+checkmailData.user_id
					        break;
					    case "partner_administrator":
					        link = "partners/update/"+checkmailData.partner_id
					        break;
					}
					$.validator.messages.checkmail = "<a href='/admin/"+link+"' target='_blank' >"+checkmailData.user+" ("+checkmailData.role_name+")</a>";
				}
				return false
			}
			else {
				$.validator.messages.checkmail = "";
				return true;
			}

		// }, 1500 );

	}, $.validator.messages.checkmail);
}

// rule: equal to
function ruleEqualTo(form) {
	form = form || "";

	$(form + ' [data-rule-equal-to]').each(function() {
		$(this).rules("add", {
		  	"equalto": true,
		});
	});

	$.validator.addMethod("equalto", function(value, element) {
		var self = $(element);
		var value = self.val();
		var equalto = $("#"+self.data("ruleEqualTo")).val();

		if (value == equalto) {
			$.validator.messages.equalto = "";
			return true;
		}
		else {
			$.validator.messages.equalto = "Please enter the same value again";
			return false
		}

	}, $.validator.messages.equalto);
}

// rule: photo uploader
function rulePhotoUploader(form) {
	form = form || "";

	$(form + ' [data-rule-photo-uploader=true].inited:not(.init-validate)').each(function() {
		var self = $(this);

		self.rules("add", {
			"photoextensions": true,
		  	"photorequired": true,
		});

		self.addClass('init-validate');
	});

	$.validator.addMethod("photorequired", function(value, element) {
		var self = $(element);
		var wrap = self.closest('[data-uploader-wrap]');

		if (wrap.hasClass('uploaded')) {
			return true;
		}
		else {
			return false;
		}

	}, 'Please upload picture');

	$.validator.addMethod("photoextensions", function(value, element) {
		var self = $(element);
		var extension = value.replace(/^.*\./, '').toLowerCase();

		if (value) {
			if (extension == 'jpg' || extension == 'png' || extension == 'jpeg') {
				return true;
			}
			else {
				return false
			}
		}
		else {
			return true;
		}

	}, 'Failed to upload image, the format is not supported');
}


// rule: file uploader
function ruleFileUploader(form) {
	form = form || "";

	$('[data-rule-file-uploader=true].inited:not(.init-validate)').each(function() {
		var self = $(this);

		self.rules("add", {
		  	"filerequired": true,
		});

		self.addClass('init-validate');
	});

	$.validator.addMethod("filerequired", function(value, element) {
		var self = $(element);
		var extension = value.replace(/^.*\./, '').toLowerCase();

		if (value) {
			if (extension == 'pdf') {
				return true;
			}
			else {
				return false
			}
		}
		else {
			return true;
		}

		

	}, 'Only pdf files are allowed');
}


// INIT
$(document).on('ready', function() {
	formValidate();
});