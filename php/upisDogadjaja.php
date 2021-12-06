<?php
include("konekcija.php");
if(isset($_POST['dodajDogadjaj'])){
    $ididBlaganika = $_POST['ididBlaganika'];
    $nazivDogadjaja = $_POST['nazivDogadjaja'];
    $duzinaDogadjaja = $_POST['duzinaDogadjaja'];
    $avatar = $_FILES['avatarDogadjaja'];
    $idObjekta=$_POST['idmestoOdrzavanja'];
    $datumOdrzavanja= $_POST['datumOdrzavanja'];
    $opisDogadjaja = $_POST['opisDogadjaja'];
    $maxBrojRezervacija = $_POST['maxBrojRezervacija'];
    $ime=$avatar['name'];
    $tip=$avatar['type'];
    $velicina=$avatar['size'];
    $tmpPutanja=$avatar['tmp_name'];
    $errors=[];
   
    function hoursandmins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes,);
    }

    if($ime == ""){
        array_push($errors,"Mora da bude uneta avatar slika!");
	 }

     if(empty($nazivDogadjaja)){
        array_push($errors,"Naziv apartmana polje mora biti popunjeno");
    }
    if(empty($duzinaDogadjaja)){
        array_push($errors,"Naziv apartmana polje mora biti popunjeno");
    }
    if(empty($datumOdrzavanja)){
        array_push($errors,"Naziv apartmana polje mora biti popunjeno");
    }
    if(empty($opisDogadjaja)){
        array_push($errors,"Naziv apartmana polje mora biti popunjeno");
    }
    
    if(count($errors)==0){

        $naziv = time() . $ime;
        $novaPutanja = "../img/" . $naziv;
        $pravaPutanja = "img/" .$naziv;
        $duzina = hoursandmins($duzinaDogadjaja, '%02d:%02d:00');
       

    if (move_uploaded_file($tmpPutanja, $novaPutanja)) {
    $upit="INSERT INTO `dogadjaj` VALUES ('', :naziv, :duzina, :urlAvatara, :datum, :opis, :maxBrojRezervacija, :id_objekat, :id_blagajnik)";
    $rez=$konekcija->prepare($upit);
    $rez->bindParam(":naziv",$nazivDogadjaja);
    $rez->bindParam(":duzina",$duzina);
    $rez->bindParam(":urlAvatara",$pravaPutanja);
    $rez->bindParam(":datum",$datumOdrzavanja);
    $rez->bindParam(":opis",$opisDogadjaja);
    $rez->bindParam(":maxBrojRezervacija",$maxBrojRezervacija);
    $rez->bindParam(":id_objekat",$idObjekta);
    $rez->bindParam(":id_blagajnik",$ididBlaganika);
   
    $rez->execute();
    if($rez){
        header("Location: ../index.php");
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
echo "nije dozvoljeno ulazak na ovu stranicu";
}

}