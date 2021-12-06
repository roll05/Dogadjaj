<?php
include("konekcija.php");
if(isset($_POST['btnUlaznice'])){

        $idDogadjaja = $_POST['idDogadjaja'];
        $ulazniceId =$_POST['ulaznice'];
        $upit = "SELECT * FROM dogadjaj d INNER JOIN objekat o ON d.id_objekat=o.id_objekat INNER JOIN cenaulaznicadogadjaja cud ON d.id_dogadjaj = cud.id_dogadjaj INNER JOIN objekatulaznice ou ON ou.id_objekatUlaznice = cud.id_objekatUlaznice INNER JOIN ulaznice u ON u.id_ulaznice = ou.id_ulaznice WHERE cud.id_dogadjaj = $idDogadjaja AND ou.id_ulaznice = $ulazniceId ";
        $rez=$konekcija->query($upit)->fetchAll();
        echo json_encode($rez,JSON_FORCE_OBJECT );
}else{
        header("Location: ../index.php");
}