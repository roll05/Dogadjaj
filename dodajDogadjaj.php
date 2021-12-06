<?php
include("views/head.php");
include("views/header.php");
?>

        <div class="container">
             <div class="row">
             <section id="dodajDogadjaj">
            <div class="col-lg-4">
            <h1 class="naslov">Dodaj dogadjaj</h1>
            <hr class="hrNaslov"/>
            <form action="php/upisDogadjaja.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="idBlaganika" name="ididBlaganika" value="<?php echo $_GET['idBlagajnik']?>">
                 <div class="form-row">
                <div class="col">
                <label>Naziv Dogadjaja </label>
                <input type="text" class="form-control" name="nazivDogadjaja" id="nazivDogadjaja">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                <label>Duzina trajanja(u minutima)</label>
                <input type="text" class="form-control" name="duzinaDogadjaja" id="duzinaDogadjaja">
                </div>
                </div><div class="form-row">
                        <div class="col">
                <label>Avatar</label>
                <input type="file" class="form-control" name="avatarDogadjaja" id="avatarDogadjaja">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                <label>lokacija</label>
                <input type="text" class="form-control" name="lokacija" id="lokacija">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                <label>Mesto odrzavanja</label>
                <input type="text" class="form-control" name="mestoOdrzavanja" id="mestoOdrzavanja">
                <input type="hidden" name="idmestoOdrzavanja" id="idmestoOdrzavanja" value="<?php echo $id= $_GET['objekat'];?>">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                <label>Datum odrzavanja</label>
                <input type="datetime-local" class="form-control" name="datumOdrzavanja" id="datumOdrzavanja">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                <label>Opis dogadjaja</label>
                <textarea class="form-control" name="opisDogadjaja" id="opisDogadjaja"></textarea>
                </div>
                </div>
                <div class="form-row">
                <div class="col">
                <label>Maksimalan broj ulaznica koje jedan korisnik moze da rezervise za ovaj dogadjaj</label>
                <input type="text" class="form-control" name="maxBrojRezervacija" id="maxRezervacija">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                    </br>
                <input type="submit" class="form-control" name="dodajDogadjaj" id="dodajDogadjaj"  Value="Dodaj dogadjaj">
                </div>
                </div>
                </form>
            </div>
</section>
<?php
        $id= $_GET['objekat'];
        $upit = "select naziv, lokacija from objekat where id_objekat = $id";
        $rez=$konekcija->query($upit)->fetchAll();
        foreach($rez as $nazivObjekta):
?>
<script>
        var nazivObjekta = "<?php echo $nazivObjekta->naziv?>";
        var lokacija = "<?php echo $nazivObjekta->lokacija?>";
        $("#mestoOdrzavanja").val(nazivObjekta);
        $("#lokacija").val(lokacija);
        $("#mestoOdrzavanja").attr('disabled','disabled');
        $("#lokacija").attr('disabled','disabled');
        </script>
<?php endforeach;?>

<!-- DODAJ ULAZNICE ZA FILM -->


