<div  class="row" style="display: none">

    <div class="top-left p-4 shadow-showcase text-center">
                <div class="row">
                <div class="col-md-8"> </div>
                <div class="col-md-4 float-right">
                 <input  type="date" name="date" class="form-control">
                </div>
                </div>
            <table>

                <tbody id="fee_structure_tbody">
                    
                   @foreach ($items as $item)
                   <tr>
                    <td scope="row"> 
                    <div class="checkbox d-inline-block mr-3">
                              <input type="checkbox" name="checkboxes[]" class="checkbox-input checkboxes" value="{{$item->amount}}-{{$item->name}} " checked>
                              <label for="checkbox1">{{$item->name}}</label>
                           </div>

                      </td>
                          <td> <input style="text-align:right" name="amount[]" type="text" class="form-control" value="{{$item->amount}}" readonly>  </td>

                      </tr>
                   @endforeach
                </tbody>
                <tfoot>
                <tr>
                <th> TOTAL </th>
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

</div>