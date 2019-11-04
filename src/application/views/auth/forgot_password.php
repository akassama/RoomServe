<!-- Logo -->
<img src="<?=project('logo')?>" alt="<?=lang('project_title')?>" class="pls_auth-logo"><!-- /logo -->

<!-- Forgot password panel -->
<div class="pls_auth-panel">
    <form action="/auth/forgot_password" method="post" data-validate="true">

        <!-- titlebar -->
        <h1 class="pls_title-2"><span><?=lang('form_reset_password')?></span></h1><!-- /titlebar -->

        <!-- form message -->
        <div class="pls_form-message">
            <?=flash_messages();?>
        </div><!-- /form message -->

        <!-- email -->
        <div class="pls_field-wrap">
            <div class="pls_field">
                <div class="pls_input-ico email"></div>
                <input type="text" name="form[email]" class="pls_input white" data-rule-email="true" placeholder="<?=lang('form_email_address')?>" required>
            </div>
        </div><!-- email -->

        <!-- submit button -->
        <div class="text-center">
            <button type="submit" class="pls_button color-info"><?=lang('form_btn_send')?></button>
        </div><!-- /submit button -->

        <!-- sign-in link -->
        <div class="text-center"><a href="/auth/login" class="pls_auth-link"><?=lang('form_sign_in')?></a></div><!-- /sign-in link -->

    </form>
</div><!-- /forgot password panel -->
