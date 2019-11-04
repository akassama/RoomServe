<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><? echo $page_title?lang('project_title').' | '.$page_title:lang('project_title') ?></title>

    <!-- favicons -->
    <? $this->load->view('favicons'); ?>

    <link rel="stylesheet" href="/assets/stylesheets/css/admin/main.css?version=<?=project('version')?>">

    <script src="/assets/plugins/pace/pace.min.js?version=<?=project('version')?>" data-pace-options='{ "ajax": true }'></script>
    <script src="/assets/plugins/respond/respond.min.js?version=<?=project('version')?>"></script>
    <script>
    	var BASEURL = '<?=create_url()?>';
    </script>
</head>
<body>
<div class="pls_main-wrap">
	<div class="pls_page-loader"><div></div></div>

	<div class="pls_main">

		<!-- Topbar -->
		<div class="pls_topbar">
			<div class="container-fluid">

				<!-- topbar - left -->
				<div class="pls_topbar-left">
					<? if (current_page() != "dashboard") : ?>
						<div class="pls_topbar-actionbar">
							<a href="/admin/dashboard" title="<?=lang('form_btn_back_to_dashboard')?>">
								<div class="pls_topbar-action dashboard" ></div>
								<span><?=lang('module_dashboard')?></span>
							</a>
						</div>
					<? endif;?>
				</div><!-- /topbar - left -->

				<!-- topbar - center -->
				<div class="pls_topbar-center">
					<a href="/admin/dashboard" class="pls_topbar-partner-logo" style="background-image: url('<?=project('logo')?>');" title="<?=lang('project_title')?>">
						<?=lang('project_title')?>
					</a>
				</div><!-- /topbar - center -->

				<!-- topbar - right -->
				<div class="pls_topbar-right">

					<!-- user widget -->
					<div class="pls_user-widget dropdown">

						<!-- user name & avatar -->
						<a href="#" class="pls_user-widget-info dropdown-toggle"
							id="user-widget-dropdown"
							role="button"
							data-toggle="dropdown"
							aria-haspopup="true"
							aria-expanded="false">

							<div class="pls_user-widget-name"><?=$this->user->first_name.' '.$this->user->last_name ?><br><span><?=$this->user->group_name?></span></div>

							<div class="pls_user-widget-avatar"
								<? if ($this->user->photo) : ?> style="background-image: url('/files/photos/admin/avatar/s/<?=$this->user->photo?>');" <? endif; ?>
							></div>

						</a><!-- /user name & avatar -->

						<!-- user dropdown menu -->
						<div class="dropdown-menu dropdown-menu-right pls_user-widget-menu" aria-labelledby="user-widget-dropdown">
							<div class="dropdown-standart-menu">
							    <a href="/admin/profile"><?=lang('module_my_profile')?></a>
							    <a href="/auth/logout"><?=lang('form_logout')?></a>
							</div>
					  	</div><!-- /user dropdown menu -->

					</div><!-- /user widget -->

				</div><!-- /topbar - right -->

			</div>
		</div><!-- /topbar -->

		<?=$content?>

	</div>

	<!-- Footer -->
	<? $this->load->view('/partials/partial-footer'); ?>

</div>
</body>
</html>
