<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center"> Add Product</h3>
                <a class="btn btn-info" href="?c=product" title="list Products"> List Products</a>
                <hr>
            </div>

            <?php if(!empty($data['errAd'])): ?>
            <div class="col-lg-12">
                <!-- day la noi thong bao loi -->
                <ul>
                    <?php foreach($data['errAd'] as $err): ?>
                        <?php if($err != ''): ?>
                            <li style="color: red;"><?php echo $err; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if($data['state'] !== '' && $data['errName'] !== ''): ?>
            <div class="col-lg-12">
                <p style="color: red">
                    San pham <b><?= $data['errName'] ?></b> da ton tai, vui long nhap ten khac !
                </p>
            </div>
            <?php endif; ?>

            <div class="col-lg-12">
                <form action="?c=product&m=handleAdd" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="namePd">Name</label>
                                <input type="text" name="namePd" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="slcCat">Categories</label>
                                <select class="form-control" name="slcCat">
                                <?php foreach($data['lstCat'] as $key => $cat): ?>
                                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name_cat']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="slcSize">Sizes</label>
                                <select class="form-control" name="slcSize">
                                <?php foreach($data['lstSize'] as $key => $size): ?>
                                    <option value="<?php echo $size['id']; ?>"><?php echo $size['name_size']; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imagePd">Image</label>
                                <input type="file" name="imagePd" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pricePd">Price</label>
                                <input type="text" name="pricePd" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="qtyPd">Quanity</label>
                                <input type="number" name="qtyPd" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="des_pd">Description</label>
                                <textarea class="form-control" rows="5" name="des_pd"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-3">
                        <button name="btnSubmit" type="submit" class="btn btn-primary btn-block" style="margin: 10px 0px;"> Add </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>