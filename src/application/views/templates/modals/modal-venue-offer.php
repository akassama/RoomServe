<div class="modal fade ajax" id="pls_order-offer" data-id="<?=$data->offer_id?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?=(isset($this->partner)) ? '/student/'. $this->partner->partner_id . '/offers/update/' : '/admin/offers/update/'?><?=$data->offer_id?>" method="post"
            data-validate="true"
            data-validate-modal="true"
            data-form-type="<?=$form_type?>"
            data-module="order"
            data-module-type="offer"
            data-card="#pls_order-offer-card-template"
            data-card-wrap="#pls_order-offers-card-wrap">

            <input type="hidden" name="form[order_id]" value="<?=$data->order_id?>">
            <input type="hidden" name="form[offer_id]" value="<?=$data->offer_id?>">

            <? if ($approve) { $approve = 'old-'; } ?>

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?=lang('form_offer')?></h4>

                    <button class="close" type="button" data-remove-modal="true"><span aria-hidden="true"></span></button>
                </div>

                <!-- modal - body -->
                <div class="modal-body <?=$approve?'pls_disabled':''?>">
                    <div class="scrollbar-inner">

                        <!-- form message -->
                        <div class="pls_form-message-modal"></div><!-- /form message -->


                        <!-- group - status -->
                        <div class="pls_form-group">

                            <!-- start & end date -->
                            <div class="pls_row-8 inline pls_daterange">

                                <div class="pls_column-50">
                                    <!-- start date -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label required"><?=lang('form_start_date')?></label>
                                        <div class="pls_field-desc"><?=lang('form_desc_offer_start_date')?></div>
                                        <div class="pls_field">
                                            <input type="text" name="<?=$approve?>form[start_date]" class="pls_input" value="<?=$data->start_date?>" required>
                                        </div>
                                    </div><!-- /start date -->
                                </div>

                                <div class="pls_column-50">
                                    <!-- end date -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label"><?=lang('form_end_date')?></label>
                                        <div class="pls_field-desc"><?=lang('form_desc_offer_end_date')?></div>
                                        <div class="pls_field">
                                            <input type="text" name="<?=$approve?>form[end_date]" class="pls_input" value="<?=$data->end_date?>">
                                        </div>
                                    </div><!-- /end date -->
                                </div>

                            </div><!-- /start & end date -->

                        </div><!-- group - status -->

                        <hr class="pls_form-divider">

                        <!-- group - basic information -->
                        <div class="pls_form-group">
                            <h2 class="pls_form-title"><?=lang('form_basic_info')?></h2>

                            <!-- discount percentage -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label required"><?=lang('form_discount_percentage')?></label>
                                <div class="pls_field">
                                    <input type="text" name="<?=$approve?>form[discount_percentage]" class="pls_input" placeholder="<?=lang('form_placeholder_offer_discount')?>" value="<?=$data->discount_percentage?>" data-rule-number="true" data-rule-range="1,99" required>
                                </div>
                            </div><!-- /discount percentage -->

                            <!-- name -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label required"><?=lang('form_name')?></label>
                                <div class="pls_field">
                                    <input type="text" name="<?=$approve?>form[name]" class="pls_input" placeholder="<?=lang('form_placeholder_offer_name')?>" value="<?=$data->name?>" required>
                                </div>
                            </div><!-- /name -->

                            <!-- description -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label required"><?=lang('form_terms_conditions')?></label>
                                <div class="pls_field">
                                    <textarea name="<?=$approve?>form[description]" class="pls_textarea" data-editor="true" placeholder="<?=lang('form_placeholder_offer_desc')?>" required><?=$data->description?></textarea>
                                </div>
                            </div><!-- /description -->

                            <!-- estimated spend & savings -->
                            <div class="pls_row-8 inline">

                                <div class="pls_column-33">
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label required"><?=lang('form_estimated_spend')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="<?=$approve?>form[estimated_spend]" class="pls_input" placeholder="<?=lang('form_placeholder_offer_estimated_spend')?>" value="<?=$data->estimated_spend?>" data-rule-number="true" data-rule-min="1" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="pls_column-33">
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label required"><?=lang('form_estimated_savings')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="<?=$approve?>form[estimated_savings]" class="pls_input" placeholder="<?=lang('form_placeholder_offer_estimated_savings')?>" value="<?=$data->estimated_savings?>" data-rule-number="true" data-rule-min="1" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="pls_column-33">
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label required"><?=lang('form_currency')?></label>
                                        <div class="pls_field">
                                            <select name="<?=$approve?>form[estimated_savings_currency]" class="pls_selectpicker" required>
                                                <option value=""><?=lang('form_choose')?></option>
                                                <?php foreach (project('currencies') as $currency): ?>
                                                    <option value="<?=$currency?>" <?=($data->estimated_savings_currency == $currency?"selected" : "")?>><?=$currency?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /estimated spend & savings -->

                            <!-- link -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label"><?=lang('form_link')?></label>
                                <div class="pls_field">
                                    <input type="text" name="<?=$approve?>form[link]" data-rule-url="true" class="pls_input" value="<?=$data->link?>">
                                </div>
                            </div><!-- /link -->

                            <!-- text for link -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label"><?=lang('form_text_for_link')?></label>
                                <div class="pls_field">
                                    <input type="text" name="<?=$approve?>form[text_for_link]" class="pls_input" value="<?=$data->text_for_link?>">
                                </div>
                            </div><!-- / text for link -->

                        </div><!-- /group - basic information -->

                        <hr class="pls_form-divider">

                        <!-- group - loyalty scheme -->
                        <div class="pls_form-group">
                            <h2 class="pls_form-title pls_margin-bottom-5"><?=lang('form_loyalty_schemes')?></h2>
                            <div class="pls_field-desc pls_margin-bottom-10"><?=lang('form_desc_offer_loyalty_schemes')?></div>
                            <div class="pls_form-loyalty-schemes">

                                <? foreach ($all_loyalty_schemes as $loyalty_scheme) : ?>
                                    <label class="pls_form-loyalty-scheme">
                                        <input type="checkbox"
                                            name="<?=$approve?>form[loyalty_schemes][]"
                                            value="<?=$loyalty_scheme['loyalty_scheme_id']?>"
                                            <?= (isset($selected_loyalty_schemes) && in_array($loyalty_scheme['loyalty_scheme_id'], $selected_loyalty_schemes))?'checked':''  ?>
                                            <? if ($data->status == STATUS_DRAFT) : ?> checked <? endif; ?>
                                            >
                                        <div class="info">
                                            <div class="logo" style="background-image: url('<?=$loyalty_scheme['logo']?'/files/photos/loyalty_scheme/logo/s/'.$loyalty_scheme['logo']:''?>');"></div>
                                            <?=$loyalty_scheme['name']?> <br>
                                            <span><?=$loyalty_scheme['number_of_members']?> <?=lang('form_loyalty_scheme_members')?></span>
                                        </div>
                                    </label>
                                <? endforeach; ?>

                            </div>
                        </div><!-- /group - loyalty scheme -->

                    </div>
                </div><!-- /modal - body -->

                <!-- modal - footer -->
                <div class="modal-footer">

                <?php if (!$approve): ?>

                    <!-- partner buttons -->
                    <? if (isset($this->partner)): ?>

                        <!-- remove button -->
                        <button class="pls_button color-grey ico-color-red no-text ico-remove"
                            type="button"
                            data-remove="<?=create_partner_url('/offers/delete/').'/'.$data->offer_id?>"
                            data-redirect="false"
                            data-type="modal">
                            <?=lang('form_btn_remove')?>
                        </button>

        				<!-- save button -->
        				<button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>

                    <!-- admin buttons -->
                    <? else : ?>

                        <!-- remove button -->
                        <button class="pls_button color-grey ico-color-red no-text ico-remove"
                            type="button"
                            data-remove="/admin/offers/delete/<?=$data->offer_id?>"
                            data-redirect="false"
                            data-type="modal">
                            <?=lang('form_btn_remove')?>
                        </button>

                        <!-- save button -->
                        <button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>

                    <? endif; ?>
                <?php endif; ?>

                </div><!-- /modal - footer -->

        </form>
    </div>

</div>
