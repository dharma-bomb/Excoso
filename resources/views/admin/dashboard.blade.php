<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/prod.css') }}">
</head>
<body>
    <div class="button-container">
        <a href="{{ route('admin.addproduct') }}" class="button">Add Product</a>
        <a href="{{ route('admin.listproduct') }}" class="button">List Product</a>
        <a href="{{ route('admin.addcat') }}" class="button">Add Category</a>
        <a href="{{ route('admin.addsubcat') }}" class="button">Add Sub Category</a>
        <a href="{{ route('admin.usersdata') }}" class="button">View Users</a>
        <a href="{{ route('admin.quotes') }}" class="button">Quote Requests</a>
    </div>
</body>
</html>
