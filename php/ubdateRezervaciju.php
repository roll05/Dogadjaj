<?php
include ("konekcija.php");
if($_SERVER['REQUEST_METHOD']!="POST"){
    header("Location: ../index.php");
}
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $kupljeno=$_POST['kupljeno'];

    $upit1 = "UPDATE `rezervacija` SET kupljenoRezervisano=$kupljeno WHERE id_rezervacija = $id" ;
    $rez1=$konekcija->prepare($upit1);
    try{
    $rez1->execute();
        if($rez1){
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
    header("Location: ../index.php");

}