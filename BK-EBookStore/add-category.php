<?php
session_start();

# If the user is logged in
if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Add Category</title>

		<!-- bootstrap 5 CDN-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

		<!-- bootstrap 5 Js bundle CDN-->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="container ">

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
								<a class="nav-link active" href="add-category.php">Add Category</a>
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


			<form action="php/add-category.php" method="post" class="shadow p-4 rounded mx-auto" style="width: 90%; max-width: 50rem;">

				<h1 class="text-center pb-5 display-4 fs-3">
					Add New Category
				</h1>
				<?php if (isset($_GET['error'])) { ?>
					<div class="alert alert-danger" role="alert">
						<?= htmlspecialchars($_GET['error']); ?>
					</div>
				<?php } ?>
				<?php if (isset($_GET['success'])) { ?>
					<div class="alert alert-success" role="alert">
						<?= htmlspecialchars($_GET['success']); ?>
					</div>
				<?php } ?>
				<div class="mb-3">
					<label class="form-label">
						Category Name
					</label>
					<input type="text" class="form-control" name="category_name">
				</div>

				<button type="submit" class="btn btn-primary">
					Add Category</button>
			</form>
		</div>
	</body>

	</html>

<?php } else {
	header("Location: login.php");
	exit;
} ?>