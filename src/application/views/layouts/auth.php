<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=lang('project_title')?> - Sign in</title>

	<!-- favicons -->
    <? $this->load->view('favicons'); ?>

	<link rel="stylesheet" href="/assets/stylesheets/css/admin/auth.css?version=<?=project('version')?>">
</head>
<body>

	<!-- PAGE CONTENT -->
	<?=$content?>
	<!-- /PAGE CONTENT -->

	<!-- Plugins -->
	<script type="text/javascript" src="/assets/plugins/jquery/jquery-2.2.2.min.js?version=<?=project('version')?>"></script>
	<script type="text/javascript" src="/assets/plugins/validate/jquery.validate.min.js?version=<?=project('version')?>"></script>

	<!-- Scripts -->
	<script type="text/javascript" src="/assets/scripts/helpers.js?version=<?=project('version')?>"></script>
	<script type="text/javascript" src="/assets/scripts/auth.js?version=<?=project('version')?>"></script>
	<script type="text/javascript" src="/assets/scripts/components/validate.js?version=<?=project('version')?>"></script>
</body>
</html>