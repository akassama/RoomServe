// Uploader generator
function uploaderGenerator() {
	$("[data-uploader='true']:not(.inited)").each(function(key, item) {
		var self 				= $(this);
		var $settings 			= uploaderSettings(self);

		// create uploader
		var uploaderTemplate = Handlebars.compile ( $('#'+$settings['file-type']+'-uploader-template').html() );
        self.after(uploaderTemplate($settings));
        self.next('[data-uploader-wrap]').find('label').append(self);

        $settings['wrap'] = self.closest("[data-uploader-wrap]");

        if ($settings['value'] && $settings['file-type'] == 'attachment') {
        	uploadAttachment($settings, $settings, false);
        }

		// inited
		self.attr('name', randomID()).addClass('inited');
		rulePhotoUploader();
		ruleFileUploader();
	});
}


function uploaderSettings(self) {
	var $settings 				= [];
	$settings['id']				= self.data("uploaderId");
	$settings['file-type']		= self.data("uploaderFileType");
	$settings['name']			= self.data("uploaderName");
	$settings['upload-text']	= self.data("uploaderUploadText");
	$settings['download-text']	= self.data("uploaderDownloadText");
	$settings['remove-text']	= self.data("uploaderRemoveText");
	$settings['uploader-type']	= self.data("uploaderType");
	$settings['classes']		= self.data("uploaderClass");
	$settings['original']		= self.data("original");
	$settings['value']			= self.data("value");
	$settings['thumb']			= $settings['value'];
	$settings['details']		= self.data("uploaderDetails");
	$settings['multiple']		= self.data("uploaderMultiple");
	$settings['multiple-wrap']	= self.closest('.pls_attachments');
	$settings['uploaded']		= true;

	if ( !checkAttr($settings['value']) ) {
		$settings['value'] 		= false;
		$settings['thumb']		= false;
		$settings['uploaded'] 	= false;
	}

	if ( !checkAttr($settings['file-type']) ) {
		$settings['file-type'] 	= 'photo';
	}

	return $settings;
}


// Uploader init
function uploaderInit() {
	$("body").on("change", "input[data-uploader='true'].inited", function(e) {
		var self 				= $(this);
		var $settings 			= uploaderSettings(self);

		$settings['file']		= this.files[0];
		$settings['wrap']		= self.closest("[data-uploader-wrap]");
		$settings['label']		= $settings['wrap'].find("label");
		$settings['bg']			= $settings['wrap'].find('.pls_uploader-bg');
		$settings['progressbar']= $settings['wrap'].find('.pls_uploader-progress div');
		$settings['input'] 		= $settings['wrap'].find('.pls_uploader-hidden');
		$formData				= new FormData();

		if ($settings['file']) {
			$settings['wrap'].addClass('upload');
			var reader = new FileReader();

			reader.onload = function (e) {
				$settings['photo'] = e.target.result;

				// Add the file to the request.
        		$formData.append('file', $settings['file'], $settings['file'].name);
        		$formData.append('type', $settings['uploader-type']);
        		$formData.append('id', $settings['id']);

        		// send file
				$.ajax({
					type: "POST",
					url: "/files/upload",
					data: $formData,
	                dataType: "json",
	                mimeType: "multipart/form-data",
	                contentType: false,
	                processData: false,
					success: function (data) {
						if (data['status']) {

							// value
							$settings['input'].val(data['name']);

							// name
							self.data("uploaderFileName", data['name']).attr("data-uploader-file-name", data['name']);

							if ($settings['file-type'] == 'photo') {
								uploadPhoto($settings['bg'], data);
							}
							else if ($settings['file-type'] == 'attachment') {
								uploadAttachment(data, $settings, true);
							}

							// add uploaded class
							$settings['wrap'].addClass('uploaded');

						}
						else {
							
							// clear value
							$settings['input'].val('');

							// clear name
							self.data("uploaderFileName", "").attr("data-uploader-file-name", "");

							// remove thumb
							$settings['bg'].removeAttr('css').removeClass('swipebox');

							// remove uploaded class
							$settings['wrap'].removeClass("uploaded");

						}

						$settings['wrap'].removeClass('upload');
					},
					// progress bar
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                            	var percentComplete = evt.loaded / evt.total;
                                	percentComplete = parseInt(percentComplete * 100);

                                $settings['progressbar'].css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    // show bg & progress bar
					beforeSend : function() {
						if ($settings['file-type'] == 'photo') {
							$settings['bg'].css('background-image', 'url('+ $settings['photo'] +')');
						}
	            	}
				});
			}
			reader.readAsDataURL($settings['file']);
		}
		else {
			$settings['wrap'].removeClass("upload uploaded");

			if ($settings['file-type'] == 'photo') {
				$settings['bg'].removeAttr('css').attr('href', '#').removeClass('swipebox');
			}
		}
		self.valid();
	});
}

