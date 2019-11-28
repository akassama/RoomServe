<div class="container-fluid">
	<form action="/admin/settings/user_groups/<?=isset($data)?"update/".$data->user_group_id:"create/"?>" method="post" data-validate="true">

		<!-- Titlebar -->
		<h1 class="pls_title-1">
			<!-- back button -->
			<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

			<!-- page title -->
			<span><?=lang('module_user_group')?></span><!-- /page title -->

			<!-- save button -->
			<button type="submit" class="pls_button color-info ico-check"><?=lang('form_btn_save')?></button><!-- /save button -->
		</h1><!-- /titlebar -->

		<!-- Form message -->
		<div class="pls_form-message">
			<?=flash_messages()?>
		</div><!-- /form message -->

		<!-- Form wrap -->
		<div class="pls_form-wrap with-status">

			<? if ( isset($data) ) : ?>
				<input type="hidden" name="form[user_group_id]" value="<?=$data->user_group_id?>">
			<? endif; ?>

			<!-- group - basic information -->
			<div class="pls_form-group">

				<!-- status -->
		        <div class="pls_field-wrap">
		        	<label class="pls_field-label"><?=lang('form_status')?></label>
		        	<div class="pls_switcher-group">
						<label class="pls_switcher switcher-success"><input type="radio" name="form[status]" value="1" checked><div><?=lang('form_btn_active')?></div></label>
						<label class="pls_switcher switcher-danger"><input type="radio" name="form[status]" value="0"><div><?=lang('form_btn_inactive')?></div></label>
					</div>
		        </div><!-- /status -->

                <!-- role -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label"><?=lang('form_role')?></label>
                    <div class="pls_switcher-group">
                        <label class="pls_switcher switcher-success"><input type="radio" name="form[user_role_id]" value="<?=USER_ROLE_PARTNER_ADMINISTRATOR?>" <? if($data->user_role_id == USER_ROLE_PARTNER_ADMINISTRATOR) echo ("checked");?>><div><?=lang('form_btn_user')?></div></label>
                        <label class="pls_switcher switcher-danger"><input type="radio" name="form[user_role_id]" value="<?=USER_ROLE_ADMINISTRATOR?>" <? if($data->user_role_id == USER_ROLE_ADMINISTRATOR) echo ("checked");?> ><div><?=lang('form_btn_admin')?></div></label>
                    </div>
                </div><!-- /role -->

				<!-- name -->
				<div class="pls_field-wrap">
		        	<label class="pls_field-label"><?=lang('form_name')?></label>
		            <div class="pls_field">
		                <input type="text" name="form[name]" class="pls_input" value="<?=isset($data)?$data->name:''?>" required>
		            </div>
		        </div><!-- /name -->

	        </div><!-- /group - basic information -->

	        <input type="hidden" name="form[permissions][]">

	        <div class="pls_form-row"><hr class="pls_form-divider"></div>

	        <!-- Nav tabs -->
		  	<ul class="pls_buttons-group center" role="tablist">
			    <li role="presentation" class="active">
			    	<a href="#admin_permissions" class="pls_button color-white" role="tab" data-toggle="tab"><?=lang('form_administrator')?></a>
			    </li>
			    <li role="presentation">
			    	<a href="#partner_admin_permissions" class="pls_button color-white" role="tab" data-toggle="tab"><?=lang('form_partner_administrator')?></a>
			    </li>
		  	</ul>

			<!-- Tab panes -->
		  	<div class="tab-content">

		  		<!-- Administrator permissions -->
			    <div role="tabpanel" class="tab-pane active" id="admin_permissions">
					 <?php foreach ($all_permissions as $module => $actions): ?>
						<?php if ($module != $show_usergroup_perms): ?>
							<div class="pls_form-row"><hr class="pls_form-divider"></div>

							<!-- group - tags -->
							<div class="pls_form-group">
								<h2 class="pls_form-title"><?=lang('module_'.$module.'s')?></h2>

								<div class="pls_checkbox-tag-group">
									<?php foreach ($actions as $action): ?>
										<label class="pls_checkbox tag">
											<input type="checkbox"
												name="form[permissions][<?=$action ?>]"
												<?=(isset($permissions) && in_array($action, $permissions))?'checked':''  ?>
												<?=$disabled ?>
												value="1">
											<div></div>
											<span><?=lang('form_'.$action)?></span>
										</label>
									<?php endforeach; ?>
								</div>

							</div><!-- /group - tags -->
						<?php endif; ?>
					<?php endforeach; ?>
			    </div>
				

				<!-- Partner administrators permissions -->
			    <div role="tabpanel" class="tab-pane" id="partner_admin_permissions">
			    	<?php foreach ($all_partner_permissions as $module => $actions): ?>
						<?php if ($module != $show_usergroup_perms): ?>
							<div class="pls_form-row"><hr class="pls_form-divider"></div>

							<!-- group - tags -->
							<div class="pls_form-group">
								<h2 class="pls_form-title"><?=lang('module_'.$module.'s')?></h2>

								<div class="pls_checkbox-tag-group">
									<?php foreach ($actions as $action): ?>
										<label class="pls_checkbox tag">
											<input type="checkbox"
												name="form[permissions][<?=$action ?>]"
												<?=(isset($permissions) && in_array($action, $permissions))?'checked':''  ?>
												<?=$disabled ?>
												value="1">
											<div></div>
											<span><?=lang('form_'.$action)?></span>
										</label>
									<?php endforeach; ?>
								</div>

							</div><!-- /group - tags -->
						<?php endif; ?>
					<?php endforeach; ?>
			    </div>
		  	</div>

		</div><!-- /form wrap -->

		<!-- save button -->
		<div class="pls_form-buttons">
			<button type="submit" class="pls_button color-success ico-color-white ico-check"><?=lang('form_btn_save')?></button>
		</div><!-- /save button -->

	</form>
</div>

<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins'); ?>

<!-- Init -->
<script>
	$(document).on('ready', function() {
		$("input[name='form[status]'][value='<?=$data->status?>']").prop("checked", true);
	});
</script>