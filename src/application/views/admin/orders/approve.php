<div class="container-fluid">
	<form action="/admin/orders/approve/<?=$draft_data->order_id?>/<?=$lang?>" method="post" data-validate="true">

		<!-- Titlebar -->
		<h1 class="pls_title-1">
			<!-- back button -->
			<a class="pls_back-button" data-back="true"><span><?=lang('form_btn_back')?></span></a><!-- /back button -->

			<!-- page title -->
			<span><?=lang('module_order')?></span><!-- /page title -->
		</h1><!-- /titlebar -->

		<? if ($decline_message) : ?>
			<div class="pls_form-decline-message">
				<h4 class="title"><?=lang('form_decline_reason')?></h4>
				<?=$decline_message->message?>
			</div>
		<? endif; ?>

		<!-- Form message -->
		<div class="pls_form-message"></div><!-- /form message -->

		<?
		// Offer options
		$offer_options = [
			'modal_id'			=> '#pls_order-offer',
			'type'				=> 'update',
			'create_link'		=> '/admin/offers/create/',
			'update_link'		=> '/admin/offers/update/',
			'remove_link'		=> '/admin/offers/delete/',
			'id'				=> '',
			'parent_id'			=> '',
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
			'parent_id'			=> '',
			'module'			=> 'order',
			'module_type'		=> 'location',
			'card_num'			=> 1,
			'card_limit'		=> 1,
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

		<div class="<?=$original_data?'pls_form-approval':''?>">
			<!-- Old order form (Original data)-->
			<? if($original_data) {
				$offer_options['parent_id'] = $location_options['parent_id'] = $original_data->order_id;

				$original_options = [
					'data' => $original_data,
					'offer_options' => $offer_options,
					'location_options' => $location_options,
					'show_pin' => true,
					'approve_page' => true,
					'approve' => true,
					'title'	=> lang('form_title_approved'),
					'desc'	=> lang('form_title_approved_desc')
				];

				$this->load->view('/admin/partials/partial-order', $original_options);
			}?>

			<!-- New order form (Draft data)-->
			<?
			$offer_options['parent_id'] = $location_options['parent_id'] = $draft_data->order_id;

			$draft_options = [
				'data' => $draft_data,
				'offer_options' => $offer_options,
				'location_options' => $location_options,
				'show_pin' => true,
				'approve_page' => true,
				'approve' => false,
				'title'	=> lang('form_title_editable'),
				'desc'	=> lang('form_title_editable_desc')
			];
			?>

			<? $this->load->view('/admin/partials/partial-order', $draft_options); ?>
		</div>

		<!-- form buttons -->
		<div class="pls_form-buttons">

			<?php if ($draft_data->status != ORDER_STATUS_DECLINED): ?>
				<!-- decline button -->
				<button class="pls_button color-danger ico-color-white ico-cancel to-left"
					type="button"
					data-toggle="modal"
					data-target="#pls_decline-modal">
					<?=lang('form_btn_decline')?>
				</button>
			<?php endif; ?>

			<!-- approve button -->
			<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_approve')?></button>
		</div><!-- /form buttons -->

	</form>
</div>


<!-- Order decline modal -->
<? $this->load->view('/admin/templates/modals/modal-decline', ['id' => $draft_data->order_id, 'url' => '/admin/orders/decline']); ?>

<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['editor' => true, 'uploader' => true, 'templater' => true, 'map_picker' => true, 'tags' => true, 'equal_height' => true]); ?>

<!-- Init -->
<script>
	$(document).on('ready', function() {
		<? if ($original_data) : ?>
			$("input[name='old-form[option_id]'][value='<?=$original_data->option_id?>']").prop("checked", true).trigger('change');
		<? endif; ?>

		<? if (isset($active_offer)) : ?>
			$('.pls_form-wrap:not(.pls_disabled) button[data-module-type="offer"][data-id="<?=$active_offer?>"]').click();
		<? endif; ?>

		$("input[name='form[status]'][value='<?=$draft_data->status?>']").prop("checked", true);
		$("input[name='form[option_id]'][value='<?=$draft_data->option_id?>']").prop("checked", true).trigger('change');

		equalHeight('.pls_locations-group');
	});
</script>
