<?php 
include("views/head.php");
include("views/header.php");
if(!isset($_SESSION['korisnik'])){
    header("Location: ../index.php");
}else{
?>
<?php
 $today = date("Y-m-d h:i:s");
 $datumIzLinka= $_GET['datum'];
 $vremeIzLinka = $_GET['vreme'];
 $datumZaPoredjenje =$datumIzLinka . " " . $vremeIzLinka;
 

 if( $today < $datumZaPoredjenje ){
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php
        
            $idDogadjaja = $_GET['idDogadjaja'];
            
            $upit = "SELECT * FROM dogadjaj  WHERE id_dogadjaj=$idDogadjaja";
            $rez = $konekcija -> query($upit)->fetchAll();
            foreach($rez as $dogadjaj):
            ?>
             <img src="<?=$dogadjaj->urlAvatara?>" width="100%" height="auto" class="img-fluid" alt="Responsive image">
             <div class="col">
                 <h1><?=$dogadjaj->naziv?></h1>
            </div>
            <div class="col">
                <label>Datum i vreme odrzavanja:</label>
            <?php 
                $tm ='';
                $datum = $dogadjaj->datum;
                $changeDate = date("d-m-Y H:i A" , strtotime($datum))
                ?>
                 <h5><?=$changeDate?></h5>
                 <?php 
                 $idObjekat =  $dogadjaj->id_objekat;
                 $upit="SELECT naziv,lokacija FROM objekat WHERE id_objekat = $idObjekat";
                 $rez = $konekcija -> query($upit)->fetchAll();
                 foreach($rez as $objekat):
                 ?>
                 <label>Mesto odrzavanja <?=$objekat->naziv?> lokacija <?=$objekat->lokacija?> </label>
                 <?php endforeach;?>
            </div>
            <div class="col">
                <label>Opis</label>
                 <h5><?=$dogadjaj->opis?></h5>
            </div>
            <div class="col"><?php
            $idDogadjaja = $_GET['idDogadjaja'];
                $idKorisnik = $_SESSION['korisnik']->id_korisnik;
                $upit = "SELECT  SUM(kolicinaRezervisanihKarata) as kolicina FROM rezervacija r INNER JOIN cenaulaznicadogadjaja cud ON r.id_cena=cud.id_cena INNER JOIN objekatulaznice ou ON cud.id_objekatUlaznice = ou.id_objekatUlaznice  WHERE id_korisnik = $idKorisnik AND id_dogadjaj = $idDogadjaja "; 
                $rez = $konekcija -> query($upit)->fetch();
                foreach($rez as $kol){
                    $kolicina = $kol;
                }
               
                $upit = "SELECT maxBrojRezervacija,datum, naziv  FROM dogadjaj WHERE id_dogadjaj = $idDogadjaja"; 
                $rez = $konekcija -> query($upit)->fetchAll();
                foreach($rez as $dogadjaji){
                    $maxBrojRezervacija = $dogadjaji->maxBrojRezervacija;
                    $datum = $dogadjaji->datum;
                    $naziv = $dogadjaji->naziv;
                }
                $time_input = strtotime($datum); 
                $new_time = date("Y-m-d H:i:s", strtotime('-48 hours', $time_input));
                $today = date("Y-m-d h:i:s");
                if($kolicina >= $maxBrojRezervacija){?>
                <p>Vec ste rezervisali maksimalan broj karata za ovaj dogadjaj.Ukoliko niste otisli do glagajne da ih podignete molimo Vas uradite sto pre.Imate 48h od trenutka rezervacije.Hvala na razumevanju<p>
                <?php
              
                }elseif($new_time < $today){
                ?>
                <p>Rezervacije za <?php echo $naziv;?> su prosle.Mozete pogledati neke druge dogadjaje klikom na <a href="index.php"><b>OVDE</b><a></p>
                <?php

                }else{
                ?>
                <div id='seat'>
                <h3>Karte za rezervaciju</h3>
                <div class="movie-container">
                <select id="ulaznice">
                    <option value="0">Izaberite Ulaznicu</option>
                <?php 
                $upit = "SELECT * FROM cenaulaznicadogadjaja cud INNER JOIN objekatulaznice ou ON ou.id_objekatUlaznice = cud.id_objekatUlaznice INNER JOIN ulaznice u ON u.id_ulaznice = ou.id_ulaznice WHERE id_dogadjaj = $idDogadjaja";
                $rez = $konekcija -> query($upit)->fetchAll();
                 foreach($rez as $ulaznice):
                ?>
                <option value="<?=$ulaznice->id_ulaznice?>"><?=$ulaznice->kategorija?></option>
                <?php endforeach;?>
                 </select>
                 </div>
                <form>
                <input type = "hidden" id="korisnik" value = "<?php echo $_SESSION['korisnik']->id_korisnik?>" name = "korisnik">
                
                 </form>
    
    <ul class="showcase">
      <li>
        <div class="seat"></div>
        <small>N/A</small>
      </li>

      <li>
        <div class="seat selected"></div>
        <small>Selected</small>
      </li>

      <li>
        <div class="seat occupied"></div>
        <small>Occupied</small>
      </li>
    </ul>

    <div class="container sedista">
    <div>
<script>
   var maxBrojRezervacija,cena,kategorija,kolicina,idcena;
 $("#ulaznice").mouseleave(function() {
                            ulaznice = $("#ulaznice").val();
                            idDogadjaja = "<?php echo $_GET['idDogadjaja'];?>";
                            if(ulaznice == 0){
                                alert("Molimo Vas izaberite ulaznicu za koju zelite da rezervisete kartu");
                            }else{
                            $.ajax({
                                                            url: "php/vratiPodatke.php",
                                                            method: "post",
                                                            data: {
                                                                idDogadjaja:idDogadjaja,
                                                                ulaznice:ulaznice,    
                                                                btnUlaznice:true
                                                            },
                                                            success: function (podaci) {
                                                                if (podaci == "") {
                                                                    alert("Doslo je do greske");
                                                                } else {
                                                                    
                                                                    var json_obj = jQuery.parseJSON(podaci);
                                                                    console.log(json_obj);
                                                                    idcena = json_obj[0]['id_cena'];
                                                                    maxBrojRezervacija = json_obj[0]['maxBrojRezervacija'];
                                                                     cena = json_obj[0]['cena'];
                                                                    kategorija = json_obj[0]['kategorija'];
                                                                    kolicina = json_obj[0]['kolicina'];
                                                                    
                                                                    var ispis =  "";
                                                                    for(var i = 0; i < kolicina; i++){
                                                                        if(kolicina < 50){
                                                                        if(i%10==0){
                                                                            ispis += "</div><div class='row raw'>";
                                                                            ispis += "<div><p hidden>A"+i+"</p><div class='seat'></div></div>";
                                                                        }else{
                                                                            ispis += "<div><p hidden>A"+i+"</p><div class='seat'></div></div>";
                                                                        }
                                                                        }else if(kolicina > 50){
                                                                            if(i%30===0){
                                                                            ispis += "</div><div class='row raw'>";
                                                                            ispis += "<div><p hidden>A"+i+"</p><div class='seat'></div></div>";
                                                                        }else{
                                                                            ispis += "<div><p hidden>A"+i+"</p><div class='seat'></div></div>";
                                                                        }
                                                                        }else if(kolicina > 100){
                                                                            if(i%80===0){
                                                                            ispis += "</div><div class='row raw'>";
                                                                            ispis += "<div><p hidden>A"+i+"</p><div class='seat'></div></div>";
                                                                        }else{
                                                                            ispis += "<div><p hidden>A"+i+"</p><div class='seat'></div></div>";
                                                                        }
                                                                        }
                                                                    }
                                                                    
                                                                     ispis += "</div>";
                                                                     ispis += "<input type='button' name='rezervisi' id='rezervisi' value='Rezervisi karte' onclick='rezervisi()' style='margin-top:10px;margin-bottom:10px;color:black;'>";
                                                                    ispis += "<p class='text'>";
                                                                    ispis += " Izabrali ste <span id='count'>0</span> sedista i to bi bilo <span id='total'>0</span> din.";
                                                                    ispis += "</p>";
                                                                    $(".sedista").html(ispis);
                                                                }

                                                            },
                                                            error: function (xhr, statuss) {
                                                                let status=xhr.status;
                                                                if(status==500){
                                                                    alert("greska na serveru");
                                                                }
                                                                else if(status==404){
                                                                    alert("Nepostoji stranica");
                                                                }
                                                                else {
                                                                    alert("greska" + statuss + status);
                                                                }
                                                            }

                                                        });
                            }
                
                })      
                const container = document.querySelector('.sedista');
                
        // Seat click event
        function updateSelectedCount() {
            const count = document.getElementById('count');
                const total = document.getElementById('total');
             var brojSedista = $('.selected').length;
            var selectedSeatsCount = brojSedista-1;
            count.innerText = selectedSeatsCount;
            total.innerText = selectedSeatsCount * cena;
            }

        container.addEventListener('click', (e) => {
        if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
            e.target.classList.toggle('selected');
            updateSelectedCount();
        }
        });

           function rezervisi(){
               var idKorisnik = <?php echo $_SESSION['korisnik']->id_korisnik?>;
                var error;
                var niz = [];
                var sedista = $('.selected');
             var brojSedista = $('.selected').length;
             for(var i = 1; i<brojSedista; i++){
                  niz.push(sedista[i].previousSibling.innerText);
             }
             nizToString = niz.toString();
             console.log(nizToString);
             if(brojSedista>maxBrojRezervacija){
                 alert("Maksimalan broj rezervacija je "+maxBrojRezervacija);
                error.push("Prevelik broj rezervacija");
             }
             $.ajax({
                          url: "php/rezervacija.php",
                               method: "post",
                             data: {
                                idKorisnik:idKorisnik,
                                nizToString:nizToString, 
                                idcena:idcena,
                                brojSedista:brojSedista,
                             btnRezervacija:true
                                },
                         success: function (podaci) {
                             if (podaci == "") {
                             alert("Doslo je do greske");
                             } else {
                                console.log(podaci);
                                 alert("Vase rezervacije su poslate");
                             }
                             },
                            error: function (xhr, statuss) {
                                  let status=xhr.status;
                                            if(status==500){
                             alert("greska na serveru");
                                        }
                                     else if(status==404){
                                     alert("Nepostoji stranica");
                                     }
                                 else {
                                         alert("greska" + statuss + status);
                                    }
                                 }

                                                        });
                            }
          
           
     
    </script>
      
    </div>
                 </div>
				 </div>




    
                 <?php }?>

                 <script>
                function upisi(){
                    <?php
                        $idDogadjaja = $_GET['idDogadjaja'];
                        $upit = "SELECT maxBrojRezervacija FROM dogadjaj WHERE id_dogadjaj =$idDogadjaja";
                        $rez = $konekcija -> query($upit)->fetch();
                        foreach($rez as $max):
                    ?>
                    var maxRezervacija = "<?php echo $max?>";
                    <?php endforeach;?>
                    var kolicina = $("#kolicina").val();
                    var idCena = $("#cenaId").val();
                    var korisnikid = $("#korisnik").val();
                    var idUlaznice = $("#idUlaznice").val();
                    var idDogadjaja = $("#idDogadjaja").val();
                    if(kolicina>maxRezervacija){
                        alert("Nije moguce rezervisati toliko karata!")
                    }else{
                        $.ajax({
                                                            url: "php/rezervacija.php",
                                                            method: "post",
                                                            data: {
                                                                kolicina:kolicina,
                                                                idCena:idCena, 
                                                                korisnikid:korisnikid,  
                                                                idUlaznice:idUlaznice,
                                                                idDogadjaja:idDogadjaja,
                                                                btnRezervacija:true
                                                            },
                                                            success: function (podaci) {
                                                                if (podaci == "") {
                                                                    alert("Doslo je do greske");
                                                                } else {
                                                                   console.log(podaci);
                                                                    var json_obj = jQuery.parseJSON(podaci);
                                                                    alert("Uspesno ste rezervisali karte za "+json_obj[0]['kategorija']+" Molimo Vas da odete na blagajnu "+json_obj[0]['naziv']+" Kako bi platili karte i podigli iste.Rezervacije traju 48 h od trenutka rezervacije");
                                                                    location.reload();
                                                                }

                                                            },
                                                            error: function (xhr, statuss) {
                                                                let status=xhr.status;
                                                                if(status==500){
                                                                    alert("greska na serveru");
                                                                }
                                                                else if(status==404){
                                                                    alert("Nepostoji stranica");
                                                                }
                                                                else {
                                                                    alert("greska" + statuss + status);
                                                                }
                                                            }

                                                        });

                    }

                }


                 </script>
            </div>
                   



<?php endforeach;?>
            </div>
    </div>
</div>
<?php }else {  ?>
    <div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php

        $idDogadjaja = $_GET['idDogadjaja'];
            
        $upit = "SELECT naziv FROM dogadjaj  WHERE id_dogadjaj=$idDogadjaja";
        $rez = $konekcija -> query($upit)->fetch();
        foreach($rez as $dogadjaj):
?>
        <h1><?=$dogadjaj?></h1>
        <h3>Malo slika sa <?=$dogadjaj?>-a</h3>
<?php
        endforeach;
        ?>
<div id="gg-screen"></div>
<div class="gg-box">
<?php
$idDogadjaja = $_GET['idDogadjaja'];
            
$upit = "SELECT * FROM slike  WHERE id_dogadjaj=$idDogadjaja";
$rez = $konekcija -> query($upit)->fetchAll();
foreach($rez as $slike):
?>
  <div class="gg-element">
    <img src="<?=$slike->url?>" alt="<?=$slike->alt?>">
  </div>
<?php endforeach; ?>
</div>
<div class="row" style="margin-top:15px;">
            <div class="col-md-12 komentar">
            
				
                <div class="form-group">
                <form method="post" action="php/komentar.php">
                    <div class="form-row">
                    
                        <input type="hidden" name="dogadjaj" value="<?=$id?>"/>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3" placeholder="Vas komentar..."></textarea>
                    </div>
                    <div class="form-row">
                        <input type="submit" class="btn btn-secondary" id="btnKomentar" style="margin-top:15px;float;" name="btnKomentar" value="Komentarisi">
                    </div>
                </form>
                </div>
            </div>
        </div>
        
       
        
        <?php

        $upit3="SELECT * FROM komentar k INNER JOIN korisnik kor ON k.id_korisnik=kor.id_korisnik 
                                        WHERE id_dogadjaj=$id ORDER BY datum DESC";
        $rez3=$konekcija->query($upit3)->fetchAll();
        foreach ($rez3 as $item) :
        ?>
        <div class="row mb-3">
            <div class="col-md-3 komentar">
                <table>
                    <tr>
                        <td><b><?=$item->ime?> <?=$item->prezime?></b></td>
                        
                    </tr>
                    <tr>
                        <td colspan="2"><b><?=$item->datum?></b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-9 komentar">
                <div class="col pt-2">
                            <p><b><?=$item->komentar?></b></p>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="js/grid-gallery.js"></script>
<?php
 }
?>
<?php
include("views/footer.php");
}              
?>