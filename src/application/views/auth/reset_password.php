<!-- Logo -->
<img src="<?=project('logo')?>" alt="<?=lang('project_title')?>" class="pls_auth-logo"><!-- /logo -->

<!-- Reset password panel -->
<div class="pls_auth-panel">
    <form action="/auth/reset_password" method="post" data-validate="true">

        <!-- titlebar -->
        <h1 class="pls_title-2"><span><?=lang('form_reset_password')?></span></h1><!-- /titlebar -->

        <!-- form message -->
        <div class="pls_form-message">
            <?=flash_messages()?>
        </div><!-- /form message -->

        <input type="hidden" name="form[verification_code]" value="<?=$form['verification_code']?>">

        <!-- password -->
        <div class="pls_field-wrap">
            <div class="pls_field">
                <div class="pls_input-ico password"></div>
                <input type="password" name="form[password]" class="pls_input white" id="password" placeholder="<?=lang('form_password')?>" required>
            </div>
        </div><!-- password -->

        <!-- confirm password -->
        <div class="pls_field-wrap">
            <div class="pls_field">
                <div class="pls_input-ico password"></div>
                <input type="password" name="form[confirm_password]" class="pls_input white" placeholder="<?=lang('form_confirm_password')?>" data-rule-equal-to="password" required>
            </div>
        </div><!-- confirm password -->

        <!-- submit button -->
        <div class="text-center">
            <button type="submit" class="pls_button color-info"><?=lang('form_btn_reset')?></button>
        </div><!-- /submit button -->

    </form>
</div><!-- /reset password panel -->
