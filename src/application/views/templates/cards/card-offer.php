<!-- Order offer card template -->
<script id="pls_order-offer-card-template" type="text/x-handlebars-template">
    <?
    $options['type']        = 'update';
    $options['link']        = $options['update_link'];
    $options['id']          = '{{offer_id}}';
    $options['card_num']    = '{{card_num}}';
    $options['name']        = '{{name}}';

    $this->load->view('/templates/template-card', ['options' => $options]);
    ?>
</script>