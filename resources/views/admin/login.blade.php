<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GAD CatSU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h1 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            color: #666;
        }
        .form-group label {
            color: #333;
            font-weight: 600;
        }
        .button {
            width: 100%;
        }
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>GAD CatSU</h1>
            <p>Admin Portal</p>
        </div>

        @if ($errors->any())
            <div class="notification is-danger">
                <button class="delete"></button>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input @error('email') is-danger @enderror" type="email" name="email" placeholder="admin@example.com" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Password</label>
                <div class="control has-icons-left">
                    <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" placeholder="Enter password" required>
                    <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer;">
                        👁️
                    </button>
                </div>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <button type="submit" class="button is-info is-fullwidth">Login</button>
            </div>
        </form>

        <hr>
        <p style="text-align: center; color: #999; font-size: 0.9rem;">
            Admin credentials required to access this area.
        </p>
    </div>

    <script>
        document.querySelectorAll('.notification .delete').forEach(button => {
            button.addEventListener('click', () => {
                button.parentElement.style.display = 'none';
            });
        });
    </script>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Optional: toggle eye icon
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>
</html>
