<div class="container-fluid">
	<form action="/student/<?=$this->partner->partner_id?>/settings/general" method="post" data-validate="true">

		<!-- Titlebar -->
		<h1 class="pls_title-1">
			<!-- back button -->
			<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

			<!-- page title -->
			<span><?=lang('module_general')?></span><!-- /page title -->
		</h1><!-- /titlebar -->

		<!-- Form message -->
		<div class="pls_form-message">
			<?=flash_messages()?>
		</div><!-- /form message -->

		<!-- Form wrap -->
		<div class="pls_form-wrap">

			<!-- group -->
			<div class="pls_form-group">

				<!-- logo -->
				<div class="pls_field-wrap">
					<label class="pls_field-label required"><?=lang('form_logo')?></label>
					<div class="pls_field-desc"><?=lang('form_desc_partner_logo')?></div>
					<input type="file"
						data-uploader="true"
						data-value="<?=$data->logo?'/files/photos/student/logo/s/'.$data->logo:''?>"
						data-original="<?=$data->logo?'/files/photos/student/logo/original/'.$data->logo:''?>"
						data-uploader-file-name="<?=$data->logo?>"
						data-uploader-name="form[logo]"
						data-uploader-id="<?=$data->partner_id?>"
						data-uploader-type="partner.logo"
						data-uploader-upload-text="<?=lang('form_btn_upload_logo')?>"
						data-uploader-remove-text="<?=lang('form_btn_remove_logo')?>">
				</div><!-- /logo -->

				<!-- name -->
		        <div class="pls_field-wrap">
		        	<label class="pls_field-label required"><?=lang('form_name')?></label>
		            <div class="pls_field">
		                <input type="text" name="form[name]" class="pls_input" value="<?=$data->name?>" required>
		            </div>
		        </div><!-- /name -->

		    </div><!-- /group-->


		    <div class="pls_form-row"><hr class="pls_form-divider"></div>

			<!-- redeem pin -->
		   	<? $this->load->view('/partials/partial-pin', ['redeem_pin' => $redeem_pin]); ?>

		</div><!-- /form wrap -->

		<!-- form buttons -->
		<div class="pls_form-buttons">
			<!-- save button -->
			<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>
		</div><!-- /form buttons -->

	</form>
</div>

<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['uploader' => true]); ?>
