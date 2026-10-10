<?php
session_start();

$errors = [];
$loginMessage = "";
$email = "";
$maxAttempts = 3;

if (!isset($_SESSION["failed_attempts"])) {
    $_SESSION["failed_attempts"] = 0;
}

if (
    $_SERVER["REQUEST_METHOD"] === "GET" &&
    $_SESSION["failed_attempts"] >= $maxAttempts
) {
    $_SESSION["failed_attempts"] = 0;
}

$failedAttempts = $_SESSION["failed_attempts"];
$loginDisabled = $failedAttempts >= $maxAttempts;

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$loginDisabled) {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "") {
        $errors["email"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Incorrect Email format.";
    }

    if ($password === "") {
        $errors["password"] = "Password is required.";
    } elseif (!preg_match('/\A.{8,}\z/s', $password)) {
        $errors["password"] = "Password must be at least 8 characters.";
    }

    if (empty($errors)) {

        $correctEmail = "admin@gmail.com";
        $correctPassword = "admin12345";

        if (
            $email === $correctEmail &&
            $password === $correctPassword
        ) {
            $_SESSION["failed_attempts"] = 0;

            header("Location: index.php");
            exit;
        }

        $_SESSION["failed_attempts"]++;

        $failedAttempts = $_SESSION["failed_attempts"];
        $remainingAttempts = $maxAttempts - $failedAttempts;

        $email = "";

        if ($failedAttempts >= $maxAttempts) {
            $loginDisabled = true;
            $loginMessage = "Wrong Credentials. No attempts remaining.";
        } else {
            $loginMessage = "Wrong Credentials. Attempts remaining: "
                . $remainingAttempts;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="templates/style.css">
</head>

<body class="login-page">

    <main>
        <div class="login-container">

            <h1>Login</h1>

            <form
                id="login-js"
                class="login-form"
                method="POST"
                action="login.php">

                <div class="input-container">

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Email"
                        autocomplete="username"
                        value="<?= htmlspecialchars(
                            $email,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-envelope-fill input-icon"
                        viewBox="0 0 16 16">

                        <path
                            d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414z"/>

                        <path
                            d="M0 4.697v7.104l5.803-3.558z"/>

                        <path
                            d="M6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586z"/>

                        <path
                            d="m9.197 8.244 6.753-4.697v7.104z"/>

                    </svg>

                    <?php if (isset($errors["email"])): ?>
                        <label class="error">
                            <?= htmlspecialchars(
                                $errors["email"],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </label>
                    <?php endif; ?>

                </div>

                <div class="input-container">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password"
                        autocomplete="current-password">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-lock-fill input-icon"
                        viewBox="0 0 16 16">

                        <path
                            fill-rule="evenodd"
                            d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>

                    </svg>

                    <?php if (isset($errors["password"])): ?>
                        <label class="error">
                            <?= htmlspecialchars(
                                $errors["password"],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </label>
                    <?php endif; ?>

                </div>

                <div class="options">

                    <label>
                        <input
                            type="checkbox"
                            name="remember"
                            value="1">

                        <h5>Remember me</h5>
                    </label>

                    <a href="#">
                        <b>Forgot password?</b>
                    </a>

                </div>

                <button
                    type="submit"
                    id="loginButton"
                    <?= $loginDisabled ? "disabled" : "" ?>>

                    <?= $loginDisabled
                        ? "Login Disabled"
                        : "Login" ?>

                </button>

                <p
                    id="loginMessage"
                    aria-live="polite"
                    <?= $loginMessage !== ""
                        ? 'style="color: #ff4d4d;"'
                        : '' ?>>

                    <?= htmlspecialchars(
                        $loginMessage,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </p>

                <div class="register-link">

                    Don't have an account?

                    <a href="register.php">
                        Register
                    </a>

                </div>

            </form>

        </div>
    </main>

</body>
</html>