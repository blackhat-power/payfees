<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students List</title>
</head>
<body>

<table>
    <thead>
    <tr>
            <th>SN</th>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Date Of Birth</th>
            <th>Gender</th>
    </tr>
    </thead>

   <tbody>


        @foreach ($students  as  $student)  
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td></td>
            <td>  {{ $student->full_name }}</td>
            <td>  {{   date("jS  F, Y", strtotime($student->dob)) }} </td>
            <td>  {{  $student->gender }} </td>

        </tr>
        @endforeach

   
    </tbody>
</table>

</body>
</html>

