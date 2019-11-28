<div class="container-fluid">
	<form action="/admin/users/update/<?=$data->user_id?>" method="post" data-validate="true">

		<!-- Titlebar -->
		<h1 class="pls_title-1">
			<!-- back button -->
			<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

			<!-- page title -->
			<span>User</span><!-- /page title -->
		</h1><!-- /titlebar -->

		<!-- Form message -->
		<div class="pls_form-message">
			<?=flash_messages()?>
		</div><!-- /form message -->

		<!-- Form wrap -->
		<div class="pls_form-wrap">

			<? if ( isset($data) ) : ?>
				<input type="hidden" name="form[user_id]" value="<?=$data->user_id?>">
			<? endif; ?>

			<!-- group - account -->
			<div class="pls_form-group">
		        <h2 class="pls_form-title"><?=lang('form_account')?></h2>

		        <!-- status -->
		        <div class="pls_field-wrap">
		        	<label class="pls_field-label required"><?=lang('form_status')?></label>
		            <div class="pls_switcher-group">
						<label class="pls_switcher switcher-success"><input type="radio" name="form[status]" value="1" checked><div><?=lang('form_btn_active')?></div></label>
						<label class="pls_switcher switcher-danger"><input type="radio" name="form[status]" value="0"><div><?=lang('form_btn_inactive')?></div></label>
					</div>
		        </div><!-- /status -->

                <!-- role -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label required"><?=lang('form_role')?></label>
                    <div class="pls_switcher-group">
                        <label class="pls_switcher switcher-success"><input type="radio" name="form[user_role_id]" value="<?=USER_ROLE_PARTNER_ADMINISTRATOR?>" <? if($data->user_role_id == USER_ROLE_PARTNER_ADMINISTRATOR) echo ("checked");?>><div><?=lang('form_btn_user')?></div></label>
                        <label class="pls_switcher switcher-danger"><input type="radio" name="form[user_role_id]" value="<?=USER_ROLE_ADMINISTRATOR?>" <? if($data->user_role_id == USER_ROLE_ADMINISTRATOR) echo ("checked");?> ><div><?=lang('form_btn_admin')?></div></label>
                    </div>
                </div><!-- /role -->

				<!-- email -->
		        <div class="pls_field-wrap">
		        	<label class="pls_field-label required"><?=lang('form_email')?></label>
		            <div class="pls_field">
		                <input type="text" name="form[email]" class="pls_input" data-rule-email-exist="true" data-value="<?=$data->email?>" value="<?=$data->email?>" required>
		            </div>
		        </div><!-- /email -->

		        <!-- password -->
		        <? $this->load->view('/partials/partial-password', ['status' => $data->status, 'id' => $data->user_id]); ?>

		    </div><!-- /group - account -->

		    <div class="pls_form-row"><hr class="pls_form-divider"></div>

			<!-- group - basic information -->
			<div class="pls_form-group">
				<h2 class="pls_form-title"><?=lang('form_basic_info')?></h2>

				
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
					

	        </div><!-- /group - basic information -->

		</div><!-- /form wrap -->

		<!-- form buttons -->
		<div class="pls_form-buttons">
			<!-- remove button -->
			<? if ($data->status != STATUS_DRAFT) : ?>
				<button class="pls_button color-white ico-color-red no-text ico-remove"
					type="button"
					data-remove="/admin/administrators/delete/<?=$data->user_id?>"
	                data-redirect="true">
				</button>
			<? endif; ?>

			<!-- save button -->
			<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>
		</div><!-- /form buttons -->

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
