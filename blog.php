<?php
session_start();
include 'db.php';

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count posts
$countSql = "SELECT COUNT(*) AS total FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
$countResult = mysqli_query($conn, $countSql);
$totalPosts = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalPosts / $limit);

// Fetch posts
$sql = "SELECT * FROM posts 
        WHERE title LIKE '%$search%' OR content LIKE '%$search%' 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BlogVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            background-color: rgb(202, 222, 254);
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }
        .blog-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .blog-img {
            height: 200px;
            object-fit: cover;
        }
        .blog-title {
            font-weight: 600;
            color: #343a40;
        }
        .blog-text {
            color: #555;
        }
        .blog-btn {
            background-color: #6c63ff;
            color: #fff;
        }
        .blog-btn:hover {
            background-color: #5848e5;
        }
    </style>
</head>
<body>
<div class="container py-4">

    <!-- Top Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">BlogVerse</h2>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="btn btn-primary me-2" href="create_post.php">Create Post</a>
                <a class="btn btn-outline-danger" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="btn btn-success me-2" href="login.php">Login</a>
                <a class="btn btn-warning" href="register.php">Register</a>
            <?php endif; ?>
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
  <a href="admin.php" class="btn btn-dark me-2">Admin Panel</a>
<?php endif; ?>

        </div>
    </div>
    

    <!-- Search Form -->
    <form method="GET" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by title or content..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary ">Search</button>
    </form>

    <!-- Post Cards -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row g-4">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card blog-card">
                            <img src="https://source.unsplash.com/600x400/?blog,post,<?= rand(1,100) ?>" class="card-img-top blog-img" alt="Post Image">
                            <div class="card-body">
                                <h5 class="card-title blog-title"><?= htmlspecialchars($row['title']) ?></h5>
                                <p class="card-text blog-text"><?= substr(strip_tags($row['content']), 0, 150) ?>...</p>
                                <a href="view_post.php?id=<?= $row['id'] ?>" class="btn blog-btn btn-sm">Read More</a>
                                <?php if ($_SESSION['user_role'] === 'admin'||$_SESSION['user_role'] === 'editor'): ?>
                                <a href="edit_post.php?id=<?= $row['id'] ?>" class="btn btn-outline-info btn-sm ms-2">Edit</a>
                                <a href="delete_post.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm ms-2">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php else: ?>
            <div class="alert alert-warning">No posts found for "<?= htmlspecialchars($search) ?>".</div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">Please login to view posts.</div>
    <?php endif; ?>
</div>
</body>
</html>
