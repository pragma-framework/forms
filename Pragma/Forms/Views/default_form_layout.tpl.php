<?php
$form = $this->get('form');
$blocks = $form->getBlocks();
?>
<div class="layered-form">
	<?= $form->get_header(); ?>
	<?php
	//We starts with the hidden fields especially for the CSRFTags
	if( ! empty($form->getBoxes()) ){
		foreach($form->getBoxes() as $boxname){
			?>
			<?= $form->hidden_field(['name' => $boxname]); ?>
			<?php
		}
	}
	foreach($blocks as $block){
		$this->partial($block->getLayout(), $block);
	}
	?>
	<?= $form->close(); ?>
</div>
