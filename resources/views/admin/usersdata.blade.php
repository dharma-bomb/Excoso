
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link rel="stylesheet" href="{{ asset('css/prod.css') }}">
</head>

<body>


        <table>

            <thead>
                <tr>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exploreuser as $users)
                <tr>
                    <td>{{ $users->id }}</td>
                    <td>{{ $users->name }}</td>
                    <td>{{ $users->email }}</td>
                    <td>{{ $users->mobile }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>

</html>
