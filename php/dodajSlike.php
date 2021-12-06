<?php
include("konekcija.php");

if(isset($_POST['UnesiSlike'])){

    $brSlika = count($_FILES['Slika']['tmp_name']);
    if($brSlika > 1){


        for($i = 0; $i < $brSlika; $i++){
            $dogadjaj = $_POST['dogadjaj'];
            $slika=$_FILES['Slika'];
            $ime=$slika['name'][$i];
            $tip=$slika['type'][$i];
            $velicina=$slika['size'][$i];
            $tmpPutanja=$slika['tmp_name'][$i];
            
            $naziv = time() .$i . $ime;

            $novaPutanja = "../img/" . $naziv;
            $pravaPutanja = "img/" .$naziv;

         if (move_uploaded_file($tmpPutanja, $novaPutanja)) {
                   $upit = "INSERT INTO slike values ('', :url, :alt, :id_dogadjaj)";
                $rez = $konekcija->prepare($upit);
                $rez->bindParam(':url', $pravaPutanja);
                $rez->bindParam(':alt', $ime);
                $rez->bindParam(':id_dogadjaj', $dogadjaj);

                    try {
                        $rez->execute();
                        echo "uspelo";

                    } catch (PDOException $e) {
                                    echo $e->getMessage();
                    }
                }
                }
                header("Location: ../index.php");
                }else{     
            
                $dogadjaj = $_POST['dogadjaj'];
                $slika=$_FILES['Slika'];
                $ime=$slika['name'][0];
                $tip=$slika['type'][0];
                $velicina=$slika['size'][0];
                $tmpPutanja=$slika['tmp_name'][0];
                
            

            $errors=[];

            if($dogadjaj=="0"){
            array_push($errors,"Polje mora biti Izabrano");
            }
        
            if(!$velicina>3000000){
            array_push($errors, "Fajl mora biti manje od 3MB");
            }

            if(count($errors)==0) {
            $naziv = time() . $ime;
            $novaPutanja = "../img/" . $naziv;
            $pravaPutanja = "img/" .$naziv;

            if (move_uploaded_file($tmpPutanja, $novaPutanja)) {
            $upit = "INSERT INTO slike values ('', :url, :alt, :id_dogadjaj)";
            $rez = $konekcija->prepare($upit);
            $rez->bindParam(':url', $pravaPutanja);
            $rez->bindParam(':alt', $ime);
            $rez->bindParam(':id_dogadjaj', $dogadjaj);

            try {
                $rez->execute();
                header("Location: ../index.php");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            }

            }
            

 }


}else{
    header("Location: ../index.php");
}