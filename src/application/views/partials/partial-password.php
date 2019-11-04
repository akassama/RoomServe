<?
$forJS = false;

$disabled = "disabled";
$class = "hide";
$btn = true;

if ($status == STATUS_DRAFT) {
	$disabled = "";
	$class = "no-arrow";
	$btn = false;
}
if (isset($templater)) {
	$forJS = true;
	$disabled = "{{pass_disabled}}";
	$class = "{{pass_class}}";
	$btn = true;
}
?>

<? if ($btn) : ?>
	<? if ($forJS) : ?> {{#if update}} <? endif; ?>
	<!-- change password btn -->
    <button type="button" class="pls_button size-slim color-info"
    	data-show="#pls_change-password-<?=$id?>"
    	data-text-close="<?=lang('form_btn_cancel')?>"
    	data-text-open="<?=lang('form_btn_change_password')?>"
    	data-class-close="color-danger"
    	data-class-open="color-">

    	<?=lang('form_btn_change_password')?>
    </button>
    <!-- /change password btn -->

	<? if ($forJS) : ?> {{/if}} <? endif; ?>
<? endif; ?>

<div class="pls_form-sub-group <?=$class?>" id="pls_change-password-<?=$id?>">
	<div class="pls_row-8 inline">
		<div class="pls_column-50">
			<!-- password -->
	        <div class="pls_field-wrap">
	        	<label class="pls_field-label required"><?=lang('form_password')?></label>
	            <div class="pls_field">
	                <input type="password" name="form[password]" class="pls_input" id="password-<?=$id?>" <?=$disabled?> required>
	            </div>
	        </div><!-- /password -->
	    </div>

		<div class="pls_column-50">
	        <!-- confirm password -->
	        <div class="pls_field-wrap">
	        	<label class="pls_field-label required"><?=lang('form_confirm_password')?></label>
	            <div class="pls_field">
	                <input type="password" name="form[confirm_password]" class="pls_input" data-rule-equal-to="password-<?=$id?>" <?=$disabled?> required>
	            </div>
	        </div><!-- /confirm password -->
	    </div>
	</div>
</div>
