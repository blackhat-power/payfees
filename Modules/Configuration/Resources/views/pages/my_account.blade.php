
@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Registered Schools</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Schools</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection



@section('content-body')

<div class="content">
            
    <div id="ajax-alert" style="display: none"></div>


<div class="card">
<div class="card-header header-elements-inline">
<h6 class="card-title">My Account</h6>
<div class="header-elements">
<div class="list-icons">
    <a class="list-icons-item" data-action="collapse"></a>
    <a class="list-icons-item" data-action="remove"></a>
</div>
</div>
</div>

<div class="card-body">
<ul class="nav nav-tabs nav-tabs-highlight">
<li class="nav-item"><a href="#change-pass" class="nav-link active" data-toggle="tab">Change Password</a></li>
                <li class="nav-item"><a href="#edit-profile" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Manage Profile</a></li>
        </ul>

<div class="tab-content">
<div class="tab-pane fade show active" id="change-pass">
<div class="row">
    <div class="col-md-8">
        <form method="post" action="http://localhost/lvs/public/my_account/change_password">
            <input type="hidden" name="_token" value="Qfy5ihhAPK884uDQxQxCldWIZn46oC3txtDP6RZG"> <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label for="current_password" class="col-lg-3 col-form-label font-weight-semibold">Current Password <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input id="current_password" name="current_password" required="" type="password" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-lg-3 col-form-label font-weight-semibold">New Password <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input id="password" name="password" required="" type="password" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="col-lg-3 col-form-label font-weight-semibold">Confirm Password <span class="text-danger">*</span></label>
                <div class="col-lg-9">
                    <input id="password_confirmation" name="password_confirmation" required="" type="password" class="form-control">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-danger">Submit form <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>
</div>
                <div class="tab-pane fade" id="edit-profile">
    <div class="row">
        <div class="col-md-6">
            <form enctype="multipart/form-data" method="post" action="http://localhost/lvs/public/my_account">
                <input type="hidden" name="_token" value="Qfy5ihhAPK884uDQxQxCldWIZn46oC3txtDP6RZG"> <input type="hidden" name="_method" value="put">
                <div class="form-group row">
                    <label for="name" class="col-lg-3 col-form-label font-weight-semibold">Name</label>
                    <div class="col-lg-9">
                        <input disabled="disabled" id="name" class="form-control" type="text" value="CJ Inspired">
                    </div>
                </div>

                                                        <div class="form-group row">
                        <label for="username" class="col-lg-3 col-form-label font-weight-semibold">Username</label>
                        <div class="col-lg-9">
                            <input disabled="disabled" id="username" class="form-control" type="text" value="cj">
                        </div>
                    </div>

                
                <div class="form-group row">
                    <label for="email" class="col-lg-3 col-form-label font-weight-semibold">Email </label>
                    <div class="col-lg-9">
                        <input id="email" value="cj@cj.com" name="email" type="email" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-lg-3 col-form-label font-weight-semibold">Phone </label>
                    <div class="col-lg-9">
                        <input id="phone" value="" name="phone" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone2" class="col-lg-3 col-form-label font-weight-semibold">Telephone </label>
                    <div class="col-lg-9">
                        <input id="phone2" value="" name="phone2" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-lg-3 col-form-label font-weight-semibold">Address </label>
                    <div class="col-lg-9">
                        <input id="address" value="" name="address" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-lg-3 col-form-label font-weight-semibold">Change Photo </label>
                    <div class="col-lg-9">
                        <div class="uniform-uploader"><input accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc=""><span class="filename" style="user-select: none;">No file selected</span><span class="action btn bg-blue" style="user-select: none;">Choose File</span></div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-danger">Submit form <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
</div>
</div>



</div>


@endsection