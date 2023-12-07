<nav class="navbar navbar-expand-lg navbar-light" style="border-radius: 5px;">
  <div class="container">
    <img src="img/hcmut.png" width="50">
    <a class="navbar-brand ms-2 fs-3 font-monospace fw-bold" href="user.php"><?php echo $_SESSION['user_nickname'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">BK-STORE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-book.php">Add Book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-category.php">Add Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-author.php">Add Author</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
