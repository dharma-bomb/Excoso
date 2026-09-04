<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
</head>
<body>

<div>
    <form id="searchForm" action="{{ route('searchprod') }}" method="POST">
        @csrf
        <label for="search">Search:</label>
        <input type="text" id="search" name="formData" placeholder="Search for products...">
        <ul id="searchResults">
            <!-- Results will be dynamically added here -->
        </ul>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').keyup(function(event) {
            var formData = $('#searchForm').serialize(); // Serialize form data

            $.ajax({
                type: 'POST',
                url: '{{ route('searchprod') }}', // Laravel route for the AJAX request
                data: formData,
                success: function(response) {
                    // Handle successful response here
                    $('#searchResults').html(response); // Replace HTML content with the response
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error(xhr.responseText); // Log the error for debugging
                }
            });
        });
    });
</script>

</body>
</html>
