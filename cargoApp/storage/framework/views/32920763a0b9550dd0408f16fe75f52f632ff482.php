<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Car</b>GO</a>
        </div>
        <div class="card">
            <div class="card-header"><?php echo e(__('Login')); ?></div>

            <div class="card-body">
                <!-- /.login-logo -->
                <div class="login-box-body">
                    <p class="login-box-msg">Sign in to start your session</p>


                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group has-feedback">
                            <input id="email" type="email" class="form-control <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="email" value="<?php echo e(old('email')); ?>" autocomplete="email" autofocus>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                            <span class="invalid-feedback">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
                        <div class="form-group has-feedback">
                            <input id="password" type="password" class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="password" autocomplete="current-password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                            <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                            <span class="invalid-feedback">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>

                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="checkbox icheck" style="margin-left: 10px;" >
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                                        <label class="form-check-label" for="remember">
                                            <?php echo e(__('Remember Me')); ?>

                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

                            </div>
                            <!-- /.col -->
                        </div>
                    </form>



                    <?php if(Route::has('password.request')): ?>
                    <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                        <?php echo e(__('Forgot Your Password?')); ?>

                    </a>
                    <?php endif; ?>
                    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

                </div>
                <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Cargo Project/cargoApp/resources/views/auth/login.blade.php ENDPATH**/ ?>