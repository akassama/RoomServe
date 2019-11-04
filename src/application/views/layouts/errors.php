<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=$heading?></title>

	<!-- favicons -->
    <? $this->load->view('favicons'); ?>
    
	<link rel="stylesheet" href="/assets/stylesheets/css/admin/error.css?version=<?=project('version')?>">
</head>
<body>
	<?=$content?>
</body>
</html>
