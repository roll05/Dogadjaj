<?php
include ("konekcija.php");
if(isset($_POST["btnReg"])){
    $ime=$_POST['ime'];
    $prezime=$_POST['prezime'];
    $korIme =$_POST['korIme'];
    $UlBroj =$_POST['UlBroj'];
    $id_grada = $_POST['gradIme'];
    $email=$_POST['email'];
    $brTelefona=$_POST['brTelefona'];
    $password=$_POST['password'];
     $vkey = md5(time().$email);
    $errors=[];
     
    $reIme="/^[A-ZĐŠŽĆČ][a-zđšžćč]{2,14}(\s[A-ZĐŠŽĆČ][a-zđšžćč]{2,14})?$/";
    $rePrezime="/^[A-ZĐŠŽĆČ][a-zđšžćč]{2,14}(\s[A-ZĐŠŽĆČ][a-zđšžćč]{2,14})?$/";
    $reBroj="/^[0-9]+$/";
    $rePassword="/^[A-z0-9]{8,}$/";

    if(!preg_match($reIme, $ime)){
        array_push($errors,"Ime nije uneto u dobrom formatu");
    }
    if(!preg_match($rePrezime,$prezime)){
        array_push($errors,"Prezime nije uneto u dobrom formatu");
    }
    if(!preg_match($reBroj,$brTelefona)){
        array_push($errors,"Korisnicko ime nije uneto u dobrom formatu");
    }
    if(!preg_match($rePassword,$password)){
        array_push($errors,"Sifra nije uneta u dobrom formatu");
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email nije unet u dobrom formatu");
    }

    if(count($errors)!=0){
    
    }
    else {

        
             $upit="SELECT * FROM korisnik WHERE email=:email";
                $rez=$konekcija->prepare($upit);
                 $rez->bindParam(":email", $email);
                $rez->execute();
            if($rez->rowCount()==0){
           
           
                $upit="INSERT INTO korisnik VALUES('', :ime, :prezime, :kor_ime, :brojTelefona, :password, :ulica_broj, :email, :vkey, 0, :id_grad, 3, 0)";
                $rez=$konekcija->prepare($upit);
                $md5password=md5($password);
                $rez->bindParam(":ime", $ime);
                $rez->bindParam(":prezime", $prezime);
                $rez->bindParam(":kor_ime", $korIme);
                $rez->bindParam(":ulica_broj", $UlBroj);
                $rez->bindParam(":id_grad", $id_grada);
                $rez->bindParam(":email", $email);
                $rez->bindParam(":brojTelefona", $brTelefona);
                $rez->bindParam(":password", $md5password);
                $rez->bindParam(":vkey", $vkey);

                $rez->execute();

                if($rez){
                    $to = $email;
                    $subject = "Email Verifikacija";
                    $mesage= "http://localhost/proba/php/verifikacija.php?vkey=$vkey Kliknte na link da bi verifikovao accounts";
                    $headers = "FROM: <sluxzlatibor@gmail.com> \r\n";
                    $headers .= "Content-type: text/html; charset=UTF-8";
                   if(mail($to, $subject, $mesage, $headers)){
                    $status=200;
                   }else{
                    $status=500;
                   }

                }else {
                    $status=500;
                }
           
		           
            }else{
                    echo "Vec postoji korisnik sa ovim email-om.";
       
			}
		
            
    }   
}else{
    header("Location: ../php/404.php");
}