<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Optional: prevent assigning admin via registration
    if ($role === 'admin') {
        $role = 'user';
    }

    // Validate length
    if (strlen($username) < 3 || strlen($password) < 8) {
        $error = "Username must be at least 3 characters and password at least 8 characters.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare insert query
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashedPassword, $role);

        if ($stmt->execute()) {
            $success = "Registered successfully as $role!";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
  <h2 class="mb-4 text-center">Create Account</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required pattern="^[a-zA-Z0-9_]{3,15}$">
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required minlength="8">
    </div>

    <div class="mb-3">
      <label class="form-label">Select Role</label>
      <select name="role" class="form-select" required>
        <option value="user" selected>User</option>
        <option value="editor">Editor</option>
      </select>
    </div>

    <button type="submit" name="register" class="btn btn-primary w-100">Register
   
    </button>
  </form>

  <div class="text-center mt-3">
    Already have an account? <a href="login.php">Login</a>
  </div>
</div>

</body>
</html>
