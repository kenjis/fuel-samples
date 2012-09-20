<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>アップロード成功</title>
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
			
			<h1>アップロードが成功しました</h1>
			
			<?php Debug::dump($file_data); ?>
			
			<p>
			<?php echo Html::anchor('upload', '他のファイルをアップロードする'); ?>
			</p>
			
			</div>
		</div>
	</div>
</body>
</html>
