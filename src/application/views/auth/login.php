<!-- Logo -->
<img src="<?=project('logo')?>" alt="<?=lang('project_title')?>" class="pls_auth-logo"><!-- /logo -->

<!-- Sign-in panel -->
<div class="pls_auth-panel">
    <form action="/auth/login" method="post" data-validate="true">

        <!-- titlebar -->
        <h1 class="pls_title-2"><span>Login</span></h1><!-- /titlebar -->

        <!-- form message -->
        <div class="pls_form-message">
            <?=flash_messages()?>
        </div><!-- /form message -->

        <!-- email -->
        <div class="pls_field-wrap">
            <div class="pls_field">
                <div class="pls_input-ico email"></div>
                <input type="text" name="form[email]" class="pls_input white" data-rule-email="true" placeholder="<?=lang('form_email_address')?>" required>
            </div>
        </div><!-- /email -->

        <!-- password -->
        <div class="pls_field-wrap">
            <div class="pls_field">
                <div class="pls_input-ico password"></div>
                <input type="password" name="form[password]" class="pls_input white" placeholder="<?=lang('form_password')?>" required>
            </div>
        </div><!-- /password -->

        <!-- submit button -->
        <div class="text-center">
            <button type="submit" class="pls_button color-info"><?=lang('form_btn_sign_in')?></button>
        </div><!-- /submit button -->

        <!-- forgot password link -->
        <div class="text-center"><a href="/auth/forgot_password" class="pls_auth-link"><?=lang('form_forgot_password')?></a></div><!-- /forgot password link -->
        <div class="text-center">New to system? <a href="/auth/signup" class="pls_auth-link">Register</a></div><!-- /forgot password link -->

    </form>
</div><!-- /sign-in panel -->
