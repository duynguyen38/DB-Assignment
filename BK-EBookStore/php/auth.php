<?php 
session_start();


if (isset($_POST['email']) && 
	isset($_POST['password'])){
    
	# Database Connection File
	include "../db_conn.php";
	
    # Validation helper function
	include "func-validation.php";


	$email = $_POST['email'];
	$password = $_POST['password'];

	# simple form validation

	$text = "Email";
	$location = "../login.php";
	$ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Password";
	$location = "../login.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");
	

	# search for the email
    $sql = "SELECT * FROM users 
            WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    # if the email is exist
    if ($stmt->rowCount() === 1) {
    	$user = $stmt->fetch();

    	$user_id = $user['id'];
		$user_nickname = $user['nickname'];
    	$user_email = $user['email'];
    	$user_password = $user['password'];
		$user_permission = $user['permission'];
    	if ($email === $user_email) {
    		if (password_verify($password, $user_password)) {
    			$_SESSION['user_id'] = $user_id;
				//echo $_SESSION['user_id'];
				$_SESSION['user_nickname'] = $user_nickname;
				//echo $_SESSION['user_nickname'];
    			$_SESSION['user_email'] = $user_email;
				$_SESSION['user_permission'] = $user_permission;
    			header("Location: ../user.php");
    		}else {
    			# Error message
    	        $em = "Incorrect User name or password";
    	        header("Location: ../login.php?error=$em");
    		}
    	}else {
    		# Error message
    	    $em = "Incorrect User name or password";
    	    header("Location: ../login.php?error=$em");
    	}
    }else{
    	# Error message
    	$em = "Incorrect User name or password";
    	header("Location: ../login.php?error=$em");
    }

}else {
	# Redirect to "../login.php"
	header("Location: ../login.php");
}