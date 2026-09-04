<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register Page</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    </head>
    <body>
        <div class="register-container">
            <div class="register-form">
                <h2>Register</h2>
                <form action="{{ url('adminreg') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="input-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="input-button">
                        <button type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
