// Timeline
function timelineInit() {
	var url = '/admin/notes/get_ajax_notes/';
	var wrap = $('[data-timeline]');
	var timelineData = [];

	timelineData['type'] = wrap.data('timelineType');
	timelineData['type_id'] = wrap.data('timelineTypeId');

	url = url + timelineData['type'] + '/' + timelineData['type_id'];

	if (timelineData['type'] && timelineData['type_id']) {

		$.getJSON(url, function( data ) {
			timelineData['timeline'] = data;

			var template = Handlebars.compile ( $('#timeline-template').html() );
			wrap.html(template(timelineData));

			scrollbarInit();
			addNote();
		});

	}
}

// Add note
function addNote() {
	$('.pls_timeline-note-form input').on('keypress', function(e) {
		var self = $(this);
		var form = self.closest('form');

		if (e && e.keyCode == 13) {

			var url = self.data('url');
			var type = self.data('type');
			var typeId = self.data('typeId');
			var value = self.val();
			var wrap = $('.pls_timeline-panel');
			var content = wrap.find('.scroll-content');

			if (url && type && typeId && value) {
				$.ajax({
					type: "POST",
					url: url,
					data: {'description' : value, 'type': type, 'type_id': typeId},
			        dataType: "json",
					success: function (data) {

						if (data.success) {
							var template = Handlebars.compile ( $('#note-template').html() );
							content.prepend(template(data.note));
							wrap.removeClass('empty');

							self.val(' ');
						}

					},
				});
			}

		}

	});
}


// INIT
$(document).on('ready', function() {
	timelineInit();
});