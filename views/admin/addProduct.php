<script src="<?= $params['dependencyAddr'] ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= $params['dependencyAddr'] ?>plugins/colorpicker/jquery.minicolors.min.js"></script>
<link rel="stylesheet" href="<?= $params['dependencyAddr'] ?>plugins/colorpicker/jquery.minicolors.css">
<script src="<?= $params['dependencyAddr'] ?>plugins/select2/select2.min.js"></script>
<link href="<?= $params['dependencyAddr'] ?>plugins/select2/select2.min.css" rel="stylesheet" />
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
                    <?php

                    use app\models\Category;
                    use app\models\Discount;

                    $form = app\core\form\Form::hasUpload('', 'post'); ?>
                    <div class="card-body">
                        <?= $form->field($model, 'text', 'title', 'نام کالا'); ?>
                        <div class="form-group">
                            <label for="productCategory">دسته بندی</label>
                            <select id="productCategory" name="category_id" class="form-control">
                                <?php $category = new Category;
                                $data = $category->fetchGroup('product_category', ['title', 'id']);
                                foreach ($data as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div id="inventories">
                            <div class="form-group">
                                <label for="newInventory">موجودی</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="stockInventory">موجودی کالا دست دوم</label>
                                <input type="number" class="form-control">
                                <input type="text" name="inventory_id" id="inventory" hidden>
                            </div>
                        </div>

                        <?= $form->field($model, 'number', 'price', 'قیمت'); ?>
                        <?= $form->field($model, 'number', 'stock_price', 'قیمت کالای دست دوم'); ?>

                        <div class="form-group">
                            <label for="productDiscount">تخفیف</label>
                            <select id="productDiscount" name="discount_id" class="form-control">
                            <option value="">بدون تخفیف</option>
                                <?php $discount = new Discount;
                                $data = $discount->fetchAll('discount');
                                foreach ($data as $row) { 
                                    if($row['active'] == 2) $disabled = true;
                                    ?>
                                    <option <?php if ($disabled == true) {$disabled = false; echo "disabled";} ?> value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <input id="color" class="demo" value="#000">
                            <script>
                                $('.demo').minicolors();
                            </script>
                            <a id="takeColor" class="btn btn-primary" onclick="takeColor()">اضافه کردن رنگ</a>
                            <hr>
                            <div id="colorList">
                            </div>
                            <input id="colorName" name="color" hidden>
                        </div>

                        <div class="form-group">
                            <textarea name="detail" id="editor" class="textarea" placeholder="لطفا متن خود را وارد کنید" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <?= $form->field($model, 'number', 'sku', 'کد sku'); ?>

                        <div id="sizes">
                            <label>موجودی اندازه ها</label>
                            <hr>
                            <label for="xxs">XXS</label>
                            <input type="number" id="xxs" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <label for="xxs">XS</label>
                            <input type="number" id="xs" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <label for="xxs">S</label>
                            <input type="number" id="s" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <label for="xxs">M</label>
                            <input type="number" id="m" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <label for="xxs">L</label>
                            <input type="number" id="l" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <label for="xxs">XL</label>
                            <input type="number" id="xl" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <label for="xxs">XXL</label>
                            <input type="number" id="xxl" class="form-control col-2">
                        </div>
                        <div class="form-group">
                            <input type="text" name="size" id="sizeValues" hidden>
                        </div>
                        <?= $form->field($model, 'text', 'promotions', 'مزایا'); ?>
                        <div class=" form-group">
                            <label for="productImage">ارسال تصویر(ها)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" multiple class="custom-file-input" id="productImage" name="pictures[]">
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
    $(document).ready(function() {

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

        //select 2 function
        // $('.select2').select2();
    });

    let colors = new Array();

    function takeColor() {
        notequal = null;
        var colorValue = document.getElementById("color").value;
        for (let i = 0; i < colors.length; i++) {
            if (colors[i] != colorValue)
                notequal = 1;
            else
                notequal = 0;
        }
        if (notequal == 1 || notequal == null)
            colors.push(colorValue);

        var colorList = '';
        colors.forEach(showColorfunc);

        function showColorfunc(value) {
            colorList +=
                "<span style=\"background-color:" + value + "\">" + "value" + "</span>"
        }
        document.getElementById("colorList").innerHTML = colorList;
    }

    const form = document.getElementById("phpForm");
    form.addEventListener("submit", setColorValue);
    form.addEventListener("submit", setSizeValue);
    form.addEventListener("submit", setInventoryValue);

    function setColorValue() {
        document.getElementById("colorName").value = JSON.stringify(colors);
    }

    function setSizeValue() {
        let sizes = [];
        let sizeNames = $('#sizes input[type="number"]');
        for (i = 0; i < sizeNames.length; i++) {
            sizes.push(sizeNames[i].value);
        }
        document.getElementById("sizeValues").value = JSON.stringify(sizes);
    }

    function setInventoryValue() {
        let inventories = [];
        let inventoryInputs = $('#inventories input[type="number"]');
        for (i = 0; i < inventoryInputs.length; i++) {
            inventories.push(inventoryInputs[i].value);
        }
        document.getElementById("inventory").value = JSON.stringify(inventories);
    }
</script>