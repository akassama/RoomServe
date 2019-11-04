<div class="container-fluid">
	<form action="/admin/profile" method="post" data-validate="true">

		<!-- Titlebar -->
		<h1 class="pls_title-1">
			<!-- back button -->
			<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

			<!-- page title -->
			<span><?=lang('module_my_profile')?></span><!-- /page title -->
		</h1><!-- /titlebar -->

		<!-- Form message -->
		<div class="pls_form-message">
			<?=flash_messages()?>
		</div><!-- /form message -->

		<!-- Form wrap -->
		<div class="pls_form-wrap">

			<!-- group - basic information -->
			<div class="pls_form-group">

                <!-- first name -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label required"><?=lang('form_first_name')?></label>
                    <div class="pls_field">
                        <input type="text" name="form[first_name]" class="pls_input" value="<?=$data->first_name?>" required>
                    </div>
                </div><!-- /first name -->

                <!-- last name -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label"><?=lang('form_last_name')?></label>
                    <div class="pls_field">
                        <input type="text" name="form[last_name]" class="pls_input" value="<?=$data->last_name?>">
                    </div>
                </div><!-- /last name -->

                <!-- email -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label required"><?=lang('form_email')?></label>
                    <div class="pls_field">
                        <input type="text" name="form[email]" class="pls_input" data-rule-email-exist="true" data-value="<?=$data->email?>" value="<?=$data->email?>" required>
                    </div>
                </div><!-- /email -->

                <!-- password -->
                <? $this->load->view('/partials/partial-password', ['status' => $data->status, 'id' => $data->user_id]); ?>

		    </div><!-- /group - basic information -->

		</div><!-- /form wrap -->

		<!-- save button -->
		<div class="pls_form-buttons">
			<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>
		</div><!-- /save button -->

	</form>
</div>

<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['uploader' => true]); ?>

<!-- Init -->
<script>
	$(document).on('ready', function() {
		$("input[name='form[status]'][value='<?=$data->status?>']").prop("checked", true);
	});
</script>
