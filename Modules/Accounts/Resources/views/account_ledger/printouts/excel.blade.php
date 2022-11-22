
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

<table class="table1" style="width:100%; margin-top: 10px" border="1">
    <thead>
        <tr>
            <th>SN</th>
            <th>Name</th>
            <th>Account Sub Group 1</th>
            <th>Account Sub Group 2</th>
          <th>Account Main Group</th>
          <th>DR</th>
          <th> CR </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ledgers  as $index  =>  $ledger)  
        <tr>
            <td>{{ ++$index }}</td>
            <td> {{   $ledger->ledger_name  }} </td>
            <td>{{  $ledger->sub_group_name }}</td>
            <td>{{  $ledger->sub_group_name }}</td>
            <td> 
                {{  $ledger->group_name   }}
            </td>

            <td> {{   $ledger->transaction_type == 'Dr' ? number_format($ledger->opening_balance) : ''      }}   </td>
            <td> {{   $ledger->transaction_type == 'Cr' ? number_format($ledger->opening_balance) : ''      }}   </td>

        </tr>
        @endforeach
       


    </tbody>



</table>

</body>
</html>