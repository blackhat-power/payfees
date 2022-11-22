
@extends('layouts.app')


@section('content-breadcrumbs')
<nav aria-label="breadcrumb" style="width: 100%;">
   <ol class="breadcrumb" style="background-color: rgb(255, 249, 249)">
      <li class="breadcrumb-item"><a href="">Dashboard </a></li>
      <li class="breadcrumb-item active" aria-current="page">Students Management &nbsp;</li>
      {{-- <li class="breadcrumb-item active" aria-current="page">Class List</li> --}}
   </ol>
</nav>
<hr>
@endsection
@section('content-body')


<div class="container-fluid">
    <div class="row">
      <div class="col-lg-3">
         <div class="card card-block p-card">
            <div class="profile-box">
               <div class="profile rounded" onmouseover="showEdit(event)" onmouseout="hideEdit(event)" style="background-color: teal; position:relative;">
                  <div class="img-display" id="dp-overlay" style="position: absolute; z-index: 10; height: inherit; width: inherit; inset: 0px; margin: auto; display: none;">
                  
                  <form id="profile_submit" action="{{ route('students.profile.pic.update',$student->id) }}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        {{-- {{ method_field('put') }} --}}

                      <input onchange ="upload(event)" style="display: none" type="file" name="profile_pic" id="profile_pic">  

                  </form>
                    
                   <a href="javascript:void(0)"> 
                     <img id="profile_image" style="display:block; position:relative; background-color:#20202090; padding: 40px;border-radius: 50%; height: 120px; width: 120px;  top: 30%;-ms-transform: translateY(-50%);transform: translateY(-50%);margin: auto;" src="{{ asset('assets/images/profile_edit.png')  }}"> 
                   </a>  
               </div>
                  @php  $url= asset('storage/student_profile_pics/'.$student->profile_pic); @endphp
                  <img id="profile_image_update" src="{{ $url }}" alt="profile-bg" class="avatar-130 rounded d-block mx-auto img-fluid mb-3">
                  <h3 class="font-600 text-white text-center mb-0">{{$student->first_name}} {{$student->last_name}}</h3>
                  <p class="text-white text-center mb-5"></p>
               </div>
               <div class="pro-content rounded">
                  <div class="d-flex align-items-center mb-3">
                     <div class="p-icon mr-3">
                        <i class="las la-envelope-open-text"></i>
                     </div>
                     <p class="mb-0 eml">johndoe9891@gmail.com</p>
                  </div>
                  <div class="d-flex align-items-center mb-3">
                     <div class="p-icon mr-3">
                        <i class="las la-phone"></i>
                     </div>
                     <p class="mb-0">075487238</p>
                  </div>
                  <div class="d-flex align-items-center mb-3">
                     <div class="p-icon mr-3">
                        <i class="las la-map-marked"></i>
                     </div>
                     <p class="mb-0">MIKOCHENI</p>
                     
                  </div>
                  <div class="d-flex justify-content-center">
                     <div class="social-ic d-inline-flex rounded">
                        <a  class="btn btn-sm btn-pill btn-outline-primary"> <i class="fa fa-edit"> </i> </a> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>   
       <div class="col-lg-9 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   {{-- <h4 class="card-title">Profile</h4> --}}
                </div>
             </div>
             {{-- <input type="file" name="innn"> --}}
            
             {{-- @include('configuration::school.includes.tabs') --}}

                              <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                   <li class="nav-item">
                                      <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#contact-people" role="tab" aria-controls="pills-profile" aria-selected="false">Contact People</a>
                                   </li>
                                   <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#invoices_list" role="tab" aria-controls="pills-profile" aria-selected="false">Invoices List</a>
                                 </li>
                                   <li class="nav-item">
                                      <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#attachments" role="tab" aria-controls="pills-contact" aria-selected="false">Attachments</a>
                                   </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent-2">

                                 <div class="tab-pane fade show active" id="contact-people" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div class="card">
                                       <div class="card-header">
                                          <a type="button" style="color:white" class=" btn btn-sm btn-primary float-right"><i class="fa fa-plus-circle"></i> New </a>
                                       </div>
                                       <div class="card-body">
                                          <div class="table-responsive">

                                             <table id="contact_people_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                  <th>Occupation</th>
                                                    <th>Phone</th>
                                                  <th>Action</th>
                                                </tr>
                                                </thead>
                                
                                            </table>
         
                                          </div>

                                       </div>
                                    </div>
  
                                 </div>

                                   <div class="tab-pane fade" id="invoices_list" role="tabpanel" aria-labelledby="pills-profile-tab">
                                      <div class="card">
                                       <div class="table-responsive">
                                    <table id="new_invoices_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                                       <thead>
                                       <tr>
                                           <th>Date</th>
                                         <th>Invoice Number</th>
                                         <th>Amount</th>
                                           <th>Paid</th>
                                           <th>Balance</th>
                                         <th>Action</th>
                                       </tr>
                                       </thead>
                       
                       
                                       <tfoot>
                                           <tr>
                                               <th colspan="2" style="text-align: right">TOTAL</th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                           </tr>
                                       </tfoot>
                       
                                   </table>

                                 </div> 

                                 </div>
                                   </div>

                                   <div class="tab-pane fade" id="attachments" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div id="content" class="container-fluid">


                        <div class="card">
                                 <div class="card-header">
                  <a type="button" style="color: white" class=" btn btn-sm btn-primary float-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-arrow-down"></i> New </a>
               </div>
                  <div class="collapse" id="collapseExample">
                              <div id="attachments_display">
                                 <div class="container">
                                     

