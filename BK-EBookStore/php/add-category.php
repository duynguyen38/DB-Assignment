<?php
session_start();

# If the user is logged in
if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {

	# Database Connection File
	include "../db_conn.php";

	# Category helper function
	include "func-category.php";
	$categories = get_all_categories($conn);


	if (isset($_POST['category_name'])) {

		$name = $_POST['category_name'];

		#simple form Validation
		if (empty($name)) {
			$em = "The category name is required";
			header("Location: ../add-category.php?error=$em");
			exit;
		} else {
			# check duplicate category
			$flag = false;
			foreach ($categories as $category) {
				if ($name == $category['name']) {
					$flag = true;
				}
			}

			if (!$flag) {
				# Insert Into Database
				$sql  = "INSERT INTO categories (name, user_id)
						 VALUES (?, ?)";
				$stmt = $conn->prepare($sql);
				$res  = $stmt->execute([$name, $_SESSION['user_id']]);

				/**If there is no error while  inserting the data**/
				if ($res) {
					# success message
					$sm = "Successfully created!";
					header("Location: ../add-category.php?success=$sm");
					exit;
				} else {
					# Error message
					$em = "Unknown Error Occurred!";
					header("Location: ../add-category.php?error=$em");
					exit;
				}
			} else {
				# Error message
				$em = "Category is already exist!!!";
				header("Location: ../add-category.php?error=$em");
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
