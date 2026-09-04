<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Product Form</title>
    <link rel="stylesheet" href="{{ asset('css/prod.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
    .selected-images img {
        height: 100px;
        margin: 10px;
    }

    .image-container {
        display: inline-block;
        position: relative;
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: red;
        color: white;
        border: none;
        cursor: pointer;
        padding: 2px 5px;
        border-radius: 50%;
    }
</style>

<body>

    <div class="container">
        <h4 class="mb-3">Add Products</h4>
        <form id="form_disable" action="{{ url('add_prod') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Productname" class="mb-1">Product Name</label>
                    <input type="text" id="Productname" name="Productname" class="form-control"
                        placeholder="Enter Product Name" required>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Description" class="mb-1">Description</label>
                    <textarea rows="1" id="Description" name="Description" class="form-control"
                        placeholder="Enter Description" required></textarea>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="category" class="mb-1">Category</label>
                    <select id="category" class="categories form-select" name="category" required>
                        <option value="" selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->cat }}">{{ $category->cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="subcategory" class="mb-1">Subcategory</label>
                    <select id="subcategory" class="subcategories form-select" name="subcat" required>
                        <option value="" selected disabled>Select SubCategory</option>
                        <!-- Options will be populated dynamically using AJAX -->
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Price" class="mb-1">Price</label>
                    <input type="number" id="Price" name="Price" class="form-control" placeholder="Enter Price" required>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Images" class="mb-1">Images</label>
                    <input type="file" id="images" name="images[]" class="form-control" multiple style="display:none;"
                        accept="image/*" required>
                    <div id="uploadButton" onclick="selectImages()" class="h-auto w-100">
                        <i class="fa-solid fa-upload"></i> &nbsp;| &nbsp;Click to upload images
                    </div>
                    <small id="errorMessage" class="error-message">User can only upload up to 5 images.</small>
                    <div class="selected-images">
                        <!-- Images will be displayed here -->
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 my-auto">
                    <button id="submitbtn" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let files = [];

    function selectImages() {
        document.getElementById('images').click();
    }

    document.getElementById('images').addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
        const selectedImagesContainer = document.querySelector('.selected-images');
        const errorMessage = document.getElementById('errorMessage');

        const newFiles = Array.from(event.target.files);

        if (files.length + newFiles.length > 5) {
            errorMessage.style.display = 'block';
            return;
        }

        files = files.concat(newFiles);

        updateSelectedImages();
        errorMessage.style.display = 'none';
    }

    function updateSelectedImages() {
        const selectedImagesContainer = document.querySelector('.selected-images');
        selectedImagesContainer.innerHTML = '';

        files.forEach((file, index) => {
            if (!file.type.startsWith('image/')) {
                return;
            }

            const imgContainer = document.createElement('div');
            imgContainer.classList.add('image-container');

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);

            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'X';
            removeBtn.classList.add('remove-btn');
            removeBtn.addEventListener('click', () => removeImage(index));

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeBtn);
            selectedImagesContainer.appendChild(imgContainer);
        });
    }

    function removeImage(index) {
        files.splice(index, 1);
        updateSelectedImages();
    }
</script>

<script>
    $(document).ready(function () {
        $('#category').change(function () {
            var categoryId = $(this).val();

            $.ajax({
                url: '{{ route('subcategories') }}',
                method: 'GET',
                data: {
                    category_id: categoryId
                },
                success: function (response) {
                    var subcategories = response.subcategories;
                    var options = '';

                    // Populate subcategory select options
                    $.each(subcategories, function (index, subcategory) {
                        options += '<option value="' + subcategory.subcat + '">' +
                            subcategory.subcat + '</option>';
                    });

                    console.log(response);

                    // Update subcategory select element
                    $('#subcategory').html(options);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    // Handle errors if needed
                }
            });
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#form_disable').on('submit', function (e) {
            e.preventDefault();
            $('#submitbtn').prop('disabled', true);

            $('#submitbtn').html('submiting...');

            this.submit();
        });
    });
</script>

</html>