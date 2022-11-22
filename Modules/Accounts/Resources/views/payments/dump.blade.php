@extends('dashboard')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
        <div class="navbar-breadcrumb">
            <h4 class="mb-0">Create Payments</h4>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">create</li>
                </ul>
            </nav>
        </div>

    </div>
  
</div> 
</div>
@endsection


@section('content-body')
<div class="container">

<div class="card">
    <div class="card-header">
        <h5 class="card-title text-center">Create Payment</h6>
        {{-- {!! Qs::getPanelOptions() !!} --}}
    </div>

<div class="card-body">
<form class="ajax-store" method="post" action="{{ route('accounts.students.payments.store') }}">
  <fieldset>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Fee Type* </label>
                    <input type="text" value="{{ old('title') }}" required type="text" name="fee_type" id="" class="form-control form-control-sm" placeholder="eg. School Fees">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""> Class </label>
                    <select name="" id="class" class="form-control form-control-sm">
                        <option value="">All Classes </option>
                        @foreach($my_classes as $c)
                        <option {{ old('my_class_id') == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""> Payment Method </label>
                    <select name="" id="" class="form-control form-control-sm">
                        <option value="">Cash</option>
                        <option value="">Online</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""> Amount&nbsp;(<del style="text-decoration-style: double">Tsh</del>) <span class="text-danger">*</span> </label>
                   <input class="form-control form-control-sm" type="number">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""> Description </label>
                   <textarea name="" id="" cols="30" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit form <i class="fas fa-paper-plane"></i> </button>
        </div>
    </fieldset>

    </form>

{{-- 

        <div class="row" style="width:100%">
            <div class="col-md-12">
                <form class="ajax-store" method="post" action="{{ route('accounts.students.payments.store') }}">
                    @csrf
                    <div class="form-group">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Title <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="title" value="{{ old('title') }}" required type="text" class="form-control" placeholder="Eg. School Fees">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my_class_id" class="col-lg-2 col-form-label font-weight-semibold">Class: </label>
                        <div class="col-lg-9">
                            <select class="form-control select-search" name="my_class_id" id="my_class_id">
                                <option value="">All Classes</option>
                                @foreach($my_classes as $c)
                                    <option {{ old('my_class_id') == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                
                    <div class="form-group">
                        <label for="method" class="col-lg-3 col-form-label font-weight-semibold">Payment Method</label>
                        <div class="col-lg-9">
                            <select class="form-control select" name="method" id="method">
                                <option selected value="Cash">Cash</option>
                                <option disabled value="Online">Online</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount" class="col-lg-3 col-form-label font-weight-semibold">Amount (<del style="text-decoration-style: double">Tsh</del>) <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input class="form-control" value="{{ old('amount') }}" required name="amount" id="amount" type="number">
                        </div>
                    </div>

                </div>
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="description" class="font-weight-semibold">Description</label>
                        <div class="col-lg-9">
                            <textarea name="description" value="{{ old('description') }}" id="description" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div> --}}
        </div>
    </div>
</div>
</div>

@endsection

@include('shadows.custom_js')
@section('scripts')


$('#class').select2({width:'100%'})

@endsection




