<?php
if(isset($_POST['btnReg'])){

    $ime= $_POST['ime'];
    $email = $_POST['email'];
    $poruka = $_POST['poruka'];

    $to = "sluxzlatibor@gmail.com";
    $subject = "Poruka od: $ime";
    $message = "Sadrzaj emaila : ".$poruka;
    $headers = "FROM: <$email> \r\n";
    $headers .= "Reply-To: ".$email."\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8";
    if(mail($to, $subject, $message, $headers)){
    $status=200;
    }else{
    $status=500;
    }
}else{
    header("Location: ../index.php");
}