<section id="DodajUlazniceZaFilm">
            <div class="col-lg-4">
            <h1 class="naslov">Dodaj cenu ulaznice</h1>
            <hr class="hrNaslov"/>
            <form method="POST" action="php/dodajUlaznice.php">
            <div class="form-row">
                <div class="col">
                <label>Dodaj ulaznice za dogadjaj</label>
        
                 <select class="form-control" name="dogadjaj" id="dogadjaj">
                 <option value='0'>Izaberite dogadjaj</option>
                 <?php
                 $danas = date("Y-m-d h:i:s");
               
                $id= $_GET['idBlagajnik'];
                $upit = "SELECT * from dogadjaj where id_blagajnik = $id AND datum > '$danas'";
                $rez=$konekcija->query($upit)->fetchAll();
                foreach($rez as $dogadj):
                ?>
                 <option value='<?=$dogadj->id_dogadjaj?>'><?=$dogadj->naziv?></option>

                <?php endforeach;?>
                </select>
                </div>
                </div>
                <div id="ulaznice">
                <?php
                $id= $_GET['objekat'];
                $upit = "SELECT * from objekatUlaznice ou inner join ulaznice u on ou.id_ulaznice = u.id_ulaznice where ou.id_objekat = $id";
                $rez=$konekcija->query($upit)->fetchAll();
                foreach($rez as $ulaznice):
                ?>
                <div class="form-row">
                        <div class="col">
                <label><?=$ulaznice->kategorija?></label>
                <input type="hidden"  name="idobjekatUlaznice" value="<?php echo $ulaznice->id_objekatUlaznice?>">
                <input type="text" class="form-control" name="cenaUlaznice"  placeholder="unesite cenu za ulaznicu">
                <input type="text" class="form-control" name="kolicina" class="kolicina" placeholder="unesite kolicinu ulaznica">
                </div>
                </div>
                <?php endforeach;?>
               
                <div class="form-row">
                        <div class="col">
                    </br>
                <input type="button" class="form-control" name="dodajUlaznice" id="dodajCenu"  Value="Dodaj cenu za ulaznice">
                </div>
                </form>
                </div>
                </div>
                </section> 
                <script>
                function Sakri (){
                         document.getElementById("ulaznice").style.visibility = 'hidden';
                         $("#dogadjaj").mouseleave(function() {
                                var dogadjaj = $("#dogadjaj").val();
                                if(dogadjaj == 0){
                                        $("#ulaznice").css("visibility","hidden");
                                }else{
                                        $("#ulaznice").css("visibility","visible");
                                }
                                
                        });
                }
                Sakri();
                $("#dodajCenu").click(function(){
                 var idObjekatUlaznice = [];
                var cenaUlaznice = [];
                var kolicina = [];
                var error = [];
                var idDogadjaj = $("#dogadjaj").val();
               var cena = document.getElementsByName("cenaUlaznice");
               var kol = document.getElementsByName("kolicina")
               var id_objekatUlaznice = $("[name='idobjekatUlaznice']");
               for(var i = 0; i< id_objekatUlaznice.length; i ++){
                      
                idObjekatUlaznice.push(id_objekatUlaznice[i].value);
               }
               
               for(var i = 0; i< cena.length; i ++){
                       if(cena[i].value==''){
                        error.push("Unesite validnu cenu za tu kategoriu ulaznica!")
                       }else{
                        cenaUlaznice.push(cena[i].value);
                       }
               }
               for(var i = 0; i< kol.length; i ++){
                if(kol[i].value==''){
                        error.push("Unesite validnu kolicinu za tu kategoriu ulaznica!")
                       }else{
                        kolicina.push(kol[i].value);     
                       }
               }
               var kol = idObjekatUlaznice.length;
               if(idObjekatUlaznice.length == cenaUlaznice.length ){
               $.ajax({
                                                            url: "php/dodajUlaznice.php",
                                                            method: "post",
                                                            data: {
                                                                idObjekatUlaznice:idObjekatUlaznice,    
                                                                cenaUlaznice:cenaUlaznice,
                                                                idDogadjaj:idDogadjaj,
                                                                kolicina:kolicina,
                                                                btnUlaznice:true
                                                            },
                                                            success: function (podaci) {
                                                                if (podaci == "") {
                                                                    alert("Uspesno ste upisali ulaznice za !")
                                                                    window.location = "dodajobjekat.php";
                                                                } else {
                                                                    alert(podaci);
                                                                    window.location = "dodajobjekat.php";
                                                                
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
                        }else{

                             alert("Proverite da li ste sve popunili kako treba");
                         }
                
                })      
                </script>  
                <section id="DodajSlikeProslogDogadjaja">
            <div class="col-lg-4">
            <h1 class="naslov">Dodaj slike dogadjaja</h1>
            <hr class="hrNaslov"/>
            <form method="POST" action="php/dodajSlike.php" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col">
                <label>Dodaj Slike sa dogadjaja</label>
        
                 <select class="form-control" name="dogadjaj" id="dogadjaj" >
                 <option value='0'>Izaberite dogadjaj</option>
                 <?php
                 $danas = date("Y-m-d h:i:s");
               
                $id= $_GET['idBlagajnik'];
                $upit = "SELECT * from dogadjaj where id_blagajnik = $id AND datum < '$danas'";
                $rez=$konekcija->query($upit)->fetchAll();
                foreach($rez as $dogadj):
                ?>
                 <option value='<?=$dogadj->id_dogadjaj?>'><?=$dogadj->naziv?></option>

                <?php endforeach;?>
                </select>
                </div>
                </div>
                
                <div class="form-row">
                        <div class="col">
                <label></label>
                <input type="file" class="form-control" name="Slika[]" multiple="" id="Slika">
                </div>
                </div>
                <div class="form-row">
                        <div class="col">
                    </br>
                <input type="submit" class="form-control" name="UnesiSlike" id="UnesiSlike"  Value="Unesi slike">
                </div>
                </div>
                </form>
                
                </div>
                </section> 
                
                </div>
</div>
<?php
include("views/footer.php");
?>