{{--                                             


                                    CURRENTLY WORKING ON ----------------->

 --}}



                                         <form method="post" id="attachments_form"  enctype="multipart/form-data">
                                         @csrf
                                          <div class="row" style="margin-top: 3%">
                                                     
                                                        <div class="col-md-5">
                                                        <div class="form-group">
                                                           <label for="">Attachment Type</label>
                                                         <select name="attachments" id="attachment_id" class="form-control form-control-sm">
                                                            <option value="">Select Attachment Type</option>
                                                            <option value="Receipt">Receipt</option>
                                                            <option value="Invoice">Invoice</option>
                                                         </select>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="form-group">
                                                            <label for="">&nbsp;</label>
                                                            <input type="file" id="myFile" name="attachment_file">
                                                         </div>
                                                         
                                                      </div>
                                                     <div class="col-md-2">
                                                        <div class="form-group">
                                                           <label for="">&nbsp;</label>
                                                           <button type="submit" data-toggle="tooltip" data-placement="top" title="" class="btn btn-info btn-default btn-sm" style="color:#fff; margin-top:20%" name="import" value="Import" data-original-title="upload attachment"><i class="fa fa-upload "></i>Upload</button>
                                                        </div>
                                                      
                                                     </div>
                                                     
                                          </div>
                                         </form>
             
                                     </div>
             
                                 </div>
                  </div>
                                
                                </div>

                                 <div class="card-body">
                                    <div class="table-responsive">
                                       <table id="attachments_table" class="table table-striped table-bordered table-sm" width="100%" style="table-layout: inherit">
                                          <thead>
                                          <tr>
                                              <th>Attachment</th>
                                            <th>Action</th>
                                          </tr>
                                          </thead>
                          
                                      </table>
   
                                    </div>        

                                           </div>
                                       </div>
                                       
                                       </div>
                                   </div>

                                </div>
                             </div>
          </div>
       </div>
      
    </div>
 </div>
 

 @endsection


 @section('scripts')


 function showEdit(event){
   $('#dp-overlay').css({"display": "block","position": "absolute", "z-index": "10", "height": "inherit", "width": "inherit", "inset": "0px", "margin": "auto"});
}

function hideEdit(event){
   $('#dp-overlay').removeAttr('style','display:block').
   attr('style','display:none');
}



