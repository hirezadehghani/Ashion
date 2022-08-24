<script src="<?= $params['dependencyAddr'] ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= $params['dependencyAddr'] ?>plugins/select2/select2.min.js"></script>
<link href="<?= $params['dependencyAddr'] ?>plugins/select2/select2.min.css" rel="stylesheet" />
<!-- Main content -->
<?php

use app\models\Category;
use app\models\Product;
use app\models\product_attributes;
use app\models\sku_values;

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
                        <?= $form->field($model, 'text', 'promotions', 'مزایا'); ?>
                        <!-- <?= $form->field($model, 'number', 'regular_price', 'قیمت واقعی'); ?> -->
                        <!-- <?= $form->field($model, 'number', 'sale_price', 'قیمت فروش'); ?> -->

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

                        <!-- select product -->
                        <?php $form = \app\core\form\Form::begin('', 'get') ?>
                        <div class="form-group">
                            <select name="product_id" class="form-control">
                                <?php
                                $products = new Product;
                                $products = $products->getLastProduct(20, 'desc');
                                foreach ($products as $product) { ?>
                                    <option value="<?= $product['id'] ?>"><?= $product['title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- ./ select product -->
                        <!-- select attribute -->
                        <div class="form-group">
                            <label for="attributeSelect">انتخاب مشخصه</label>
                            <select class="form-group custom-select" multiple name="attribute_id[]" id="attributeSelect">
                                <?php $productAttributes = new product_attributes;
                                $lastAttributes = $productAttributes->fetchGroup("product_attributes", ["attribute_name", "attribute_id"]);
                                foreach ($lastAttributes as $row) {
                                ?>
                                    <option value="<?= $row['attribute_id'] ?>">
                                        <?= $row['attribute_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <button type="submit" id="getAttributes" class="btn btn-danger">ذخیره مشخصه ها برای محصول</button>

                            <?= $form->end() ?>
                        </div>
                        <!-- ./select attribute -->

                        <!-- select attribute values -->
                        <?php $attrForm = \app\core\form\Form::begin('', $_GET); ?>
                        <div class="form-group">
                            <?php
                            $attrs = [];
                            $attrs = $_GET['attribute_id']; //array of attributes
                            $parant_attribute = $attrs[0];
                            $child_attribute = $attrs[1];
                            $productId = $_GET['product_id'];
                            if (isset($attrs)) {
                                $attrs_vals = new product_attributes;
                                $parent_values = $attrs_vals->fetchWhere("attribute_values", 'attribute_id', $parant_attribute);
                                $child_values = $attrs_vals->fetchWhere("attribute_values", 'attribute_id', $child_attribute);
                            ?>
                                <div class="form-group">
                                    <select name="parent_value_id" class="form-control">
                                        <?php
                                        foreach ($parent_values as $val) {
                                        ?>
                                            <option value="<?= $val['value_id'] ?>"><?= $val['value_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="child_value_id" class="form-control">
                                        <?php
                                        foreach ($child_values as $val) {
                                        ?>
                                            <option value="<?= $val['value_id'] ?>"><?= $val['value_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php
                            }
                            ?>
                            <input hidden type="text" value="<?= $parant_attribute ?>" name="parent_attribute_id">
                            <input hidden type="text" value="<?= $child_attribute ?>" name="child_attribute_id">
                            <input hidden type="number" value="<?= $productId ?>" name="product_id">
                            <input hidden name="combination_string" type="text" value="" id="combination_input">
                            <button type="submit" class="btn btn-success">وارد کردن اطلاعات مشخصه</button>
                            <?php
                            $attrForm::end() ?>
                        </div>
                        <!-- ./select attribute values -->

                        <!-- set product_skus table values -->
                        <?php
                        if (isset($_GET['parent_attribute_id'])) {
                            $parent_attribute_id = $_GET['parent_attribute_id'];
                            $parent_value_id = $_GET['parent_value_id'];
                            $child_attribute_id = $_GET['child_attribute_id'];
                            $child_value_id = $_GET['child_value_id'];
                            $product_id = $_GET['product_id'];
                            $attrForm = \app\core\form\Form::begin('', $_GET);

                        ?>
                            <!-- ATTRIBUTE VALUES FORM -->
                            <input hidden name="parent_attribute_id" type="text" value="<?= $parent_attribute_id ?>">
                            <input hidden name="parent_value_id" type="text" value="<?= $parent_value_id ?>">
                            <input hidden name="child_attribute_id" type="text" value="<?= $child_attribute_id ?>">
                            <input hidden name="child_value_id" type="text" value="<?= $child_value_id ?>">
                            <input hidden name="product_id" type="text" value="<?= $product_id ?>">
                            <?= $attrForm->field($model, 'text', 'sku', 'کد sku') ?>
                            <?= $attrForm->field($model, 'number', 'regular_price', 'قیمت واقعی') ?>
                            <?= $attrForm->field($model, 'number', 'sale_price', 'قیمت فروش') ?>
                            <?= $attrForm->field($model, 'number', 'quantity', 'موجودی') ?>
                            <div class="form-group">
                                <label for="stockSelect">وضعیت انبارداری</label>
                                <select name="stock_id" id="stockSelect" class="form-control">
                                    <option value="1">در انبار</option>
                                    <option value="2">خارج از انبار</option>
                                    <option value="3">بازگشت سفارش</option>
                                </select>
                            </div>
                            <!-- /. Stock -->
                        <?php }
                        ?>
                        <button type="submit" class="btn btn-primary">ذخیره</button>

                        <?php $attrForm::end() ?>
                        <!-- ./set product_skus table values -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script src="<?= $params['dependencyAddr'] ?>plugins/ckeditor/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {

            toolbar: {
                items: [
                    'heading',
                    'fontFamily',
                    'fontSize',
                    'fontColor',
                    'fontBackgroundColor',
                    'highlight',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    'alignment',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'htmlEmbed',
                    'code',
                    'CKFinder',
                    'undo',
                    'redo'
                ]
            },
            language: 'fa',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',


        })
        .then(editor => {
            window.editor = editor;

        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: lk1jrmfyew48-v2doq7vgpypp');
            console.error(error);
        });

    //select 2 function
    // $('.select2').select2();
</script>