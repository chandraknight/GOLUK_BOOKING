@extends('layouts.app')
@section('content')

@php 

$name = explode(' ',$user->name,2);
$firstName = $name[0];
$lastName = $name[1];
 @endphp
	
	<div class="container">
            <h1 class="page-title">Account Settings</h1>
        </div>




        <div class="container">
            <div class="row">
                @include('partials.usersidebar')
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{route('editprofile')}}" method="post">
                            	{{csrf_field()}}
                                <h4>Personal Infomation</h4>
                                <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                    <label>First Name</label>
                                    <input class="form-control" value="{{$firstName}}" type="text" name="firstname">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                    <label>Last Name</label>
                                    <input class="form-control" value="{{$lastName}}" type="text" name="lastname">
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
                                    <label>E-mail</label>
                                    <input class="form-control" readonly disabled value="{{$user->email}}" type="text">
                                </div>
                               
                                <div class="gap gap-small"></div>
                                
                                <hr>
                                <input type="submit" class="btn btn-primary" value="Save Changes">
                            </form>
                        </div>
                        <div class="col-md-4 col-md-offset-1">
                            <h4>Change Password</h4>
                            <form method="post" action="{{route('changepassword')}}">
                            	{{csrf_field()}}
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                	<input type="hidden" name="user_id" value="{{$user->id}}">
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" name="currentpassword">
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="newpassword">
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label>New Password Again</label>
                                    <input class="form-control" type="password" name="newpasswordconfirm">
                                </div>
                                <hr>
                                <input class="btn btn-primary" type="submit" value="Change Password">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>


@endsection