let init_url = '{{ route('accounts.invoices.individual.datatable',':id') }}';

let url = init_url.replace(':id', @php echo $student->id  @endphp );

{{-- INVOICES DATATATBLE --}}


 $('#new_invoices_table').DataTable({
   processing: true,
  serverSide: true,
   ajax:url,
   columns:[
      {data: 'invoice_date', name:'invoice_date'},
      {data: 'invoice_number', name:'invoice_number'},
      {data: 'amount', name:'amount'},
      {data: 'paid', name:'paid'},
      {data: 'balance', name:'balance'},
      {data:'action', name:'action', orderable:false, searchable:false}
  ],


  "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;

       {{-- converting to interger to find total --}}
      var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
      };

      {{-- computing column Total of the complete result  --}}
      let billAmountTotal = api
          .column( 2 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
          
  var receiptAmountTotal = api
          .column( 3)
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
          
  var balanceTotal = api
          .column( 4)
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );
      
          
       {{-- Update footer by showing the total with the reference of the column index  --}}

      $( api.column( 2 ).footer() ).html(billAmountTotal.toLocaleString());
      $( api.column( 3 ).footer() ).html(receiptAmountTotal.toLocaleString());
      $( api.column( 4 ).footer() ).html(balanceTotal.toLocaleString());
  },



}
); -


{{-- END INVOICES DATATABLE --}}
 

$('#profile_image').click(function(){
   $('#profile_pic').click();
});

function upload(event){

   let profile_url = '{{ route('students.profile.pic.update','id') }}';
   let final_profile_url = profile_url.replace('id',@php echo $student->id @endphp );

      data = new FormData($('#profile_submit')[0]);

   $.ajax({
         type:'POST',
         processData: false,
         contentType: false,
         enctype: 'multipart/form-data',
         url:final_profile_url,
         data:data,
         success:function(response){
            console.log(response)

            $("#profile_image_update").attr("src",response);
         }

}); 

}

{{-- CONTACT PEOPLE DATATABLE --}}

 let contact_url = '{{ route('configurations.contact.people',[':id']) }}';

let cnct_url = contact_url.replace(':id', @php echo $student->id  @endphp );
 

 $('#contact_people_table').DataTable({
   processing: true,
  serverSide: true,
   ajax:cnct_url,
   columns:[
      {data: 'full_name', name:'full_name'},
      {data: 'occupation', name:'occupation'},
      {data: 'phone', name:'phone'},
      {data:'action', name:'action', orderable:false, searchable:false}
  ],

});

{{-- END CONTACT PEOPLE --}}


{{-- START ATTACHMENTS DATATABLE  --}}

 let attachments_url = '{{ route('students.attachments.datatable','id') }}';
let final_attachments_url = attachments_url.replace('id', @php echo $student->id @endphp);

 let attachments_table = $('#attachments_table').DataTable({
   processing: true,
  serverSide: true,
   ajax:final_attachments_url,
   columns:[
      {data: 'name', name:'name'},
      {data:'action', name:'action', orderable:false, searchable:false}
  ],


});

{{-- END ATTACHMENTS TABLE --}}



$('#attachments_form').submit(function(e){
 e.preventDefault();

   let init_url = '{{   route('students.attachments.store','id')  }}';

   let url = init_url.replace('id', @php echo $student->id @endphp);
  
   let formData = new FormData(this);
       {{-- $('#image-input-error').text(''); --}}

       $.ajax({
          type:'POST',
          url: url,
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();

               attachments_table.draw();
               
      }
           }


});
});


$('body').on('click','.attDltBtn', function(e){
   e.preventDefault();

   let init_url = '{{   route('students.attachments.delete','id')  }}';

   let url = init_url.replace('id', @php echo $student->id @endphp);

  let id = $(this).data('dlt_attachment');

  $.ajax({

   type:'POST',
   url:url,

   success: function(response){

      console.log(response);
      attachments_table.draw();

   }


  });
  
  
});
 @endsection





















 






