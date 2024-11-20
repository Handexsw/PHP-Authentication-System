<?php

require_once 'db.php';
include 'logged.php'; // This line makes it impossible to log in to the account page.
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(32));

    if ($user) {
        $message = "A user with this name already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, token) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $token);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            setcookie('token', $token, time() + (86400 * 30), '/');
            header("Location: /dashboard.php"); // Menu that can only be accessed in your account
            exit();
        } else {
            $message = "Registration error";
        }
    }

    $stmt->close();
}

?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #121212;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            overflow: hidden;
            padding: 1rem;
        }

        .background-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10rem;
            color: rgba(255, 255, 255, 0.05);
            white-space: nowrap;
            z-index: 0;
        }

        .login-container {
            background-color: #1e1e1e;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 100%;
            max-width: 400px;
            z-index: 1;
            position: relative;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .group {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 1rem;
        }

        .group input {
            width: 100%;
            padding-left: 45px;
            background-color: #2c2c2c;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 0.75rem;
            padding-left: 45px;
        }

        .group input::placeholder {
            color: #9e9e9e;
        }

        .group .icon {
            position: absolute;
            left: 0.75rem;
            fill: none;
            width: 1.5rem;
            height: 1.5rem;
            color: #ffffff;
            top: 50%;
            transform: translateY(-50%);
        }

        button {
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            background-color: #ff3b3b;
            color: #ffffff;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff1c1c;
        }

        .boton-elegante {
            padding: 15px 30px;
            border: 2px solid #2c2c2c;
            background-color: #1a1a1a;
            color: #ffffff;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 30px;
            transition: all 0.4s ease;
            outline: none;
            position: relative;
            overflow: hidden;
            font-weight: bold;
        }

        .boton-elegante::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle,
                    rgba(255, 255, 255, 0.25) 0%,
                    rgba(255, 255, 255, 0) 70%);
            transform: scale(0);
            transition: transform 0.5s ease;
        }

        .boton-elegante:hover::after {
            transform: scale(4);
        }

        .boton-elegante:hover {
            border-color: #666666;
            background: #292929;
        }

        @media (max-width: 768px) {

            .login-container {
                width: 90%;
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="background-text">Example</div>
    <div class="login-container">
        <form action="" method="post">
            <?php if (!empty($message)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="group">
                <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    class="icon">
                    <path
                        d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zm0 1.5c-3.315 0-6 2.685-6 6H18c0-3.315-2.685-6-6-6z"
                        stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <input type="text" id="username" name="username" placeholder="username" required>
            </div>

            <div class="group">
                <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    class="icon">
                    <path
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                        stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
                <input type="password" id="password" name="password" placeholder="password" required>
            </div>

            <button type="submit" class="boton-elegante">Register</button>
        </form>
        <p class="text-center mt-3">No account?<a href="login.php">Login</a>.</p>
    </div>
    </div>
    </div>
</body>

</html>