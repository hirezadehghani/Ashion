<div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">فرم زیر را تکمیل کنید و ورود بزنید</p>

      <?php $form = \app\core\form\Form::begin('', 'post') ?>
        <!-- <div class="input-group mb-3"> -->
        <!-- <div class="input-group-append">
            <span class="fa fa-envelope input-group-text"></span>
          </div>   -->
        <?= $form->field($model, 'email', 'email', 'ایمیل');?>
          
        <!-- </div> -->
        <?= $form->field($model, 'password', 'password', 'رمز عبور');?>
          <!-- <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
          </div> -->
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> یاد آوری من
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">ورود</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fa fa-facebook mr-2"></i> ورود با اکانت فیسوبک
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i> ورود با اکانت گوگل
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">رمز عبورم را فراموش کرده ام.</a>
      </p>
      <p class="mb-0">
        <a href="/register" class="text-center">ثبت نام</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->