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
            font-family: "DejaVu Sans Mono" !important;
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
<?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
?>

<body>
    <br />
    <?php

    ?>
    <table cellspacing="0.5" class="table-main" style="table-layout: fixed">
        <tr>
            <td style="width: 40%">
                <img width="200" height="80" src="LOGO">
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
                                    <td style="background-color: white; color: #464674; line-height: 10px; text-align: center; vertical-align: center"> {{ 'RCPTNO-'.add_leading_zeros($receipts[0]->receipt_id)   }} </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 30%; line-height: 9px">&nbsp;</td>
                        <td style="line-height: 9px">
                            <table cellspacing="0.5" class="table-to-table">
                                <tr>
                                    <td style="background-color: white; color: #464674; line-height: 10px; text-align: center; vertical-align: center"> {{ date("M jS, Y", strtotime("".$receipts[0]->receipt_date."")) }}</td>
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
                        <td style="color: #323D8C; height: 5px"> {{ ucwords($school_details[0]->name)  }} </td>
                    </tr>
                    <tr>
                        <td style="color: #31314E; height: 5px"> {{ $school_details[0]->villages->name  }}</td>
                    </tr>
                    @foreach ($school_details as $school_detail )
                    @foreach ($school_detail->contactable as $index => $contactable)
                    <tr style="padding-top:1px">
                        <td style="color: #31314E;"><br> {{$contactable->contact}} </br></td>
                    </tr> 
                    @endforeach 
                    @endforeach
                    <tr>
                        <td style="color: #31314E; height: 10px"><span>TIN: 128-500-669</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>VRN: 40026370-Z</span></td>
                    </tr>
                </table>
            </td>
            <td style="width: 45%;">
                <table cellspacing="0.5" class="table-to-table">
                    <tr>
                        <th style="text-align: left; padding: left 15px;">TO</th>
                    </tr>
                    <tr>
                        <td>M/s</td>
                    </tr>
                    <tr>
                        <td style="color: #31314E; height: 10px"> {{ strtoupper($receipts[0]->payer) }} </td>
                    </tr>
                    <tr>
                        <td style="color: #417AC0; height: 10px">
                            <span> FAX: </span><br />
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #31314E; height: 50px">
                            <span> phone: </span><br />
                            <span> email: </span><br />
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
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
                            <th colspan="7">Description</th>
                            <th colspan="5">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td colspan="7"> Payment for </b> to </b> </td>
                            <td style="text-align: right;" colspan="5">  </td>
                        </tr>
                    </tbody>
                    <tfoot>

                        <tr>
                            <td colspan="10" style="text-align: right"><strong>TOTAL</strong></td>
                            <td style="text-align: right" colspan="5"><strong> </strong></td>
                        </tr>
                        <tr style="background-color: white;">
                            <td colspan="10" style="color: #393894; text-align: right;">Total Payable </td>
                            <td style="background-color: #548235; color: white; text-align: right" colspan="3"><strong> </strong></td>
                        </tr>
                        <tr>
                            <td colspan="15" style="color: #4166BD; width:100%"><strong>AMOUNT IN WORDS: </strong>&nbsp; Shillings&nbsp;ONLY<br/></td>
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
                        <?php if (1 == 0) { ?>
                            <td style="text-align: left; width: 90%">
                                <strong>Bank Details:</strong><br />
                                <span>Bank Name<b>:</b>&nbsp;&nbsp; National Microfinance Bank (NMB)</span> <br>
                                <span>Acc No<b>:</b>&nbsp;&nbsp; 23910000722</span> <br>
                                <span>Branch<b>:</b>&nbsp;&nbsp; Oyster Plaza </span><br>
                                <span>Swift Code<b>:</b>&nbsp;&nbsp; NMIBTZTZ</span>
                            </td>
                            <td>
                                <img height="100" width="100" src="" alt="">
                            </td>
                        <?php } else { ?>
                            <td style="text-align: left; width: 90%">
                                <strong>Bank Details:</strong><br />
                                <span>Bank Name<b>:</b>&nbsp;&nbsp; BANK NAME </span> <br>
                                <span>Acc No<b>:</b>&nbsp;&nbsp;  </span> <br>
                                <span>Branch<b>:</b>&nbsp;&nbsp;  BRANCH </span><br>
                                <span>Swift Code<b>:</b>&nbsp;&nbsp; SWIFT CODE </span>
                            </td>
                            <td>
                                <img height="100" width="100" src="" alt="">
                            </td>

                        <?php } ?>
                    </tr>
                    <br />
                    <br />

                    <tr style="background-color: #AEAAAA">
                        <td colspan="2">
                            <strong>Payment Terms:</strong><br />
                            1. Payment is required before or on DUE DATE <br>
                            2. All payments should be addressed to BIZY TECH LIMITED.
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
                            <span style="text-decoration: underline">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span><br />
                            Adelmars Kiselar
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>