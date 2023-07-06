<?php
// Initialize the session
session_start();
//if the user is already logged in, if yes then go redirect to welcome.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables for stroing username and password data and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
//When form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){

		$sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){

			mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
               
				mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: welcome.php");
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Something went wrong. Please try again later.";
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
  	<title>Quiz App'e Giriş Yap!</title>
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
								  <h3 style="text-align:center;"><a href="register.php" >Hesabın yok mu?</a></h3>
		    				<form action="" class="login-form" method="post">
		          		            <div class="form-group">
		          			            <input type="text" name="username" class="form-control rounded-left" placeholder="Kullanıcı Adı" required>
		          		            </div>
	                                <div class="form-group d-flex">
	                                    <input type="password" name="password" class="form-control rounded-left" placeholder="Şifre" required>
	                                </div>
	                                <div class="form-group d-md-flex">
	                	                <div class="w-50">
	                		                <label class="checkbox-wrap checkbox-primary">Beni hatırla
		    						    	    <input type="checkbox" checked>
		    						    	    <span class="checkmark"></span>
		    						    	</label>
		    						    </div>
		    						    <div class="w-50 text-md-right">
		    						    	<a href="forgot-password.html">Şifreni mi unuttun?</a>
		    						    </div>
	                                </div>
									
									<?php if($username_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($username_err);?>
									<?php if($username_err!="") echo "</div>"; ?>
	                                
									<?php if($password_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($password_err);?>
									<?php if($password_err!="") echo "</div>"; ?>
	                                
									<?php if($login_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($login_err);?>
									<?php if($login_err!="") echo "</div>"; ?>
	                                


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

