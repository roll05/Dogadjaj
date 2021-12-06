<?php
include ("konekcija.php");
if($_SERVER['REQUEST_METHOD']!="POST"){
    header("Location: ../index.php");
}
if(isset($_POST['id'])){
    $id=$_POST['id'];

    $upit = "SELECT r.kolicinaRezervisanihKarata, r.id_cena, cud.kolicina FROM rezervacija r INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena = cud.id_cena WHERE id_rezervacija = $id";
    $rez=$konekcija->query($upit)->fetchAll();
    foreach($rez as $rezervacija){
        $kolicinaRezervisanih = $rezervacija->kolicinaRezervisanihKarata;
        $cenaId= $rezervacija->id_cena;
        $kolicina = $rezervacija -> kolicina;
    }
    $updateKolicina = $kolicinaRezervisanih + $kolicina;
    $upit1 = "UPDATE `cenaulaznicadogadjaja` SET kolicina=$updateKolicina WHERE id_cena = $cenaId" ;
    $rez1=$konekcija->prepare($upit1);
    $rez1->execute();
    if($rez1){
    $upit="DELETE FROM rezervacija WHERE id_rezervacija = $id";
    $rez=$konekcija->prepare($upit);
    try{
    $rez->execute();
        if($rez){
            $statusCode=204;
            header("Location: ../index.php");
        }
        else {
            $statusCode=500;
        }
    }
    catch(PDOException $e){
        $statusCode=500;
    }

}else{
    $statusCode=500;
}
}else{
    header("Location: ../index.php");

}