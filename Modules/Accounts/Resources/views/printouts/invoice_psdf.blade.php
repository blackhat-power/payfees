
<html>
    <head>

  

<style>







</style>

  
    </head>

    <body>
       <div class="container">

      
        <span id="invoice_span">Invoice</span>
    
        <div class="school_address">
            <span style="font-size: 1.5em">
                {{ ucwords($school_details->name)  }}
            </span>
            <div style="padding-left: 8px">
                <div style="color:lavender">
                   <span>Email: &nbsp; {{ $school_email }}</span> 
                </div>
                <div>
                    <span style="color: lavender">Address: &nbsp; {{ $school_address }} </span>
                </div>
                <div style="color: lavender">
                    <span>TIN: 128-500-669</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>VRN: 40026370-Z</span>
                </div>
            </div>
           
        </div>

    </div>

    <div class="invoice_details">
        <div>
            <table>
                <tr>
                    <td>Invoice Date:</td>
                    <td> {{ date("M jS, Y", strtotime("".$particulars->invoice_date."")) }} </td>
                </tr>
                <tr>
                    <td>Invoice Number:</td>
                    <td>  {{ $particulars->invoice_number }} </td>
                </tr>

                <tr>
                    <td>Currency:</td>
                    <td> TZS </td>
                </tr>


                

                <tr><td></td></tr>
                <tr><td style="padding-top: 10px"></td></tr>

                <tr>
                    <td>Bill To:</td>
                    <td>  {{ strtoupper($particulars->name) }} </td>
                </tr>

                <tr>
                    <td>Bill To Phone:</td>
                    <td> {{ $student_phone }}  </td>
                </tr>

                <tr>
                    <td>Bill To Email:</td>
                    <td> {{ $student_email }}  </td>
                </tr>

             

            </table>

        </div>

       



    </div>

    <div class="charge_details">

    <div>  <h2 style="color:lightslategrey"> Charge Details </h2> </div>
    <div style="margin-top: 20px;">
        <table class="description" style="width:90%">
            <thead>
                <tr>
                    <th style="color: #2196f3" >SN</th>
                    <th style="text-align: left; color:#2196f3"> CHARGE DESCRIPTION </th>
                    <th style="text-align: right; color:#2196f3 " > AMOUNT </th>
                   </tr>
            </thead>

            <tbody>
                @foreach ($invoice_items as $index => $item )
                <tr>
                    <td style="text-align: center;">{{++$index}}</td>
                    <td > Payment for </b> {{ strtolower($item->descriptions) }} </b> </td>
                    <td style="text-align: right; padding:8px;">{{ number_format($item->rate) }}  </td>
                </tr>
                @endforeach
              
            </tbody>
           
        </table>




        <table class="" style="width:90%; margin-top:20">
            <thead>
                <tr>

                    <th style="text-align: left; color:#2196f3; padding-left:350px"> TOTAL </th>
                    <th style="text-align:right"> {{ number_format($particulars->amount)}} </th>
                   
                   </tr>
                   <tr>
                    <th style="text-align: left; color:#2196f3; padding-top:20px; padding-left:340px"> TOTAL  PAYABLE </th>
                    <th  style="background-color: #548235; color: white; text-align: right; padding:6px"> {{ number_format($particulars->amount)}} </th>
                   </tr>

                   <tr>
                    <td colspan="15" style="color: #4166BD; width:100%; padding:5px; background-color:#D6EEEE"><strong>AMOUNT IN WORDS: </strong>&nbsp; {{-- {{ strtoupper($f->format($particulars->amount))  }} --}} SHILLINGS&nbsp;ONLY<br/></td>
                </tr>
            </thead>            
        </table>

        <table style="font-size: 12px">
            <tr>
                    <td style="text-align: left; width: 100%">
                    <table>
                        @foreach ($school_bank_details as $bank_detail )
                        <tr>
                        <td style="text-align: left; width: 100%">
                            <tr>
                                <table>
                                    <tr><td><strong>Bank Details</strong></td></tr>
                                    <tr>
                                        <td><span>Bank Name<b>:</b>&nbsp;</span></td>
                                        <td>{{$bank_detail->bank_name}}</td>
                                    </tr>
                                    <tr>
                                        <td><span>Acc No<b>:</b>&nbsp;</span></td>
                                        <td>{{$bank_detail->account_no}}</td>
                                    </tr>
                                </table>
                            </tr>
                        </td> 
                    </tr>
    
                        @endforeach
                     
                    </table>
                    </td>
                    <td style="padding-left: 340px; padding-top:2px">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate( $qrcode )) !!} ">
                    </td>
                
            </tr>
            <tr style="background-color: #AEAAAA;">
                <td colspan="2" style="padding-top:8px">
                    <strong>Payment Terms:</strong><br />
                    1. Payment is required before or on <?= date('M jS, Y', strtotime($particulars->invoice_date . ' + 7 days')); ?> <br>
                    2. All payments should be addressed to {{ ucwords($school_details->name) }}.
                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <hr />
                </td>
            </tr>
            <br />
            @if ($no_of_installments == 1)
            <tr>
                <td colspan="2" style="vertical-align: top; text-align: center;">
                    <strong style="color: #1B219C">APPROVED BY: </strong><br /><br />
                    <span>      </span>
                    <br />
                   <span>Adelmars Kiselar</span> 
                </td>
            </tr>
            @endif

        </table>

        @if ($no_of_installments != 1)
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; width:90% ">
            <span style="font-weight:bold; color: #000; padding-left: 10px">PAYMENT SCHEDULE</span>
        </div>

        <table class="payment_schedule" style="width: 90%">
            <thead>
            <tr>
                <td class="bold">Installment No.</td>
                <td class="bold">Description</td>
                <td class="bold">Due Date </td>
                <td class="bold">Percentage</td>
                <td class="bold">Amount <del style="text-decoration-style: double">Tsh</del></td>
            </tr>
          
 
             @foreach ( $payments_schedule_list as $index=> $p_schedule )
             <tr>
             <td>{{$index + 1}}</td>
             @if ($index == 0 || $index%2 == 0)
                 <td>{{$p_schedule['description']['start_date']}}</td>
                 <td>{{$p_schedule['due_date']['start_final_date']}}</td>
             @else
             <td>{{$p_schedule['description']['before_end_description']}}</td>
             <td>{{$p_schedule['due_date']['before_end_due']}}</td>
             @endif
 
             <td>{{$p_schedule['percentage']}}</td>
             <td>{{number_format ($p_schedule['amount_per_installment']) }}</td>
 
             </tr>
             @endforeach

             <tr>
                <td colspan="6">
                    <hr />
                </td>
            </tr>
            <br />
 
              <tr>
                <td colspan="6" style="vertical-align: top; text-align: center;">
                    <strong style="color: #1B219C">APPROVED BY: </strong><br /><br />
                    <span>      </span>
                    <br />
                   <span>Adelmars Kiselar</span> 
                </td>
            </tr> 
         
         
            </thead>
             <tbody>
             
             </tbody>
         </table>

        @endif

    </div>

</div>
    </body>


</html>


