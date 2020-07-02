@extends('layouts.default')
@section('title')
    HOME
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        
                            @php
                                use App\Models\User;

                                if(auth()->user()->key != null){
                                    $id = auth()->user()->key;
                                    }
                                    else{
                                        $id = auth()->user()->id;
                                    }
                                $user = User::find($id);
                            @endphp
                                {{$user->name}} BRANCH
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
