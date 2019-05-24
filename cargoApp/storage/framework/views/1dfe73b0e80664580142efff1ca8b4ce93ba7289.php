    <?php $__env->startSection('content'); ?>
    <!-- <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?> -->

    <br>
    <br>

    <div class="container con">
        <h2>Add Company</h2>

    <form action="<?php echo e(route('companies.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Company Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control"/>
        </div>


        <div class="form-group">
            <label>Address</label>
            <input name="address" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone"  type="phone" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="<?php echo e(route('companies.index')); ?>" class="btn btn-danger">Back</a>
    </form>
 </div>
 <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Cargo Project/cargoApp/resources/views/companies/create.blade.php ENDPATH**/ ?>