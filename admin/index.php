<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .alert {
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Login</h2>
        <div class="alert alert-danger" id="errorMessage"></div>
        <form id="loginForm">
            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" class="form-control" name="login" id="login" placeholder="Digite seu login" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="senha" id="password" placeholder="Digite sua senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: './admin/logar.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = './admin/home.php';
                        } else {
                            $('#errorMessage').text(response.message).show();
                        }
                    },
                    error: function() {
                        $('#errorMessage').text('Erro ao tentar se conectar ao servidor.').show();
                    }
                });
            });
        });
    </script>
</body>

</html>