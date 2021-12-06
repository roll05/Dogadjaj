<?php
include("views/head.php");
include("views/header.php");
	 if(isset($_SESSION['korisnik'])){
        if($_SESSION['korisnik']->id_uloga != 1){
            header("Location: index.php");
        }
    }
    else {
        $_SESSION['greska'] ="Niste ulogovani!";
        header("Location: index.php");
    }
?>
<main class="container">
    <div class="row">
        <h1 class="naslov">Dodaj dolazeci film</h1>
    </div>
    <hr class="hrNaslov"/>
    <div class="container">
        <div class="row">
    <div class="col-md-7 border border-sencondary rounded">
        <div>
            <label class="label"> * Sva polja su obavezna </label>
        </div>
    <form method="POST" action="php/addUcomingMovie.php" enctype="multipart/form-data">
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                <label class="ml-0"> Naziv Dogadjaja</label>
                <input type="text" class="form-control" id="nazivDogadjaja" name="nazivDogadjaja">
                </div>
            </div>
                <div class="form-row">
                            <div class="col">
                            <label class="ml-0">Datum premijere</label>
                            <input type="date" id="datum" name="datum">
                            </div>
                        </div>
                <div class="col">
                    <label class="ml-0"> Dodaj sliku </label><br>
                <input type="file" id="avatar" name="avatar" accept=".jpg, .png, .jpeg, .gif">
                </div>
                 
                <div class="col">
            <input type="submit" class="btn btn-secondary" id="btnUpis" name="btnUpis" value="Upiši"/>
            </div>
            </form>
            <div class="form-row" id="dodatnoPoljeUpis">
        
            </div>
        </div>
    </div>  
         
        <div class="col-md-5 border border-sencondary rounded">
                <h3>Dodaj sliku</h3>
            <hr/>
                <div>
                <label class="label"> * Sva polja su obavezna </label>
                </div>
                 <form method="POST" action="php/upisSlike.php" enctype="multipart/form-data">
    <div class="form-row">
                <div class="col">
                <label class="ml-0"> Dodaj sliku </label>
                <input type="file" class="form-control-file" id="fSlika" multiple="" name="fSlika[]" accept=".jpg, .png, .jpeg">
                </div>
            
            </div>
            <div class="form-row">
                <div class="col">
                <label class="ml-0"> Opis slike(alt) </label>
                <input type="text" class="form-control" id="alt" name="alt">
                </div>
            </div>
            <div class="col">
            <input type="button" class="btn btn-secondary" id="btnUpisSlike" name="btnUpisSlike" value="Upiši" />
            </div>
        </div>
    </form>
    </div>
     </main>




<?php 
include("views/footer.php");
?>