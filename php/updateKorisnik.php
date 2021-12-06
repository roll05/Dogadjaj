<?php 
include("konekcija.php");
if(isset($_POST["id_korisnik"])){
	
	$idkorisnika = $_POST["id_korisnik"];
	$ime=$_POST["ime"];
	$prezime=$_POST["prezime"];
	$username = $_POST["kor_ime"];
	$brTelefona = $_POST["br_telefona"];
	$ulica_broj = $_POST["ulica_broj"];
	$email = $_POST["email"];
	$verification = $_POST["verification"];
	$id_grad = $_POST["id_grad"];
	$ulogaId = $_POST["id_uloga"];

	$upit="UPDATE `korisnik` SET `ime`=:ime,`prezime`=:prezime,`kor_ime`=:kor_ime,`br_telefona`=:br_telefona,`ulica_broj`=:ulica_broj,`email`=:email,`verification`=:verification,`id_grad`=:id_grad,`id_uloga`=:id_uloga WHERE  id_korisnik=$idkorisnika";
                        $rez=$konekcija->prepare($upit);
                        $rez->bindParam(":ime",$ime);
                        $rez->bindParam(":prezime",$prezime);
						$rez->bindParam(":kor_ime",$username);
						$rez->bindParam(":br_telefona",$brTelefona);
						$rez->bindParam(":ulica_broj",$ulica_broj);
                        $rez->bindParam(':email', $email);
		                $rez->bindParam(':verification', $verification);
                        $rez->bindParam(':id_grad', $id_grad);
                        $rez->bindParam(':id_uloga', $ulogaId);
						 $rez->execute();
                        if($rez){
                        header("Location: ../korisnici.php");
						}
                        else{
                            header("Location: ../index.php");
						}
            
                    


}else{
	    header("Location: 404.php");
}
?>