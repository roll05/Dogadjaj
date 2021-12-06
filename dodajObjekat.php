<?php 
include("views/head.php");
include("views/header.php");
?>

        <div class="container">
             <div class="row">
             <section id="dodajObjekat">
                    <div class="col-lg-4">
                    <h1 class="naslov">Dpdaj objekat</h1>
                    <hr class="hrNaslov"/>
                    <form action="php/upisObjekta.php" method="post">
                    <div class="form-row">
                    <div class="col">
                        <label>Naziv objekat </label>
                        <input type="text" class="form-control" name="nazivObjekta" id="nazivObjekta">
                        </div>
                        </div>
                        <div class="form-row">
                    <div class="col">
                        <label>Lokacija </label>
                        <input type="text" class="form-control" name="lokacija" id="lokacija">
                        </div>
                        </div>
                        <div class="form-row">
                    <div class="col">
                        <label>Broj telefona </label>
                        <input type="text" class="form-control" name="brojtelefona" id="brojtelefona">
                        </div>
                        </div>
                        <div class="form-row">
                    <div class="col">
                        <label>Avatar objekta </label>
                        <input type="file" class="form-control" name="avatar" id="avatar">
                        </div>
                        </div>
                        <div class="form-row">
                    <div class="col">
                        <label>Grad U kojem se nalazi</label>
                        <select class="form-control">
                            <option value='0'>Izaberite grad</option>
                            <?php
                            $upit = "select * from grad";
                            $rez = $konekcija->query($upit)->fetchAll();
                            foreach($rez as $grad):
                            ?>
                             <option value='<?=$grad->id_grad?>'><?=$grad->naziv?></option>
                             <?php endforeach;?>
                        </select></br>
                        </div>
                        </div>
                        <div class="form-row">
                    <div class="col">
                       <input type="submit" class="form-control" name="dodajObjekat" id="dodajObjekat" value="Dodaj objekat">
                        </div>
                        </div>
                            </form>
            </div>
     
</section>
<section id="dodajkategorijeulaznica">
                    <div class="col-lg-4">
                    <h1 class="naslov">Kategoriju ulaznica</h1>
                    <hr class="hrNaslov"/>
                    <form action="php/upisUlaznica.php" method="post">
                    <div class="form-row">
                    <div class="col">
                        <label>Naziv objekat </label>
                        <select class="form-control" id="objekat">
                            <option value='0'>Izaberite objekat</option>
                            <?php
                            $upit = "SELECT *
                            FROM   objekat 
                            WHERE  NOT EXISTS (SELECT id_objekat 
                                               FROM   objekatUlaznice 
                                               WHERE  objekat.id_objekat = objekatUlaznice.id_objekat)";
                            $rez = $konekcija->query($upit)->fetchAll();
                            foreach($rez as $objekat):
                            ?>
                             <option value='<?=$objekat->id_objekat?>'><?=$objekat->naziv?></option>
                             <?php endforeach;?>
                        </select>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="col">
                        <label>Kategorije ulaznica</label></br>
                        <table>
                        <?php 
                                $upit = "select * from ulaznice";
                                $rez = $konekcija->query($upit)->fetchAll();
                                foreach($rez as $ulaznice):
                                ?>
                               <tr><td><?=$ulaznice->kategorija?></td><td><input type="checkbox" class="checkboxUlaznice" name="ulaznice<?=$ulaznice->id_ulaznice?>" value="<?=$ulaznice->id_ulaznice?>"></td></tr>
                                <?php endforeach;?>
                                </table>
                                <label id="ulaznice"></label>
                        </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                       <input type="button" class="form-control" name="dodajObjekat" id="dodajUlaznice" value="Dodaj ulaznice">
                        </div>
                        </div>
                            </form>
                         <script>
                               $("#dodajUlaznice").click(function(){
                                var ulaznice = []
                                var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
                                var niz = [];
                                    for (var i = 0; i < checkboxes.length; i++) {
                                    ulaznice.push(checkboxes[i].value)
                                    }
                                var objekat = $("#objekat").val();
                                        if(objekat == 0){
                                            $("#objekat").css("border","1px solid red");
                                            niz.push("Izaberite objekat");
                                        }
                                        else{
                                            $("#objekat").css("border","1px solid green");
                                        }
                                        if(ulaznice.length == 0){
                                                $("#ulaznice").html("<span style='color:red'>Izaberite ulaznice za taj objekat</span>");
                                                niz.push("Izaberite Ulaznice");
                                        }
                                        else{
                                            $("#ulaznice").html("");
                                        }
                                        if(niz.length==0){
                                                $.ajax({
                                                            url: "php/dodajUlaznicu.php",
                                                            method: "post",
                                                            data: {
                                                                ulaznice:ulaznice,
                                                                objekat:objekat,
                                                                btnUlaznice:true
                                                            },
                                                            success: function (podaci) {
                                                                if (podaci == "") {
                                                                    alert("Uspesno ste upisali ulaznice za !")
                                                                    window.location = "index.php";
                                                                } else {
                                                                    alert(podaci);
                                                                    window.location = "index.php";
                                                                
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
                                                 });
                               
                        </script>
                         
                 </section>
            </div>
     </div>
</div>


<?php 
include("views/footer.php");
?>