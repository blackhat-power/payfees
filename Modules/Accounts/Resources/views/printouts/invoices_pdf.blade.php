<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        @page {
            sheet-size: A4;
            margin: 1pt 4pt 3pt 4pt;
        }

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
            padding: 5px;
            text-indent: 8px;
            color: #000000;
            font-family: "DejaVu Sans Mono";
            font-size: 11px;
        }

        .address strong {
            font-size: 12px;
            color: #bc1f27;
        }

        header {
            padding: 4px 0;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #000000;
            font-size: 1.5em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 2px 0;
        }

        h4 {
            color: #000000;
            font-size: 12px;
            line-height: 0.7em;
            font-weight: normal;
            text-align: center;
            margin-bottom: 10px;
        }

        .table-main {
            width: 89%;
            border: 1px solid #000000;
            border-collapse: collapse;
            margin-top: 5%;
            margin-left: auto;
            margin-right: auto;
        }

        .table-header-table {
            width: 100%;
            font-size: 20px;
            border-top: 3px solid #000000;
            border-bottom: 3px solid #000000;
            border-collapse: collapse;
            margin-bottom: 3px;
        }

        .table-from-table,
        .table-to-table {
            width: 100%;
            font-size: 14px;
            border: 2px solid #6C6C9D;
            overflow: hidden;
            border-radius: 15px;
            -moz-border-radius: 15px;
            -webkit-border-radius: 15px;
            border-collapse: separate !important;
            margin-top: 3px;
        }

        .table-below-table {
            width: 100%;
            font-size: 12px;
            border: none;
            overflow: hidden;
            border-radius: 15px;
            -moz-border-radius: 15px;
            -webkit-border-radius: 15px;
            border-collapse: separate !important;
            margin-top: 3px;
        }

        .table-main-item-table {
            width: 100%;
            border: 1px solid #000000;
            border-collapse: collapse;
        }

        .table-from-table td:first-child,
        .table-from-table th:first-child {
            border-left: none;
        }

        .table-from-table th:first-child {
            -moz-border-radius: 15px 0 0 0;
            -webkit-border-radius: 15px 0 0 0;
            border-radius: 15px 0 0 0;
        }

        .table-from-table th:last-child {
            -moz-border-radius: 0 15px 0 0;
            -webkit-border-radius: 0 15px 0 0;
            border-radius: 0 15px 0 0;
        }

        .table-from-table th:only-child {
            -moz-border-radius: 15px 15px 0 0;
            -webkit-border-radius: 15px 15px 0 0;
            border-radius: 15px 15px 0 0;
        }

        .table-from-table tr:last-child td:first-child {
            -moz-border-radius: 0 0 0 15px;
            -webkit-border-radius: 0 0 0 15px;
            border-radius: 0 0 0 15px;
        }

        .table-from-table tr:last-child td:last-child {
            -moz-border-radius: 0 0 15px 0;
            -webkit-border-radius: 0 0 15px 0;
            border-radius: 0 0 15px 0;
        }

        .table-from-table tr:nth-child(4) >td {
            margin-top:0px !important; 
        }

        .table-main td,
        .table-main th {
            border: none;
            padding-left: 0;
            padding-right: 0;
        }

        .table-header-table td,
        .table-header-table th {
            font-size: 14px;
            padding: 0px;
        }

        .table-main-item-table td,
        .table-main-item-table th {
            border: 1px solid #000000;
            font-size: 14px;
            padding: 3px;
        }

        .table-from-table td,
        .table-from-table th {
            font-size: 14px;
            padding: 3px;
        }

        .table-below-table td,
        .table-below-table th {
            font-size: 14px;
            padding: 3px;
        }

        .table-to-table td,
        .table-to-table th {
            font-size: 14px;
            padding: 3px;
        }

        .table-main-item-table tfoot tr {
            border: none;
            background: #D9D9D9;
        }

        table tfoot tr:first-child td {
            border-top: 1px solid #000000;
        }
    </style>
</head>
{{-- <?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
?> --}}

