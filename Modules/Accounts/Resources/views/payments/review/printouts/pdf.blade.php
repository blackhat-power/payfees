<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

        header {
            padding: 4px 0;
            margin-bottom: 4px;
        }

        #logo {
            text-align: center;
        }

        #logo img {
            width: 100px;
        }

        h1 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            color: #000000;
            font-size: 1.5em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 2px 0;
        }

        .table1 {
            border-top: 1px solid #000000;
            /*border-bottom: 1px solid #000000;*/
            border-left: 0;
            font-family: "DejaVu Sans Mono";
            width: 100%;
            border-collapse: collapse;
        }

        .table1 td {
            border-left: 1px solid #000000;
            /*border-to: 1px solid #000000;*/
            padding: 5px;
            line-height: 12px;
            font-size: 10px;
        }

        .table1 table td {
            border-left: 0;
        }

        .table1 th {
            padding: 4px;
            line-height: 13px;
            font-size: 12px;
        }

        .table1 thead th {
            border-left: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }

        .table1 thead th:last-child {
            border-left: 1px solid #000000;
        }

        .table1 tbody td:last-child {
            border-left: 1px solid #000000;
        }

        .table2 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            font-family: "DejaVu Sans Mono";
            width: 100%;
            border-collapse: collapse;
        }

        .table2 td {
            border: 1px solid #000000;
            padding: 10px;
            line-height: 12px;
            font-size: 12px;
            text-align: right;
        }

        .event > span {
            position: fixed;
            top: 0px;
            right: 0px;
            display: block;
            width: 80px;
            background: #000000;

            /* Text */
            color: #fff;
            font-size: 10px;
            padding: 2px 7px;
            text-align: right;
        }

        /*#header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }*/
        .footer_ {
            position: fixed;
            left: 0px;
            /*padding: 8px 0;*/
            text-align: center;
            bottom: 0px;
            right: 0px;
            height: 150px;
            color: #000000;
            width: 100%;
            border-top: 1px solid #C1CED9;
        }

        .footer_ .page:after {
            content: counter(page, upper-roman);
        }

        .footer__ {
            width: 100%;
            position: fixed;
            left: 0px;
            bottom: 0px;
            right: 0px;
            height: 60px;
            text-align: center;
            color: #000000;

        }

        .footer__ .page:after {
            content: counter(page, upper-roman);
        }

        .space:before {
            content: " ";
            padding-right: 120px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px
        }

        .space-no-underline:before {
            content: " ";
            padding-right: 100px;
        }
    </style>
    <title>Unprocessed Payments</title>
</head>
<body>


<header class="clearfix">

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

<p style="text-align:center"> <b> Unprocessed Payments </b>  </p>
<table class="table1" style="width:100%; margin-top: 10px" border="1">
    <thead>
        <tr>
            <th>SN</th>
            <th style="text-align: left;font-size: 12px">Date</th>
            <th style="text-align: left;font-size: 12px">Invoice Number</th>
            <th style="text-align: left;font-size: 12px">Student</th>
            <th style="text-align: left;font-size: 12px">Billed Amount</th>
            <th style="text-align: left;font-size: 12px">Paid</th>
            <th style="text-align: left;font-size: 12px">Due</th>
        </tr>
    </thead>

    <tbody>
    @if( count($payments_review) )
        @foreach ($payments_review  as $index  =>  $review)  
        <tr>
            <td>{{ ++$index }}</td>
            <td> {{  $review['date']}} 
             <td>{{  $review['invoice_number'] }}</td>
            <td>{{  $review['student_name'] }}</td>
            <td>{{  $review['billed_amount'] }}</td>
            <td> {{  $review['paid']}} </td> 
            <td> {{  $review['balance']}} </td>
        </tr>
        @endforeach
       @else
       <tr>
            <td colspan="7" style="text-align:center;">  NO  DATA RECORDS FOUND  </td>
        </tr>
     @endif

    </tbody>



</table>

</body>
</html>
