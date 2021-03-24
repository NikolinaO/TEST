<?php

session_start();

// initializing variables
$username = "";
$email    = "";


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'probalog');


// REGISTER USER
if (isset($_POST['reg_user']))
{
	// receive all input values from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		
	//validation    
	if (empty($username)) { die( "Username is required."); }
    if (empty($email))    {  die ("Email is required"); }
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {die ("Incorrect email adress");}
    if (empty($password_1)) { die("Password is required"); }
    if (strcmp($password_1,$password_2)) {
	     die(  "The two passwords do not match");
    }
	
	// first check - if user already exist with the same username and/or email
	$check_query = "SELECT * FROM users WHERE  email='$email' LIMIT 1";
	$result = mysqli_query($db, $check_query);
	$user = mysqli_fetch_assoc($result);
	
	if ($user) { // if user exists
		 if ($user['email'] === $email) { echo( "Email already exists. Please try again!");
          }
	}
	else{
		//registration
		$password = md5($password_1);//encrypt the password
		$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	    mysqli_query($db, $query);
		$_SESSION['username'] = $username;
  	    //header('location: results.php');
	}

}

// LOGIN USER
if (isset($_POST['login_user'])) 
{
    $email = mysqli_real_escape_string($db, $_POST['email']); 
    $password = mysqli_real_escape_string($db, $_POST['password']);

	// DODATI ISPRAVNOST EMAILADRESE PREKO REGULARNIH IZRAZA
    if (empty($email) || empty($password)) { 	  die("Email  and password are required");      }
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {die ("Incorrect email adress");}
    	
	//we are looking for a user.....
	$password = md5($password);
  	$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
		$user = mysqli_fetch_assoc($results);
  	  $_SESSION['username'] = $user['username'];  	  	  
	  header('location: results.php');
  	}
	else {
  		echo("Error logging you in! Please login...... "."\n");
		//header('location: login.php');
  	}
}




?>