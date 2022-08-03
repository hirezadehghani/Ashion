<?php echo  ?>

<!-- for Product discount -->
<script>
    document.getElementById('addProductForm').onsubmit = function() {
        var valInDecimals = document.getElementById('productDiscount').value / 100;
    }
</script>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">مثال ساده</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="productName">نام</label>
                                <input name="productName" type="text" value="" class="form-control" placeholder="نام کالا را وارد کنید">
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
                                <label for="productDiscount">تخفیف</label>
                                <input id="productDiscount" type="number" min="1" max="100" name="productDiscount" value="" placeholder="20" class="form-control">
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