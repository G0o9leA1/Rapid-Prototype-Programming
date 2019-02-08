<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>calculator</title>
</head>

<body>
    <form action="calculator.php" method="GET">
    <label>number 1 : <input type="text" name="num1" /></label>
    <br>
    <input type="radio" name="action" value="+" checked>+<br>
    <input type="radio" name="action" value="-">-<br>
    <input type="radio" name="action" value="*">*<br>
    <input type="radio" name="action" value="/">/<br>
    <label>number 2 : <input type="text" name="num2" /></label>
    <br>
    <input type="submit" value="Submit">
    </form>
<?php

$argv = sanitize();
calculate($argv[0], $argv[1], $argv[2]);

function sanitize(){
    if(isset($_GET['num1'])&&isset($_GET['num2'])&&isset($_GET['action'])){
        if(empty($_GET['num1'])&&empty($_GET['num2'])){
            echo 'Please enter number!';
            exit;
        }
        if (empty($_GET['num1'])) $_GET['num1']=0; 
        $num1=$_GET['num1'];
        if (empty($_GET['num2'])) $_GET['num2']=0; 
        $num2=$_GET['num2'];
    }
    else exit;
    
    if((!is_numeric($num1))||(!is_numeric($num2))){
        echo '<br>Please enter number!';
        exit;
    }

    $action=$_GET['action'];
    if ($action!="+"&&$action!="-"&&$action!="*"&&$action!="/"){
        echo "invalid action!";
        exit;
    }
    return $argv=array($num1,$num2,$action);
}

function calculate($num1, $num2, $action){
    if ($action=="+") $result=$num1+$num2;
    elseif ($action=="-") $result=$num1-$num2;
    elseif ($action=="*") $result=$num1*$num2;
    elseif ($action=="/") { 
    if ($num2==0) {
        echo"cannot divide by 0";
        exit;
        }
    else $result=$num1/$num2;
    }
    echo '    '.sprintf("<p>%s %s  %s = %s</p>\n",$num1,$action,$num2,$result);
}
?>
</body>
</html>