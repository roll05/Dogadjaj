<?php
include("konekcija.php");
if(isset($_POST['resetujPasswotd'])){

    $text =$_POST['text'];
    $errors = [];
    $regKorIme ="/^(?!(.*[_].*){2,}$)(?!(.*[0-9].*){4,}$)(?=.{6,20}$)(?![_])[a-zA-Z0-9çÇ_]+(?<![_])$/";

    if(preg_match($regKorIme, $text)){
        $upit = "SELECT * FROM korisnik WHERE kor_ime = '$text'";
        $rez=$konekcija->prepare($upit);
        $rez->execute();
        $email = $rez -> email;
        var_dump($email);
        $count = $rez->rowCount();
    if($count == 0){
        array_push($errors,"Ne postoji korisnik sa ovim korisnickim imenom");
    }else{

    $vkey = md5(time().$text);
    $upit1 = "UPDATE `korisnik` SET `vkey`= '$vkey' WHERE kor_ime = '$text'";
    $rez1=$konekcija->prepare($upit1);
	$rez1->execute();
    if($rez1){

        $to = $email;
        $subject = "Email Verifikacija";
        $mesage= " http://localhost/proba/php/verifikacijaPassword.php?vkey=$vkey Kliknte na link da bi resetovali password!";
        $header = "From:sluxzlatibor@gmail.com"." \r\n";
        $header .= "Cc:sluxzlatibor@gmail.com". "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
      if(mail($to, $subject, $mesage, $header)){
         $status=200; 
         header("Location: ../index.php");
        }else {
                    $status=500;
                }
    }
    }
 }else if(filter_var($text, FILTER_VALIDATE_EMAIL)){
    $upit = "SELECT * FROM korisnik WHERE email = '$text'";
    $rez=$konekcija->prepare($upit);
    $rez->execute();
    $count = $rez->rowCount();
        if($count == 0){
        array_push($errors,"Ne postoji korisnik sa ovim e-mail-om");

    }else{

    $vkey = md5(time().$text);
    $upit1 = "UPDATE `korisnik` SET `vkey`= '$vkey' WHERE email = '$text'";
    $rez1=$konekcija->prepare($upit1);
	$rez1->execute();
    
    if($rez1){
    $to = $text;
    $subject = "Email Verifikacija";
    $mesage= " http://localhost/proba/php/verifikacijaPassword.php?vkey=$vkey Kliknte na link da bi resetovali password!";
    $header = "From:sluxzlatibor@gmail.com"." \r\n";
    $header .= "Cc:sluxzlatibor@gmail.com". "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $asdwe = mail($to, $subject, $mesage, $header);
      if($asdwe == true){
         $status=200; 
         header("Location: ../index.php");
       
        }else {
                    $status=500;
                    
                }
    }
    }
    }
    else{
        array_push($errors,"Niste dobro unelin korisnicko ime/email");
    }
    echo json_encode($errors);
}