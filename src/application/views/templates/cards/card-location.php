<!-- Order location card template -->
<script id="pls_order-location-card-template" type="text/x-handlebars-template">
    <?
    $options['type']        = 'update';
    $options['link']        = $options['update_link'];
    $options['id']          = '{{location_id}}';
    $options['card_num']    = '{{card_num}}';
    $options['name']        = '{{mini_address}}';

    $this->load->view('/templates/template-card', ['options' => $options]);
    ?>
</script>
