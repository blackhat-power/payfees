<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students Collection</title>
</head>
<body>

    <table class="table1" style="width:100%; margin-top: 10px" border="1">
        <thead>
            <tr>
                <th style="text-align: center">SN</th>
                <th style="text-align: left" >Student Name</th>
                <th style="text-align: left" >Class</th>
                <th style="text-align: left" >Stream</th>
                <th style="text-align: right" >Amount Paid</th>
               
            </tr>
        </thead>
    
        <tbody>
            @foreach ($collection  as $index  =>  $col)  
            <tr>
                <td style="text-align: center">{{ ++$index }}</td>
                <td style="text-align: left"> {{ $col['student_name']  }} </td>
                <td style="text-align: left">{{ $col['class']   }}</td>
                <td style="text-align: left"> {{ $col['stream']   }}</td>
                <td style="text-align: right">{{ number_format($col['amount_paid'])   }}</td>
            </tr>
            @endforeach
           
    
            <tr>
                <td style="text-align: right" colspan="4">TOTAL</td>
            <td style="text-align: right"><b>{{ number_format($total_collection) }}</b> </td>
            </tr>
        </tbody>    
    
    </table>

</body>
</html>

