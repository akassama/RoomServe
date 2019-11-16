<div class="container-fluid">

	<!-- Titlebar -->
	<?php if ($this->session->userdata('loggedin')): ?>
	<h1 class="pls_title-1"><span><?=lang('welcome_back_note').$this->user->first_name ?></span></h1><!-- /titlebar -->
	<?php endif; ?>

	<!-- Modules -->
	<div class="pls_modules">
		
		<? foreach (get_main_nav() as $nav) : ?>
			<?if (! $nav['access'] || has_permission($nav['access'])):?>
				<a href="/admin/<?=$nav['url']?>" class="pls_module">
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
