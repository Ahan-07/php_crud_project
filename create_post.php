<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imageName = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $targetPath = "uploads/" . $imageName;

        // Create uploads folder if it doesn't exist
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }

        move_uploaded_file($imageTmp, $targetPath);
    }

    // Insert post with image name (or NULL)
    $stmt = $conn->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $imageName);
    $stmt->execute();

    header('Location: blog.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(98, 99, 100);
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
    <h3 class="text-center mb-4 text-primary">📝 Create New Post</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Post Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter title..." required>
        </div>

        <div class="mb-3">
            <label class="form-label">Post Content</label>
            <textarea name="content" class="form-control" rows="8" placeholder="Write your content here..." required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Image</label>
            <input type="file" name="image" accept="image/*" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-custom w-100">📢 Publish Post</button>
    </form>

    <div class="text-center mt-3">
        <a href="blog.php" class="text-decoration-none text-secondary">← Back to Blog</a>
    </div>
</div>

</body>
</html>
