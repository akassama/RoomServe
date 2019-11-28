<div class="container-fluid">
	<form action="/admin/settings/cleaning_options/update/<?=$data->option_id?>" method="post" data-validate="true">

		<!-- Titlebar -->
		<h1 class="pls_title-1">
			<!-- back button -->
			<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

			<!-- page title -->
			<span>Cleaning option</span><!-- /page title -->

            <?/* if($is_access_multilang): ?>
                <!-- lang switcher -->
                <div class="dropdown">
                    <button class="pls_button color-white flag-<?=$lang?>" id="drop-lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    	<?=$lang?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="drop-lang">
                        <div class="pls_languages-panel">

                            <? foreach ($languages as $item) : ?>
                                <a href="/admin/settings/categories/update/<?=$data->option_id.'/'.$item?>"
                                	class="pls_language flag-<?=$item?> <?=($lang==$item?'added':'')?>">
                                	<span><?=$item;?></span>
                                </a>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div><!-- /lang switcher -->
            <? endif; */?>
		</h1><!-- /titlebar -->

		<!-- Form message -->
		<div class="pls_form-message">
			<?=flash_messages()?>
		</div><!-- /form message -->

		<!-- Form wrap -->
		<div class="pls_form-wrap">

			<!-- group -->
			<div class="pls_form-group">

		        <!-- status -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label required"><?=lang('form_status')?></label>
                    <div class="pls_switcher-group">
                        <label class="pls_switcher switcher-success">
                        	<input type="radio" name="form[status]" value="1" checked required><div><?=lang('form_btn_active')?></div>
                        </label>
                        <label class="pls_switcher switcher-danger">
                        	<input type="radio" name="form[status]" value="0" required><div><?=lang('form_btn_inactive')?></div>
                        </label>
                    </div>
                </div><!-- /status -->

				<!-- name -->
		        <div class="pls_field-wrap">
		        	<label class="pls_field-label required"><?=lang('form_name')?></label>
		            <div class="pls_field">
		                <input type="text" name="form[name]" class="pls_input" value="<?=$data->name?>" required>
		            </div>
		        </div><!-- /name -->

                
                <!-- price -->
		        <div class="pls_field-wrap">
		        	<label class="pls_field-label required">Service price (in Ruble)</label>
		            <div class="pls_field">
		                <input type="number" name="form[price]" class="pls_input" value="<?=$data->price?>" required>
		            </div>
		        </div><!-- /price -->


                        <!-- about us -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label">Description</label>
                    <div class="pls_field">
                        <textarea name="form[description]" id="editor" class="pls_textarea" data-editor="true"><?=$data->description?></textarea>
                    </div>
                </div><!-- /about us -->

		    </div><!-- /group -->

		    <div class="pls_form-row"><hr class="pls_form-divider"></div>

		    

		</div><!-- /form wrap -->

		<!-- save button -->
		<div class="pls_form-buttons">
			<button type="submit" class="pls_button color-success ico-color-white ico-check"><?=lang('form_btn_save')?></button>
		</div><!-- /save button -->

	</form>
</div>


<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['uploader' => true]); ?>

<!-- Init -->
<script>
	$(document).on('ready', function() {
		$("input[name='form[status]'][value='<?=$data->status?>']").prop("checked", true);
		$("input[name='form[icon]'][value='<?=$data->icon?>']").prop("checked", true);
	});
</script>
