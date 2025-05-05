<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        header('Location: blog.php');
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .password-toggle {
      cursor: pointer;
    }
  </style>
</head>
<body class="bg-dark">
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 350px;">
      <div class="card-body">
        <h3 class="card-title text-center mb-4">Sign In</h3>

        <?php if (isset($error)) : ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" autocomplete="username" required autofocus>
          </div>

          <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
              <span class="input-group-text password-toggle" id="togglePassword">
                <i><img src="eye-fill.svg" alt="Show/Hide" /></i>
              </span>
            </div>
          </div>

          <button type="submit" name="login" class="btn btn-primary w-100" id="submitBtn">Login</button>
        </form>

        <div class="text-center mt-3">
          <a href="#">Forgot Password?</a> | <a href="register.php">Sign Up</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      togglePassword.innerHTML = type === 'password'
        ? '<i><img src="eye-fill.svg" alt="Show/Hide" /></i>'
        : '<i><img src="eye-slash-fill.svg" alt="Show/Hide" /></i>';
    });
  </script>
</body>
</html>