// Photo
function uploadPhoto(bg, data) {
	// thumb
	bg.css('background-image', 'url('+ data['thumb'] +')').attr('href', data['original']).addClass('swipebox');
}


// Attachment
function uploadAttachment(data, $settings, $create) {

	if ($settings['multiple'] && $create) {
    	var attachment = $settings['wrap'].closest('li.pls_attachment').clone(true);
    	attachment.find('input[data-uploader=true]').val('');
    	$settings['multiple-wrap'].append(attachment);
    }

	// data
	var uploadedData = {
		'name': 			data['name'],
		'original': 		data['original'],
		'remove-text': 		$settings['remove-text'],
		'download-text': 	$settings['download-text'],
	};

	$.each(data['details'], function(k, i) {
		uploadedData[k] = i;
	});

	var uploadedTemplate = Handlebars.compile ( $('#attachment-uploaded-template').html() );
    $settings['wrap'].append(uploadedTemplate(uploadedData));

}


// Uploader - remove file
function uploaderRemove() {
	$("body").on("click", ".pls_uploader-remove", function(e) {
		e.preventDefault();
		var self 		= $(this);
		var wrap 		= self.closest("[data-uploader-wrap]");
		var input 		= wrap.find(".pls_uploader-hidden");
		var uploader 	= wrap.find("input[type=file]");
		var fileName 	= uploader.data("uploaderFileName");
		var fileType 	= uploader.data("uploaderFileType");
		var type 		= uploader.data("uploaderType");
		var multiple	= uploader.data("uploaderMultiple");
		var id 			= uploader.data("uploaderId");
		var bg 			= wrap.find('.pls_uploader-bg');
		var formData 	= new FormData();
		var typeName	= 'photo';

		if (checkAttr(fileType)) {
			typeName = fileType;
		}

		// Add the file to the request.
		formData.append('file', fileName);
		formData.append('type', type);
		formData.append('id', id);

		swal({
		    title: 'Are you sure?',
		    text: "You won't be able to revert this!",
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonText: 'Remove',
		    cancelButtonText: 'Cancel!',
		    confirmButtonClass: 'pls_button color-danger ico-color-white ico-remove',
		    cancelButtonClass: 'pls_button color-grey',
		    buttonsStyling: false,
		    reverseButtons: true
		}).then((result) => {

		    if (result.value) {
		    	$.ajax({
					type: "POST",
					url: "/files/remove",
					data: formData,
		            dataType: "json",
		            mimeType: "multipart/form-data",
		            contentType: false,
		            processData: false,
					success: function (data) {
						input.val('');
						uploader.data("uploaderFileName", "").attr("data-uploader-file-name", "");

						if (multiple) {
							wrap.closest('.pls_attachment').remove();
						}
						else {
							if (typeName == 'photo') {
								bg.removeAttr('css').attr('href', '#').removeClass('swipebox');
								wrap.removeClass("uploaded");
							}
							else if (typeName == 'attachment') {
								wrap.find('button.pls_form-card, .dropdown-menu').remove();
							}
						}
						
						

						swal({
		                    title: 'Deleted!',
		                    text: 'Your file has been deleted.',
		                    type: 'success',
		                    buttonsStyling: false,
		                    confirmButtonClass: 'pls_button color-info ico-check',
		                });
					}
				});
		    }

		});
	});
}

// INIT
$(document).on('ready', function() {
	uploaderGenerator();
	uploaderInit();
	uploaderRemove();
});