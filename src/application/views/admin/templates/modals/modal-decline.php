<!-- Decline modal template -->
<div class="modal fade" id="pls_decline-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?=$url?>" method="post" data-validate="true">
            <input type="hidden" name="form[id]" value="<?=$id?>">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?=lang('form_decline')?></h4>
                    <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="scrollbar-inner">

                        <!-- form message -->
                        <div class="pls_form-message-modal"></div><!-- /form message -->

                        <!-- group - account -->
                        <div class="pls_form-group">

                            <!-- decline message -->
                            <div class="pls_field-wrap">
                                <label class="pls_field-label required"><?=lang('form_decline_reason')?></label>
                                <div class="pls_field">
                                    <textarea name="form[message]" class="pls_textarea" required></textarea>
                                </div>
                            </div><!-- /decline message -->

                        </div><!-- /group - account -->

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="pls_button color-info ico-check" data-submit><?=lang('form_btn_send')?></button>
                </div>
            </div>

        </form>
    </div>
</div>
