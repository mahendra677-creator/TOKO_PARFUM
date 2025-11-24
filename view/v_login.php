<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            font-size: 24px;
            color: #333;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .input-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        /* ICON MATA */
 .password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #777;
    font-size: 18px;
    user-select: none;
}


        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .text-center a {
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .text-center a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <form action="../controller/c_login.php" method="POST">
            <div class="input-group">
                <label for="username">Username atau Email</label>
                <input type="text" id="username" name="nama" placeholder="Masukkan username atau email Anda" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                <span class="password-toggle" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="text-center">
            <a href="#">Lupa password?</a>
            <p class="mt-2">Belum punya akun? <a href="v_tambah_data_pelanggan.php">Daftar di sini</a></p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            input.type = (input.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>
