@extends('layouts.app')

@section('content-heading')
<div class="col-lg-12 mb-3">
    <div class="d-flex align-items-center justify-content-between welcome-content">
          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</a></li>
                <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
              </ol>
          </nav>
    </div>
</div>

@endsection
