  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">ثبت نام کاربر جدید</p>

      <?php $form = \app\core\form\Form::begin('', "post"); ?>
<div class="row">
  <div class="col">
    <?= $form->field($model, 'firstName', 'نام') ?>
  </div>
  <div class="col">
    <?= $form->field($model, 'lastName', 'نام خانوادگی') ?>
  </div>
</div>
<?= $form->field($model, 'email', 'ایمیل') ?>
<?= $form->field($model, 'telephone', 'شماره تلفن') ?>
<?= $form->field($model, 'password', 'رمز عبور')->passwordField() ?>
<?= $form->field($model, 'passwordConfirm', 'تکرار رمز عبور')->passwordField() ?>

<div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" required> با <a href="#">شرایط</a> موافق هستم
              </label>
            </div>
          </div>

<div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">ثبت نام</button>
          </div>
          <!-- /.col -->
        </div>

<?= app\core\form\Form::end() ?>

      <!-- <form action="" method="post">
        <div class="input-group mb-3">
          <input name="firstname" type="text" class="form-control" placeholder="نام">
          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="lastname" type="text" class="form-control" placeholder="نام خانوادگی">
          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="ایمیل">
          <div class="input-group-append">
            <span class="fa fa-envelope input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="telephone" type="number" class="form-control" placeholder="شماره تلفن">
          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="رمز عبور">
          <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="تکرار رمز عبور">
          <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> با <a href="#">شرایط</a> موافق هستم
              </label>
            </div>
          </div>
          <!-- /.col -->
<!-- 

      <div class="social-auth-links text-center">
        <p>- یا -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fa fa-facebook mr-2"></i>
          ثبت نام با اکانت فیس بود
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i>
          ثبت نام با گوگل
        </a>
      </div> -->

      <a href="/login" class="text-center">من قبلا ثبت نام کرده ام</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->