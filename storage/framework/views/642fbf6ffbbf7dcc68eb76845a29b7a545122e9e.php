  
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?php echo e(route('products.index')); ?>"> Back</a>
        </div>
    </div>
</div>
   
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
   
<form action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                <input class="form-control"  name="price" placeholder="Price">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>UPC:</strong>
                <input class="form-control"  name="upc" placeholder="Upc">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label><strong>Image : </strong></label>
                <input type="file" name="image" class="form-control" required="required">
            </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label><strong>Status : </strong></label>
            <select class="form-control" name="status" required="required">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        <div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>


    <script>
function changeUserStatus(_this, id) {
    var status = $(_this).prop('checked') == true ? 1 : 0;
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: `/change-status`,
        type: 'post',
        data: {
            _token: _token,
            id: id,
            status: status 
        },
        success: function (result) {
        }
    });
}

</script>
   
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('products.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/shreemant/Desktop/auth-crud-app/resources/views/products/create.blade.php ENDPATH**/ ?>