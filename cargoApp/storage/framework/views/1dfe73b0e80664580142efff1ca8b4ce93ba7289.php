<?php $__env->startSection('content'); ?>

<div class="container con">
    <h2>Add Company</h2>


    <form action="<?php echo e(route('companies.store')); ?>" method="POST">
        <?php if($errors->any()): ?>
        <br>
        <br>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Company Name</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" />
        </div>


        <div class="form-group">
            <label>Address</label>
            <input name="address" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" type="phone" class="form-control" />
        </div>
        <br>
        <hr style="border: 1px solid #7d747a1f">
        <!-- <label>Contact List</label>
        <hr style="border: 1px solid #7d747a1f">
        <br> -->

        <div class="form-group">
            <label>Receiver Name</label>
            <input name="receiver_name" type="text" class="form-control" />
        </div>
        <div class="form-group">
            <label>Contact Name</label>
            <input name="conatct_name" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <label>Contact Phone</label>
            <input name="contact_phone" type="phone" class="form-control" />
        </div>

        <div class="form-group">
            <label for="address_address">Address</label>
            <input type="text" id="address-input" name="address_address" class="form-control map-input">
            <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
        </div>

        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>

        <br>
        <br>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content_scripts'); ?>
##parent-placeholder-fcc84f431abb7e2c8e2f8f13e68753c22136a1e9##
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places&callback=initialize" async defer></script>
<script src="/js/mapInput.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Cargo Project/cargoApp/resources/views/companies/create.blade.php ENDPATH**/ ?>