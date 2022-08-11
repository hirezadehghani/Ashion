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
                        <h3 class="card-title"><?= $params['pageTitle'] ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <?php $form = \app\core\form\Form::begin('', "post"); ?>
                    <!-- form start -->

                    <div class="card-body">
                        <?= $form->field($model, 'title', 'عنوان تخفیف'); ?>
                        <?= $form->field($model, 'detail', 'توضیحات'); ?>
                        <?= $form->field($model, 'discount_percent', 'میزان تحفیف'); ?>

                        <div class="row">
                            <div class="col-8">
                                <div class="checkbox icheck">
                                    <label>فعال
                                        <input type="checkbox" name="active" id="chck" value="2">
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>
                        <?= \app\core\form\Form::end() ?>
                    </div>
                </div>
            </div>
        </div>
</section>

<script type="text/javascript">
    const form = document.getElementsByTagName('form');
    form[1].addEventListener(onsubmit, getValueInput);

    function getValueInput() {
        var activeElement = document.getElementById("chck");
        if(activeElement.checked == false){
        document.getElementById("chck").value = "0";
        }
        if (activeElement.checked == true)  {
        document.getElementById("chck").value = "1";
        }
    }
</script>