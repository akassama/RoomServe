<!-- Logo -->
<img src="<?=project('logo')?>" alt="<?=lang('project_title')?>" class="pls_auth-logo"><!-- /logo -->

<!-- Sign-in panel -->
<div class="pls_auth-panel">
    <form action="/auth/signup" method="post" data-validate="true">

        <!-- titlebar -->
        <h1 class="pls_title-2"><span>Register</span></h1><!-- /titlebar -->

<!-- form message -->
<div class="pls_form-message"></div><!-- /form message -->

<div class="flex-row">

    <div class="flex-col-xs-6">
        <!-- first name -->
        <div class="pls_field-wrap">
            <div class="pls_field pls_input_color-white">
                <input type="text" name="form[first_name]" class="pls_input" placeholder="<?=lang('form_first_name')?>" required autocomplete="off">
            </div>
        </div><!-- /first name -->
    </div>

    <div class="flex-col-xs-6">
        <!-- last name -->
        <div class="pls_field-wrap">
            <div class="pls_field pls_input_color-white">
                <input type="text" name="form[last_name]" class="pls_input" placeholder="<?=lang('form_last_name')?>" required autocomplete="off">
            </div>
        </div><!-- /last name -->
    </div>
</div>

<!-- email -->
<div class="pls_field-wrap">
    <div class="pls_field pls_input_color-white">
        <input type="text" name="form[email]" class="pls_input" data-rule-email="true" placeholder="<?=lang('form_email')?>" required autocomplete="off">
    </div>
</div><!-- /email -->

<div class="flex-row">

    <div class="flex-col-xs-6">
        <!-- password -->
        <div class="pls_field-wrap">
            <div class="pls_field pls_input_color-white">
                <input type="password" name="form[password]" id="password" class="pls_input" placeholder="<?=lang('form_password')?>" required autocomplete="new-password">
            </div>
        </div><!-- /password -->
    </div>

    <div class="flex-col-xs-6">
        <!-- confirm password -->
        <div class="pls_field-wrap">
            <div class="pls_field pls_input_color-white">
                <input type="password" name="form[confirm_password]" class="pls_input" data-rule-equal-to="password" placeholder="<?=lang('form_confirm_password')?>" required autocomplete="off">
            </div>
        </div><!-- confirm password -->
    </div>
</div>


<!-- submit button -->
<div class="text-center">
    <button type="submit" class="pls_button color-info" id="signup-button">
        Signup
    </button>
</div><!-- /submit button -->

<!-- sign-in link -->
<div class="text-center">
    Already registered? <a href="/auth/login" class="pls_auth-link"><?=lang('form_sign_in')?></a>
</div><!-- /sign-in link -->

    </form>
</div><!-- /sign-in panel -->
