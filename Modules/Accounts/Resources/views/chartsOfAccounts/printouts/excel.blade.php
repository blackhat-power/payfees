<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Charts Of Account</title>
</head>
<body>

<table>
    <thead>
    <tr>
            <th>SN</th>
            <th>Code</th>
            <th> Account Name</th>
            <th>Account Group</th>
    </tr>
    </thead>

   <tbody>


        @foreach ($chart_of_accounts  as $loop => $chart_of_account)  
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td> {{  $chart_of_account->code }} </td>
            <td>  {{ $chart_of_account->account_name  }} </td>
            <td>  {{  $chart_of_account->name }} </td>
        </tr>
        @endforeach

   
    </tbody>
</table>

</body>
</html>

