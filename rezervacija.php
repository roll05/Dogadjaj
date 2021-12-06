<?php
include("views/head.php");
include("views/header.php");
$output = "";
$outpur1 = "";
 $strana=0;
$upit="SELECT * FROM apartman a INNER JOIN cena c ON a.cenaid = c.cenaid WHERE apartmanid limit $strana, 8";
if(isset($_POST["search"])){
$search = $_POST["form1"];
  $upit = "SELECT * FROM apartman a INNER JOIN cena c ON a.cenaid = c.cenaid WHERE apartmanid AND naziv LIKE '%$search%' limit $strana, 8";
$rez=$konekcija->query($upit)->fetchAll();
$count  = count($rez);
  if($count == 0){
   $output = "Nema to sto trazite";
  }else {
     foreach($rez as $iteam):

      $id = $iteam->apartmanid;
      $slika =$iteam->urlSlike;
     
      
      endforeach ;
     
   }

}
?>

<main class="container">
<div class="row">
    <h1 class="naslov"> Rezervacije </h1>
    <hr class="hrNaslov"/>
</div>
    <div class="row">
    <div class="col-md-6">
    <form method = "post" action="rezervacija.php">
                <table>
                <tr>
                <td width="80%">
					<input type="search" id="form1" placeholder="search..." name="form1"  style="width: 100%;"/>
                    </td><td>
                    <input type="submit" id="search" name="search" value="Search" class="btn btn-xs btn-primary">
                    </td><tr>
                    </table>
                   </form>
                   <?php 
                   echo $outpur1;
                   ?>

				</div>
				
				<div class="col-md-6" style="text-align:right;">
                <form method="post" action="rezervacija.php?objekat=<?=$_GET['objekat']?>&idBlagajnik=<?=$_GET['idBlagajnik']?>.php">
					<select name="ddlistFilter" id="ddlistFilter">
						<option value="0">Izaberite filter</option>
						<option value="1">Rezervisane karte</option>
						<option value="2">Kupljene karte</option>
					</select>
                <input type="submit" id="filter" name="filter" value="Primeni Filter" class="btn btn-xs btn-primary">
                </form>
                
</div>
</div>

