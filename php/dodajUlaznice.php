<?php 
include("konekcija.php");
if(isset($_POST['btnUlaznice'])){
    $idobjekatUlaznice = $_POST['idObjekatUlaznice'];
    $idDogadjaj = $_POST['idDogadjaj'];
    $cenaUlaznice= $_POST['cenaUlaznice'];
    $kolicina = $_POST['kolicina'];
    for($i = 0; $i< count($idobjekatUlaznice); $i++ ){
        $upit = "INSERT INTO cenaulaznicadogadjaja VALUE ('', '$idDogadjaj', '$idobjekatUlaznice[$i]', '$cenaUlaznice[$i]','$kolicina[$i]')";
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