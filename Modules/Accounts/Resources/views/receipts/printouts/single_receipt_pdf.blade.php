<html>
<head>
    <title>{{-- Receipt_{{ $pr->ref_no.'_'.$sr->user->name }} --}}</title>
<style>

.clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        body {
            margin: 0 auto;
            color: #000000;
            background: #FFFFFF;
            font-family: "DejaVu Sans Mono";
            font-size: 12px;
        }

        .bill_to_phone{
    margin-bottom:-20px;
}


        body p .text-val {
            text-transform: uppercase;
            font-size: 12px;
            /*text-decoration: underline;*/
        }

       
        .address strong {
            font-size: 12px;
            color: #bc1f27;
        }
        
        .container {
    margin: 10px;
}


td {
    text-align: center;
}

table.td-left td {
    text-align: left !important;
    padding: 5px;
}



.bold {
    font-weight: bold;
}

.clear {
    clear: both;
}

@page {
    margin: 0px 20px;
}

#invoice_span{
    font-size:2.7em;
    display: inline-block;
    padding-top: 25px;
    padding-left: 10px;
    color: #040965 !important;
}

#footer {
    position: fixed;
    bottom: 0 !important;
    margin-bottom:0px !important;
    width: 100% !important;
    padding-top: 15px;
    background-color: #050857;
    text-align: center;
    color: white !important;
}



</style>


</head>
<body>

    <div class="container">
        <span id="invoice_span">Payment Receipt</span>

        <span style="padding-left: 140px; padding-top:100px">
</span>
    
        <div class="school_address">
        <img width="180" height="120" alt="logo" src="">
        </div>

    </div>
<div class="container">
    <div id="print">
        {{--  School Details--}}
        {{-- <table width="100%">
            <tr>

                <td>
                    <strong><span
                                style="color: #1b0c80; font-size: 17px;">{{ strtoupper($school_details->name) }}</span></strong><br/>
                    <strong> Address: &nbsp;<span class="address" style="color: #000;"><i > {{ ucwords($address) }}</i></span></strong>
                    <br>
                    <strong> Email: &nbsp;<span class="address" style="color: #000;"><i>  {{ $email }}</i></span></strong>
                    <br>
                    <strong> Tel: &nbsp;<span class="address" style="color: #000;"><i> {{ $phone }}</i></span></strong>
                    <br/> 
                    <br/>
                     <span style="color: #000; font-weight: bold; font-size: 16px;"> PAYMENT RECEIPT</span>
                </td>
            </tr>
        </table> --}}

        {{--Background Logo--}}
        {{-- <div style="position: relative;  text-align: center; ">
            <img src="{{ asset('images/logo.png') }}"
                 style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.1; margin-left: auto;margin-right: auto; left: 0; right: 0;"/>
        </div> --}}
        {{--Receipt No --}}
    <div class="bold arial" style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
        <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
            <span> Receipt Reference No. </span>
        </div>
        <div  style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
            <span>{{  $receipts->receipt_no  }}</span>
        </div>
    </div>
      <div class="float-left" style="margin-top:68px">
            <span class="bold"> DATE: </span>
            <span> {{ date('D\, j F\, Y', strtotime($receipts->date)) }}</span>
         </div>

        <div style="clear: both"></div>

        {{-- Student Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; color: #000;">STUDENT INFORMATION</span>
        </div>

        {{--Photo--}}
        <table class="td-left" cellspacing="2" cellpadding="2">
            <tr>
                <td class="bold bill_to_phone">NAME:</td>
                <td class="bill_to_phone">{{ strtoupper($receipts->payer) }}</td>  
            </tr>
            <tr>
                <td class="bold bill_to_phone">WALLET NUMBER:</td>
                <td class="bill_to_phone">  </td>
            </tr>

            <tr>
                <td class="bold bill_to_phone">CLASS:</td>
                <td class="bill_to_phone"> {{ strtoupper($class_stream) }} </td>
            </tr>
s
        </table>

        <div class="clear"></div>

        {{-- Payment Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; color: #000;">PAYMENT INFORMATION</span>
        </div>

        <table class="td-left" cellspacing="2" cellpadding="2">
                <tr>
                    <td class="bold">REFERENCE:</td>
                    <td>{{ $receipts->invoice_number }}</td>
                    {{-- <td class="bold">TITLE:</td>
                    <td>{{ isset($receipts->remarks) ? ($receipts->remarks) : ''  }}</td> --}}
                        <td class="bold">BILLED AMOUNT:</td>
                    <td> {{ number_format($billed_amount) }} </td>
                   
                {{-- <td>{{ number_format($receipts->quantity * $receipts->rate) }}</td> --}}
                </tr>
                {{-- <tr>
                
                </tr> --}}
            </table>

        {{-- Payment Desc --}}
        {{-- <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">DESCRIPTION</span>
        </div> --}}

        <table class="td-left" width="100%" cellspacing="2" cellpadding="2">
           <thead  style="background-color: rgba(92, 172, 237, 0.12); padding-top:5px; padding-bottom:5px">
           <tr> 
           <th  style="padding-top:7px; text-align:left; padding-bottom:7px"> DESCRIPTION</th>
        <th class="bold" style="text-align:right !important">AMOUNT PAID <del style="text-decoration-style: double">Tsh</del></th>
        </tr>
           
           </thead>
            <tbody>

            <tr>
                 {{-- <td>{{ date('D\, j F\, Y', strtotime($receipts->date)) }}</td> --}}
                 <td> Being payment received for {{ ucwords($receipts->payer) }}  fees (Bank Name / Cash  ) </td>
                <td style="text-align:right !important">{{ number_format($receipts->quantity * $receipts->rate) }}</td>
            </tr>
            <tr>
                <td colspan="15" style="color: #040965; width:100%; padding:5px; background-color:rgba(92, 172, 237, 0.12)"> AMOUNT IN WORDS: <p style="display:inline"> <b> {{  Helper::inwords($receipts->quantity * $receipts->rate)    }} Only </b> </p></td>
            </tr>
            </tbody>
        </table>

        <hr>
        <div class="clear"></div>

        <table style="margin-left:300px; margin-top:20px">
            <tr>
                <td colspan="2" style="vertical-align: top; text-align: center;">
                    <strong style="color: #1B219C">RECEIVED BY: </strong><br /><br />
                    <span>      </span>
                    <br />
                   <span>Adelmars Kiselar</span> 
                </td>
            </tr>
    </table>

    </div>


</div>
</div>

<div id="footer">

    <div style="text-align: center; margin-bottom:3%">
    
    <p  style="text-align: center;"> Address:&nbsp; {{ ucwords($address) }} </p>
    <span  style="text-align: center;"> Phone: {{ $phone }} &nbsp;  </span>
    <span  style="text-align: center;"> Email: &nbsp; {{ $email }} </span>
    </div>
                            
    </div>
{{-- <script>
 window.print();
 window.onafterprint = function () {
    window.close();
}
</script> --}}
</body>
</html>
