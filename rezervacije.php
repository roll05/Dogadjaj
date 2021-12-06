<?php 
include("views/head.php");
include("views/header.php");
?>
<main class="container">
    <h1 class="naslov"> Rezervacije </h1>
    <hr class="hrNaslov"/>
    <table class="table table-striped korisnici">
        <thead>
        <tr>
            <th scope="col">Ime</th>
            <th scope="col">Prezime</th>
            <th scope="col">Dogadjaj</th>
            <th scope="col">kolicina</th>
            <th scope="col">Ukupna cena</th>
            <th scope="col">Datum rezervacije</th>
            <th scope="col">Datum Isteka rezervacije</th>
            <th scope="col">Otkazi rezervaciju</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $idKorisnik = $_SESSION['korisnik']->id_korisnik;
        $upit="SELECT k.ime,k.prezime, d.naziv,r.kolicinaRezervisanihKarata, r.kupljenoRezervisano, r.kolicinaRezervisanihKarata*cud.cena as ukupnaCena, r.id_rezervacija, r.vremeRezervacije FROM korisnik k INNER JOIN rezervacija r ON k.id_korisnik = r.id_korisnik INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena = cud.id_cena INNER JOIN dogadjaj d ON d.id_dogadjaj = cud.id_dogadjaj WHERE k.id_korisnik = $idKorisnik";
        $rez=$konekcija->query($upit)->fetchAll();
        foreach($rez as $kor):
        ?>
        <tr>
            <th scope="row"><?=$kor->ime?></th>
            <td><?=$kor->prezime?></td>
            <td><?=$kor->naziv?></td>
            <td><?=$kor->kolicinaRezervisanihKarata?></td>
            <td><?=$kor->ukupnaCena?> din</td>
            <td><?=$kor->vremeRezervacije?></td>
            <?php
            $time_input = strtotime($kor->vremeRezervacije); 
            $new_time = date("Y-m-d H:i:s", strtotime('+48 hours', $time_input));
            ?>
            <td><?php echo $new_time?></td>
            <?php 
                $daLiSuKupljene = $kor->kupljenoRezervisano;
                if($daLiSuKupljene == 1){?>
            <td>Karte su kupljene</td>
            <?php        
            }else{
            ?>
            <td><a class="btn btn-primary delete" data-id="<?=$kor->id_rezervacija?>" title="Otkazi rezervaciju">Otkazi rezervaciju</a></td>
            <?php }?>
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
                  
            }
        </script>
        </main>
<?php
include("views/footer.php");
?>