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
    

    <table class="table table-bordered text-center" id="income_table">
        <thead>
            <tr>
                <th>DATE</th>
                <th>INCOME TITLE</th>
                <th>INCOME AMOUNT</th>
                <th>VIEW DETAILS</th>
            </tr>
        </thead>
</table>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <table class="table text-center exp table-bordered" style="width: 100%;">
            <thead class="bg-dark text-center">
                <tr>
                    <th rowspan="1" colspan="8">DETAILS</th>
                </tr>
                <tr class="bg-primary">
                    <th rowspan="2">ITEM NAME</th>
                    <th rowspan="2">SOLD QTY</th>
                    <th rowspan="2">UNIT COST</th>
                    <th rowspan="2">DISCOUNT</th>
                    <th rowspan="2">TOTAL</th>
                </tr>
            </thead>
            <tbody id="thin" class="bg-light">
                
            </tbody>
                </table>
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
        $('#income').addClass('focus');
    });

    $(document).ready(function(){
        $('.incomes').addClass('active');
        $('.acc-menu').addClass('menu-open');
        $('.input-daterange').datepicker({
                todayBtn: 'linked',
                dateFormat: 'yy-mm-dd',
                autoclose: true,
            });

        load_data();

        function load_data(from_date = '', to_date = ''){
            $('#income_table').DataTable({
            processing: true,
            serverSide: true,
            ajax : {
                url : '{{route("income.index")}}',
                data : {from_date:from_date, to_date:to_date}
            },     
            columns : [
                {data : 'created_at', name: 'created_at'},
                {data : 'income_title', name: 'income_title'},
                {
                        data: 'income_amount',
                        render: function ( data, type, row ) {
                            return data+ ' MMK';
                        }
                    },
                {data: 'action', name: 'action', orderable: false}
            ]
        });
        }
        $('#filter').click(function(){
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if(from_date != '' && to_date != ''){
               $('#income_table').DataTable().destroy();
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
                $('#income_table').DataTable().destroy();
                load_data();
        });
    });
    $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            
            $.ajax({
                type: 'GET',
                url:'{{ route("income.detail") }}',
                data: {
                    'id' : id,
                },
                dataType: 'json',
                success:function(data) {
                    x = '';
                    for (var i = 0; i < data.length; i++) {
                    x += '<tr>';
                    x += '<td>' + data[i].product_name + "</td>";
                    x += "<td>" + data[i].quantity + "</td>";
                    x += "<td>" + data[i].unitcost + "</td>";
                    x += "<td>" + data[i].discount + "</td>";
                    x += "<td>" + data[i].total + "</td></tr>";
                    }
                    $('#thin').html(x);
                }
            });


        });
</script>


@endsection