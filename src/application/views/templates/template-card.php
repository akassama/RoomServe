<button type="button"
	data-modal-id="<?=$options['modal_id']?>"
	data-link-type="<?=$options['type']?>"
	data-link="<?=$options['link']?>"
	data-id="<?=$options['id']?>"
	data-parent-id="<?=$options['parent_id']?>"
	data-module="<?=$options['module']?>"
	data-module-type="<?=$options['module_type']?>"
	data-card-num="<?=$options['card_num']?>"
	data-card-limit="<?=$options['card_limit']?>"
	data-card-wrap="<?=$options['card_wrap']?>"
	data-card-des="<?=$options['des']?>"
	data-photo-link="<?=$options['photo_link']?>"
	data-modal-editor="<?=isset($options['modal_editor'])?'true':'false'?>"
	<? if (isset($options['modal_map'])) : ?>
		data-modal-map="<?=$options['modal_map']?>"
	<? endif; ?>
	class="pls_form-card <?=$options['type']=='create'?'add':''?>">
	
	<? if ($options['type'] == "create") : ?>
		<div class="ico-add"></div>
		<div class="info"><?=$options['add_button']?></div>
	<? else : ?>
		<div class="picture" 
			<? if ($options['photo']) : ?> style="background-image: url('<?=$options['photo_link'].$options['photo']?>');" <? endif;?> >
			<? if ($options['status']) : ?> <div class="status status-<?=$options['status']?>"></div> <? endif;?>
		</div>
		<div class="info">
			<div class="name"><?=$options['name']?></div>
			<div class="des"><?=$options['des']?></div>
		</div>
	<? endif; ?>
</button>