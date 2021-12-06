<?php 
include ("views/head.php");
include ("views/header.php");
?>

<main class="container">
    <div class="row">
        <h1 class="naslov">Registration / Log in</h1>
    </div>
    <hr class="hrNaslov"/>
    <div class="row">
    <div class="col-md-12">
            <h3>Registration</h3>
            <form method="POST">
                    <div class="form-row">
                        <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Ime" id="tbIme" name="tbIme">
                            <label class="label"> * Ime mora sadržati veliko pocetno slovo ostala slova treba da budu mala. </label>
                            
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Prezime" id="tbPrezime" name="tbPrezime">
                            <label class="label"> * Prezime mora sadržati veliko pocetno slovo ostala slova treba da budu mala. </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Korisničko ime" id="username" name="username">
                            <label class="label"> * Korisničko ime mora sadržati velika i mala slova i brojeve. </label>

                        </div>
                    </div>
                        <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Broj telefona" id="brTelefona" name="brTelefona">
                            <label class="label"> * Broj relefona mora biti u formatu +381. </label>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Ulica i broj" id="UlBroj" name="UlBroj">
                            <label class="label"> * Unesite Ulicu i broj.</label>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col">
                            <select id="grad" class="form-control" aria-label="Default select example">
                                <option value="0">Izaberite grad</option>
                        <?php 
                                $upit="SELECT * FROM grad";
                                $rez=$konekcija->query($upit)->fetchAll();
                                foreach($rez as $grad):
                            
                            ?>
                            <option value="<?=$grad->id_g?>"><?=$grad->naziv?></option>
                            
                            <?php endforeach; ?>
                                </select>
                                <label class="label"> * Izaberite grad u kojem zivite.</label>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col">
                            <input type="password" class="form-control" placeholder="Šifra" id="password" name="password">
                            <label class="label mb-0"> * Minimalno 8 karaktera, mora imati velika, mala slova i brojeve </label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                        <input type="text" class="form-control" placeholder="E-mail" id="email" name="email">
                    </div>
                    </div>
                    <div class="form-row" id="dodatnoPoljeReg">

                    </div>
                    <div class="form-row">
                        <script src="js/registracija.js"></script>
                        <input type="button" class="btn btn-secondary" id="btnReg" name="btnReg" value="Registruj se" onclick="konzola()"/>
                    </div>
                </form>
    </div>
        
    </div>
</main>


<?php
include ("views/footer.php");
?>