<div class="container-fluid">
	<form action="<?=create_partner_url('/orders/update/'.$data->order_id.'/'.$lang)?>" method="post" data-validate="true">

		<!-- Titlebar !-->
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


		<div class="">
                <!-- New order form (Draft data)-->
			<? $offer_options['parent_id'] = $location_options['parent_id'] = $data->order_id;

			$draft_options = [
				'data' => $data,
				'offer_options' => $offer_options,
				'location_options' => $location_options,
				'show_pin' => true,
				'approve_page' => true,
				'approve' => false,
				'title'	=> lang('form_title_new'),
				'desc'	=> lang('form_title_new_desc')
			];

			// if ($original_data) {
			// 	$draft_options['title'] = lang('form_title_editable');
			// 	$draft_options['desc'] = lang('form_title_editable_desc');
			// }

			$this->load->view('/student/partials/partial-order', $draft_options); ?>
		</div>

		<!-- form buttons -->
		<div class="pls_form-buttons">
		<?php if ($data->status != ORDER_STATUS_CANCELLED): ?>
			<!-- save button -->
			<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>
		<?php endif; ?>
		</div><!-- /form buttons -->

	</form>
</div>


<!-- Plugins & scripts -->
<? $this->load->view('/partials/partial-plugins', ['editor' => true, 'uploader' => true, 'templater' => true, 'equal_height' => true]); ?>

<!-- Init -->
<script>
	$(document).on('ready', function() {
		<? if ($original_data) : ?>
			$("input[name='old-form[status]'][value='<?=$original_data->status?>']").prop("checked", true);
			$("input[name='old-form[option_id]'][value='<?=$original_data->option_id?>']").prop("checked", true).trigger('change');
		<? endif; ?>

		<? if (isset($data->active_offer)) : ?>
			<? if ($data->active_offer == 'new') : ?>
				$('button[data-module-type="offer"][data-link-type="create"]').click();
			<? else : ?>
				$('button[data-module-type="offer"][data-id="<?=$data->active_offer?>"]').click();
			<? endif; ?>
		<? endif; ?>

		$("input[name='form[status]'][value='<?=$data->status?>']").prop("checked", true);
		$("input[name='form[option_id]'][value='<?=$data->option_id?>']").prop("checked", true).trigger('change');

		equalHeight('.pls_locations-group');
	});
</script>
