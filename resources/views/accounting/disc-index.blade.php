@extends('layouts.default')



@section('title')
    DISCOUNTS
@endsection
@section('content')


        <div class="container">

                <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
        MAKE NEW DISCOUNT
        </button>
  
  

            <div class="row">
                <div class="col"></div>
                <div class="col-md-8"><table class="table table-bordered text-center">
                    <thead class="bg-primary">
                        <tr>
                            <th>DISCOUNT NAME</th>
                            <th>DISCOUNT AMOUNT</th>
                            <th>CREATED DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->discount_name}}</td>
                                <td>{{$item->amount}} %</td>
                                <td>{{$item->created_at->format('d/m/Y')}}</td>
                                <td><button class="btn btn-danger btn-delete btn-sm" id={{$item->id}}>DELETE</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col"></div>
            </div>

        </div>


        <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">CREATE DISCOUNT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" id="sample_form">
                @csrf
                <div class="form-group">
                    <label for="discount_name">DISCOUNT NAME</label>
                    <input type="text"
                      class="form-control" name="discount_name" id="discount_name" aria-describedby="helpId" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="amount">DISCOUNT AMOUNT</label>
                    <input type="text"
                      class="form-control" name="amount" id="amount" aria-describedby="helpId" placeholder="">
                  </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
          <button type="submit" class="btn btn-primary btn-add">CREATE</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
    $('.discount').addClass('active');
});

    $(document).on('click', '.btn-delete', function(){
        var id = $(this).attr('id');
            $.ajax({
                url : "/destroy-discount/"+ id,
                success:function(data){
                    setTimeout(function(){
                        location.reload();
                    });
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

            })        

    });

    $('#sample_form').on('submit', function(event){
        event.preventDefault();
        action_url = "{{route('discount.add')}}";
        $.ajax({
            url : action_url,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success:function(data){
                if(data.success){
                $('#sample_form')[0].reset();
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
                            });

                            Toast.fire({
                              icon: 'success',
                              title: 'SUCCESS!'
                            });
                setTimeout(function(){
                        location.reload();
                    });        
                }
                if(data.errors){
                    Swal.fire({
                    icon: 'error',
                    title: 'Invalid Info',
                    text: data.errors,
                    })
                }
            }
        });
    });

</script>  
@endsection