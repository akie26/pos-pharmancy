@extends('layouts.default')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">   
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.jqueryui.min.css">
<style>
  .toolbar {
    float: left;
}
</style>

@endsection

@section('title')
    127.0.0.1
@endsection

@section('content')
 <table class="table table-bordered text-center" id="products_datatable">
    <thead>
       <tr>
          <th>ITEM NAME</th>
          {{-- <th>MANUFACTURER COUNTRY</th> --}}
          <th>BRAND</th>
          <th>DETAIL</th>
          <th>SIZE</th>
          <th>CODE</th>
          {{-- <th>ORIGINAL PRICE</th> --}}
          <th>SELLING PRICE</th>
          <th>QTY</th>
          {{-- @role('admin') --}}
          <th>ACTIONS</th>
          {{-- @endrole --}}
       </tr>
    </thead>
 </table>



<div class="modal fade bd-example-modal-lg-edit" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <table class="table table-bordered text-center bg-primary">
           <tr>
               <th id="form-title">EDIT</th>
           </tr>
       </table>
      <div class="container">
        <div class="row">
            <div class="col">
                <span id="form_result"></span>
            <form method="post" id="sample_form" class="form-horizontal">
                @csrf
            <div class="form-group">
              <label for="item_name">ITEM NAME</label>
              <input type="text"
                class="form-control" name="item_name" id="item_name" aria-describedby="helpId" placeholder=""  autocomplete="off">
            </div>
            <div class="form-group">
                <label for="size">SIZE</label>
                <input type="text"
                  class="form-control" name="size" id="size" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="brand">BRAND</label>
                <input type="text"
                  class="form-control" name="brand" id="brand" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="detail">DETAILS</label>
                <input type="text"
                  class="form-control" name="detail" id="detail" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="barcode">BARCODE</label>
                <input type="text"
                  class="form-control" name="barcode" id="barcode" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
          </div>
          <div class="col">
              <div class="form-group">
                <label for="original_price">ORIGINAL PRICE</label>
                <input type="text"
                  class="form-control" name="original_price" id="original_price" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="selling_price">SELLING PRICE</label>
                <input type="text"
                  class="form-control" name="selling_price" id="selling_price" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="quantity">QUANTITY</label>
                <input type="text"
                  class="form-control" name="quantity" id="quantity" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
              </div>
              <br>
              <input type="hidden" id="hidden_id" name="hidden_id" value="">
              <input type="hidden" name="action" id="action" value="">
              <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-md-4 ml-2"><button class="eve-btn btn btn-primary mt-2 text-right" type="submit"></button></div>
              </div> 
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<br><script src = "https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer ></script>
<script>
    $(document).ready(function(){
        $('#products').addClass('focus');
    });

    $(document).ready( function () {
     $('#products_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('product-list') }}",
            lengthMenu: [10, 20, 50, 100, 200, 500],
            dom: '<"toolbar">frtip',
            fnInitComplete: function(){
              $('div.toolbar').html('<button type="button" data-target=".bd-example-modal-lg-edit" data-toggle="modal" name="edit" id="Add" class="add-btn btn btn-primary btn-sm"><i class="fas fa-plus"></i>&nbsp;ADD ITEMS</button>');
            },
            columns: [
                     { data: 'item_name', name: 'item_name' },
                     { data: 'brand', name: 'brand' },
                     { data: 'detail', name: 'detail' },
                     { data: 'size', name: 'size' },
                     { data: 'barcode', name: 'barcode' },
                    //  {
                    //     data: 'original_price',
                    //     render: function ( data, type, row ) {
                    //         return data+ ' MMK';
                    //     }
                    // },
                    {
                        data: 'selling_price',
                        render: function ( data, type, row ) {
                            return data+ ' MMK';
                        }
                    },
                     { data: 'quantity', name: 'quantity' },
                     {
                        data:'action',
                        name:'action',
                        orderable: false
                        }
                  ]
         });
      });




      
$(document).ready(function(){
        var date_input=$('input[name="expire_date"]');
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
          dateFormat: 'yy-mm-dd',
          container: container,
          todayHighlight: true,
          autoclose: true,
        };
        date_input.datepicker(options);

});

    $(document).on('click', '.edit-btn', function(){
        var id = $(this).attr('id');
        $.ajax({
            type : 'GET',
            url : '{{ url('/edit-prod')}}',
            data : {'id': id},
            dataType : 'json',
            success:function(data){
                $('#hidden_id').val(data.id);
                $('#item_name').val(data.item_name);
                $('#size').val(data.size);
                $('#brand').val(data.brand);
                $('#detail').val(data.detail);
                $('#barcode').val(data.barcode);
                $('#expire_date').val(data.expire_date);
                $('#original_price').val(data.original_price);
                $('#selling_price').val(data.selling_price);
                $('#quantity').val(data.quantity);
                $('#action').val('Edit');
                $('.eve-btn').html('UPDATE');
                $('#form-title').html('EDIT');
            }
        });

    });


    $(document).on('click', '.add-btn', function(){
      $('#form-title').html('ADD');
       $('.eve-btn').html('ADD');
       $('#action').val('Add');
       $('#sample_form')[0].reset();
    });


    $('#sample_form').on('submit', function(event){
        event.preventDefault();
        var action_url = '';

        if($('#action').val() == 'Edit')
        {
            action_url = "{{route('products.update')}}";
        }
        if($('#action').val() == 'Add')
        {
          action_url = "{{route('products.store')}}";
        }

        var i  = $(this).serialize();
        console.log(i);

        $.ajax({
            url : action_url,
            method : 'POST',
            data:$(this).serialize(),
            dataType: 'json',
            success:function(data){
                if(data.success){
                    $('#sample_form')[0].reset();
                    $('#products_datatable').DataTable().ajax.reload();
                    $('#myModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    const Toast = Swal.mixin({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer:1000,
                              timerProgressBar: true,
                              onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                              }
                            })

                            Toast.fire({
                              icon: 'success',
                              title: 'SUCCESS!'
                            })
                }
            }
        })

    });
            $(document).on('click', '.delete-btn', function(){
                var id = $(this).attr('id');
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<i class="fas fa-check"></i>&nbsp;&nbsp;Yes!',
                        cancelButtonText: '<i class="fas fa-times"></i>&nbsp;&nbsp;No!'
                        }).then((result) => {
                        if (result.value) {
                             $.ajax({
                                 url: "/destroy-prod/"+id,
                                success:function(data){
                                    $('#products_datatable').DataTable().ajax.reload();
                                    if(data.success){
                           const Toast = Swal.mixin({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer:1000,
                              timerProgressBar: true,
                              onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                              }
                            })

                            Toast.fire({
                              icon: 'success',
                              title: 'PRODUCT REMOVED!'
                            })
                                    }
                                }
                                
                             })   

                            
                        }
                        })
            });
    
        
            $(document).ready(function(){
          $('.products').addClass('active');
      });


   </script>
@endsection
