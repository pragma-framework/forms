<?php
$block = $object;
?>
<div class="layered-form-block" id="<?= $block->getId(); ?>">
	<?php
	if($block->getLabel() != ''){
		?>
		<h<?= $block->getHeaderLevel(); ?>><?= $block->getLabel(); ?></h<?= $block->getHeaderLevel(); ?>>
		<?php
	}
	foreach($block->getFields() as $field){
		$label = $field['label'];
		$f = $field['field'];
		switch($f->getType()){
			case 'hidden':
			case 'submit':
				?><?= $f->render(); ?><?php
				break;
			case 'radio':
			case 'checkbox':
				?>
				<div class="layered-field <?= $f->getType(); ?>">
					<label for="<?= $f->id; ?>"><?= $label; ?><?= $f->render(); ?></label>
				</div>
				<?php
				break;
			default:
				?>
				<div class="layered-field <?= $f->getType(); ?>">
					<label for="<?= $f->id; ?>"><?= $label; ?></label>
					<?= $f->render(); ?>
				</div>
				<?php
				break;
		}
	}
	?>
</div>
