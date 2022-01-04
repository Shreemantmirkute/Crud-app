@extends('products.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Simple Web Application</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <button style="margin-bottom: 10px" class="btn btn-danger delete_all" data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected</button>  
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
        @foreach ($products as $product)
        <tr>
        <td><input type="checkbox" class="sub_chk" data-id="{{$product->id}}"></td>  
            <td>{{ ++$i }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->upc }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->image }}</td>
            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
   
                    <!-- <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a> -->
    
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
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
    {!! $products->links() !!}
      
@endsection