<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
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

    .existing-images {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin: 10px 0 20px;
    }

    .existing-image {
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px;
        width: 110px;
    }

    .existing-image img {
        max-width: 90px;
        max-height: 90px;
        object-fit: cover;
        display: block;
        margin: 0 auto 6px;
    }

    .existing-image label {
        font-size: 12px;
        font-weight: normal;
        color: #b00020;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        margin: 0;
    }

    .form-error {
        color: #b00020;
        background: #ffecec;
        border: 1px solid #f5b5b5;
        padding: 10px 14px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
</style>

<body>

    <div class="container" style="max-width: 700px;">
        <h4 class="mb-3">Edit Product &mdash; {{ $product->Productname }}</h4>

        @if ($errors->any())
            <div class="form-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form id="form_disable" action="{{ route('admin.updateproduct', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Productname" class="mb-1">Product Name</label>
                    <input type="text" id="Productname" name="Productname" class="form-control"
                        value="{{ old('Productname', $product->Productname) }}" required>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Description" class="mb-1">Description</label>
                    <textarea rows="1" id="Description" name="Description" class="form-control" required>{{ old('Description', $product->description) }}</textarea>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="category" class="mb-1">Category</label>
                    <select id="category" class="categories form-select" name="category" required>
                        <option value="" disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->cat }}" @selected($category->cat === $product->cat)>{{ $category->cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="subcategory" class="mb-1">Subcategory</label>
                    <select id="subcategory" class="subcategories form-select" name="subcat" required>
                        <option value="" disabled>Select SubCategory</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->subcat }}" @selected($subcategory->subcat === $product->subcat)>{{ $subcategory->subcat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Price" class="mb-1">Price</label>
                    <input type="number" id="Price" name="Price" class="form-control"
                        value="{{ old('Price', $product->price) }}" required>
                </div>

                <div class="col-sm-12 mb-3">
                    <label class="mb-1">Current Images</label>
                    <div class="existing-images">
                        @php $currentImages = json_decode($product->images) ?: []; @endphp
                        @foreach ($currentImages as $image)
                            <div class="existing-image">
                                <img src="{{ asset('images/addproduct/' . $image) }}" alt="{{ $product->Productname }}">
                                <label>
                                    <input type="checkbox" name="remove_images[]" value="{{ $image }}">
                                    Remove
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small style="color:#666;">Check "Remove" on any photo you want to drop. At least one image must remain.</small>
                </div>

                <div class="col-sm-12 col-md-4 mb-3">
                    <label for="Images" class="mb-1">Add More Images</label>
                    <input type="file" id="images" name="images[]" class="form-control" multiple style="display:none;"
                        accept="image/*">
                    <div id="uploadButton" onclick="selectImages()" class="h-auto w-100">
                        <i class="fa-solid fa-upload"></i> &nbsp;| &nbsp;Click to upload new images
                    </div>
                    <small id="errorMessage" class="error-message">User can only upload up to 5 images.</small>
                    <div class="selected-images">
                        <!-- Newly picked images will preview here -->
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 my-auto">
                    <button id="submitbtn" type="submit">Save Changes</button>
                    <a href="{{ route('admin.listproduct') }}" class="btn btn-secondary ms-2">Cancel</a>
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
    // Re-populate the subcategory dropdown when the category changes,
    // same as the Add Product form — the currently selected subcategory
    // (loaded server-side above) is kept as long as the category is unchanged.
    $(document).ready(function () {
        $('#category').change(function () {
            var categoryId = $(this).val();

            $.ajax({
                url: '{{ route('subcategories') }}',
                method: 'GET',
                data: { category_id: categoryId },
                success: function (response) {
                    var subcategories = response.subcategories;
                    var options = '';
                    $.each(subcategories, function (index, subcategory) {
                        options += '<option value="' + subcategory.subcat + '">' +
                            subcategory.subcat + '</option>';
                    });
                    $('#subcategory').html(options);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#form_disable').on('submit', function (e) {
            e.preventDefault();
            $('#submitbtn').prop('disabled', true).text('Saving...');
            this.submit();
        });
    });
</script>

</html>
