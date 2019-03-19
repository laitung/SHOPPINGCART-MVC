<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center"> Edit Product</h3>
                <a class="btn btn-info" href="?c=product" title="list Products"> List Products</a>
                <hr>
            </div>

            <div class="col-lg-12">
                <form action="?c=product&m=handleEdit&id=<?= $data['info']['id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="namePd">Name</label>
                                <input type="text" name="namePd" class="form-control" value="<?= $data['info']['name_pd']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="statusPd">Status</label>
                                <select class="form-control" name="statusPd">
                                    <option <?php echo ($data['info']['satus_pd'] == 0) ? "selected='selected'" : ""; ?> value="0">Deactive</option>
                                    <option <?php echo ($data['info']['satus_pd'] == 1) ? "selected='selected'" : ""; ?> value="1">Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="slcCat">Categories</label>
                                <select class="form-control" name="slcCat">
                                <?php foreach($data['lstCat'] as $key => $cat): ?>
                                    <option <?php echo ($cat['id'] == $data['info']['cat_id']) ? "selected='selected'" : ""; ?>  value="<?php echo $cat['id'] ?>"><?php echo $cat['name_cat']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="slcSize">Sizes</label>
                                <select class="form-control" name="slcSize">
                                <?php foreach($data['lstSize'] as $key => $size): ?>
                                    <option <?php echo ($size['id'] == $data['info']['size_id']) ? "selected='selected'" : ""; ?> value="<?php echo $size['id']; ?>"><?php echo $size['name_size']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imagePd">Image</label>
                                <input type="file" name="imagePd" class="form-control">
                                <br>
                                <img src="<?php echo PATH_IMAGE . $data['info']['image_pd']; ?>" width="90" height="90" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pricePd">Price</label>
                                <input type="text" name="pricePd" class="form-control" value="<?= $data['info']['price_pd']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="qtyPd">Quanity</label>
                                <input type="number" name="qtyPd" class="form-control" value="<?= $data['info']['qty_pd'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="des_pd">Description</label>
                                <textarea class="form-control" rows="5" name="des_pd">
                                    <?= $data['info']['des_pd']; ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-3">
                        <button name="btnSubmit" type="submit" class="btn btn-primary btn-block" style="margin: 10px 0px;"> Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>