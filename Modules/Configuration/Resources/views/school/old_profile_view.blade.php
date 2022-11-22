

@extends('dashboard')
@section('content-body')

<div class="container-fluid">
    <div class="row">
      <div class="col-lg-3">
         <div class="card card-block p-card">
            <div class="profile-box">
               <div class="profile-card rounded">
                  <img src="{{ asset('assets/images/user/12.jpg')}}" alt="profile-bg" class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                  <h3 class="font-600 text-white text-center mb-0">{{$school_details->name}}</h3>
                  <p class="text-white text-center mb-5">xx</p>
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
                     <p class="mb-0">(123) 123 1234</p>
                  </div>
                  <div class="d-flex align-items-center mb-3">
                     <div class="p-icon mr-3">
                        <i class="las la-map-marked"></i>
                     </div>
                     <p class="mb-0">USA</p>
                  </div>
                  <div class="d-flex justify-content-center">
                     <div class="social-ic d-inline-flex rounded">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>   
      {{--  <div class="col-lg-3 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   <h4 class="card-title">{{$school_details->name}}</h4>
                </div>
             </div>
             <div class="card-body">
                <ul class="list-inline p-0 mb-0">

                   <li>
                      <div class="d-flex align-items-center justify-content-between row">
                         <div class="col-lg-4">
                            <p class="mb-0 font-size-16">Figma</p>
                         </div>
                         <div class="col-lg-8">
                            <div class="iq-progress-bar bg-info-light mt-2">
                               <span class="bg-info iq-progress progress-1" data-percent="60" style="transition: width 2s ease 0s; width: 60%;">
                                  <span class="progress-text-one bg-info">60%</span>
                               </span>
                            </div>
                         </div>
                      </div>
                   </li>

                </ul>
             </div>
          </div>
       </div> --}}
       <div class="col-lg-9 col-md-6">
          <div class="card card-block card-stretch card-height">
             <div class="card-header">
                <div class="header-title">
                   <h4 class="card-title">Settings</h4>
                </div>
             </div>
             <div class="card-body">
                @include('configuration::registration.formwizard')
             </div>
          </div>
       </div>
      
    </div>
 </div>


 <script>
  
$('#semester_add_row').click(function(){
   
   let duplicate_row =   $('#semester_duplicate').clone().removeAttr('style id');
      $(this).parents('#semesters_div').append(duplicate_row);

      removeRow(duplicate_row);

});





    $('#add_row').click(function(){
  let duplicate_row =   $('#duplicate_row').clone().removeAttr('style id');
      $(this).parents('#seasons_div').append(duplicate_row);

      removeRow(duplicate_row);
     });

   
  /*    $('#fees').find('.duplicate_fee_add_row').each(function () {
        
        $(this).click(function(){
           console.log('cliked');
         let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
         $(this).closest('.duplicate').append(duplicate_row);
         removeRow(duplicate_row);
        });
        
     }); */
     $('#save_fee_payment').click(function(){
        let form_data = $('#fee_payment_form').serialize();
        let school_id = $('#school_id').val();
         
        let url = '{{route('configurations.school.fee.structure',':id')}}';
   url = url.replace(':id',school_id);
      $.ajax({
      type: "POST",
       url: url,
       data: form_data,
       dataType: "JSON",
       success: function (response) {
    }
  }); 




     });
     $('#class_add_row').click(function(){

        let duplicate_row = $('#class_duplicate_row').clone().removeAttr('style id')
        $(this).parents('#classes_row').append(duplicate_row);
        removeRow(duplicate_row);

     });

     $('.fee_add_row').click(function(){
      let duplicate_row = $('#fee_structure_inner_row').clone().removeAttr('style id')
         $(this).parents('#fees_append').append(duplicate_row);
         removeRow(duplicate_row);
     }); 

  
$('#add_new_fee_row').click(function(){
   let duplicate_row = $('#fee_copy').clone().removeAttr('style id')
   console.log('awii');
   $(this).parents('#fees').prepend(duplicate_row);
   removeDiv(duplicate_row);

});
     
   function removeRow(duplicate_row){
    duplicate_row.find('.remove_row').click(function(){
            $(this).parent().parent().remove();
            console.log('remove');
     });
  }
  function removeDiv(duplicate_row){
   duplicate_row.find('.remove_div').click(function(){
            $(this).parent().parent().parent().remove();
            console.log('remove');
     });

  }



/* SEASONS & CLASSES SAVE */




$('#save_seasons_n_classes').click(function(e){
   e.preventDefault();
   let school_id = $('#school_id').val();
   let form_data = $('#seasons_and_classes_form').serialize();
   let url = '{{route('configurations.school.seasons.store',':id')}}';
   url = url.replace(':id',school_id);
      $.ajax({
      type: "POST",
       url: url,
       data: form_data,
       dataType: "JSON",
       success: function (response) {
    }
  }); 

});

    </script>
 @endsection