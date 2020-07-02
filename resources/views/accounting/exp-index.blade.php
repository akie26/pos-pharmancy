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
    EXPENSES
@endsection

@section('content')

        <div class="row">
            <div class="col"></div>
            <div class="col-md-8 text-right mr-3">
                <div class="row mb-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="from_date" id="from_date" class="form-control input-daterange"  readonly/>
                        <button class="btn btn-dark btn-sm ml-2 mr-2" disabled>TO</button>
                        <input type="text"  name="to_date" id="to_date" readonly class="form-control input-daterange" readonly/>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <button class="btn btn-primary" type="button" name="filter" id="filter">&nbsp;&nbsp;&nbsp;Filter&nbsp;&nbsp;&nbsp;</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark" type="button" name="refresh" id="refresh">Refresh</button>
                </div>
        </div></div>
        </div>

        <div class="container">
            

            <table class="table table-bordered text-center" id="expense_table">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>EXPENSE TITLE</th>
                        <th>EXPENSE DETAIL</th>
                        <th>EXPENSE COST</th>
                    </tr>
                </thead>
        </table>
        </div>




<div class="modal fade bd-example-modal-lg-edit" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <table class="table table-bordered text-center bg-primary">
            <tr>
                <th>ADD EXPENSE</th>
            </tr>
        </table>



    <div class="container">
        <div class="row">
            <div class="col">
                <span id="form_result"></span>
            <form id="sample_form" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label for="created_at">DATE</label>
                    <input type="text" name="created_at" class="form-control @error('created_at') is-invalid @enderror" id="created_at" value="{{ old('created_at') }}" autocomplete="off"/>
                    @error('created_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="expense_title">EXPENSE TITLE</label>
                    <input type="text" name="expense_title" class="form-control @error('expense_title') is-invalid @enderror" id="expense_title" value="{{ old('expense_title') }}" autocomplete="off"/>
                    @error('expense_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            
        </div>
        <div class="col">
            
            <div class="form-group">
                <label for="expense_details">EXPENSE DETAILS</label>
                <input type="text"
                class="form-control @error('expense_details') is-invalid @enderror" name="expense_details" id="expense_details" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
                @error('expense_details')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="expense_cost">EXPENSE COST</label>
                <input type="text"
                class="form-control @error('expense_cost') is-invalid @enderror" name="expense_cost" id="expense_cost" aria-describedby="helpId" placeholder="" value="" autocomplete="off">
                @error('expense_cost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        </div>
        <div class="row text-center">
            <div class="col"></div>
            <div class="col mb-3"><button class="eve-btn btn btn-primary"  type="submit">ADD EXPENSE</button></div>
            <div class="col"></div>
        </div>
        </form>
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
    $(document).ready(function() {
        load_data();



        function load_data(from_date = '', to_date = ''){
            $('#expense_table').DataTable({
            processing: true,
            serverSide: true,
            ajax : {
                url : '{{route("expense.index")}}',
                data : {from_date:from_date, to_date:to_date}
            },
            dom: '<"toolbar">frtip',
                    fnInitComplete: function(){
                    $('div.toolbar').html('<button type="button" data-target=".bd-example-modal-lg-edit" data-toggle="modal" name="add" id="Add" class="add-btn btn btn-primary btn-sm "><i class="fas fa-plus"></i>&nbsp;ADD EXPENSE</button>');
                    },       
            columns : [
                {data : 'created_at', name: 'created_at'},
                {data : 'expense_title', name: 'expense_title'},
                {data : 'expense_details', name: 'expense_details'},
                {
                        data: 'expense_cost',
                        render: function ( data, type, row ) {
                            return data+ ' MMK';
                        }
                    },
            ]
        });
        }
        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' && to_date != ''){
               $('#expense_table').DataTable().destroy();
               load_data(from_date, to_date);
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date!',
                    })
            }
    });
    $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#expense_table').DataTable().destroy();
            load_data();
    });


    });


    $(document).ready(function(){
        var created_at_input=$('input[name="created_at"]');
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
          dateFormat: 'yy-mm-dd',
          container: container,
          todayHighlight: true,
          autoclose: true,
        };
        created_at_input.datepicker(options).datepicker("setDate", new Date());

        $('.expenses').addClass('active');
        $('.acc-menu').addClass('menu-open');
        $('.input-daterange').datepicker({
                todayBtn: 'linked',
                dateFormat: 'yy-mm-dd',
                autoclose: true,
            });

}); 

    



    $('#sample_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: '{{route("expense.add-exp")}}',
            method : 'POST',
            data: $(this).serialize(),
            dataType : 'json',
            success:function(data){
                if(data.errors){
                    Swal.fire({
                    icon: 'error',
                    title: 'Invalid Info',
                    text: data.errors,
                    })
                }
                if(data.success){
                    $('#myModal').modal('toggle');
                    $('body').removeClass('modal-open');
                    $('#sample_form')[0].reset();
                    $('#expense_table').DataTable().ajax.reload();
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

        });


    });



    

</script>




@endsection