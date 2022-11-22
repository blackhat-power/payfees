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
            line-height: 1.0em;
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
        #debtors_table {
            border: 1px solid #ddd;
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

<body>
    <br />
    <?php

    ?>
    <table cellspacing="0.5" class="table-main" style="table-layout: fixed">
        <tr>
            <td style="width: 40%">
                <img width="200" height="80" src="">
            </td>
            <td style="width: 50%">
                <h2 style="text-align: left; color: #2B336F"> {{ strtoupper($full_name) }}  DEBTS LIST  </h2>
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
                        <td style="color: white">Date:</td>
                        <td style="width: 32%">&nbsp;</td>
                        <td></td>

                    </tr>
                    <tr style="background-color: #2B336F; ">
                        <td style="width: 5%; line-height: 9px" >&nbsp;</td>
                        <td style="line-height: 9px">
                            <table cellspacing="0.5" class="table-to-table">
                                <tr>
                                <td style="background-color: white; color: #464674; line-height: 10px; text-align: center; vertical-align: center"> {{ date("jS M Y") }} </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 30%; line-height: 9px; background-color: #2B336F;">&nbsp;</td>
                        <td style="width: 30%; line-height: 9px; background-color: #2B336F;">&nbsp;</td>
                    </tr>


                    <tr style="background-color: #AEAAAA">
                        <td colspan="4" style="padding: 3px"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table id="debtors_table" style=" font-size: 12px; width:100% " class="table table-sm">
                <thead>
                                <tr>
                                    <th style="width: 3%; text-align: right">S/N</th>
                                    <th style="width: 10.4%; text-align: center">DATE</th>
                                    <th style="width: 17.4%; text-align: left">INVOICE NO</th>
                                    <th style="width: 17.4%; text-align: right">BILLED AMOUNT</th>
                                    <th style="width: 17.4%; text-align: right">PAID AMOUNT</th>
                                    <th style="width: 17.4%; text-align: right">BALANCE</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($debtors as $index=>$debtor )
                                @if (number_format($debtor['billed_amount']) && number_format($debtor['billed_amount'] - $debtor['amount_paid']) )
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td style="text-align: center; width: 17.4%;">{{ date("jS M Y", strtotime($debtor['date'])) }}</td>
                                    <td>{{$debtor['invoice_number']}}</td>
                                  <td style="text-align: right">{{  number_format($debtor['billed_amount']) }}</td>
                                  <td style="text-align: right">{{ number_format($debtor['amount_paid']) }}</td>
                                  <td style="text-align: right">{{ number_format($debtor['billed_amount'] - $debtor['amount_paid']) }}</td>
                               </tr>
                                @endif

                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold; background-color: #AEAAAA">
                                    <th colspan="4" style="text-align: right;">TOTAL</th>
                                    {{-- <th style="text-align: right;">{{ number_format($total_billed_amount)  }}</th> --}}
                                    <th style="text-align: right;"> {{ number_format($total_paid_amount)  }} </th>
                                    <th style="text-align: right;"> {{ number_format($total_balance) }} </th>
                                   
                                </tr>
                            </tfoot>

                </table>

            </td>
        </tr>
    </table>
</body>



</html>





