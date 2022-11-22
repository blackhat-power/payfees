<p class="text-center font-weight-bold">FEE STRUCTURE FOR <span> {{ $class_name }} </span> <span class="text-danger"> - {{ strtoupper($semester)  }} </span> </p>

@if (count($query))

<form id="invoice_form_store" action="">

 <div class=" p-4 shadow-showcase text-center">
        <div class="row">
        <div class="col-md-8"> </div>

        <div class="col-md-4 float-right">
           <div class="form-group">
            <input  type="date" name="date" class="form-control form-control-sm">
            <input type="hidden" name="stdnt_id" id="std_id" value="{{$std_id}}">
           </div>
        </div>
        </div>
    <table  class="table">
       <thead>
         <tr>
            <th>S/NO</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
         </tr>

       </thead>
      
        <tbody id="fee_structure_tbody">
           @foreach ($query as $fee_structure)

           @foreach( $fee_structure->items as $index=> $fee_item)
           <tr>
              <td>{{ ++$index }}</td>
              <td></td>
            <td scope="row"> 
            <div class="checkbox d-inline-block mr-3">
                      <label for="checkbox1">{{$fee_item->name}}</label>
                   </div>

              </td>
                  <td> <input style="text-align:right" name="amount[]" type="text" class="form-control form-control-sm" value="{{number_format($fee_item->amount)}}" readonly>  </td>
                  <td></td>
                  <td> <input type="checkbox" name="checkboxes[]" class="checkbox-input checkboxes" value="{{number_format($fee_item->amount)}}-{{$fee_item->name}} " checked> </td>
                  
              </tr>
           @endforeach
           @endforeach
        </tbody>
        <tfoot>
        <tr>
           <th></th> <th></th>
        <th style="padding-left:40px;"> <span class="text-center">TOTAL</span>  </th>
        <th>   <input style="text-align:right" type="text" class="totalSum form-control" readonly>  </th>
        </tr>
        </tfoot>
     </table>


    </div>

    <div class="input-group">
        <div class="input-group-prepend">
           <span class="input-group-text text-area">REMARKS</span>
        </div>
        <textarea name="remarks" class="form-control" aria-label="With textarea"></textarea>
     </div>

        <div class="btn-group btn-group-toggle float-right" style="margin-top:3%">
      <button type="submit" class="btn bg-secondary btn-sm mr-2" id="print_bill">Print Bill</button>
     <button type="submit" class="btn btn-primary btn-sm mr-2" id="save_bill"  >Save Bill</button>
   
   </form>

@else

 <p class="text-center text-bold text-danger"> *** THERE IS NO FEE STRUCTURE YET FOR CHOSEN CLASS  /  SEMESTER  *** </p>

@endif
{{-- </div> --}}