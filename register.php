<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($db);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Quiz App'e kayıt ol!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
	    <section class="ftco-section">
		    <div class="container">
		    	<div class="row justify-content-center">
		    		<div class="col-md-6 text-center mb-5">
		    			<h2 class="heading-section">Quiz App'e Hoşgeldin</h2>
		    		</div>
		    	</div>
		    	<div class="row justify-content-center">
		    		<div class="col-md-6 col-lg-5">

		    			<div class="login-wrap p-4 p-md-5">
		          	        <div class="icon d-flex align-items-center justify-content-center">
		          		        <span class="fa fa-user-o"></span>
		          	        </div>
		    				<form action="" class="login-form" method="post">
		          		            <div class="form-group">
		          			            <input type="text"     name="username" class="form-control rounded-left" placeholder="Kullanıcı Adı" required>
		          		            </div>
	                                <div class="form-group d-flex">
	                                    <input type="password" name="password" class="form-control rounded-left" placeholder="Şifre" required>
	                                </div>
	                                <div class="form-group d-flex">
	                                    <input type="password" name="confirm_password" class="form-control rounded-left" placeholder="Şifre Tekrar" required>
	                                </div>

									<?php if($username_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($username_err);?>
									<?php if($username_err!="") echo "</div>"; ?>
	                                
									<?php if($password_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($password_err);?>
									<?php if($password_err!="") echo "</div>"; ?>
	                                
									<?php if($confirm_password_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($confirm_password_err);?>
									<?php if($confirm_password_err!="") echo "</div>"; ?>
	                                

	                                <div class="form-group">
	                	                <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Hadi başlayalım!</button>
	                                </div>
	                        </form>
	                    </div>
		    		</div>
		    	</div>
		    </div>
	    </section>

	    <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

	</body>
</html>

