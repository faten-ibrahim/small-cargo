<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Cargo</title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/bower_components/admin-lte/dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="/bower_components/admin-lte/dist/css/skins/skin-blue.min.css">
</head>
<body class="hold-transition login-page">
    <div id="app">


        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
            <!-- <?php echo $__env->yieldContent('notFoundContent'); ?> -->
        </main>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/new/before api/merge/Cargo Project/cargoApp/resources/views/layouts/app.blade.php ENDPATH**/ ?>