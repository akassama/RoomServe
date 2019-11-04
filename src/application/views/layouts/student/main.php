<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><? echo $page_title?$this->stuent->first_name.' | '.$page_title:$this->student->first_name ?></title>

    <!-- favicons -->
    <? $this->load->view('favicons'); ?>

    <link rel="stylesheet" href="/assets/stylesheets/css/admin/main.css?version=<?=project('version')?>">

    <script src="/assets/plugins/pace/pace.min.js?version=<?=project('version')?>" data-pace-options='{ "ajax": true }'></script>
    <script src="/assets/plugins/respond/respond.min.js?version=<?=project('version')?>"></script>
    <script>
    	var BASEURL = '<?=create_url()?>';
    	var user_id = '<?=$this->student->user_id?>';
    </script>
</head>
<body>
<div class="pls_main-wrap">
	<div class="pls_page-loader"><div></div></div>

	<? if($this->user->user_role_id == USER_ROLE_ADMINISTRATOR):?>
		<!-- Sticky panel -->
		<a href="/admin/partners" class="pls_sticky-panel">
			<div class="container-fluid">
				<div class="link"><?=lang('back_to_admin')?></div>
				<div class="info"><?=lang('logged_in_as')?> “<?=$this->student->name?>“</div>
			</div>
		</a><!-- /sticky panel -->
	<? endif;?>

	<div class="pls_main">

		<!-- Topbar -->
		<div class="pls_topbar">
			<div class="container-fluid">

				<!-- topbar - left -->
				<div class="pls_topbar-left">
					<? if (current_page() != "dashboard") : ?>
						<div class="pls_topbar-actionbar">
							<a href="<?='/student/'.$this->student->user_id.'/dashboard' ?>" title="<?=lang('form_btn_back_to_dashboard')?>">
								<div class="pls_topbar-action dashboard" ></div>
								<span><?=lang('module_dashboard')?></span>
							</a>
						</div>
					<? endif;?>
				</div><!-- /topbar - left -->

				

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

							<div class="pls_user-widget-name"><?=$this->user->first_name.' '.$this->user->last_name ?><br></div>

							<div class="pls_user-widget-avatar"
								<? if ($this->user->photo) : ?>
									style="background-image: url('/files/photos/<?=($this->user->user_role_id == USER_ROLE_ADMINISTRATOR)?'admin':'partner_admin'?>/avatar/s/<?=$this->user->photo?>');"
								<? endif; ?>
							></div>

						</a><!-- /user name & avatar -->

						<!-- user dropdown menu -->
						<div class="dropdown-menu dropdown-menu-right pls_user-widget-menu" aria-labelledby="user-widget-dropdown">
							<div class="dropdown-standart-menu">
							    <a href="<?='/student/'.$this->student->user_id.'/profile' ?>"><?=lang('module_my_profile')?></a>
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
