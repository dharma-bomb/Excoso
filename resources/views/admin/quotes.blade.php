<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quote Requests</title>
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

    .mail-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: bold;
    }

    .mail-badge.sent {
        background: #e7f6e9;
        color: #1e6b2e;
    }

    .mail-badge.pending {
        background: #fdf1e3;
        color: #a15c00;
    }

    .btn-delete {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        color: #fff;
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
                    <th>Received</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Emailed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quotes as $quote)
                    <tr>
                        <td>{{ $quote->created_at->format('d M Y, g:ia') }}</td>
                        <td>{{ $quote->name }}</td>
                        <td>{{ $quote->company ?: '-' }}</td>
                        <td><a href="mailto:{{ $quote->email }}">{{ $quote->email }}</a></td>
                        <td>{{ $quote->phone }}</td>
                        <td>{{ $quote->location ?: '-' }}</td>
                        <td>{{ $quote->product ?: '-' }}</td>
                        <td>{{ $quote->quantity ?: '-' }}</td>
                        <td>
                            @if ($quote->emailed)
                                <span class="mail-badge sent">Sent</span>
                            @else
                                <span class="mail-badge pending">Not sent</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.quotes.delete', $quote->id) }}" method="POST"
                                onsubmit="return confirm('Remove this quote request? This cannot be undone.');">
                                @csrf
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding: 20px;">No quote requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
