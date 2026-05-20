<?php
// this is  line comment 
/*
this is block comment
*/
    echo "Hello world. We're here";
    $num1 =20;
    $num2 =10;
    $add = $num1 + $num2 ;
    echo "<br>";
    echo "<font color = 'RED'><b>The addition is:</b>
    </font>". $add;if ($num1>$num2){
        echo "<br> You win";
    }else{
        echo "<br> You lose";
    }
?>