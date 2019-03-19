<ul>
	<?php foreach ($data['lstPd'] as $key => $item): ?>
		<li style="padding: 5px 0px; border-bottom: 1px solid black;">
			<img src="<?php echo PATH_IMAGE . $item['image_pd']; ?>" alt="product" witdh = "45" height = "45">
			<span> </span>
			<span><?= $item['name_pd']; ?></span>
		</li>
	<?php endforeach ?>
	
</ul>