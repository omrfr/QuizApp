<?php
    include "ifnotloggedin.php";
    require_once "config.php";

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/navbar.css">

    <title>Document</title>
</head>
<body>
    <style>
        h1{
            text-align: center;
            font-family: Verdana;
            font-size:2em;
            font-weight:bold;
        }
    </style>
   
   <nav class="flex align-center">
        <p><span>Quiz</span>App</p>
        <ul>
          <li class="big-screens">
            <!--Saat koy -->
            <form method="post">
              <input name="quiz_id" placeholder="Join Quiz:">
              <button class="btn login add-question" type="submit" >Join Quiz</button>
            </form>
          </li>
          <li class="small-screens">
            <i class="fa-solid fa-bars"></i>
          </li>
        </ul>
    </nav>
<?php
        $json="{"; 
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if(isset($_POST["quiz_id"])){
              $json=$json.'"x":[';
            $questions=$db->query("SELECT *FROM questions WHERE quiz_id={$_POST['quiz_id']}");
              foreach($questions as $question){
                
                $json=$json.'{'.'"quiz_id":'.$question['quiz_id'].",".          
                '"question_id":'.$question['question_id'].",".     
                '"question_text":"'.$question['question_text'].'",'.   
                '"choice_a":"'.$question['choice_a'].'",'.        
                '"choice_b":"'.$question['choice_b'].'",'.        
                '"choice_c":"'.$question['choice_c'].'",'.        
                '"choice_d":"'.$question['choice_d'].'",'.        
                '"question_time":'.$question['question_time'].",".   
                '"correct_answer":'.$question['correct_answer']."},";  
                
              }
              $json=$json."]}";
              setcookie("questions",$json);
            }
        }
?>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

</body>
</html>