<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Account Sub Groups</title>
</head>
<body>

<table>
    <thead>
    <tr>
            <th>SN</th>
            <th> Name</th>
            <th>Account Group</th>
    </tr>
    </thead>

   <tbody>


        @foreach ($sub_groups  as $loop => $sub_group)  
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td> {{  $sub_group->sub_group_name }} </td>
            <td>  {{ $sub_group->group_name  }} </td>
        </tr>
        @endforeach

   
    </tbody>
</table>

</body>
</html>

