<?php
   include "ifnotloggedin.php";
   require_once "config.php";

    $quiz_id=      "ffffff";
    $question_text="";
    $question_time=10;
    $choice_a=     "";
    $choice_b=     "";
    $choice_c=     "";
    $choice_d=      "";
    $correct_answer= 0;

    $question_text_err=$quiz_id_err=$question_id_unique_err="";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["quiz_id"]) && isset($_POST["question_text"]) ){
        
        if((empty(trim($_POST["quiz_id"])))){
            $quiz_id_err="quiz_id is cannot be empty!'";
        }
        
        if((empty(trim($_POST["question_text"])))){
            $question_text_err="question text is cannot be empty!";
        }

        if(empty($question_text_err) && empty($quiz_id_err)){

            $quiz_id=      $_POST["quiz_id"];
            $question_id=      $_POST["question_id"];
            $question_text=$_POST["question_text"];
            $choice_a=      $_POST["choice_a"];
            $choice_b=      $_POST["choice_b"];
            $choice_c=      $_POST["choice_c"];
            $choice_d=      $_POST["choice_d"];
            $question_time=$_POST["question_time"];
            $correct_answer=      $_POST["correct_answer"];

            if($db->query("SELECT question_id,quiz_id FROM questions WHERE quiz_id={$quiz_id} AND question_id={$question_id}")->num_rows>0){

                $quiz=$db->query(
                    "UPDATE questions
                     SET 
                        question_text='{$question_text}',
                        choice_a='{$choice_a}',    
                        choice_b='{$choice_b}',
                        choice_c='{$choice_c}',
                        choice_d='{$choice_d}',
                        question_time={$question_time},
                        correct_answer={$correct_answer}
                    WHERE
                        quiz_id={$quiz_id} AND question_id={$question_id};");
            }else{
                $quiz=$db->query(
                    "INSERT INTO questions
                    (`quiz_id`, `question_id`, `question_text`, `choice_a`, `choice_b`, `choice_c`, `choice_d`, `question_time`, `correct_answer`)
                    VALUES({$quiz_id},{$question_id},'{$question_text}','{$choice_a}','{$choice_b}','{$choice_c}','{$choice_d}',{$question_time},{$correct_answer})
                    ;");

            }




        }



    
    }
    

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
            <form method="post" action="../show-quiz.php">
                <button type="submit" class="btn login add-question" >Show Quiz</button>
            </form>    
            </li>
          <li class="small-screens">
            <i class="fa-solid fa-bars">
                
            </i>
          </li>
        </ul>
    </nav>
    
    <div class="container-fluid">
    <div class="modal-dialog">
        <div class="modal-content" style="width:120%;margin-left:auto;margin-right:auto;">
            <form method="POST" action="" id="question-form">
                <div class="modal-header">
                    <label for="quiz_id">Enter Quiz Id'sini Giriniz:</label>
                    <input name="quiz_id" placeholder="Enter quiz_id" type="int" value="99999999" min="0" max="99999999" style="margin-left:auto;margin-right:auto;text-align:center;" required/>
                    
                    <label for="question_id">Question Id'sini Giriniz:</label>
                    <input type="number" name="question_id" placeholder="question_id" value="99999999" min="0" max="99999999"/> 
                </div>

                <div class="modal-header">
                    <h3>Q.<input name="question_text" placeholder="Soru metnini giriniz" type="text" value="Soru metni:" required>?</h3>
                      <p> <input name="question_time" placeholder="Süre" type="number" min="1" max="90" value="10" required></p>
                    
                </div>
                <div class="modal-body">
                    <div class="row-xs-3 5 justify-content-md-center"  ></div>
                    <div class="quiz" id="quiz" data-toggle="buttons"> 
                    <label class="element-animation1 btn btn-lg btn-info btn-block"> <input type="radio" value="0" disabled> <input name="choice_a" placeholder="A Seçeneğini giriniz" type="text"></label> 
                    <label class="element-animation2 btn btn-lg btn-info btn-block"> <input type="radio" value="1" disabled> <input name="choice_b" placeholder="B Seçeneğini giriniz" type="text"></label> 
                    <label class="element-animation3 btn btn-lg btn-info btn-block"> <input type="radio" value="2" disabled> <input name="choice_c" placeholder="C Seçeneğini giriniz" type="text"></label> 
                    <label class="element-animation4 btn btn-lg btn-info btn-block"> <input type="radio" value="3" disabled> <input name="choice_d" placeholder="D Seçeneğini giriniz" type="text"> </label> </div>
                    
                    <p> 
                        <label for="correct_answer" >Doğru cevabın indis numarsını giriniz <strong>{A:0,B:1,C:2,D:3}</strong>:</label>
                        <input name="correct_answer" placeholder=""  type="number" min="0" max="3" value="4" required>
                    
                    </p>
                        
                    <?php if($quiz_id_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($quiz_id_err);?>
					<?php if($quiz_id_err!="") echo "</div>"; ?>
                    <?php if($question_id_unique_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($question_id_unique_err);?>
					<?php if($question_id_unique_err!="") echo "</div>"; ?>
                   
                    <?php if($question_text_err!="") echo '<div class="form-group d-md-flex">';?>
										 <?php echo($question_text_err);?>
					<?php if($question_text_err!="") echo "</div>"; ?>
                        

                    <div class="d-flex justify-content-between">  
                        <button type="submit" form="question-form" class="btn login" style="margin-left:auto;margin-right:0;border:1px turquoise solid;" >Submit</button>
                </div>
            </form>    
            </div>
            
        </div>

    
    </div>
</div>
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

</body>
</html>
