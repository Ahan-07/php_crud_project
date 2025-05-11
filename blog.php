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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body, html {
        background-color: rgb(245, 247, 255);
        font-family: 'Poppins', sans-serif;
    }
    .navbar {
        background-color: #6c63ff;
    }
    .navbar-brand {
        font-weight: 600;
        color: #fff !important;
    }
    .nav-link, .dropdown-item {
        color: #fff !important;
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

    /* Dark mode styles */
    body.dark-mode {
        background-color: #121212;
        color: #f0f0f0;
    }
    .dark-mode .navbar {
        background-color: #1f1f1f;
    }
    .dark-mode .navbar-brand,
    .dark-mode .nav-link {
        color: #ffffff !important;
    }
    .dark-mode .blog-card {
        background-color: #1f1f1f;
        color: #e0e0e0;
    }
    .dark-mode .blog-btn {
        background-color: #9f91ff;
    }
    .dark-mode .blog-btn:hover {
        background-color: #7d6ef5;
    }
    .dark-mode .form-control,
    .dark-mode .form-select {
        background-color: #2a2a2a;
        color: #f8f8f8;
        border-color: #444;
    }
    .dark-mode .blog-title ,.blog-text {
        color:rgb(232, 239, 247);}
    .dark-mode .pagination .page-link {
        background-color: #2a2a2a;
        color: #ddd;
        border-color: #444;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand" href="blog.php">BlogVerse</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="create_post.php">Create Post</a>
          </li>
          <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="admin.php">Admin Panel</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <button id="darkModeToggle" class="btn btn-sm btn-light ms-3">🌙 Dark Mode</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
  <form method="GET" class="input-group my-4">
    <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-primary" type="submit">Search</button>
  </form>

  <?php if (isset($_SESSION['user_id'])): ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
      <section class="mt-4">
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
      </section>

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

<script>
  const toggleBtn = document.getElementById('darkModeToggle');
  const body = document.body;

  if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    
    toggleBtn.textContent = '☀ Light Mode';
  }

  toggleBtn.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    const isDark = body.classList.contains('dark-mode');
    toggleBtn.textContent = isDark ? '☀ Light Mode' : '🌙 Dark Mode';
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
