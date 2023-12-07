<?php 

# Get all Author function
function get_all_users($con){
   $sql  = "SELECT * FROM users";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $users = $stmt->fetchAll();
   }else {
      $users = 0;
   }

   return $users;
}