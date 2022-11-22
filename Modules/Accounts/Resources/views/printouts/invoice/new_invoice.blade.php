





<html>
<head>
    <title>{{-- Receipt_{{ $pr->ref_no.'_'.$sr->user->name }} --}}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/invoice.css') }}"/>
<style>

.clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        @font-face {
	    font-family: sans-pro;
	    src: url('../../fonts/SourceSansPro-Regular.ttf');
        }

        body {
            margin: 0 auto;
            color: #000000;
            background: #FFFFFF;
            /* background: #000; */
            font-family: "sans-pro";
            font-size: 16rem !important;
        }

        body p {
            text-indent: 8px;
            color: #000000;
            /*font-family: "Times New Roman Georgia";*/
            font-size: 16px;
        }

        body p .text-val {
            text-transform: uppercase;
            font-size: 14px;
            /*text-decoration: underline;*/
        }

        .address {
            font-family: "DejaVu Sans Mono";
            font-size: 10px;
            color: #000000;
        }
        .banks{

            font-size: 1.5rem;
        }

        .address strong {
            font-size: 12px;
            color: #bc1f27;
        }
        .td-left {
            font-size: 1.5rem;
        }
        .payment_info{
            font-size: 1.5rem;
        }

        table.td-left td{
            font-size: 1.5rem;
        }

        #payment_terms{
            font-size: 1.5rem;
        }
        



</style>


