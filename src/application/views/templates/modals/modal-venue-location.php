<!-- Location template -->
<div class="modal fade ajax" id="pls_order-location" data-id="<?=$data->location_id?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="/locations/update/<?=$data->location_id?>" method="post"
            data-validate="true"
            data-validate-modal="true"
            data-form-type="<?=$form_type?>"
            data-module="order"
            data-module-type="location"
            data-card="#pls_order-location-card-template"
            data-card-wrap="#pls_order-locations-card-wrap">

            <input type="hidden" name="form[location_id]" value="<?=$data->location_id?>">

            <div class="modal-content gllpLatlonPicker">
                <div class="modal-header">
                    <h4 class="modal-title"><?=lang('form_location')?></h4>

                    <button class="close" type="button" data-remove-modal="true"><span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body <?=$approve?'pls_disabled':''?>">
                    <div class="scrollbar-inner">

                        <!-- form message -->
                        <div class="pls_form-message-modal"></div><!-- /form message -->

                        <!-- group - address -->
                        <div class="pls_form-group">

                            <!-- map -->
                            <div class="pls_field-wrap">
                                <div class="pls_map-picker-wrap">
                                    <div class="pls_map-picker-search">
                                        <input type="text" class="pls_input" placeholder="<?=lang('form_map_search')?>">
                                        <button type="button" class="pls_button color-info ico-search no-text" value="search"></button>
                                    </div>

                                    <div class="pls_map-picker" id="map"></div>
                                    <div class="alert alert-warning text-center"><?=lang('form_map_note')?></div>

                                    <input type="hidden" name="form[latitude]" value="<?=$data->latitude?>">
                                    <input type="hidden" name="form[longitude]" value="<?=$data->longitude?>">
                                    <input type="hidden" name="form[country]" value="<?=$data->country?>">
                                    <input type="hidden" name="form[street]" value="<?=$data->street?>">
                                </div>
                            </div><!-- /map -->

                            <!-- full address -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label required"><?=lang('form_full_address')?></label>
                                <div class="pls_field">
                                    <input type="text" name="form[full_address]" class="pls_input" value="<?=$data->full_address?>" required>
                                </div>
                            </div><!-- /full address -->

                            <div class="pls_row-8 inline">

                                <div class="pls_column-50">
                                    <!-- city -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label required"><?=lang('form_city')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="form[city]" class="pls_input" value="<?=$data->city?>" required>
                                        </div>
                                    </div><!-- /city -->
                                </div>

                                <div class="pls_column-50">
                                    <!-- area -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label required"><?=lang('form_area')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="form[area]" class="pls_input" value="<?=$data->area?>" required>
                                        </div>
                                    </div><!-- /area -->
                                </div>

                            </div>

                        </div><!-- /group - address -->

                        <!-- group - contacts -->
                        <div class="pls_form-group">
                            <h2 class="pls_form-title"><?=lang('form_contacts')?></h2>
                            <div class="pls_row-8 inline">

                                <div class="pls_column-33">
                                    <!-- phone number -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label"><?=lang('form_phone_number')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="form[phone]" class="pls_input" value="<?=$data->phone?>">
                                        </div>
                                    </div><!-- /phone number -->
                                </div>

                                <div class="pls_column-33">
                                    <!-- email -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label"><?=lang('form_email')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="form[email]" class="pls_input" value="<?=$data->email?>" data-rule-email="true">
                                        </div>
                                    </div><!-- /email -->
                                </div>

                                <div class="pls_column-33">
                                    <!-- website -->
                                    <div class="pls_field-wrap">
                                        <label class="pls_field-label"><?=lang('form_website')?></label>
                                        <div class="pls_field">
                                            <input type="text" name="form[website]" class="pls_input" value="<?=$data->website?>">
                                        </div>
                                    </div><!-- /website -->
                                </div>

                            </div>
                        </div><!-- /group - contacts -->

                        <!-- group - opening hours -->
                        <? $this->load->view('/partials/partial-opening-hours', ['data' => $data->opening_hours]); ?>
                        <!-- /group - opening hours -->

                    </div>
                </div>
                <div class="modal-footer">
                    <?php if (!$approve): ?>
                        <button class="pls_button color-grey ico-color-red no-text ico-remove"
                        type="button"
                        data-remove="/locations/delete/<?=$data->location_id?>"
                        data-redirect="false"
                        data-type="modal">
                        <?=lang('form_btn_remove')?>
                    </button>

                    <?php endif; ?>

                    <?php if (!$approve): ?>
                        <button class="pls_button color-success ico-color-white ico-check" data-submit><?=lang('form_btn_save')?></button>
                    <?php endif; ?>
                </div>
            </div>

        </form>
    </div>
</div>
