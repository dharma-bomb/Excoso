<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category</title>
    <link rel="stylesheet" href="{{ asset('css/prod.css') }}">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        <h4 class="mb-3">Add Category</h4>
        <form action="{{ url('addingcat') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="inputField" class="mb-1">Category</label>
                    <input type="text" id="inputField" class="form-control" name="category"
                        placeholder="Enter Category" required>
                </div>
                <div class="col-sm-12 col-md-4 my-auto">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>