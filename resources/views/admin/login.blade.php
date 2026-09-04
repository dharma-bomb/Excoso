<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>

            @if (session('status'))
                <p style="color:#2f6ba0;">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <p style="color:#d9453d;">{{ $errors->first() }}</p>
            @endif

            <form action="{{ url('adminlog') }}" method="POST">
                @csrf


                <div class="input-group">
                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <div class="input-button">
                    <button type="submit">Login</button>
                </div>
            </form>
            <div class="register-text">
                <?php $adminId = session('admin_id');
                    echo $adminId;
                ?>
                <a href="{{ route('admin.register') }}">Register</a>
            </div>
        </div>
    </div>
</body>

</html>
