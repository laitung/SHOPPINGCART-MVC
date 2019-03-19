<?php if(!defined('APP_PATH')) { die('can not access'); } ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gio hang</title>
    <link rel="stylesheet" href="publics/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1 class="text-center">
			List Products
		</h1>
		<div class="row">
			<?php foreach($data['lstPd'] as $key => $item): ?>
			<div class="col-md-4" style="border: 1px solid #ccc; padding: 10px;">
				<img style="width: 100px; height: 100px;" src="<?php echo 'publics/uploads/images/' . $item['image_pd']; ?>">
				<p><?= $item['name_pd']; ?></p>
				<p><?= number_format($item['price_pd']); ?>vnd</p>
				<a href="?c=cart&m=add&id=<?= $item['id']; ?>" class="btn btn-info">Add Cart</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</body>
</html>