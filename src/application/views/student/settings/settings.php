<div class="container-fluid">

	<!-- Titlebar -->
	<h1 class="pls_title-1">
		<!-- back button -->
		<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->
		
		<span><?=lang('module_settings')?></span>
	</h1><!-- /titlebar -->

	<!-- Modules -->
	<div class="pls_modules">

		<? foreach (get_partner_settings_nav() as $nav) : ?>
			<?if (! $nav['access'] || has_permission($nav['access'])):?>

				<a href="/student/<?=$this->partner->partner_id.'/'.$nav['url']?>" class="pls_module">
					<div class="pls_module-ico <?=$nav['class']?>"></div>
					<div class="pls_module-name"><?=$nav['title']?></div>
					<div class="pls_module-des"><?=$nav['desc']?></div>
				</a>

			<? endif; ?>
		<? endforeach; ?>

	</div><!-- /modules -->

</div>


<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins'); ?>