<body>
    <br />
    <table cellspacing="0.5" class="table-main" style="table-layout: fixed">
        <tr>
            <td style="width: 40%">
                @php  $logo= asset('storage/'.\Modules\Configuration\Entities\AccountSchoolDetail::first()->logo); @endphp
                @if ($logo)
                <img width="100" src="{{ $logo }}" class="img-fluid rounded-normal" alt="logo">
                @else
                <img width="100" src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-normal" alt="logo">
                @endif
            </td>
            <td style="width: 60%">
                <h2 style="text-align: left; color: #2B336F">DEBIT NOTE</h2>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%">
                <table cellspacing="0.5" class="table-header-table">
                    <tr style="background-color: #AEAAAA">
                        <td colspan="4" style="padding: 3px"></td>
                    </tr>
                    <tr style="background-color:#2B336F;">
                        <td style="width: 8%">&nbsp;</td>
                        <td style="color: white">Note Number:</td>
                        <td style="width: 32%">&nbsp;</td>
                        <td style="color: white">Date:</td>
                    </tr>
                    <tr style="background-color: #2B336F; ">
                        <td style="width: 5%; line-height: 9px">&nbsp;</td>
                        <td style="line-height: 9px">
                            <table cellspacing="0.5" class="table-to-table">
                                <tr>
                                    <td style="background-color: white; color: #464674; line-height: 10px; text-align: center; vertical-align: center"> {{ $particulars->invoice_number }} </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 30%; line-height: 9px">&nbsp;</td>
                        <td style="line-height: 9px">
                            <table cellspacing="0.5" class="table-to-table">
                                <tr>
                                    <td style="background-color: white; color: #464674; line-height: 10px; text-align: center; vertical-align: center"> {{ date("M jS, Y", strtotime("".$particulars->invoice_date."")) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="background-color: #AEAAAA">
                        <td colspan="4" style="padding: 3px"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 55%">
                <table cellspacing="0.5" class="table-from-table">
                    <!-- invoice type(to or from) -->
                    <tr>
                        <td style="padding-left: 15px;"> FROM </td>
                    </tr>
                    <tr>
                        <td></td>

                    </tr>
                    <tr>
                        <td style="color: #323D8C;"> {{ ucwords($school_details->name)  }} </td>
                    </tr>

                    <tr>
                        <td style="color: #31314E;"><br>phone: &nbsp; {{ $school_phone }} </br></td>
                    </tr>

                    <tr>
                        <td style="color: #31314E;"><br>Email: &nbsp; {{ $school_email }} </br></td>
                    </tr>

                    <tr>
                        <td style="color: #31314E;  height:1px;"><br>Address: &nbsp; {{ $school_address }}   </br></td>
                    </tr>

                    <tr>
                        <td style="color: #31314E; height: 1px"><span>TIN: 128-500-669</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>VRN: 40026370-Z</span></td>
                    </tr>
                   
                </table>
            </td>

            <td style="width: 55%">
                <table cellspacing="0.5" class="table-from-table" style="table-layout:fixed; overflow: hidden;height:240px">
                    <!-- invoice type(to or from) -->
                    <tr>
                        <td style="padding-left: 15px;"> TO </td>
                    </tr>
                    <tr>
                        <td>M/s</td>

                    </tr>
                    <tr>
                        <td style="color: #31314E; height: 10px"> {{ strtoupper($particulars->name) }} </td>
                    </tr>
                    <tr>
                        <td>
                        <table>
                            <tr>
                                <td>Phone:</td>
                                <td style="color: #31314E; width:60%; overflow:wrap;" >  
                                    {{ $student_phone }}                 
                                </td>

                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td> {{ $student_email }}</td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="background-color: #2B336F">
            <td colspan="2" style="padding: 8px; width: 100%; text-align: center; color: white; font-size: 14px">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%">
                <table cellspacing="0.5" class="table-main-item-table" style="table-layout: fixed">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th colspan="7" style="text-align: left"> Description </th>
                            <th colspan="5" style="text-align: right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_items as $index => $item )
                        <tr>
                            <td style="text-align: center;">{{++$index}}</td>
                            <td colspan="7"> Payment for </b> {{ strtolower($item->descriptions) }} </b> </td>
                            <td style="text-align: right;" colspan="5">{{ number_format($item->rate) }}  </td>
                        </tr>
                        @endforeach
                      
                    </tbody>
                    <tfoot>

                        <tr>
                            <td colspan="10" style="text-align: right"><strong>TOTAL</strong></td>
                            <td style="text-align: right" colspan="5"><strong> {{ ReadableNumber ($particulars->amount) }}  </strong></td>
                        </tr>
                        <tr style="background-color: white;">
                            <td colspan="10" style="color: #393894; text-align: right;">Total Payable </td>
                            <td style="background-color: #548235; color: white; text-align: right" colspan="3"><strong> {{ReadableNumber($particulars->amount)}} </strong></td>
                        </tr>
                        <tr>
                            <td colspan="15" style="color: #4166BD; width:100%"><strong>AMOUNT IN WORDS: </strong>&nbsp; {{Terbilang::make($particulars->amount, ' shillings'); }} &nbsp;ONLY<br/></td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <tr>
            <td colspan="2">
                <table style=" font-size: 12px" class="table-below-table">
                    <tr>
                            <td style="text-align: left; width: 90%">
                            <table>
                                @foreach ($school_bank_details as $bank_detail )
                                <tr>
                                <td style="text-align: left; width: 90%">
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
                            <td>
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate( $qrcode )) !!} ">
                            </td>
                        
                    </tr>
                    <br />
                    <br />

                    <tr style="background-color: #AEAAAA">
                        <td colspan="2">
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
                    <tr>
                        <td colspan="2" style="vertical-align: top; text-align: center;">
                            <strong style="color: #1B219C">APPROVED BY: </strong><br /><br />
                            <span>      </span>
                            <br />
                           <span>Adelmars Kiselar</span> 
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            
        </tr>

    </table>
   
                      
    <table style="height: 32px">
        <tr>
            <td>&nbsp;&nbsp;</td>
        </tr>
    </table>

    <table style="margin-top: 5px; margin-left: 45px; margin-right: 95px;">
        <tr>
            <td colspan="12" style="margin-left:28px; width: 1277px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px;">
                <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 499px">PAYMENT SCHEDULE</span>  
            </td>
        </tr>
    </table>

<table class="table-main" style="font-size: 16px; table-layout: fixed" width="100%" cellspacing="2" cellpadding="2">
    <thead style="padding: 10px 20px; width: 200px; background-color: #AEAAAA;">
    <tr>
        <td class="bold">Installment No.</td>
        <td class="bold">Description</td>
        <td class="bold">Due Date </td>
        <td class="bold">Percentage</td>
        <td class="bold">Amount <del style="text-decoration-style: double">Tsh</del></td>
    </tr>
  
    </thead>
    <tbody>
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
     <td>{{ReadableNumber ($p_schedule['amount_per_installment']) }}</td>

     </tr>
     @endforeach
 
    </tbody>
 </table>
 <table>
    <tr>
        <td colspan="2" style="vertical-align: top; text-align: center;">
            <strong style="color: #1B219C">APPROVED BY: </strong><br /><br />
            <span>      </span>
            <br />
           <span>Adelmars Kiselar</span> 
        </td>
    </tr>
 </table>

</body>

</html>