<div class="row">
    <table class="table table-striped korisnici">
        <thead>
        <tr>
            <th scope="col">Ime</th>
            <th scope="col">Prezime</th>
            <th scope="col">Korisnicko ime</th>
            <th scope="col">Dogadjaj</th>
            <th scope="col">kolicina</th>
            <th scope="col">Ukupna cena</th>
            <th scope="col">Datum rezervacije</th>
            <th scope="col">Datum Isteka rezervacije</th>
            <th scope="col">Rezervacija/Kupovina</th>
            <th scope="col">Izbrisi rezervaciju</th>
            <th scope="col">Update rezervaciju</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $objekat = $_GET['objekat'];
        if(isset($_POST["filter"])){
            $strana=0;
            $ddlista = $_POST["ddlistFilter"];
            if($ddlista == 1){
                 $upit="SELECT k.ime,k.prezime,k.kor_ime, d.naziv,r.kolicinaRezervisanihKarata,r.kupljenoRezervisano,r.id_rezervacija, r.kolicinaRezervisanihKarata*cud.cena as ukupnaCena, r.vremeRezervacije FROM korisnik k INNER JOIN rezervacija r ON k.id_korisnik = r.id_korisnik INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena = cud.id_cena INNER JOIN dogadjaj d ON d.id_dogadjaj = cud.id_dogadjaj INNER JOIN objekatulaznice ou ON cud.id_objekatUlaznice=ou.id_objekatUlaznice WHERE r.kupljenoRezervisano = 0 AND ou.id_objekat = $objekat";
            }elseif($ddlista == 2){
                 $upit="SELECT k.ime,k.prezime,k.kor_ime, d.naziv,r.kolicinaRezervisanihKarata,r.kupljenoRezervisano,r.id_rezervacija, r.kolicinaRezervisanihKarata*cud.cena as ukupnaCena, r.vremeRezervacije FROM korisnik k INNER JOIN rezervacija r ON k.id_korisnik = r.id_korisnik INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena = cud.id_cena INNER JOIN dogadjaj d ON d.id_dogadjaj = cud.id_dogadjaj INNER JOIN objekatulaznice ou ON cud.id_objekatUlaznice=ou.id_objekatUlaznice WHERE r.kupljenoRezervisano = 1 AND ou.id_objekat = $objekat";
            }else{
        $upit="SELECT k.ime,k.prezime,k.kor_ime, d.naziv,r.kolicinaRezervisanihKarata,r.kupljenoRezervisano,r.id_rezervacija, r.kolicinaRezervisanihKarata*cud.cena as ukupnaCena, r.vremeRezervacije FROM korisnik k INNER JOIN rezervacija r ON k.id_korisnik = r.id_korisnik INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena = cud.id_cena INNER JOIN dogadjaj d ON d.id_dogadjaj = cud.id_dogadjaj INNER JOIN objekatulaznice ou ON cud.id_objekatUlaznice=ou.id_objekatUlaznice WHERE ou.id_objekat = $objekat";
            }
        }else{
            $upit="SELECT k.ime,k.prezime,k.kor_ime, d.naziv,r.kolicinaRezervisanihKarata,r.kupljenoRezervisano,r.id_rezervacija, r.kolicinaRezervisanihKarata*cud.cena as ukupnaCena, r.vremeRezervacije FROM korisnik k INNER JOIN rezervacija r ON k.id_korisnik = r.id_korisnik INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena = cud.id_cena INNER JOIN dogadjaj d ON d.id_dogadjaj = cud.id_dogadjaj INNER JOIN objekatulaznice ou ON cud.id_objekatUlaznice=ou.id_objekatUlaznice WHERE ou.id_objekat = $objekat";
        }
        $rez=$konekcija->query($upit)->fetchAll();
        foreach($rez as $kor):
        ?>
        <tr>
            <td scope="row"><?=$kor->ime?></td>
            <td><?=$kor->prezime?></td>
            <td><?=$kor->kor_ime?></td>
            <td><?=$kor->naziv?></td>
            <td><?=$kor->kolicinaRezervisanihKarata?></td>
            <td><?=$kor->ukupnaCena?> din</td>
            <td><?=$kor->vremeRezervacije?></td>
            <?php
            $time_input = strtotime($kor->vremeRezervacije); 
            $new_time = date("Y-m-d H:i:s", strtotime('+48 hours', $time_input));
            ?>
            <td><?php echo $new_time?></td>
            <td><input type="text" id="kupljenoRezervisano" name = "kupljenoRezervisano"value = "<?=$kor->kupljenoRezervisano?>"></td>
            <?php 
                $daLiSuKupljene = $kor->kupljenoRezervisano;
                if($daLiSuKupljene == 1){?>
            <td colspan="2">Karte su kupljene</td>
            <?php        
            }else{
            ?>
            <td><a class="btn btn-primary delete" data-id="<?=$kor->id_rezervacija ?>" title="Otkazi rezervaciju">Izbrisi</a></td>
            <td><a class="btn btn-primary update" data-id="<?=$kor->id_rezervacija ?>" title="Update rezervaciju">Update</a></td>
            <?php } ?>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        <script>
            window.onload=function () {
                $(".delete").click(function(){
                    let id=$(this).data('id');

                    $.ajax({
                        method:"POST",
                        url:"php/deleteRezervaciju.php",
                        data:{
                            id:id,
                            dugme:true
                        },
                        success: function (podaci) {
                        console.log(podaci);
                        alert("Uspesno ste izbrisali rezervaciju");
                         location.reload();
                        },
                        error:function(xhr, statuss){
                            let status=xhr.status;
                            switch (status) {
                                case 500:
                                    alert("Server error, it is not possible to delete post at this moment.");
                                    break;
                                case 404:
                                    alert("Page not found");
                                    break;
                                default:
                                    alert("Error: " + status + " - " + statuss);
                                    break;
                            }
                        }
                    })
                })
                    $(".update").click(function(){
                    let id=$(this).data('id');
                    var kupljeno = $("#kupljenoRezervisano").val();
                    console.log(kupljeno);
                    $.ajax({
                        method:"POST",
                        url:"php/ubdateRezervaciju.php",
                        data:{
                            id:id,
                            kupljeno:kupljeno,
                            dugme:true
                        },
                        success: function (podaci) {
                        console.log(podaci);
                        alert("Uspesno ste ubdatovali rezervaciju");
                         location.reload();
                        },
                        error:function(xhr, statuss){
                            let status=xhr.status;
                            switch (status) {
                                case 500:
                                    alert("Server error, it is not possible to delete post at this moment.");
                                    break;
                                case 404:
                                    alert("Page not found");
                                    break;
                                default:
                                    alert("Error: " + status + " - " + statuss);
                                    break;
                            }
                        }
                    })
            
            })
            }
        </script>
        </div>
        </main>
<?php
include("views/footer.php");
?>