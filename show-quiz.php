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
    <link rel="stylesheet" href="css/quiz-card.css">
    <link rel="stylesheet" href="css/tag.css">

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
            <form method="post" action="./show-quiz.php">
                <input type="number" name="quiz_id" placeholder="Enter Quiz Id" value="-1" >
                <button type="submit" class="btn login add-question" >Show Questions</button>
            </form>    
            </li>
          <li class="small-screens">
            <i class="fa-solid fa-bars">
                
            </i>
          </li>
        </ul>
    </nav>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      
        if(isset($_POST["quiz_id"]))
        $questions=$db->query("SELECT * FROM questions WHERE quiz_id={$_POST["quiz_id"]}");
        
        if(isset($questions)){
            foreach($questions as $question){
            
            echo("
            <div class='container-fluid'>
                <div class='modal-dialog'>
                    <div class='modal-content' style='width:120%;margin-left:auto;margin-right:auto;'>
                        <div class='modal-header'>
                            <p for='quiz_id'>Quiz Id'si: {$question["quiz_id"]}</p>

                            <p for='question_id'>Question Id'si: {$question["question_id"]}</p>
                        </div>

                        <div class='modal-header'>
                            <h3>Q. {$question["question_text"]}?</h3>
                              <p>Soru Süresi: {$question["question_time"]}</p>

                        </div>
                        <div class='modal-body'>
                            <div class='row-xs-3 5 justify-content-md-center'  ></div>
                            <div class='quiz' id='quiz' data-toggle='buttons'> 
                                <label class='element-animation1 btn btn-lg btn-info btn-block'>{$question["choice_a"]}</label> 
                                <label class='element-animation2 btn btn-lg btn-info btn-block'>{$question["choice_b"]}</label> 
                                <label class='element-animation3 btn btn-lg btn-info btn-block'>{$question["choice_c"]}</label> 
                                <label class='element-animation4 btn btn-lg btn-info btn-block'>{$question["choice_d"]}</label> 
                            </div>

                            <p for='correct_answer'>Doğru cevabın indis numarsı: <strong>{$question["correct_answer"]}</strong></p>


                    </div>

                </div>

            
            </div>");
            }
                
        }
        else{
            echo "There is no any quiz with given id";    
        }
    }
    ?>
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

</body>
</html>
