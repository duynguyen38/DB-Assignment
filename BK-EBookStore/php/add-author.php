<?php
session_start();

# If the user is logged in
if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {

	# Database Connection File
	include "../db_conn.php";

	# author helper function
	include "func-author.php";
	$authors = get_all_authors($conn);

	/** check if author name is submitted **/
	if (isset($_POST['author_name'])) {
		/** Get data from POST request and store it in var **/
		$name = $_POST['author_name'];

		#simple form Validation
		if (empty($name)) {
			$em = "The author name is required";
			header("Location: ../add-author.php?error=$em");
			exit;
		} else {

			$flag = false;
			foreach ($authors as $author) {
				if ($name == $author['name']) {
					$flag = true;
				}
			}

			if (!$flag) {
				# Insert Into Database
				$sql  = "INSERT INTO authors (name, user_id)
			     		 VALUES (?,?)";
				$stmt = $conn->prepare($sql);
				$res  = $stmt->execute([$name, $_SESSION['user_id']]);

				/**If there is no error while inserting the data**/
				if ($res) {
					# success message
					$sm = "Successfully created!";
					header("Location: ../add-author.php?success=$sm");
					exit;
				} else {
					# Error message
					$em = "Unknown Error Occurred!";
					header("Location: ../add-author.php?error=$em");
					exit;
				}
			} else {
				# Error message
				$em = "Author is already exist!!!";
				header("Location: ../add-author.php?error=$em");
				exit;
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
