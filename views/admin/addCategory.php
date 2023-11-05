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
                        <h3 class="card-title">دسته بندی جدید</h3>
                    </div>
                    <!-- /.card-header -->
                    <?php $form = \app\core\form\Form::begin('', "post"); ?>
                    <!-- form start -->

                    <div class="card-body">
                        <?= $form->field($model, 'title', 'text', 'عنوان دسته بندی'); ?>
                        <?= $form->field($model, 'detail', 'text', 'جزئیات دسته بندی'); ?>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>
                        <?= \app\core\form\Form::end() ?>
                    </div>
                </div>
            </div>
        </div>
</section>