<?php 
  session_start();
?>

<!DOCTYPE html>
<html>
 <body>

<form method="post" action="">
<?php 
    if (isset($_SESSION['username'])){
		printf("Welcome , %s!\n", $_SESSION['username']);
		
	}
	//LOGOUT
    if (isset($_POST['log_out'])){
	  unset($_SESSION["id"]);
      unset($_SESSION["name"]);
      header("Location:login.php");
    }
?>

<input type="submit" name="log_out" value="Logout" />
</form>

 </body>
</html>
 