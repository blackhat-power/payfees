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

        body p {
            text-indent: 8px;
            color: #000000;
            /*font-family: "Times New Roman Georgia";*/
            font-size: 11px;
        }

        body p .text-val {
            text-transform: uppercase;
            font-size: 12px;
            /*text-decoration: underline;*/
        }

        .address {
            font-family: "DejaVu Sans Mono";
            font-size: 10px;
            color: #000000;
        }

        .address strong {
            font-size: 12px;
            color: #bc1f27;
        } 
        
        .container {
    margin: 10px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

@media (min-width: 768px) {
    .container {
        width: 750px;
    }
}

@media (min-width: 992px) {
    .container {
        width: 970px;
    }
}

@media (min-width: 1200px) {
    .container {
        width: 1170px;
    }
}

@media print {
    td,
    th {
        padding: 2px;
        text-align: center;
    }
    @page {
        /*size: auto;    auto is the initial value */
        /* margin: 0;   this affects the margin in the printer settings */
    }
    html {
        -webkit-print-color-adjust: exact;
        background-color: #FFFFFF;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        /* margin: 10px;  this affects the margin on the html before sending to printer */
    }
    body {
        /*margin: 0 10mm;  margin you want for the content */
    }
}

td {
    text-align: center;
}

table.td-left td {
    text-align: left !important;
    padding: 5px;
}

.arial {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

.bold {
    font-weight: bold;
}

.clear {
    clear: both;
}

@page {
    margin: 25px 20px;
}


    </style>
</head>
<body>
<div class="container">
    <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">
        {{--  School Details--}}
        <table width="100%">
            <tr>

                <td>
                    <strong><span
                                style="color: #1b0c80; font-size: 20px;">{{ strtoupper($school_details->name) }}</span></strong><br/>
                    {{-- <strong><span style="color: #1b0c80; font-size: 20px;">MINNA, NIGER STATE</span></strong><br/>--}}
                    <strong> Address: &nbsp;<span class="address" style="color: #000; font-size: 16px !important;"><i > {{ ucwords($address) }}</i></span></strong>
                    <br>
                    <strong> Email: &nbsp;<span class="address" style="color: #000; font-size: 16px !important;"><i>  {{ $email }}</i></span></strong>
                    <br>
                    <strong> Tel: &nbsp;<span class="address" style="color: #000; font-size: 16px !important;"><i> {{ $phone }}</i></span></strong>
                    <br/> 
                    <br/>

                     <span style="color: #000; font-weight: bold; font-size: 20px;"> PAYMENT RECEIPTS</span>
                </td>
            </tr>
        </table>

        {{--Background Logo--}}
        <div style="position: relative;  text-align: center; ">
            <img src="{{ asset('images/logo.png') }}"
                 style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.1; margin-left: auto;margin-right: auto; left: 0; right: 0;"/>
        </div>

        {{--Receipt No --}}
    {{-- <div class="bold arial" style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
        <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
            <span  style="font-size: 16px;"> Receipt Reference No. </span>
        </div>
        <div  style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
            <span  style="font-size: 15px;">{{  'RCPTNO-' . add_leading_zeros($receipts->receipts[0]->id)  }}</span>
        </div>
    </div> --}}

        <div style="clear: both"></div>

        {{-- Student Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">STUDENT INFORMATION</span>
        </div>

        {{--Photo--}}

        <div style="margin: 15px;">
            <img style="width: 100px; height: 100px; float: left;" src="" alt="...">
        </div>

       <div style="float: left; margin-left: 20px">
           <table style="font-size: 16px" class="td-left" cellspacing="5" cellpadding="5">
               <tr>
                   <td class="bold">NAME:</td>
                   <td>{{ strtoupper($receipts->receipts[0]->payer)  }}</td>
               </tr>
               <tr>
                   <td class="bold">ADM_NO:</td>
                   <td>{{-- {{ $sr->adm_no }} --}} ADM_N0  </td>
               </tr>
               <tr>
                   <td class="bold">CLASS:</td>
                   <td>{{ strtoupper( $class_stream) }}</td>
               </tr>
           </table>
       </div>
        <div class="clear"></div>

        {{-- Payment Info --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">PAYMENT INFORMATION</span>
        </div>

        <table class="td-left" style="font-size: 16px" cellspacing="2" cellpadding="2">
                <tr>
                    <td class="bold">REFERENCE:</td>
                    <td>{{ $receipts->invoice_number }}</td>
                    <td class="bold">TITLE:</td>
                    <td>{{ $receipts->remarks }}</td>
                </tr>
                <tr>
                    <td class="bold">AMOUNT:</td>
                    <td> {{ number_format($receipts->invoiceItems()->sum('rate')) }} </td>
                    <td class="bold">DESCRIPTION:</td>
                    <td>PAYMENT DESCRIPTION </td>
                </tr>
            </table>

        {{-- Payment Desc --}}
        <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
            <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">DESCRIPTION</span>
        </div>

        <table class="td-left" style="font-size: 16px" width="100%" cellspacing="2" cellpadding="2">
           <thead>
           <tr>
               <td class="bold">Date</td>
               <td class="bold">REF NO.</td>
               <td class="bold">Amount Paid <del style="text-decoration-style: double">Tsh</del></td>
               <td class="bold">Balance <del style="text-decoration-style: double">Tsh</del></td>
           </tr>
           </thead>
            <tbody>
                @php
                $total_paid =0;
                $balance = 0;
            @endphp
            @foreach($receipts->receipts as $index => $receipt)
            {{-- <dd> {{$receipt}} </dd> --}}
            @if ($receipt->status == 3)
            @foreach ($receipt->receiptItems()->get() as $index => $rcpt )
            <tr>
                
               @php
                   $total_paid += $rcpt->quantity * $rcpt->rate;
               @endphp
                <td>{{ date('D\, j F\, Y', strtotime($rcpt->created_at)) }}</td>
                <td>{{$receipt->receipt_no}}</td>
                <td style="text-align:right">{{ number_format($rcpt->quantity * $rcpt->rate) }}</td>
                <td style="text-align:right">{{  number_format($receipts->invoiceItems()->sum('rate') - $total_paid) }}</td>
            </tr>
            @endforeach   
            @endif
           
                @endforeach
            </tbody>
        </table>

        <hr>
        <div class="bold arial" style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
            <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
                <span  style="font-size: 16px;"> {{ number_format($receipts->invoiceItems()->sum('rate') - $total_paid) ? 'TOTAL DUE' : 'PAYMENT STATUS' }} </span>
            </div>
            <div  style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
                <span  style="font-size: 20px;">{{ number_format($receipts->invoiceItems()->sum('rate') - $total_paid) ? number_format($receipts->invoiceItems()->sum('rate') - $total_paid)   : 'CLEARED'  }}</span>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script>
 window.print();

 window.onafterprint = function () {
    window.close();
}
</script>
</body>
</html>
