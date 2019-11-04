<div class="pls_error-page">
	<div class="pls_error-ico error-not-found"></div>
	<h2 class="pls_title-1"><span><?=$heading?></span></h2>
	<div class="pls_error-des"><?=$message?></div>

	<div class="text-center">
		<a class="pls_button color-info" href="<?=(isset($partner_id))?'/student/'.$partner_id.'/dashboard':'/'?>"><?=lang('error_btn_back_to_homepage')?></a>
	</div>
</div>
