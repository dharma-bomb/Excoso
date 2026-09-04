<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link rel="stylesheet" href="{{ asset('css/prod.css') }}">
</head>

<style>
    .status-banner {
        max-width: 100%;
        margin: 0 auto 16px;
        background: #e7f6e9;
        border: 1px solid #b6e2bc;
        color: #1e6b2e;
        padding: 10px 16px;
        border-radius: 6px;
    }

    .action-cell {
        display: flex;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-edit,
    .btn-delete {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
        text-decoration: none;
        border: none;
        cursor: pointer;
        color: #fff;
    }

    .btn-edit {
        background-color: #3b82c4;
    }

    .btn-edit:hover {
        background-color: #2f6ba0;
        color: #fff;
    }

    .btn-delete {
        background-color: #d9453d;
    }

    .btn-delete:hover {
        background-color: #b7362f;
    }
</style>

<body>

    <div class="table-container">

        @if (session('status'))
            <div class="status-banner">{{ session('status') }}</div>
        @endif

        <table>

            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    @php $images = json_decode($product->images); @endphp
                    <tr>
                        <td>{{ $product->Productname }}</td>
                        <td>{{ $product->cat }}</td>
                        <td>{{ $product->subcat }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            @if (!empty($images))
                                <img src="{{ asset('images/addproduct/' . $images[0]) }}" alt="{{ $product->Productname }}" style="max-width: 50px; margin: 5px;">
                            @endif
                        </td>
                        <td>&#8377;{{ number_format($product->price) }}</td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('admin.editproduct', $product->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('admin.deleteproduct', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Delete &quot;{{ addslashes($product->Productname) }}&quot;? This cannot be undone.');">
                                    @csrf
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px;">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
