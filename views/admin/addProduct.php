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
                    <?php
                    use app\models\Category;
                    $form = app\core\form\Form::hasUpload('', 'post'); ?>
                    <div class="card-body">
                        <?= $form->field($model, 'text', 'title', 'نام کالا'); ?>
                        <div class="form-group">
                            <label for="productCategory">دسته بندی</label>
                            <select name="productCategory" value="" class="form-control">
                                <?php $category = new Category;
                                $data = $category->fetchTitle('title');
                                foreach ($data as $row) { ?>
                                    <option value=""><?= $row['title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?= $form->field($model, 'number', 'inventory_id',  'موجودی کالا'); ?>
                        <?= $form->field($model, 'number', 'price', 'قیمت'); ?>
                        <?= $form->field($model, 'number', 'stockprice', 'قیمت کالای دست دوم'); ?>
                        <?= $form->field($model, 'number', 'discount', 'تخفیف'); ?>

                        <div class="form-group">
                            <input id="color" class="demo" value="#000">
                            <script>
                                $('.demo').minicolors();
                            </script>
                            <a id="takeColor" class="btn btn-primary" onclick="takeColor()">اضافه کردن رنگ</a>
                            <hr><div id="colorList">
                            </div>
                            <input id="colorName" name="color">
                        </div>

                        <div class="form-group">
                            <textarea name="detail" id="editor" class="textarea" placeholder="لطفا متن خود را وارد کنید" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <?= $form->field($model, 'number', 'sku', 'کد sku'); ?>

                        <div class="form-group">
                            <span>موجودی اندازه ها</span></br>
                            <?= $form->field($model, 'number', 'xxs', 'xxs'); ?>
                            <?= $form->field($model, 'number', 'xs', 'xs'); ?>
                            <?= $form->field($model, 'number', 's', 's'); ?>
                            <?= $form->field($model, 'number', 'm', 'm'); ?>
                            <?= $form->field($model, 'number', 'l', 'L'); ?>
                            <?= $form->field($model, 'number', 'xl', 'xL'); ?>
                            <?= $form->field($model, 'number', 'xxl', 'xxL'); ?>
                        </div>
                        <?= $form->field($model, 'text', 'promotions', 'مزایا'); ?>
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
                "<span style=\"background-color:" + value + "\">"+"value"+"</span>"
        }
        document.getElementById("colorList").innerHTML = colorList;
    }

    const form = document.getElementById("phpForm");
    form.addEventListener(onsubmit, setColorValue);
    function setColorValue(){
        document.getElementById("colorName").value = 'test';
    };
</script>