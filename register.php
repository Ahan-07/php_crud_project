<?php
include 'db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Successfully Register</strong>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>" ;
            
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background:rgb(95, 93, 93);
    }
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .card-title {
      font-weight: 600;
      color: #333;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #6c63ff;
    }
    .btn-custom {
      background: #6c63ff;
      color: #fff;
      border-radius: 50px;
      transition: background 0.3s ease;
    }
    .btn-custom:hover {
      background: #5751d6;
    }
    .link-custom {
      color: #6c63ff;
      text-decoration: none;
    }
    .link-custom:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4" style="width: 360px;">
      <h3 class="card-title text-center mb-4">Create Account</h3>
      <form method="POST" id="registerForm">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3 position-relative">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required>
            <span class="input-group-text password-toggle" id="togglePassword"><i>
            <img src="eye-fill.svg" alt="" srcset="">
            </i></span>
          </div>
          <div class="strength-meter mt-2">
            <div class="strength-meter-fill" id="strengthMeterFill"></div>
          </div>
          <small id="strengthText" class="text-muted"></small>
        </div>
        <button type="submit" name="register" class="btn btn-custom w-100" id="submitBtn" disabled>Register</button>
      </form>
      <p class="text-center mt-3">Already have an account? <a href="login.php" class="link-custom">Sign In</a></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
  <script>
    const passwordInput = document.getElementById('password');
    const meterFill = document.getElementById('strengthMeterFill');
    const strengthText = document.getElementById('strengthText');
    const submitBtn = document.getElementById('submitBtn');
    const togglePassword = document.getElementById('togglePassword');

    function evaluatePassword(password) {
      let score = 0;
      if (password.length >= 8) score++;
      if (/[A-Z]/.test(password)) score++;
      if (/[a-z]/.test(password)) score++;
      if (/[0-9]/.test(password)) score++;
      if (/[^A-Za-z0-9]/.test(password)) score++;
      return score;
    }

    passwordInput.addEventListener('input', () => {
      const pwd = passwordInput.value;
      const score = evaluatePassword(pwd);
      const percent = (score / 5) * 100;
      meterFill.style.width = percent + '%';
      if (score <= 2) {
        meterFill.style.background = 'red';
        strengthText.textContent = 'Weak';
        submitBtn.disabled = true;
      } else if (score === 3) {
        meterFill.style.background = 'orange';
        strengthText.textContent = 'Moderate';
        submitBtn.disabled = false;
      } else {
        meterFill.style.background = 'green';
        strengthText.textContent = 'Strong';
        submitBtn.disabled = false;
      }
    });

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
      togglePassword.innerHTML = type === 'password' ? '<i><img src="eye-fill.svg" alt="" srcset=""></i>' : '<i><img src="eye-slash-fill.svg" alt="" srcset=""></i>';
    });

    document.getElementById('registerForm').addEventListener('submit', e => {
      if (submitBtn.disabled) e.preventDefault();
    });
  </script>
</body>
</html>
