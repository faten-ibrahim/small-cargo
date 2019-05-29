<?php $__env->startSection('content'); ?>
<div class="container" style="width:100%;">
    <h2>Manage Companies</h2>
    <a class="btn btn-info" href="<?php echo e(route('companies.create')); ?>"><i class="fa fa-plus"></i><span>Add New Company</span></a><br><br>
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>status</th>
                <th>Orders Number</th>
                <th>Options</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#example').DataTable({

            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?php echo e(route('get.companies')); ?>',
                dataType: 'json',
                type: 'get',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'address'
                },
                {
                    data: 'status'
                },
                {
                    data: 'orders_count'
                },
                {
                    mRender: function(data, type, row) {
                        return '<a href="/companies/' + row.id + '/orders" class="bttn btn btn-info" data-id="' + row.id + '" ><span>Show Orders</span></a>' +
                            '<a href="/companies/' + row.id + '/contacts" class="bttn btn btn-primary" data-id="' + row.id + '"><span>Contact List</span></a>'


                    }
                },
                {
                    mRender: function(data, type, row) {

                        if (!row.banned_at && row.status=='active')
                            return '<a  href="/companies/' + row.id + '/edit" class="bttn btn btn-success" data-id="' + row.id + '"><i class="fa fa-edit"></i><span>Edit</span></a><br>' +
                                '<a href="/companies/' + row.id + '/ban" class="bttn btn btn-warning" data-id="' + row.id + '"><i class="fa fa-ban"></i><span>Deactive</span></a>'
                                // '<a href="#" class="bttn btn btn-danger" row_id="' + row.id + '" data-toggle="modal" data-target="#DeleteModal" id="delete_toggle"><i class="fa fa-times"></i><span>Delete</span></a>'

                        else
                            return '<a href="/companies/' + row.id + '/edit" class="bttn btn btn-success" data-id="' + row.id + '"><i class="fa fa-edit"></i><span>Edit</span></a>' +
                                '<a href="/companies/' + row.id + '/unban" class="bttn btn btn-success" data-id="' + row.id + '" ><i class="fa fa-check"></i><span>Active</span></a>'
                                // '<a href="#" class="bttn btn btn-danger" row_id="' + row.id + '" data-toggle="modal" data-target="#DeleteModal" id="delete_toggle"><i class="fa fa-times"></i><span>Delete</span></a>'


                    }
                },
            ],

            'lengthChange': true,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'paging': true,
        });

    </script>


</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Cargo Project/cargoApp/resources/views/companies/index.blade.php ENDPATH**/ ?>
