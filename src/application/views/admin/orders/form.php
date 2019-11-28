<div class="container-fluid">

	<!-- Titlebar! -->
	<h1 class="pls_title-1">
		<!-- back button -->
		<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

		<!-- page title -->
		<span><?=lang('module_order')?></span><!-- /page title -->

		<!-- lang switcher -->
        <?/* if($is_access_multilang): ?>
            <div class="dropdown">
                <button class="pls_button color-white flag-<?=$lang?>" id="drop-lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                	<?=$lang?>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="drop-lang">
                    <div class="pls_languages-panel">

                        <? foreach ($languages as $item) : ?>
                            <a href="<?=create_url('/orders/update/'.$data->order_id.'/'.$item)?>"
                            	class="pls_language flag-<?=$item?> <?=($lang==$item?'added':'')?>">
                            	<span><?=$item;?></span>
                            </a>
                        <? endforeach; ?>

                    </div>
                </div>
            </div><!-- /lang switcher -->
        <? endif; */?>
	</h1><!-- /titlebar -->

	<? if ($decline_message) : ?>
		<div class="pls_form-decline-message">
			<h4 class="title"><?=lang('form_decline_reason')?></h4>
			<?=$decline_message->message?>
		</div>
	<? endif; ?>
	<? if ($cancel_message) : ?>
	    <div class="pls_form-decline-message">
		    <h4 class="title"><?=lang('form_cancel_reason')?></h4>
		    <?=$cancel_message->message?>
	    </div>
    <? endif; ?>

	<!-- Form message -->
	<div class="pls_form-message">
		<?=flash_messages()?>
	</div><!-- /form message -->

	<?
	// Offer options
	$offer_options = [
		'modal_id'			=> '#pls_order-offer',
		'type'				=> 'update',
		'create_link'		=> '/admin/offers/create/',
		'update_link'		=> '/admin/offers/update/',
		'remove_link'		=> '/admin/offers/delete/',
		'id'				=> '',
		'parent_id'			=> $data->order_id,
		'module'			=> 'order',
		'module_type'		=> 'offer',
		'card_num'			=> 1,
		'card_limit'		=> 99,
		'card_wrap'			=> '#pls_order-offers-card-wrap',
		'photo_link'		=> '',
		'photo'				=> '',
		'name'				=> '',
		'des'				=> '',
		'status'			=> '',
		'add_button'		=> lang('form_btn_add_offer'),
		'modal_map'			=> false,
		'modal_editor'		=> true,
	];

	// Location options
	$location_options = [
		'modal_id'			=> '#pls_order-location',
		'type'				=> 'update',
		'create_link'		=> '/locations/create/',
		'update_link'		=> '/locations/update/',
		'remove_link'		=> '/locations/delete/',
		'id'				=> '',
		'parent_id'			=> $data->order_id,
		'module'			=> 'order',
		'module_type'		=> 'location',
		'card_num'			=> 1,
		'card_limit'		=> 0,
		'card_wrap'			=> '#pls_order-locations-card-wrap',
		'photo_link'		=> '',
		'photo'				=> '',
		'name'				=> '',
		'des'				=> '',
		'status'			=> '',
		'add_button'		=> lang('form_btn_add_location'),
		'modal_map'			=> true,
	];
	?>

	<!-- Panels -->
	<div class="pls_panels-wrap form">

		<!-- main panel -->
		<div class="pls_main-panel">
			<form action="/admin/orders/update/<?=$data->order_id?>/<?=$lang?>" method="post" data-validate="true">

				<!-- Order form -->
				<? $this->load->view('/admin/partials/partial-order', ['data' => $data, 'offer_options' => $offer_options, 'location_options' => $location_options, 'show_pin' => false, 'approve_page' => false, 'approve' => false]); ?>

				<!-- form buttons -->
				<div class="pls_form-buttons text-center">
					<!-- remove button -->
					<? if ($data->status != STATUS_DRAFT) : ?>
						<button class="pls_button color-white ico-color-red no-text ico-remove"
							type="button"
							data-remove="/admin/orders/delete/<?=$data->order_id?>"
			                data-redirect="true">
						</button>
					<? endif; ?>
					<?php if ($data->status != ORDER_STATUS_CANCELLED): ?>
						<!-- save button -->
						<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>
					<?php endif; ?>
				</div><!-- /form buttons -->

			</form>
		</div><!-- /main panel -->

	</div><!-- /panels -->

</div>


<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['editor' => true, 'templater' => true]); ?>

<!-- Init -->
<script>
	$(document).on('ready', function() {
		$("input[name='form[option_id]'][value='<?=$data->option_id?>']").prop("checked", true).trigger('change');
		$("input[name='form[personnel_id]'][value='<?=$data->personnel_id?>']").prop("checked", true).trigger('change');

	});
</script>
