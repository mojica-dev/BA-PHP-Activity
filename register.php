<?php
$errors = [];

$username = "";
$email = "";
$tel = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $tel = trim($_POST["tel"] ?? "");

    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm-password"] ?? "";


    if ($username === "") {
        $errors["username"] = "Username is required.";
    } elseif (!preg_match('/\A[A-Za-z0-9_ ]{7,20}\z/', $username)) {
        $errors["username"] =
            "Username must be 7-20 characters and contain only letters, numbers, spaces, or underscores.";
    }

    if ($email === "") {
        $errors["email"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address.";
    }

    if ($tel === "") {
        $errors["tel"] = "Phone number is required.";
    } elseif (!preg_match('/\A[0-9]{11}\z/', $tel)) {
        $errors["tel"] = "Phone number must contain exactly 11 digits.";
    }

    if ($password === "") {
        $errors["password"] = "Password is required.";
    } elseif (!preg_match('/\A.{8,}\z/s', $password)) {
        $errors["password"] = "Password must be at least 8 characters long.";
    }

    if ($confirmPassword === "") {
        $errors["confirm-password"] = "Please confirm your password.";
    } elseif ($password !== $confirmPassword) {
        $errors["confirm-password"] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $username = "";
        $email = "";
        $tel = "";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="templates/style.css">
</head>

<body class="register-page">

<main>
    <div class="register-container">

        <h1>Register</h1>

        <form class="register-form" method="POST" action="register.php">

            <div class="input-container">

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Username"
                    value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                >

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16"
                    fill="currentColor"
                    class="bi bi-person-circle input-icon"
                    viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>

                <?php if (isset($errors["username"])): ?>
                    <label class="error">
                        <?= htmlspecialchars($errors["username"], ENT_QUOTES, 'UTF-8') ?>
                    </label>
                <?php endif; ?>

            </div>

            <div class="input-container">

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Email"
                    value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                >

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16"
                    fill="currentColor"
                    class="bi bi-envelope-fill input-icon"
                    viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414z"/>
                    <path d="M0 4.697v7.104l5.803-3.558z"/>
                    <path d="M6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586z"/>
                    <path d="m9.197 8.244 6.753-4.697v7.104z"/>
                </svg>

                <?php if (isset($errors["email"])): ?>
                    <label class="error">
                        <?= htmlspecialchars($errors["email"], ENT_QUOTES, 'UTF-8') ?>
                    </label>
                <?php endif; ?>

            </div>

            <div class="input-container">

                <input
                    type="tel"
                    id="tel"
                    name="tel"
                    placeholder="Phone Number"
                    value="<?= htmlspecialchars($tel, ENT_QUOTES, 'UTF-8') ?>"
                >

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16"
                    fill="currentColor"
                    class="bi bi-telephone-fill input-icon"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                </svg>

                <?php if (isset($errors["tel"])): ?>
                    <label class="error">
                        <?= htmlspecialchars($errors["tel"], ENT_QUOTES, 'UTF-8') ?>
                    </label>
                <?php endif; ?>

            </div>

            <div class="input-container">

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                >

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16"
                    fill="currentColor"
                    class="bi bi-lock-fill input-icon"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 8 0v2h-2V4a2 2 0 0 0-4 0v2h4"/>
                </svg>

                <?php if (isset($errors["password"])): ?>
                    <label class="error">
                        <?= htmlspecialchars($errors["password"], ENT_QUOTES, 'UTF-8') ?>
                    </label>
                <?php endif; ?>

            </div>

            <div class="input-container">

                <input
                    type="password"
                    id="confirm-password"
                    name="confirm-password"
                    placeholder="Confirm Password"
                >

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16"
                    fill="currentColor"
                    class="bi bi-shield-fill-check input-icon"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793z"/>
                </svg>

                <?php if (isset($errors["confirm-password"])): ?>
                    <label class="error">
                        <?= htmlspecialchars($errors["confirm-password"], ENT_QUOTES, 'UTF-8') ?>
                    </label>
                <?php endif; ?>

            </div>

            <button type="submit">Register</button>

            <div class="login-link">
                Already have an account?
                <a href="login.php">Login</a>
            </div>

        </form>
    </div>
</main>

</body>
</html>