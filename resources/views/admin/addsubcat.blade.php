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
        <h4 class="mb-3">Add SubCategory</h4>
        <form action="{{ url('addingsubcat') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Category" class="mb-1">Category</label>
                    <select id="Category" name="Category" class="form-select" required>
                        <option value="" selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->cat }}">{{ $category->cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="subcat" class="mb-1">SubCategory</label>
                    <input type="text" id="subcat" name="subcat" class="form-control" placeholder="Enter SubCategory"
                        required>
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