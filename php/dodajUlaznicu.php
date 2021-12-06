<?php
include("konekcija.php");
if(isset($_POST['btnUlaznice'])){
    $ulaznice = $_POST['ulaznice'];
    $objekat = $_POST['objekat'];


    for($i = 0; $i < count($ulaznice); $i++){

        $upit = "INSERT INTO objekatUlaznice VALUE('',$objekat, $ulaznice[$i])";
        $rez=$konekcija->prepare($upit);
        $rez->execute();
        if($rez){
            $status =200;}
            else {
                $status=500;
            }
        
    }


}else{
    header("Location: ../indenx.php");
}