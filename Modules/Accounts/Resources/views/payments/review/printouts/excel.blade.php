<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unprocessed Payments</title>
</head>
<body>

<table>
    <thead>
        <tr>
            <th>SN</th>
            <th style="text-align: left;font-size: 12px">Date</th>
            <th style="text-align: left;font-size: 12px">Invoice Number</th>
            <th style="text-align: left;font-size: 12px">Student</th>
            <th style="text-align: left;font-size: 12px">Amount</th>
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

