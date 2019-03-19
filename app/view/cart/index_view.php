<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Demo Cart PHP</title>
	<link rel="stylesheet" href="publics/css/bootstrap.min.css">
	<script type="text/javascript" src="publics/js/jquery.min.js"></script>
</head>
<body>
	<div class="container">
		<h3 class="text-center">Cart</h3>
		<p class="text-center">Co <b>(<?php echo (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : 0; ?> )</b> san pham </p>
		<div class="row">
			<div class="col-md-12">
			  <form action="?c=cart&m=update" method="POST" accept-charset="utf-8">
				<table>
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Image</th>
							<th>Quanity</th>
							<th>Price</th>
							<th>Money</th>
							<th width="5%">Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php $totalMoney = 0; ?>
						<?php foreach($cart as $key => $item): ?>
						<tr>
							<td><?= $key; ?></td>
							<td><?= $item['name']; ?></td>
							<td>
								<img style="width: 100px; height: 100px;" src="<?php echo 'publics/uploads/images/' . $item['image'];  ?>">
							</td>
							<td>
								<input onchange="updateCart('<?= $item['id']; ?>',this);" type="number" name="qty[<?= $item['id']; ?>]" value="<?= $item['qty']; ?>">
							</td>
							<td><?= number_format($item['price']); ?></td>
							<td><?= number_format($item['qty']*$item['price']); ?></td>
							<td>
								<a href="?c=cart&m=delete&id=<?= $item['id']; ?>" class="btn btn-danger">Remove</a>
							</td>
						</tr>
						<?php $totalMoney += ($item['qty']*$item['price']); ?>
					<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td>Total Money</td>
							<td colspan="4"></td>
							<td id="totalMoney" colspan="2"><?= number_format($totalMoney); ?></td>
						</tr>
						<tr>
							<td>
								<button type="submit" name="btnSub" class="btn btn-primary">UpdateCart</button>
							</td>
							<td>
								<a href="?c=cart&m=deleteall" class="btn btn-danger">Remove All</a>
							</td>
							<td>
								<a href="index.php" class="btn btn-primary">Mua tiep</a>
							</td>
							<td>
								<a href="?c=index" class="btn btn-primary">Thanh Toan</a>
							</td>
						</tr>
					</tfoot>
				</table>		
			  </form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function updateCart(id,obj){
			// alert(id);
			let qty = $(obj).val().trim();
			if(qty > 0 && qty < 10){
				$.ajax({
					url: "?c=cart&m=ajax_cart",
					type: "POST",
					data: {id: id,qty: qty},
					success: function(res){
						let dbObj = $.parseJSON(res);
						$(obj).parent().next().next().html(dbObj.money);
						$('#totalMoney').html(dbObj.totalMoney);
					}
				});
			}
		}
	</script>
</body>
</html>