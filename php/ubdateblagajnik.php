<?php 
session_start();
include("konekcija.php");
if(isset($_SESSION['korisnik'])){
if(isset($_POST['button'])){
    $radnoMesto = $_POST['radnomesto'];
    $idKorisnik = $_SESSION['korisnik']->id_korisnik;

    $upit = "UPDATE `korisnik` SET `id_objekat`='$radnoMesto' WHERE id_korisnik = $idKorisnik";
    $rez=$konekcija->prepare($upit);
    $rez->execute();

    unset($_SESSION['korisnik']);
    session_destroy();
    header("Location: ../index.php");
}
}else{
    $status = 404;
    header("Location: ../index.php");
}