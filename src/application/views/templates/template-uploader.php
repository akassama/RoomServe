<!-- Photo uploader -->
<script id="photo-uploader-template" type="text/x-handlebars-template">
	<div class="pls_uploader-wrap {{classes}} {{#if uploaded}} uploaded {{/if}}" data-uploader-wrap>
		<label class="pls_uploader-label">
			<div class="pls_uploader-button">
				<div class="pls_button size-slim color-info ico-color-green ico-upload">{{upload-text}}</div>
			</div>
		</label>
		
		<a href="{{original}}" class="pls_uploader-bg zoom-photo {{#if uploaded}} swipebox {{/if}}" rel="gallery-1" style="background-image: url('{{thumb}}');"></a>

		<div class="pls_uploader-progress"><div style="width:0px;"></div></div>

		<div class="pls_uploader-button">
			<button type="button" class="pls_button size-slim color-danger ico-color-white ico-remove pls_uploader-remove">{{remove-text}}</button>
		</div>

		<input type="hidden" name="{{name}}" class="pls_uploader-hidden" />
	</div>
</script>


<!-- File uploader -->
<script id="attachment-uploader-template" type="text/x-handlebars-template">
	<div class="pls_attachment-uploader-wrap {{classes}} {{#if uploaded}} uploaded {{/if}}" data-uploader-wrap>
		<label class="pls_form-card add attachment">
			<div class="ico-upload"></div>
			<div class="info">{{upload-text}}</div>
		</label>

		<div class="pls_uploader-progress"><div style="width:0px;"></div></div>

		<input type="hidden" name="{{name}}" class="pls_uploader-hidden" />
	</div>
</script>


<script id="attachment-uploaded-template" type="text/x-handlebars-template">
	<button type="button" class="pls_form-card attachment with-action"
		id="drop-uploader-{{name}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

		<div class="picture"></div>
		<div class="info">
			<ul class="details">
				<li>{{file_extension}}</li>
				<li>{{file_size}}</li>
			</ul>
		</div>

		<div class="pls_form-card-more"></div>
	</button>

	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="drop-uploader-{{name}}">
		<div class="dropdown-standart-menu">
			<a href="{{original}}" target="_blank" class="pls_uploader-download">{{download-text}}</a>
			<button type="button" class="pls_uploader-remove">{{remove-text}}</button>
		</div>
	</div>
</script>