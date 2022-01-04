 
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Simple Web Application</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="<?php echo e(route('products.create')); ?>"> Create New Product</a>
            </div>
        </div>
    </div>
   
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="<?php echo e(url('myproductsDeleteAll')); ?>">Delete All Selected</button>  
    <table class="table table-bordered">
        <tr>
        <th width="50px"><input type="checkbox" id="master"></th>  
            <th>No</th>
            <th>Name</th>
            <th>Price</th>
            <th>UPC</th>
            <th>Status</th>
            <th>Image</th>
            <th width="280px">Action</th>
        </tr>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <td><input type="checkbox" class="sub_chk" data-id="<?php echo e($product->id); ?>"></td>  
            <td><?php echo e(++$i); ?></td>
            <td><?php echo e($product->name); ?></td>
            <td><?php echo e($product->price); ?></td>
            <td><?php echo e($product->upc); ?></td>
            <td><?php echo e($product->status); ?></td>
            <td><?php echo e($product->image); ?></td>
            <td>
                <form action="<?php echo e(route('products.destroy',$product->id)); ?>" method="POST">
   
                    <!-- <a class="btn btn-info" href="<?php echo e(route('products.show',$product->id)); ?>">Show</a> -->
    
                    <a class="btn btn-primary" href="<?php echo e(route('products.edit',$product->id)); ?>">Edit</a>
   
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">  
    $(document).ready(function () {  
  
        $('#master').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".sub_chk").prop('checked', true);    
         } else {    
            $(".sub_chk").prop('checked',false);    
         }    
        });  
  
        $('.delete_all').on('click', function(e) {  
  
            var allVals = [];    
            $(".sub_chk:checked").each(function() {    
                allVals.push($(this).attr('data-id'));  
            });    
  
            if(allVals.length <=0)    
            {    
                alert("Please select row.");    
            }  else {    
  
                var check = confirm("Are you sure you want to delete this row?");    
                if(check == true){    
  
                    var join_selected_values = allVals.join(",");   
  
                    $.ajax({  
                        url: $(this).data('url'),  
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                        data: 'ids='+join_selected_values,  
                        success: function (data) {  
                            if (data['success']) {  
                                $(".sub_chk:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='" + value + "']").remove();  
                  });  
                }    
            }    
        });  
  
        $('[data-toggle=confirmation]').confirmation({  
            rootSelector: '[data-toggle=confirmation]',  
            onConfirm: function (event, element) {  
                element.trigger('confirm');  
            }  
        });  
  
        $(document).on('confirm', function (e) {  
            var eele = e.target;  
            e.preventDefault();  
  
            $.ajax({  
                url: ele.href,  
                type: 'DELETE',  
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                success: function (data) {  
                    if (data['success']) {  
                        $("#" + data['tr']).slideUp("slow");  
                        alert(data['success']);  
                    } else if (data['error']) {  
                        alert(data['error']);  
                    } else {  
                        alert('Whoops Something went wrong!!');  
                    }  
                },  
                error: function (data) {  
                    alert(data.responseText);  
                }  
            });  
  
            return false;  
        });  
    });  
</script>  
    <?php echo $products->links(); ?>

      
<?php $__env->stopSection(); ?>
<?php echo $__env->make('products.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/shreemant/Desktop/auth-crud-app/resources/views/products/index.blade.php ENDPATH**/ ?>