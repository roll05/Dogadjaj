<?php 
include("konekcija.php");

if(isset($_POST['btnUpis'])){

    $nazivFilma = $_POST['nazivFilma'];
    $datum = $_POST['datum'];
    $avatar=$_FILES['avatar'];
    $ime=$avatar['name'];
    $tip=$avatar['type'];
    $velicina=$avatar['size'];
    $tmpPutanja=$avatar['tmp_name'];
     $errors=[];
      

     if($ime == ""){
        array_push($errors,"Mora da bude uneta avatar slika!");
	 }

     if(empty($nazivFilma)){
        array_push($errors,"Naziv apartmana polje mora biti popunjeno");
    }
   
    if(!$velicina>3000000){
            array_push($errors, "Fajl mora biti manje od 3MB");
        }
    
    if(count($errors)==0){
        
            
            $naziv = time() . $ime;
            $novaPutanja = "../img/" . $naziv;
            $pravaPutanja = "img/" .$naziv;
            
        if (move_uploaded_file($tmpPutanja, $novaPutanja)) {
        $upit="INSERT INTO upcomingmovies VALUES ('', :name, :pictures, :date)";
        $rez=$konekcija->prepare($upit);
        $rez->bindParam(":name",$nazivFilma);
        $rez->bindParam(":pictures",$pravaPutanja);
        $rez->bindParam(":date",$datum);
       
        $rez->execute();
        if($rez){
            header("Location: ../index.php");
        }
        }
        else {
            $status=500;
        }
     }else {
        
        for($i = 0; $i < count($errors); $i++){
            echo $errors[$i];   
            }

     }


    
        
    }else{
    header("Location: ../php/404.php");
}


