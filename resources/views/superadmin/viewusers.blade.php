@extends('superadmin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <ul class="nav nav-pills nav-stacked">
                @foreach($roles as $role)
                    <li role="presentation"><a href=""> {{ucfirst($role->name)}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-4">
            @foreach($users as $user)

                <ul class="list-group">
                    @if($user->hasRole($viewrole))
                        <li class="list-group-item">{{$user->name}}</li>
                    @endif
                </ul>
            @endforeach
        </div>

    </div>

@endsection