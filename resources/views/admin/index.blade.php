@extends('layouts.app')


@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">   
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.jqueryui.min.css">

@endsection
@section('title')
    ADMIN HOME
@endsection
@section('content')

    <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">BRANCHES</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">REGISTER NEW BRANCH</a>
                                </li>
                              </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <table class="table table-bordered text-center" id="user_table">
                                        <thead class="bg-success">
                                            <tr>
                                                <th>BRANCH NAME</th>
                                                <th>BRANCH CREATED DATE</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>


                                </div>
<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="row">
        <div class="col"></div>
        <div class="col-md-8">
            <form id="new_form">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('BRANCH NAME') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus >

                    @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>  

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> 

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                        <button type="submit" 
                        class="btn btn-success">{{ __('REGISTER') }}</button>
            </form>
        </div>
        <div class="col"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
    </div>


    

     


@endsection




@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<br><script src = "https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer ></script>

    <script>
        $(document).ready(function(){
            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admin') }}",
                lengthMenu: [10, 20, 50, 100, 200, 500],
                columns: [
                     { data: 'name', name: 'name' },
                     { data: 'created_at', name: 'created_at' },
                     {
                        data:'action',
                        name:'action',
                        orderable: false
                        }
                  ]
            });
        });


        $(document).on('click', '.access-btn', function(){
            var id = $(this).attr('id');
            $.ajax({
                url : '/admin-view',
                data : {'id' : id},
                dataType : 'json',
                success:function(data){
                    window.location.href = "/home";
                }
            })
        });

        $('#new_form').on('submit', function(event){
            event.preventDefault();
            action_url = '/admin-branch';
            $.ajax({
                url : action_url,
                method : 'POST',
                data : $(this).serialize(),
                dataType : 'json',
                success:function(data){
                   if(data.success){
                    $('#new_form')[0].reset();
                    $('#user_table').DataTable().ajax.reload();
                    const Toast = Swal.mixin({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer:2000,
                              timerProgressBar: true,
                              onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                              }
                            });

                            Toast.fire({
                              icon: 'success',
                              title: 'BRANCH CREATED!'
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
            })
        })
        


    </script>


@endsection