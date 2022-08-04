<link rel="stylesheet" href="<?= $params['dependencyAddr'] ?>plugins/colorpicker/css/bootstrap-colorpicker.min.css">

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
                    <form action="upload.php" method="post" role="form" enctype="multipart/form-data">
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

                            <!-- for Product discount -->
                            <script>
                                document.getElementById('addProductForm').onsubmit = function() {
                                    var productDiscount = document.getElementById('productDiscount').value / 100;
                                }
                            </script>

                            <!-- <div class="form-group">
                                <label>انتخاب رنگ</label>
                                <div class="input-group my-colorpicker2">
                                    <input name="color" type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                    </div>
                                </div>

                            </div> -->

                            <div class="input-group my-colorpicker2 colorpicker-element" data-colorpicker-id="2">
                                <input type="text" class="form-control" data-original-title="" title="">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
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


<script src="<?= $params['dependencyAddr']?>plugins/jquery/jquery.min.js"</script>
<script src="<?= $params['dependencyAddr'] ?>plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>

<script>

    // //color picker with addon
    // $('.my-colorpicker2').colorpicker()

    // $('.my-colorpicker2').on('colorpickerChange', function(event) {
    //     $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    // })

    $(document).ready(function () {
            $.fn.extend({
                ColorPicker: MyColorPicker.init,
                ColorPickerHide: MyColorPicker.hidePicker,
                ColorPickerShow: MyColorPicker.showPicker,
                ColorPickerSetColor: MyColorPicker.setColor
            });
            $('.my-colorpicker2').ColorPicker({
                color: '#000',
                onShow: function (colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    $('#colorSelector').css('backgroundColor', '#' + hex);
                }
            });
            //            $('#<%=txtReserveType.ClientID %>')
        });

    </script>

</script>