<script src="<?= $params['dependencyAddr'] ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= $params['dependencyAddr'] ?>plugins/colorpicker/jquery.minicolors.min.js"></script>
<link rel="stylesheet" href="<?= $params['dependencyAddr'] ?>plugins/colorpicker/jquery.minicolors.css">
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">افزودن کالا</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form" enctype="multipart/form-data">
                    <div class="card-body">
                            <div class="form-group">
                                <label for="title">نام</label>
                                <input name="title" type="text" value="" class="form-control" placeholder="نام کالا را وارد کنید">
                            </div>
                            <div class="form-group">
                                <label for="productCategory">دسته بندی</label>
                                <select name="productCategory" value="" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productInventory">موجودی</label>
                                <input type="number" value="" name="productInventory" class="form-control" placeholder="موجودی کالا به عدد">
                            </div>
                            <div class="form-group">
                                <label for="productPrice">قیمت</label>
                                <input type="number" name="productPrice" value="" placeholder="15000000" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="productsStockPrice">قیمت کالای دست دوم</label>
                                <input id="productsStockPrice" type="number" name="productsStockPrice" value="" placeholder="1200000" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="productDiscount">تخفیف</label>
                                <input id="productDiscount" type="number" min="1" max="100" name="productDiscount" value="" placeholder="20" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="text" id="demo" class="demo" value="#ff6161">
                                <script>
                                    $('.demo').minicolors();
                                </script>
                            </div>

                            <div class="form-group">
                                <textarea id="editor" class="textarea" placeholder="لطفا متن خود را وارد کنید" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="productSku">کد SKU</label>
                                <input name="productSku" type="text" value="" class="form-control" placeholder="کد SKU کالا را وارد کنید">
                            </div>

                            <div class="form-group">
                                <span>اندازه</span></br>
                                <label for="xxs">XXS</label>
                                <input class="form-control" type="number" name="xxs">
                                <label for="xs">XS</label>
                                <input class="form-control" type="number" name="xs">
                                <label for="s">S</label>
                                <input class="form-control" type="number" name="xxs">
                                <label for="m">M</label>
                                <input class="form-control" type="number" name="m">
                                <label for="l">L</label>
                                <input class="form-control" type="number" name="l">
                                <label for="xl">l</label>
                                <input class="form-control" type="number" name="xl">
                                <label for="xxl">XXL</label>
                                <input class="form-control" type="number" name="xxl">
                                <label for="xxl">XXL</label>
                                <input class="form-control" type="number" name="xxl">

                            </div>

                            <div class="form-group">
                                <label for="productPromotions">مزایا</label>
                                <input type="text" id="productPromotions" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="productImage">ارسال تصویر(ها)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" multiple class="custom-file-input" id="productImage" name="productImage">
                                        <label class="custom-file-label" for="productImage">ارسال تصویر(ها)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">ارسال</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= $params['dependencyAddr'] ?>plugins/ckeditor/ckeditor.js"></script>
<script>
    $(function() {
        // Replace the <textarea id="editor"> with a CKEditor
        // instance, using default configuration.
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(function(editor) {
                // The editor instance
            })
            .catch(function(error) {
                console.error(error)
            })
    });
    document.getElementById('addProductForm').onsubmit = function() {
        var productDiscount = document.getElementById('productDiscount').value / 100;
    }
</script>