
@extends('layouts.app')

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
           
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students Promotion</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promotion</a></li>
              </ol>
          </nav>
  
@endsection 

@section('content-body')
        <div class="card" style="width: 100%">
            <div class="card-body text-center">
                <h5 class="card-title font-weight-bold">Students Who Were Promoted From <span class="text-danger">{{ $old_year }}</span> TO <span class="text-success">{{ $new_year }}</span> Session</h5>
            </div>
        </div>

{{-- Reset Promotions --}}

        <div class="card" style="width:100%">
            <div class="card-header">
                <a href="javascript:void(0)" title="new invoice"  id="promotion-reset-all" type="button" class=" btn btn-danger btn-sm float-right" ><i class="fa fa-undo"></i> Reset All Promotions for the Session </a>
            </div>
        
            <div class="card-body">
        
                <table id="promotions-list" class="table table-striped table-bordered" width="100%" style="table-layout: inherit" >
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>From Class</th>
                        <th>To Class</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($promotions->sortBy('fc.name')->sortBy('account_school_details.id') as $p)
                       
                            @foreach ($p->promotions as $promotion )
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" style="height: 40px; width: 40px;" src=" {{ asset('storage/student_profile_pics/'.$p->profile_pic) }}" alt="photo"></td>
                            <td>{{ $p->first_name }} {{ $p->last_name }}</td>
                            <td>{{ $promotion->fc->name }} {{$promotion->fs ? $promotion->fs->name : '' }}</td>
                            <td>{{ $promotion->tc->name }} {{ $promotion->ts ? $promotion->ts->name : '' }}</td>

                            @if($promotion->status === 'P')
                            <td><span class="text-success">Promoted</span></td>
                        @elseif($promotion->status === 'D')
                            <td><span class="text-danger">Not Promoted</span></td>
                        @else
                            <td><span class="text-primary">Graduated</span></td>
                        @endif
                           

                            <td class="text-center">
                                <button data-id="{{ $promotion->id }}" class="btn btn-sm btn-danger promotion-reset"><i class="fa fa-undo"></i>Reset</button>
                                <form id="promotion-reset-{{ $promotion->id }}" method="post" action="{{ route('students.promotion_reset', $promotion->id) }}">@csrf @method('DELETE')</form>
                            </td>
                        </tr>
                        @endforeach 
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

@section('scripts')

/* Single Reset */
$('.promotion-reset').on('click', function () {
    let pid = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reset!'
      }).then((result) => {
        if (result.isConfirmed) {
            $('form#promotion-reset-'+pid).submit();
        }
      })
    return false;
});

/* Reset All Promotions */
$('#promotion-reset-all').on('click', function () {

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reset All Promotions!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:"{{ route('students.promotion_reset_all') }}",
                type:'POST',
                data:{ '_token' : $('#csrf-token').attr('content') },
                success:function (resp) {
                    $('#promotions-list > tbody').fadeOut().remove();
                   if(resp.state = 'Done'){
                    toastr.success('All promotions are reset','success');
                   } 
                    
                    {{-- flash({msg : resp.msg, type : 'success'}); --}}
                }
            })
        }
      })
    return false;
})

@endsection