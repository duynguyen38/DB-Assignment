<?php
session_start();

# If the user is logged in
if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {

	# Database Connection File
	include "../db_conn.php";

	# Book helper function
	include "func-book.php";
	$books = get_all_books($conn);

	# Category helper function
	include "func-category.php";
	$categories = get_all_categories($conn);

	# author helper function
	include "func-author.php";
	$authors = get_all_authors($conn);

	# Validation helper function
	include "func-validation.php";

	# File Upload helper function
	include "func-file-upload.php";


	/** If all Input field are filled
	 **/
	if (
		isset($_POST['book_title'])       &&
		isset($_POST['book_description']) &&
		isset($_POST['book_author'])      &&
		isset($_POST['book_category'])    &&
		isset($_FILES['book_cover'])      &&
		isset($_FILES['file'])
	) {

		/** Get data from POST request and store them in var**/
		$title       = $_POST['book_title'];
		$description = $_POST['book_description'];
		$author_id    = $_POST['book_author'];
		$category_id   = $_POST['book_category'];
		$user_id     	 = $_SESSION['user_id'];

		# making URL data format
		$user_input = 'title=' . $title . '&category_id=' . $category_id . '&desc=' . $description . '&author_id=' . $author_id;

		#simple form Validation

		$text = "Book title";
		$location = "../add-book.php";
		$ms = "error";
		is_empty($title, $text, $location, $ms, $user_input);

		$text = "Book description";
		$location = "../add-book.php";
		$ms = "error";
		is_empty($description, $text, $location, $ms, $user_input);

		$text = "Book author";
		$location = "../add-book.php";
		$ms = "error";
		is_empty($author_id, $text, $location, $ms, $user_input);

		$text = "Book category";
		$location = "../add-book.php";
		$ms = "error";
		is_empty($category_id, $text, $location, $ms, $user_input);

		# book cover Uploading
		$allowed_image_exs = array("jpg", "jpeg", "png");
		$path = "cover";
		$book_cover = upload_file($_FILES['book_cover'], $allowed_image_exs, $path);

		/**If error occurred while uploading the book cover**/
		if ($book_cover['status'] == "error") {
			$em = $book_cover['data'];

			/**Redirect to '../add-book.php' and passing error message & user_input
			 **/
			header("Location: ../add-book.php?error=$em&$user_input");
			exit;
		} else {
			# file Uploading
			$allowed_file_exs = array("pdf", "docx", "pptx");
			$path = "files";
			$file = upload_file($_FILES['file'], $allowed_file_exs, $path);

			/**If error occurred whileuploading the file
			 **/
			if ($file['status'] == "error") {
				$em = $file['data'];

				/**Redirect to '../add-book.php' and passing error message & user_input**/
				header("Location: ../add-book.php?error=$em&$user_input");
				exit;
			} else {

				$flag = false;
				if ($books != 0) {
					foreach ($books as $book) {
						if ($text == $book['title']) {
							$flag = true;
						}
					}
				}


				if (!$flag) {
					/**Getting the new file name and book cover name **/
					$file_URL = $file['data'];
					$book_cover_URL = $book_cover['data'];

					# Insert the data into database
					$sql  = "INSERT INTO books (title,
												description,
												cover,
												file,
												author_id,
												category_id,
												user_id)
							 VALUES (?,?,?,?,?,?,?)";
					$stmt = $conn->prepare($sql);
					$res  = $stmt->execute([$title, $description, $book_cover_URL, $file_URL, $author_id, $category_id, $user_id]);

					/**If there is no error while inserting the data**/
					if ($res) {
						# success message
						$sm = "The book successfully created!";
						header("Location: ../add-book.php?success=$sm");
						exit;
					} else {
						# Error message
						$em = "Unknown Error Occurred!";
						header("Location: ../add-book.php?error=$em");
						exit;
					}
				} else {
					# Error message
					$em = "Book Title already in use!! Please choose another title";
					header("Location: ../add-book.php?error=$em");
					exit;
				}
			}
		}
	} else {
		header("Location: ../user.php");
		exit;
	}
} else {
	header("Location: ../login.php");
	exit;
}
