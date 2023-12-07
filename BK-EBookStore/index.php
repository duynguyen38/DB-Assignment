<?php
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_authors($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

include "php/func-user.php";
$users = get_all_users($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Book Store</title>

	<!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

	<!-- bootstrap 5 Js bundle CDN-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light" style="border-radius: 5px;">
			<div class="container">
				<img src="img/hcmut.png" width="50">
				<a class="navbar-brand ms-2 fs-3 font-monospace fw-bold" href="index.php">BK-EBookStore</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item">
							<a class="nav-link active" href="index.php">BK-STORE</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Contact</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">About</a>
						</li>
						<li class="nav-item">
							<?php if (isset($_SESSION['user_id'])) { ?>
								<a class="nav-link" href="user.php"><?php echo $_SESSION['user_nickname'] ?></a>
							<?php } else { ?>
								<a class="nav-link" href="login.php">Login</a>
							<?php } ?>
						</li>
					</ul>
				</div>
			</div>
		</nav>


		<form action="search.php" method="get" style="width: 100%; max-width: 30rem">

			<div class="input-group my-5">
				<input type="text" class="form-control" name="key" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">

				<button class="input-group-text
		                 btn btn-primary" id="basic-addon2">
					<img src="img/search.png" width="20">

				</button>
			</div>
		</form>
		<div class="d-flex pt-3">
			<?php if ($books == 0) { ?>
				<div class="alert alert-warning 
        	            text-center p-5" role="alert">
					<img src="img/empty.png" width="100">
					<br>
					There is no book in the database
				</div>
			<?php } else { ?>
				<div class="pdf-list d-flex flex-wrap">
					<?php foreach ($books as $book) { ?>
						<div class="card m-1">
							<img src="uploads/cover/<?= $book['cover'] ?>" class="card-img-top">
							<div class="card-body">
								<h5 class="card-title">
									<?= $book['title'] ?>
								</h5>
								<p class="card-text">
									<i><b>By:
											<?php foreach ($authors as $author) {
												if ($author['id'] == $book['author_id']) {
													echo $author['name'];
													break;
												}
											?>

											<?php } ?>
											<br></b></i>
									<?= $book['description'] ?>
									<br><i><b>Category:
											<?php foreach ($categories as $category) {
												if ($category['id'] == $book['category_id']) {
													echo $category['name'];
													break;
												}
											?>

											<?php } ?>
											<br></b></i>
									<i><b>Upload By:
											<?php foreach ($users as $user) {
												if ($book['user_id'] == $user['id']) {
													echo $user['nickname'];
													break;
												}
											?>

											<?php } ?>
											<br></b></i>
								</p>
								<a href="uploads/files/<?= $book['file'] ?>" class="btn btn-success">Open</a>

								<a href="uploads/files/<?= $book['file'] ?>" class="btn btn-primary" download="<?= $book['title'] ?>">Download</a>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="category">
				<!-- List of categories -->
				<div class="list-group">
					<?php if ($categories == 0) {
						// do nothing
					} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Category</a>
						<?php foreach ($categories as $category) { ?>

							<a href="category.php?id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
								<?= $category['name'] ?></a>
					<?php }
					} ?>
				</div>

				<!-- List of authors -->
				<div class="list-group mt-5">
					<?php if ($authors == 0) {
						// do nothing
					} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Author</a>
						<?php foreach ($authors as $author) { ?>

							<a href="author.php?id=<?= $author['id'] ?>" class="list-group-item list-group-item-action">
								<?= $author['name'] ?></a>
					<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
</body>

</html>