</head>
<body>
<div class="container">
    <div id="print">
        {{--  School Details--}}
        <table width="100%">
            <tr>

                <td>
                    <strong><span
                                style="color: #1b0c80; font-size: 35px;">{{ strtoupper($school_details->name) }}</span></strong><br/>
                    {{-- <strong><span style="color: #1b0c80; font-size: 20px;">MINNA, NIGER STATE</span></strong><br/>--}}
                    <strong> Address: &nbsp;<span class="address" style="color: #000; font-size: 24px !important;"><i > {{ ucwords($school_address) }} </i></span></strong>
                    <br>
                    <strong> Email: &nbsp;<span class="address" style="color: #000; font-size: 24px !important;"><i>   {{ $school_email }} </i></span></strong>
                    <br>
                    <strong> Tel: &nbsp;<span class="address" style="color: #000; font-size: 24px !important;"><i> {{ $school_phone }} </i></span></strong>
                    <br/> 
                    <br/>

                     <span style="color: #000; font-weight: bold; font-size: 30px;"> DEBIT NOTE  </span>
                </td>
            </tr>
        </table>

        {{--Background Logo--}}
        <div style="position: relative;  text-align: center; ">
            <img src="{{ asset('images/logo.png') }}"
                 style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.1; margin-left: auto;margin-right: auto; left: 0; right: 0;"/>
        </div>

        {{--Receipt No --}}
    <div class="bold arial" style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:50px">
        <div style="padding: 10px 20px; width: 250px; background-color: lightcyan;">
            <span  style="font-size: 25px;"> Invoice No. </span>
        </div>
        <div  style="padding: 10px 20px; width: 250px; background-color: lightyellow;">
            <span  style="font-size: 25px;">{{ $particulars->invoice_number }}</span>
        </div>
    </div>

        <div style="clear: both"></div>

        {{-- Student Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">STUDENT INFORMATION</span>
        </div>

        {{--Photo--}}

        <div style="margin: 15px;">
            <img style="width: 100px; height: 100px; float: left;" src="" alt="...">
        </div>

       <div >
           <table class="td-left" style="" cellspacing="5" cellpadding="5">
            <tr>
                <td>
                    <tr>
                        <td class="bold">NAME:</td>
                        <td>{{ strtoupper($particulars->name) }}</td>
                    </tr>
                    <tr>
                        <td class="bold">ADM_NO:</td>
                        <td>{{-- {{ $sr->adm_no }} --}} ADM_N0  </td>
                    </tr>
                    <tr>
                        <td class="bold">CLASS:</td>
                        {{-- <td>{{ strtoupper($class_stream) }}</td> --}}
                    </tr>
                </td>
                <td>
                   {{-- {{ QrCode::size(100)->generate( $qrcode ) }} --}}
                </td>
            </tr>
             
              
           </table>
       </div>
        <div class="clear"></div>

        {{-- Payment Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 25px; color: #000; padding-left: 10px">PAYMENT INFORMATION</span>
        </div>

        
                    <table class="payment_info"> 
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                                <th style="width: 746px">&nbsp;</th>
                                <th style="text-align: center">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice_items as $index => $item )
                            
                            <tr>
                                <td>   {{ ++$index }}     </td>
                                <td> Payment for </b> {{ strtolower($item->descriptions) }} </b> </td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                <td> <span style="padding:4px" >{{ number_format($item->rate) }}</span>   </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
               
                 
                    <table style="padding-left: 661px; font-size:1.5rem">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th><strong>TOTAL</strong></th>
                                <th style="padding-left:165px;"> <span style="padding:4px"><strong> {{ number_format ($particulars->amount) }}  </strong> </span></th>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="max-width:1000px;"><strong>TOTAL PAYABLE</strong></td>
                                <td style="text-align: right; color:#fff  "> <span style="background-color: #548235; padding:4px;"><strong> {{number_format($particulars->amount)}} </strong></span> </td>
                                {{-- <td style="padding-left: 670px"><strong> {{ number_format ($particulars->amount) }}  </strong></td> --}}
                            </tr>

                        </thead>
                    </table>


            <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
                <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">BANK DETAILS</span>
            </div>

            <table>
                <tr>
                   <td>
                    <table class="banks" style="table-layout:fixed;">
                        @foreach ($school_bank_details as $bank_detail )
                        <tr>
                            <td style="width: 1000px; max-width:1000px">
                                <span>Bank Name:</span> 
                            </td>
                            <td></td>
                            <td>{{$bank_detail->bank_name}}</td>
                            <td></td>
                        </tr>
        
                        <tr>
                            <td style="width: 1000px; max-width:2000px"> Account No: </td>
                            <td></td>
                            <td> <span>{{$bank_detail->account_no}}</span> </td>
                        </tr>
        
                        @endforeach
                    </table>
                   </td>

                   <td style="padding-left: 684px">  {{ QrCode::size(130)->generate( $qrcode )}}  </td>


                </tr>
              
            </table>

            <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
                <span style="font-weight:bold; font-size: 25px; color: #000; padding-left: 10px">PAYMENT TERMS</span>
            </div>
            <table id="payment_terms">
                <tr>
                    <td>1.</td>
                    <td> <span>Payment is required to be paid before OR on Provided DUE dates</span>  </td>
                </tr>
                <tr>
                   <td>2.</td>
                   <td> <span>All payments should be addressed to {{ ucwords($school_details->name) }}</span> </td>
                </tr>
            </table>
          

        {{-- Payment Desc --}}

            @if ($no_of_installments != 1)
            <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
                <span style="font-weight:bold; font-size: 25px; color: #000; padding-left: 10px">PAYMENT SCHEDULE</span>
            </div>

            <table class="td-left" style="font-size: 16px" width="100%" cellspacing="2" cellpadding="2">
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
     
                
             
             
                </thead>
                 <tbody>
                 {{-- <tr>
                      <td>{{ date('D\, j F\, Y', strtotime($receipts->date)) }}</td>
                     <td>{{ number_format($receipts->quantity * $receipts->rate) }}</td>
                 </tr> --}}
                 </tbody>
             </table>

            @endif

     
        <hr>

        <table>
            <tr>
                <td style="width: 500px"></td>
                <td><strong style="color: #1B219C; font-size:30px">APPROVED BY: </strong></td> 
            </tr>
            </table>
            <table>

            <tr><td> </td> </tr>
            <tr>
                <td style="width: 500px; font-size:25px; padding-left: 347px;">Adelmars Kiselar</td>

            </tr>

        </table>
    </div>
</div>
</body>
<footer>
    <script>

        window.print();
        window.onafterprint = function () {
          window.close();
       
      }
       </script>
</footer>
</html>
