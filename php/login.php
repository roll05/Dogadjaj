<?php
session_start();
include ("konekcija.php");
if(isset($_POST["btnLog"])){
    $username=$_POST["username"];
    $password=$_POST["password"];

    $errors=[];

    $reUsername= "/^(?!(.*[_].*){2,}$)(?!(.*[0-9].*){4,}$)(?=.{6,20}$)(?![_])[a-zA-Z0-9çÇ_]+(?<![_])$/";
    $rePassword="/^[A-z0-9]{8,}$/";
    if(!preg_match($rePassword,$password)){
        array_push($errors,"Niste uneli odgovarajucu sifru!");
    }
    if(!preg_match($reUsername,$username)){
        array_push($errors,"Niste uneli odgovarajuci username!");
    }

    if(count($errors) !=0){
        echo"ima greska";
    }
    else {
//        
        $upit="SELECT * FROM `korisnik` WHERE  kor_ime = :kor_ime AND password= :password";
        $rez=$konekcija->prepare($upit);
        $md5password=md5($password);
        $rez->bindParam(":kor_ime", $username);
        $rez->bindParam(":password", $md5password);


        if($rez->execute()){
            if($rez->rowCount()==1){
                $korisnik=$rez->fetch();
                
              

                    if($korisnik->verification == 1){
                $_SESSION["id_korisnik"]=$korisnik->id_korisnik;
                $idd=$korisnik->id_korisnik;
                $_SESSION["korisnik"]=$korisnik;

                http_response_code(201);

                if($_SESSION['korisnik']->id_uloga==1){
                    header("Location: ../korisnici.php");


                } elseif($_SESSION['korisnik']->id_uloga==2){
                    header("Location: ../dodajFilm.php");


                }
                else {
                    header("Location: ../index.php");
                }
                }else{
                        
                echo "Niste verifikovali vas account.";    
				}

            }
            else {
                http_response_code(400);
                echo "$rez";

            }
        }
        else {
            http_response_code(400);
            echo "Upit nije ok";
        }
    }
}
else{
    header("Location: ../php/404.php");
}