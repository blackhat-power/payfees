{{-- DUPLICATES --}}

<div class="row" id="duplicate_row" style="display: none">
    <div class="col-md-4">
           <input type="text" class="form-control" name="season_name[]">
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <input type="date" class="form-control" name="season_start_date[]" >
        </div>
   </div>
   <div class="col-md-3">
       <div class="form-group">
        <input type="date" class="form-control" name="season_end_date[]" >
       </div>    
   </div>
   <div class="col-md-1">
        <button type="button" style="color:black; margin-top:30%" class="btn btn-warning btn-sm fa fa-minus remove_row" > </button>
        
   </div>
</div>

{{-- classes --}}

{{-- end classes --}}

{{-- inner fee structure --}}


<div class="row" id="fee_structure_inner_row" style=" display:none; " >
    <div class="col-md-4">
       <div class="form-group">
          <input type="text" class="form-control form-control-sm" name="fee_types[]" placeholder="fee">
       </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
         <select name="currency[]" class="form-control form-control-sm currency" id="">
            @foreach ($currencies as $currency)
            <option value="{{$currency->id}}">{{$currency->name}}</option>
            @endforeach
         </select>
      </div>
     </div>
     <div class="col-md-4">
        <div class="form-group">
           <input type="text" class="form-control form-control-sm amounts" name="amounts[]" placeholder="amount.">
        </div>
     </div>
     <div class="col-md-1">
        <button type="button" style="color:black; margin-top:4%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
 </div>
 </div>


{{-- New  class fee structure --}}

<div id="fee_copy" style="display: none;">

    <div class="row">
       <div class="col-md-6">
          <div class="form-group">
             <label> Class </label>
             <input type="text" class="form-control form-control-sm" name="classes[]" placeholder="enter class">
          </div>
       </div>
       <div class="col-md-5">
          <div class="form-group">
             <label> Semester/term </label>
             <input type="text" class="form-control form-control-sm" name="semesters[]" placeholder="enter semester">
          </div>
       </div>

           <div class="col-md-1">
            <button type="button" style="color:black; margin-top:90%" class="btn btn-warning btn-sm fa fa-minus remove_div"> </button>
           </div>
    </div>
    <div class="row duplicate">
       <div class="col-md-3">
          <div class="form-group">
             <label> Fee *</label>
             <input type="text" class="form-control form-control-sm" name="fee_type[]" placeholder="fee">
          </div>
       </div>
       <div class="col-md-3">
          <div class="form-group">
             <label>Installment.: *</label>
             <input type="text" class="form-control form-control-sm" name="installments[]" placeholder="Installment.">
          </div>
       </div>
       <div class="col-md-2">
            <div class="form-group">
               <label>Currency.: *</label>
               <select name="currency[]" class="form-control form-control-sm" id="">
                  @foreach ($currencies as $currency)
                  <option value="{{$currency->id}}">{{$currency->name}}</option>
                  @endforeach
                  
               </select>
         </div>
        </div>
        <div class="col-md-3">
           <div class="form-group">
              <label>Amount.: *</label>
              <input type="text" class="form-control form-control-sm" name="amounts[]" placeholder="amount.">
           </div>
        </div>
        <div class="col-md-1">
          <button type="button" style="color:black; margin-top:70%" class="btn btn-primary btn-sm fa fa-plus duplicate_fee_add_row"> </button>
   </div>
    </div>

  </div>

{{-- SEMESTERS --}}

<div class="row"  id="semester_duplicate" style="display: none">
<div class="col-md-1"></div>
<div class="col-md-10">
   <div class="row">
      <div class="col-md-4">
         <div class="form-group">
            <input type="text" class="form-control form-control-sm" name="semester_name[]" >
         </div>
  
     </div>

     <div class="col-md-3">
      <div class="form-group">
         <input type="date" class="form-control form-control-sm" name="semester_start_date[]" >
         <input type="hidden" name="school_id" id="school_id" value="{{$school_details->id}}">
      </div>
  </div>

  <div class="col-md-4">
   <div class="form-group">
      <input type="date" class="form-control form-control-sm" name="semester_end_date[]" >
   </div>
</div>

<div class="col-md-1">
   <button type="button" style="color:black; margin-top:4%" class="btn btn-warning btn-sm fa fa-minus remove_row"> </button>
  </div>

   </div>
</div>
  
</div>

{{-- END OF DUPLICATES --}}
