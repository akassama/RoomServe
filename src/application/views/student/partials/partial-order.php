<?
if ($approve) {
	$approve = 'old-';
}
?>

<!-- Form wrap -->
<div class="pls_form-wrap <?=$approve?'pls_disabled':''?>">

	<!-- panel header -->
	<? if ($approve_page && $data->status != STATUS_DRAFT) : ?>
		<div class="pls_form-wrap-header <?=$approve?'approved':'pending'?>">
			<div class="icon"></div>
			<div class="info">
				<div class="title"><?=$title?></div>
				<div class="desc"><?=$desc?></div>
			</div>
		</div>
	<? endif; ?><!-- /panel header -->
    
    <!-- group - basic information -->
	<div class="pls_form-group">
		<h2 class="pls_form-title"><?=lang('form_basic_info')?></h2>

	<!-- name -->
    <div class="pls_field-wrap">
        	<label class="pls_field-label required">Apartnment #</label>
            <div class="pls_field">
                <input type="text" name="<?=$approve?>form[name]" class="pls_input" value="<?=$data->name;?>" required>
            </div>
        </div><!-- /name -->

        <!-- about us -->
		<div class="pls_field-wrap">
        	<label class="pls_field-label">Comment</label>
            <div class="pls_field">
            	<textarea name="<?=$approve?>form[description]" id="editor" class="pls_textarea" data-editor="true"><?=$data->description?></textarea>
            </div>
        </div><!-- /about us -->


    </div><!-- /group - basic information -->


    <div class="pls_form-row"><hr class="pls_form-divider"></div>

    <? if ($categories) : ?>

		<!-- group - categories -->
		<div class="pls_form-group">
			<h2 class="pls_form-title">Service option</h2>

			<!-- categories -->
			<div class="pls_form-categories"
				data-categories="/admin/settings/tags/get_ajax_tags"
				data-tags-wrap="<?=$approve?>data-tags-group-wrap"
				data-lang="<?=$lang?>"
				data-value='<?=$data->selected_tags?>'>

				<? foreach ($categories as $category) : ?>

					<label class="pls_form-category">
						<input type="radio" name="<?=$approve?>form[option_id]" value="<?=$category['option_id']?>" required>
						<div class="info"><?=$category['name']?></div>
					</label>

				<? endforeach; ?>

			</div><!-- /categories -->

        </div><!-- /group - categories -->

		<div class="pls_form-row"><hr class="pls_form-divider"></div>

	<? endif; ?>



    <!-- group - contact details -->
	<div class="pls_form-group">
		<h2 class="pls_form-title">Order details</h2>

		<div class="pls_row-8 inline">

			<div class="pls_column-50">
				<!-- start date -->
                <div class="pls_field-wrap">
                    <label class="pls_field-label">Order date</label>
                    <div class="pls_field-desc"><?=lang('form_desc_partner_start_date')?></div>
                    <div class="pls_field">
                        <input type="text" name="form[order_date]" class="pls_input pls_datepicker" value="<?=$data->order_date?>">
                    </div>
                </div><!-- /start date -->
			</div>

			<div class="pls_column-50">
				<!-- email -->
				<div class="pls_field-wrap">
                <label class="pls_field-label required">Payment type</label>
                    <div class="pls_field">
                        <select name="form[estimated_savings_currency]" class="pls_selectpicker" required>
                            <option value="cash" <?=$data->payment_type=='cash' ? 'selected' : ''?>>Cash</option>
                            <option value="card" <?=$data->payment_type=='card' ? 'selected' : ''?>>Bank card</option>
                        </select>
                    </div>
		        </div><!-- /email -->
			</div>

		</div>
    </div><!-- /group - contact details -->

</div><!-- /form wrap -->
