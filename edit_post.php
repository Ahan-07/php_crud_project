<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$post = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: blog.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .form-card {
            max-width: 700px;
            margin: auto;
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-custom {
            background-color: #6c63ff;
            color: #fff;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #5848e5;
        }
    </style>
</head>
<body class="py-5">

    <div class="form-card">
        <h3 class="text-center mb-4 text-primary">✏️ Edit Post</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Post Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Post Content</label>
                <textarea name="content" class="form-control" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-custom w-100">💾 Update Post</button>
        </form>

        <div class="text-center mt-3">
            <a href="blog.php" class="text-decoration-none text-secondary">← Back to Blog</a>
        </div>
    </div>

</body>
</html>
