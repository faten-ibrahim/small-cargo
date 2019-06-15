<?php $__env->startSection('content'); ?>
<div class="container" style="width:100%;">
    <h2>Manage Companies</h2>
    <a class="btn btn-info" href="<?php echo e(route('companies.create')); ?>"><i class="fa fa-plus"></i><span>Add New Company</span></a><br><br>
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>status</th>
                <th>Orders Number</th>
                <th>Options</th>
                <th>Actions</th>
                <th>Extra</th>
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
            columns: [
                {
                    data: 'id'
                },
                {
                    data: 'comp_name'
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
                    data: 'orders_count'},
                {
                    mRender: function(data, type, row) {
                        return '<a href="/companies/' + row.id + '/Send_orders" class="bttn btn btn-info btn-sm" data-id="' + row.id + '" ><span>Send Orders</span></a><br>' +
                        '<a href="/companies/' + row.id + '/Recived_orders" class="bttn btn btn-info btn-sm" data-id="' + row.id + '" ><span>Recived Orders</span></a><br>' 

                    }
                },
                {
                    mRender: function(data, type, row) {
                        return '<a  href="/companies/' + row.id + '/edit" class="bttn btn btn-success btn-sm" data-id="' + row.id + '"><i class="fa fa-edit"></i><span>Edit</span></a><br>' +
                        '<form method="POST" action="companies/'+row.id+'">@csrf {{ method_field('DELETE')}}<button style="margin-left:-18px;" type="submit" onclick="return myFunction();" class="bttn btn btn-danger btn-sm"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i><span>Delete</span></button></form>'


                    }
                },
                {
                    mRender: function(data, type, row) {

                        if (!row.banned_at && row.status=='active')
                            return '<a href="/companies/' + row.id + '/ban" class="bttn btn btn-warning btn-sm" data-id="' + row.id + '"><i class="fa fa-ban"></i><span>Deactive</span></a><br>'+
                                    '<a href="/companies/' + row.id + '/add_list" class="bttn btn btn-primary btn-sm" data-id="' + row.id + '"><i class="fa fa-plus"></i><span>Add Contact</span></a>'


                        else
                            return '<a href="/companies/' + row.id + '/unban" class="bttn btn btn-success btn-sm" data-id="' + row.id + '" ><i class="fa fa-check"></i><span>Active</span></a><br>'+
                                    '<a href="/companies/' + row.id + '/contacts" class="bttn btn btn-primary btn-sm" data-id="' + row.id + '"><span>Contact List</span></a>'


                    }
                },
            ],

            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'paging'      : true,
        });

          //confirm deleting
                function myFunction(){
                     var agree = confirm("Are you sure you want to delete this Company\?");
                        if(agree == true){
                           return true
                           }
                           else{
                           return false;
                           }
                     }

    </script>


</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Cargo Project/cargoApp/resources/views/companies/index.blade.php ENDPATH**/ ?>
