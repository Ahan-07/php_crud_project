<?php
session_start();
include 'db.php';
// Update role
if (isset($_POST['change_role'])) {
    $uid = intval($_POST['user_id']);
    $new_role = $_POST['new_role'];

    // Prevent changing your own role (optional)
    if ($_SESSION['user_id'] == $uid) {
        echo "<script>alert('You cannot change your own role.');</script>";
    } else {
        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $new_role, $uid);
        $stmt->execute();
        $stmt->close();
        echo "<script>location.reload();</script>"; // refresh to reflect change
    }
}

// Delete user
if (isset($_POST['delete_user'])) {
    $delete_id = intval($_POST['delete_id']);

    // Prevent deleting yourself
    if ($_SESSION['user_id'] == $delete_id) {
        echo "<script>alert('You cannot delete yourself.');</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        // echo "<script>location.reload();</script>";
    }
}


// Restrict access to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo "<div style='text-align:center; margin-top:50px;'><h3>Access Denied: Admins only.</h3></div>";
    exit;
}

// Fetch all users from database
$query = "SELECT id, username, role FROM users ORDER BY id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - BlogVerse</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-center">Admin Dashboard</h2>

  <div class="d-flex justify-content-between mb-4">
    <h5>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</h5>
    <a href="blog.php" class="btn btn-primary">← Back to Blog</a>
  </div>

  <div class="card">
    <div class="card-header bg-dark text-white">
      <h6 class="mb-0">Registered Users</h6>
    </div>
    <div class="card-body p-0">
      <table class="table table-striped table-hover m-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
  <?php if ($result->num_rows > 0): ?>
    <?php while ($user = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td>
          <form method="POST" class="d-flex gap-2 align-items-center">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
            <select name="new_role" class="form-select form-select-sm w-auto">
              <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
              <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
              <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" name="change_role" class="btn btn-sm btn-outline-primary">Update</button>
          </form>
        </td>
        <td>
          <?php if ($_SESSION['user_id'] != $user['id']): ?>
            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
              <input type="hidden" name="delete_id" value="<?= $user['id'] ?>">
              <button type="submit" name="delete_user" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          <?php else: ?>
            <em>Logged in user</em>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="4" class="text-center">No users found.</td></tr>
  <?php endif; ?>
</tbody>

      </table>
    </div>
  </div>
</div>

</body>
</html>
