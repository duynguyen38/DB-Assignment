<?php

# server name
$sName = "localhost:3307";
# user name
$uName = "root";
# password
$pass = "";

# database name
$db_name = "bk_ebookstore_db";

try {
  $conn = new PDO(
    "mysql:host=$sName;dbname=$db_name",
    $uName,
    $pass
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed : " . $e->getMessage();
}
