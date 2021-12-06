<?php 

include("konekcija.php");
if(isset($_POST['btnRezervacija'])){
    $idKorisnika = $_POST['idKorisnik'];
    $cenaid = $_POST['idcena'];
    $kolicina = $_POST['brojSedista'];
    $mesta = $_POST['nizToString'];
    $vremeRezervacije = date("Y-m-d H:i:s");
    echo  $idKorisnika;
    echo  $cenaid;
    echo  $kolicina;
    echo  $mesta;
    $upit = "INSERT INTO rezervacija VALUE ('', $idKorisnika, $cenaid, $kolicina, 0,'$vremeRezervacije', '$mesta')";
    $rez=$konekcija->prepare($upit);
    $rez->execute();
    if($rez){

        $upit = "SELECT kolicina FROM cenaulaznicadogadjaja WHERE id_cena = $cenaid";
        $rez=$konekcija->query($upit)->fetch();
        foreach($rez as $kol){
            $ostalaKolicina = $kol;
        }

        $updateKolicina = $ostalaKolicina - $kolicina;

       $upit1 = "UPDATE `cenaulaznicadogadjaja` SET kolicina=$updateKolicina WHERE id_cena = $cenaid" ;
       $rez1=$konekcija->prepare($upit1);
       $rez1->execute();
    }
}else{
    header("Location: ../index.php");
}