<?php 

try{
    $pdo = new PDO('mysql:host=localhost;dbname=aitech_payment','root','');
    //echo'Connection Successful!';

    
}catch(PDOException $f){
    
    echo $f->getmessage();
}


?>