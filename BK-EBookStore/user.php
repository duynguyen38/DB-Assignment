<?php
session_start();

# If the user is logged in
if (
	isset($_SESSION['user_id'])    &&
	isset($_SESSION['user_email'])
) {

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
		<title><?php
				if (isset($_SESSION['user_id'])) {
					echo $_SESSION['user_nickname'];
				}
				?>
		</title>

		<!-- bootstrap 5 CDN-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

		<!-- bootstrap 5 Js bundle CDN-->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

		<!-- Liên kết tới tệp CSS -->
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="container">

			<?php include 'navbar.php';

			?>


			<form action="search.php" method="get" style="width: 100%; max-width: 30rem">

				<div class="input-group my-5">
					<input type="text" class="form-control" name="key" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">

					<button class="input-group-text
		                 btn btn-primary" id="basic-addon2">
						<img src="img/search.png" width="20">

					</button>
				</div>
			</form>


			<?php if ($_SESSION['user_permission'] == 'admin') { ?>
				<!-- admin -->
				<?php if ($books == 0) { ?>
					<div class="alert alert-warning 
							text-center p-5" role="alert">
						<img src="img/empty.png" width="100">
						<br>
						There is no book in the database
					</div>
				<?php } else { ?>

					<!-- List of all books -->
					<h4>All Books</h4>
					<table class="table table-bordered shadow ">
						<thead>
							<tr>
								<th>No.</th>
								<th>Title</th>
								<th>Author</th>
								<th>Description</th>
								<th>Category</th>
								<th>Upload by</th>
								<th colspan="2">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach ($books as $book) {
								$i++;
							?>
								<tr>
									<!-- No. book -->
									<td><?= $i ?></td>

									<!-- Book's Cover -->
									<td>
										<img width="100" src="uploads/cover/<?= $book['cover'] ?>">
										<a class="link-dark d-block
								text-center" href="uploads/files/<?= $book['file'] ?>">
											<?= $book['title'] ?>
										</a>

									</td>

									<!-- Book's Author -->
									<td>
										<?php if ($authors == 0) {
											echo "Undefined";
										} else {

											foreach ($authors as $author) {
												if ($author['id'] == $book['author_id']) {
													echo $author['name'];
												}
											}
										}
										?>

									</td>

									<!-- Book Description -->
									<td><?= $book['description'] ?></td>
									<td>
										<?php if ($categories == 0) {
											echo "Undefined";
										} else {

											foreach ($categories as $category) {
												if ($category['id'] == $book['category_id']) {
													echo $category['name'];
												}
											}
										}
										?>
									</td>

									<td>
										<?php
										foreach ($users as $user) {
											if ($book['user_id'] == $user['id']) {
												echo $user['nickname'];
											}
										}
										?>
									</td>

									<!-- EDIT AND DELETE BUTTON -->
									<td>
										<a href="edit-book.php?id=<?= $book['id'] ?>" class="btn btn-warning" style="background-color:#fffdd9;">
											Edit</a>
										<a href="php/delete-book.php?id=<?= $book['id'] ?>" class="btn btn-danger" style="background-color:#fff0f0; color:black">
											Delete</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } ?>


				<?php if ($categories == 0) { ?>
					<div class="alert alert-warning 
							text-center p-5" role="alert">
						<img src="img/empty.png" width="100">
						<br>
						There is no category in the database
					</div>
				<?php } else { ?>
					<!-- List of all categories -->
					<h4 class="mt-5">All Categories</h4>
					<table class="table table-bordered shadow">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>Category Name</th>
								<th>Created By</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$j = 0;
							foreach ($categories as $category) {
								$j++;
							?>
								<tr>
									<td class="text-center"><?= $j ?></td>
									<td><?= $category['name'] ?></td>
									<td>
										<?php
										foreach ($users as $user) {
											if ($category['user_id'] == $user['id']) {
												echo $user['nickname'];
											}
										}
										?>
									</td>

									<td>
										<a href="edit-category.php?id=<?= $category['id'] ?>" class="btn btn-warning" style="background-color:#fffdd9;">
											Edit</a>
										<a href="php/delete-category.php?id=<?= $category['id'] ?>" class="btn btn-danger" style="background-color:#fff0f0; color:black">
											Delete</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } ?>


				<?php if ($authors == 0) { ?>
					<div class="alert alert-warning 
							text-center p-5" role="alert">
						<img src="img/empty.png" width="100">
						<br>
						There is no author in the database
					</div>
				<?php } else { ?>
					<!-- List of all Authors -->
					<h4 class="mt-5">All Authors</h4>
					<table class="table table-bordered shadow">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>Author Name</th>
								<th>Created By</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$k = 0;
							foreach ($authors as $author) {
								$k++;
							?>
								<tr>
									<td class="text-center"><?= $k ?></td>
									<td><?= $author['name'] ?></td>

									<td>
										<?php
										foreach ($users as $user) {
											if ($author['user_id'] == $user['id']) {
												echo $user['nickname'];
											}
										}
										?>
									</td>

									<td>
										<a href="edit-author.php?id=<?= $author['id'] ?>" class="btn btn-warning" style="background-color:#fffdd9;">
											Edit</a>
										<a href="php/delete-author.php?id=<?= $author['id'] ?>" class="btn btn-danger" style="background-color:#fff0f0; color:black">
											Delete</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } ?>


			<?php } elseif ($_SESSION['user_permission'] == 'user') { ?>
				<!-- user -->
				<?php if ($books == 0) { ?>
					<div class="alert alert-warning 
							text-center p-5" role="alert">
						<img src="img/empty.png" width="100">
						<br>
						You have not uploaded any books
					</div>
				<?php } else { ?>

					<!-- List of all books -->
					<h4>Your Books</h4>
					<table class="table table-bordered shadow ">
						<thead>
							<tr>
								<th>No.</th>
								<th>Title</th>
								<th>Author</th>
								<th>Description</th>
								<th>Category</th>
								<th>Upload by</th>
								<th colspan="2">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							foreach ($books as $book) {

								if ($book['user_id'] == $_SESSION['user_id']) {
									$i++;
							?>
									<tr>
										<!-- No. book -->
										<td><?= $i ?></td>

										<!-- Book's Cover -->
										<td>
											<img width="100" src="uploads/cover/<?= $book['cover'] ?>">
											<a class="link-dark d-block
								text-center" href="uploads/files/<?= $book['file'] ?>">
												<?= $book['title'] ?>
											</a>

										</td>

										<!-- Book's Author -->
										<td>
											<?php if ($authors == 0) {
												echo "Undefined";
											} else {

												foreach ($authors as $author) {
													if ($author['id'] == $book['author_id']) {
														echo $author['name'];
													}
												}
											}
											?>

										</td>

										<!-- Book Description -->
										<td><?= $book['description'] ?></td>
										<td>
											<?php if ($categories == 0) {
												echo "Undefined";
											} else {

												foreach ($categories as $category) {
													if ($category['id'] == $book['category_id']) {
														echo $category['name'];
													}
												}
											}
											?>
										</td>

										<td>
											<?php
											foreach ($users as $user) {
												if ($book['user_id'] == $user['id']) {
													echo $user['nickname'];
												}
											}
											?>
										</td>

										<!-- EDIT AND DELETE BUTTON -->
										<td>
											<a href="edit-book.php?id=<?= $book['id'] ?>" class="btn btn-warning" style="background-color:#fffdd9;">
												Edit</a>
											<a href="php/delete-book.php?id=<?= $book['id'] ?>" class="btn btn-danger" style="background-color:#fff0f0; color:black">
												Delete</a>
										</td>
									</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				<?php } ?>


				<?php if ($categories == 0) { ?>
					<div class="alert alert-warning 
							text-center p-5" role="alert">
						<img src="img/empty.png" width="100">
						<br>
						There is no category in the database
					</div>
				<?php } else { ?>
					<!-- List of all categories -->
					<h4 class="mt-5">All Categories You Created</h4>
					<table class="table table-bordered shadow">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>Category Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$j = 0;
							foreach ($categories as $category) {
								if ($category['user_id'] == $_SESSION['user_id']) {
									$j++;
							?>
									<tr>
										<td class="text-center"><?= $j ?></td>
										<td><?= $category['name'] ?></td>
										<td>
											<a href="edit-category.php?id=<?= $category['id'] ?>" class="btn btn-warning" style="background-color:#fffdd9;">
												Edit</a>
											<a href="php/delete-category.php?id=<?= $category['id'] ?>" class="btn btn-danger" style="background-color:#fff0f0; color:black">
												Delete</a>
										</td>
									</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				<?php } ?>


				<?php if ($authors == 0) { ?>
					<div class="alert alert-warning 
							text-center p-5" role="alert">
						<img src="img/empty.png" width="100">
						<br>
						There is no author in the database
					</div>
				<?php } else { ?>
					<!-- List of all Authors -->
					<h4 class="mt-5">All Authors You Created</h4>
					<table class="table table-bordered shadow">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>Author Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$k = 0;
							foreach ($authors as $author) {
								if ($author['user_id'] == $_SESSION['user_id']) {
									$k++;
							?>
									<tr>
										<td class="text-center"><?= $k ?></td>
										<td><?= $author['name'] ?></td>
										<td>
											<a href="edit-author.php?id=<?= $author['id'] ?>" class="btn btn-warning" style="background-color:#fffdd9;">
												Edit</a>
											<a href="php/delete-author.php?id=<?= $author['id'] ?>" class="btn btn-danger" style="background-color:#fff0f0; color:black">
												Delete</a>
										</td>
									</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				<?php } ?>


			<?php } else { ?>
				<!-- Người dùng không có quyền -->
				<div class="alert alert-danger text-center p-5" role="alert">
					<strong>Access Denied!</strong> You do not have permission to access this page.
				</div>
			<?php } ?>
		</div>






	</body>

	</html>


<?php } else {
	header("Location: login.php");
	exit;
} ?>