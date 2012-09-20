<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>アップロードフォーム</title>
	<?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
			
			<?php if (isset($error)): ?>
			<p class="alert alert-error"><?php echo $error; ?></p>
			<?php endif; ?>
			
			<?php
			echo Form::open(
				array(
					'name' => 'upload',
					'enctype' => 'multipart/form-data',
				)
			);
			?>
			<?php echo Form::file('file'); ?>
			<?php echo Form::submit('submit', 'アップロード', array('class' => 'btn')); ?>
			<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</body>
</html>
