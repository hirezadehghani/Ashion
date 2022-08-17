<script src="<?= $params['dependencyAddr'] ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= $params['dependencyAddr'] ?>plugins/select2/select2.min.js"></script>
<link href="<?= $params['dependencyAddr'] ?>plugins/select2/select2.min.css" rel="stylesheet" />
<!-- Main content -->
<?php

use app\models\Category;
use app\models\Discount;
use app\models\product_attributes;

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Right Coloumn -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">افزودن کالا</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php
                    $form = app\core\form\Form::hasUpload('', 'post'); ?>
                    <div class="card-body">
                        <?= $form->field($model, 'text', 'title', 'نام کالا'); ?>

                        <div class="form-group">
                            <label for="editor">توضیحات</label>
                            <textarea name="detail" id="editor" class="textarea" placeholder="لطفا متن خود را وارد کنید" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                        <?= $form->field($model, 'number', 'sku', 'کد sku'); ?>
                        <?= $form->field($model, 'text', 'promotions', 'مزایا'); ?>
                        <?= $form->field($model, 'number', 'regular_price', 'قیمت واقعی'); ?>
                        <?= $form->field($model, 'number', 'sale_price', 'قیمت فروش'); ?>

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
                        <!-- /.Category -->

                        <div class="form-group">
                            <label for="stockSelect">وضعیت انبارداری</label>
                            <select name="stock_id" id="stockSelect" class="form-control">
                            <option value="1">در انبار</option>
                            <option value="2">خارج از انبار</option>
                            <option value="3">بازگشت سفارش</option>
                            </select>
                        </div>
                        <!-- /. Stock -->
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
            <!-- left column -->
            <div class="col-md-4">

                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">جزئیات</h3>
                    </div>
                    <div class="card-body">
                        <!-- continue of product form -->
                        <div class="form-group">
                            <p for="productCategory">وابستگی ها</p>
                            <label for="attributeSelect">انتخاب مشخصه</label>
                            <select class="form-group custom-select" multiple name="attribute_id[]" id="attributeSelect">
                                <?php $productAttributes = new product_attributes;
                                $lastAttributes = $productAttributes->fetchGroup("product_attributes", ["attribute_name", "attribute_id"]);
                                foreach ($lastAttributes as $row) {
                                ?>
                                    <option value="<?= $row['attribute_id'] ?>"><?= $row['attribute_name'] ?></option>
                                <?php } ?>
                            </select>

                            <button id="getAttributes" class="btn btn-danger">ذخیره مشخصه ها برای محصول</button>

                            <?php $attrs = [];
                            // $attrs_vals = $product_attributes->fetchAll("attribute_values");
                            foreach ($attrs_vals as $row) {
                                foreach ($attrs as $attr) {
                                    if ($row['attribute_id'] == $attr) {
                            ?>
                                        <select name="value_id" id="">
                                            <option value="<?= $row['value_id'] ?>">
                                                <?= $row['value_name'] ?>
                                            </option>
                                        </select>
                            <?php }
                                }
                            } ?>
                            <?php $values = $productAttributes->fetchAll("attribute_values");
                            foreach ($values as $value) {
                            ?>

                            <?php
                            } ?>
                        </div>
                    </div>
                </div>
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
</script>