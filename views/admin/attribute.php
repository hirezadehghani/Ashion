<script src="<?= $params['dependencyAddr'] ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= $params['dependencyAddr'] ?>plugins/colorpicker/jquery.minicolors.min.js"></script>
<script src="<?= $params['dependencyAddr'] ?>js/ntc.js"></script>

<link rel="stylesheet" href="<?= $params['dependencyAddr'] ?>plugins/colorpicker/jquery.minicolors.css">
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Right column -->
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $params['pageTitle'] ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php

                    use app\models\product_attributes;

                    $form = \app\core\form\Form::begin('', "post",); ?>
                    <!-- form start -->

                    <div class="card-body">
                        <?= $form->field($model, 'text', 'attribute_name', 'نام مشخصه'); ?>
                        <div class="card-footer">
                            <button id="submitBtn" type="submit" class="btn btn-primary">ذخیره</button>
                        </div>
                        <?= \app\core\form\Form::end() ?>
                    </div>
                </div>
            </div>
            <!-- Left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">مشاهده مشخصه ها</h3>
                    </div>

                    <div class="card-body">

                        <table>
                            <thead>
                                <tr>
                                    <th>عنوان مشخصه</th>
                                    <th>مقدار مشخصه</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $productAttributes = new product_attributes;
                                $attributes = $productAttributes->fetchGroup("product_attributes", ["attribute_id", "attribute_name"]);
                                $values = $productAttributes->fetchGroup("attribute_values", ["attribute_id", "value_name"]);
                                foreach ($attributes as $row) { ?>
                                    <tr>
                                        <td><?= $row['attribute_name'] ?></td>
                                        <?php
                                        if ($values) {
                                            foreach ($values as $valueRow) {
                                                if ($row['attribute_id'] == $valueRow['attribute_id']) {
                                        ?>
                                                    <td><?= $valueRow['value_name'] ?></td>
                                    <?php }
                                            }
                                        }
                                    } ?>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">اضافه کردن مقدار</h3>
                    </div>
                    <div class="card-body">
                        <?php $form = \app\core\form\Form::beginWithId('', "post", "getValueForm"); ?>
                        <label for="attributeSelect">انتخاب مشخصه</label>
                        <select name="attribute_id" id="attributeSelect">
                            <?php $lastAttributes = $productAttributes->fetchGroup("product_attributes", ["attribute_name", "attribute_id"]);
                            foreach ($lastAttributes as $row) {
                            ?>
                                <option value="<?= $row['attribute_id'] ?>"><?= $row['attribute_name'] ?></option>
                            <?php } ?>
                        </select>
                        <hr />
                        <div id="textValue">
                            <label class="form-label">مقدار مشخصه</label>
                            <input type="text" name="value_name" id="value_name_input" class="form-control">
                        </div>
                        <div id="colorSection" style="display:none;">
                            <label class="form-label">مقدار مشخصه</label>
                            <input id="color" class="demo" value="#000">
                            <script>
                                $('.demo').minicolors();
                            </script>
                        </div>
                        <hr />
                        <span id="colorButton" class="btn btn-danger">اضافه کردن رنگ</span>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>
                        <?= \app\core\form\Form::end() ?>
                    </div>
                </div>
            </div>
        </div>

</section>
<script>
    let colorMode = false;
    $('#colorButton').on('click', function() {
        $('#colorSection').show('slow');
        $('#textValue').hide('slow');
        colorMode = true;
    });

    let form = document.getElementById("getValueForm");
    form.addEventListener("submit", setColorValue);

    function setColorValue() {
        if(colorMode == true){
        let color = document.getElementById("color").value;
        color = ntc.name(color);
        let attrValue = document.getElementById("value_name_input");
        attrValue.value = color[1];
        }
    }

    // // 1. You need a hex code of the color
    // var ColorCode = "#008559";

    // // 2. Rate the color using NTC
    // var ntcMatch  = ntc.name(ColorCode);

    // // 3. Handle the result. The library returns an array with the identified color.

    // // 3.A RGB value of closest match e.g #01826B
    // console.log(ntcMatch[0]);
    // // Text string: Color name e.g "Deep Sea"
    // console.log(ntcMatch[1]);
    // // True if exact color match, a Boolean
    // console.log(ntcMatch[2]);
</script>