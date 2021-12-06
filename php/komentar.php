<?php
session_start();
include ("konekcija.php");
if(isset($_SESSION['korisnik'])){

if(isset($_POST['btnKomentar'])) {
    $komentar = $_POST['komentar'];
    $id = $_SESSION['korisnik']->id_korisnik;
    $date = date('Y-m-d H:i:s');
    $dogadjaj = $_POST["dogadjaj"];
    $page = $_SERVER['PHP_SELF'];
    $upit1 = "SELECT datum FROM dogadjaj WHERE id_dogadjaj = $dogadjaj";
    $rez=$konekcija->query($upit1)->fetch();
    foreach($rez as $date){
        $datum = $date;
    }

    $datumZaLink = date("Y-m-d", strtotime($datum));
    $vremeZaLink = date("H:i:s", strtotime($datum));

    if(!empty($komentar)){
        $upit="INSERT INTO komentar VALUES ('', :komentar, :datum, :id_korisnik, :id_dogadjaj)";
        $rez=$konekcija->prepare($upit);
        $rez->bindParam(":komentar", $komentar);
        $rez->bindParam(":datum", $date);
        $rez->bindParam(":id_korisnik", $id);
        $rez->bindParam(":id_dogadjaj", $dogadjaj);

        $rez->execute();

        if($rez){
            $status=201;
            header("Location: ../dogadjaj.php?id=$dogadjaj&datum=$datumZaLink&vreme=$vremeZaLink");
        }
        else {
            $status=500;
        }
    }
    
}else{
           header("Location: ../index.php");
	}
}else{
           header("Location: ../registracija.php");
	}
