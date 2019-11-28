<div class="container-fluid">

	<!-- Titlebar! -->
	<h1 class="pls_title-1">
		<? if ( isset($data['back_url']) ) : ?>
			<!-- back button -->
			<a href="<?=$data['back_url']?>" class="pls_back-button"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->
		<? else : ?>
			<div></div>
		<? endif; ?>

		<!-- page title -->
		<span><?=$data['page_title']?></span><!-- /page title -->

        <div class="pls_form-message">
            <?=flash_messages()?>
        </div><!-- /form message -->

		<!-- action buttons -->
		<ul class="pls_buttons-group right">

			<!-- export to csv -->
			<li data-tooltip title="<?=lang('table_btn_export_to_csv')?>">
				<button class="pls_button color-white no-text ico-export" id="pls_table-export"></button>
			</li><!-- /export to csv -->

			<!-- table view -->
			<li class="dropdown pls_action-dropdown pls_table-view-dropdown" data-tooltip title="<?=lang('table_btn_table_view')?>">
				<button class="pls_button color-white no-text ico-view" id="drop-table-view"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				</button>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="drop-table-view" data-inside-click></div>
			</li><!-- /table view -->

			<? if ( is_array($data['add_btn']) ) : ?>
				<? if (has_permission($data['access']['add_btn'])) : ?>
					<!-- add button -->
					<li class="isolate">
						<a href="<?=$data['add_btn']['link']?>" <?=isset($data['add_btn']['attr'])?$data['add_btn']['attr']:''?> class="pls_button color-info ico-add" data-table-hide="true"><?=$data['add_btn']['text']?></a>
					</li><!-- /add button -->
				<? endif; ?>
			<? endif; ?>
		</ul><!-- /action buttons -->
	</h1><!-- /titlebar -->

	<!-- Form message -->
	<div class="pls_form-message size-full">
		<?=flash_messages()?>
	</div><!-- /form message -->

	<!-- Panels -->
	<div class="pls_panels-wrap" data-table-hide="true">

		<!-- filter -->
		<form class="pls_side-panel pls_form-group" id="pls_filter"></form><!-- /filter -->

		<div class="pls_main-panel">

			<!-- quick stats -->
			<div class="hide" id="pls_table-quick-stats" data-table-hide="true"></div><!-- /quick stats -->

			<!-- table -->
			<table class="pls_table datatable"></table><!-- /table -->
		</div>

	</div><!-- /panels -->

	<!-- No data -->
	<div class="pls_table-empty">
		<div class="pls_table-empty-ico <?=$data['empty']['ico']?$data['empty']['ico']:'default'?>"></div>
		<div class="pls_table-empty-text"><?=$data['empty']['text']?$data['empty']['text']:lang('module_empty_desc_'.$data['table']['module'])?></div>
		<? if ($data['add_btn'] ) : ?>
			<a href="<?=$data['add_btn']['link']?>" <?=isset($data['add_btn']['attr'])?$data['add_btn']['attr']:''?> class="pls_button color-info ico-add"><?=$data['add_btn']['text']?></a>
		<? endif; ?>
	</div><!-- /no data -->

</div>

<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['datatable' => true]); ?>

<!-- Template -->
<? $this->load->view('/templates/template-table-elements'); ?>

<!-- Cancellation modal -->
<? $this->load->view('/templates/modals/modal-cancellation'); ?> 

<!-- Init -->
<script>
	var list_generator_url = "<?=list_generator_url().$data['table']['module']?>";
	var list_state_url = "<?=($this->user->user_role_id == USER_ROLE_ADMINISTRATOR)?'/admin':'/student/'.$this->user->user_id?>/tools/get_list_state";

	$(document).ready(function() {
		list_generator('<?=$data['table']['url']?>', list_generator_url, '<?=$data['table']['module']?>', '<?=$data['table']['type']?>');
	});

</script>
