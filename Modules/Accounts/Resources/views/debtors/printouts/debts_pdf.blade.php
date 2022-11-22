<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
        <style>

<style>
        @page {
            sheet-size: A4;
            /*margin: 1pt 4pt 3pt 4pt;*/
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
            text-indent: 8px;
            color: #000000;
            /*font-family: "Times New Roman Georgia";*/
            font-size: 11px;
        }
        
        .debtors_data{
            border:1px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        .debtors_data :nth-child(even){background-color: #f2f2f2;}



        .table-main {
            border-top: 1px solid #000000;
            /* border-bottom: 1px solid #000000; */
            border-left: 0;
            font-family: "DejaVu Sans Mono";
            width: 100%;
            border-collapse: collapse;
        }

        .table-main td {
            /* border-left: 1px solid #000000; */
            border: 1px solid #000000;
            padding: 5px;
            line-height: 12px;
            font-size: 10px;
        }

        .table-main table td {
            border-left: 0;
        }

        .table-main th {
            padding: 4px;
            line-height: 13px;
            font-size: 12px;
        }

        .table-main thead th {
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }

        .table-main thead th:last-child {
            border-left: 1px solid #000000;
        }
        .table-main tfoot th {
            border: 1px solid black;
        }

        .table-main tbody td:last-child {
            border-left: 1px solid #000000;
        }


        .table-header-table {
            width: 100%;
            font-size: 12px;
            /* border-top: 3px solid #000000; */
            /* border-bottom: 3px solid #000000; */
            border-collapse: collapse;
            margin-bottom: 1px;
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



        #customers {
            font-family: "DejaVu Sans Mono";
            font-size: 12px !important;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 3px;
}

/* #customers tr:nth-child(even){background-color: #f2f2f2;} */

/* #customers tr:hover {background-color: #ddd;} */

#customers th {
  padding-top: 6px;
  padding-bottom: 6px;
  text-align: left;
  /* background-color: #d8dadd; */
  color: black;
}

#summary th {
  padding-top: 6px;
  padding-bottom: 6px;
  text-align: left;
  /* background-color: #d8dadd; */
  color: black;
}

#summary{

    font-family: "DejaVu Sans Mono";
            font-size: 12px !important;
  border-collapse: collapse;
  width: 100%;

}
    </style>
</head>

<body>

    <header class="clearfix" style="text-align: center">

        <div id="logo">
            <address class="address" style="line-height: 16px">
                <h2 style="color: #040404">{{$school_info->name}}</h2>
                <strong style="color: #000000">Address:</strong> {{ $address }}<br>
                <strong style="color: #000000">Tel:</strong> {{ $phone   }} <br/><strong
                        style="color: #000000">Email:</strong> {{ $email }}
                <br>
                <strong style="color: #000000">TIN:</strong> 128-500-669 <strong style="color: #000000">VRN:</strong>
                40026370Z
            </address>
        </div>
    
    </header>

    <br />
    <?php

    ?>
                   <p style="text-align: center; color: #2B336F; font-size:15px !important"> <b>DEBTORS LIST</b>  </p>
                   <span>Date: {{   date('jS M Y')   }} </span>                
                <table style="width:100%; margin-top: 10px " class="table table-main table-sm">
                <thead>
                                <tr>
                                    <th style="text-align: center">S/N</th>
                                    <th style="width: 17.4%; text-align: left">DATE</th>
                                    <th style="width: 25.4%; text-align: left">STUDENT NAME</th>
                                    <th style="width: 19.4%; text-align: left">INVOICE NO</th>
                                    <th style="width: 15.4%; text-align: right">BILL AMOUNT</th>
                                    <th style="width: 15.4%; text-align: right">PAID AMOUNT</th>
                                    <th style="width: 17.4%; text-align: right">BALANCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($debtors as $index=>$debtor )
                                @if (number_format($debtor['billed_amount']) && number_format($debtor['billed_amount'] - $debtor['amount_paid']) )
                                
                                <tr>    
                                    <td style="text-align: center">{{ ++$index }}</td>
                                    <td>{{ date('jS M Y',strtotime($debtor['date'])) }}</td>
                                    <td style="text-align: left">{{ ucwords($debtor['name']) }}</td>
                                    <td> {{ $debtor['invoice_number'] }}</td>
                                  <td style="text-align: right">{{  number_format($debtor['billed_amount']) }}</td>
                                  <td style="text-align: right">{{ number_format($debtor['amount_paid']) }}</td>
                                  <td style="text-align: right">{{ number_format($debtor['billed_amount'] - $debtor['amount_paid']) }}</td>
                               </tr>
                                @endif

                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold; background-color: #AEAAAA;  border-left: 1px solid #000000;  border-right: 1px solid #000000;">
                                    <th colspan="4" style="text-align: right;">TOTAL</th>
                                    <th style="text-align: right;">{{ number_format($total_billed_amount)  }}</th>
                                    <th style="text-align: right;"> {{ number_format($total_paid_amount)  }} </th>
                                    <th style="text-align: right;"> {{ number_format($total_balance) }} </th>
                                   
                                   
                                </tr>


                                {{-- <tr>
                                <table id="summary">
                                    <thead>  
                                    <tr> <th colspan="" style="text-align:center;">SUMMARY</th> </tr>
                                    <tr>
                                        <th style="text-align: right !important;">TOTAL DEBT NOTE VALUE </th>
                                        <th style="text-align: right !important;">PAID</th>
                                        <th style="text-align: right !important;">BALANCE</th>
                                    </tr>       
                                    
                                    </thead>
                                    <tbody> 
                                    <tr>
                                        <td style="text-align: right !important;">{{ $all_total_billed_amount  }}</td>
                                        <td style="text-align: right !important;">{{ $all_total_paid_amount }}</td>
                                        <td style="text-align: right !important;">{{ $all_total_balance }}</td>
                                    </tr>
                                    </tbody>
                                    
                                    </table>
                                    </tr> --}}


                            </tfoot>

                </table>

            {{-- </td>
        </tr>
    </table> --}}
</body>


</html>





