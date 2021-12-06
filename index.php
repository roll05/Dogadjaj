<?php
include("views/head.php");
$strana=0;
?>


<body>
<section id="meni">
    
<?php 
    include("views/header.php");
    
 if(isset($_SESSION['korisnik'])):
                if($_SESSION['korisnik']->id_uloga==1):?>
                 <div class="container">
                <div class="row border-top">
                    <nav class="nav ml-5">
                        <a class="nav-link" href="korisnici.php">Korisnici</a>
                        <a class="nav-link" href="dodajObjekat.php">Dodaj objekat</a>
                         <style>
                             .nav-link{
                                 padding-right:3px;
                                 margin-right:3px;
                             }
                         </style> 
                    </nav>
                </div>
                <?php endif;
                if($_SESSION['korisnik']->id_uloga==2):?>

                <?php 
                if($_SESSION['korisnik']->id_objekat==0){

                ?>
                   <div class="container">
                <div class="row border-top">
                    <div id='radnomesto'>
                    </div>
                    </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            var dd = "<form action ='php/ubdateblagajnik.php' method='post'><select name='radnomesto' id='radnomesto'>"
                                dd += "<option value ='0'>izaberite Radno mesto </option>";
                            <?php 
                                $upit1 = "Select * from objekat";
                                $rez1=$konekcija->query($upit1)->fetchAll();
                                 foreach($rez1 as $radnomesto):
                            ?>
                           dd +=  "<option value ='<?= $radnomesto->id_objekat?>'> <?= $radnomesto->naziv?> </option>";
                           <?php endforeach; ?>
                           dd += "<input type='submit' name='button' id='button'></input>";
                           dd += "</select>";
                           dd += "</form>";
                                    document.getElementById("radnomesto").innerHTML = dd;
                        })
                        </script>

                    <?php }else{?>
                        <style>
                             .nav-link{
                                 padding-right:3px;
                                 margin-right:3px;
                             }
                         </style>
                 <div class="container">
                <div class="row border-top">
                    <nav class="nav ml-5">
                        <a class="nav-link" href="dodajDogadjaj.php?objekat=<?=$_SESSION['korisnik']->id_objekat?>&idBlagajnik=<?=$_SESSION['korisnik']->id_korisnik?>">Dodaj dogadjaj</a>
                        <a class="nav-link" href="rezervacija.php?objekat=<?=$_SESSION['korisnik']->id_objekat?>&idBlagajnik=<?=$_SESSION['korisnik']->id_korisnik?>">Rezervacije</a>
                    </nav>
                </div>
                <?php }?>
                <?php endif;?>
                <?php endif;?>
                </div>

</section>

        
        <!-- End Preloader -->

        <!-- =========================
                 HOME
        ========================== -->
       
                    </div>
		<section id="home">
        <div class="content">
        <div class="sliders">
		 <?php 
         $danasnjiDatum = date("Y/m/d h:i:s");
         $datumZaDesetDana = date('Y-m-d', strtotime($danasnjiDatum. ' + 10 days'));
            $upit2 = "SELECT * FROM dogadjaj WHERE datum > '$danasnjiDatum' AND datum BETWEEN '$danasnjiDatum' AND '$datumZaDesetDana'";
            $rez2=$konekcija->query($upit2)->fetchAll();
            foreach($rez2 as $uncomingMovie):
        ?>
         <div>
			<div class="content">
                <div id="large-header" class="large-header" style="background-image:url('images/pattern.png'),url('<?=$uncomingMovie->urlAvatara?>'); background-size: 100% 100%;">
                    <canvas id="demo-canvas"></canvas>
                    <div id="countdown_dashboard" class="home-main container countdown_dashboard">
                        <div class="row">
                            <div class="logo">
                                <p>COMING SOON</p>
                                <p><?=$uncomingMovie->naziv?></p>
                            </div>
                        </div>
                        <div class="row">
                        <div id="countDown" class="countDown">
                            <!-- DAYS -->
                            <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                <div class="dash days_dash">
                                    <div id="days<?php echo $uncomingMovie->id_dogadjaj?>"></div>
                                    <span class="dash_title">Days</span>
                                </div>
                            </div>
                            <!-- HOURS -->
                            <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                <div class="dash hours_dash">
                                    <div id="hours<?=$uncomingMovie->id_dogadjaj?>"></div>
                                    <span class="dash_title">Hours</span>
                                </div>
                            </div>
                            <!-- MINUTES -->
                            <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                <div class="dash minutes_dash">
                                    <div id="minutes<?=$uncomingMovie->id_dogadjaj?>"></div>
                                    <span class="dash_title">Minutes</span>
                                </div>
                            </div>
                            <!-- SECONDS -->
                            <div class="col-md-3 col-sm-3 col-xs-6 dash-glob" data-scroll-reveal="enter bottom move 25px, after 0.3s">
                                <div class="dash seconds_dash">
                                    <div id="secunds<?=$uncomingMovie->id_dogadjaj?>"></div>
                                    <span class="dash_title">Seconds</span>
                                </div>
								</div>
                            </div>
                        </div> <!-- END ROW -->
                    </div> <!-- END COUNTDOWN -->
                </div> <!-- LARGE HEADER -->
            </div> <!-- END CONTENT -->
		</div>		
        
<?php endforeach;?>
</div>
</div>
<?php
$danasnjiDatum = date("Y/m/d h:i:s");
$datumZaDesetDana = date('Y-m-d', strtotime($danasnjiDatum. ' + 10 days'));
$upit3 = "SELECT * FROM dogadjaj WHERE datum > '$danasnjiDatum' AND datum BETWEEN '$danasnjiDatum' AND '$datumZaDesetDana'";
$rez3=$konekcija->query($upit3);
$rez3->execute();
$count = $rez3->rowCount();
if(!$count == 0):
$result = $rez3->fetchAll();
foreach($result as $datumi):

?>
<script>
   
    var days<?php echo $datumi->id_dogadjaj?> = document.getElementById("days<?php echo $datumi->id_dogadjaj?>");
                    var hours<?php echo $datumi->id_dogadjaj?> = document.getElementById("hours<?php echo $datumi->id_dogadjaj?>");
                    var minuts<?php echo $datumi->id_dogadjaj?> = document.getElementById("minutes<?php echo $datumi->id_dogadjaj?>");
                    var secunds<?php echo $datumi->id_dogadjaj?> = document.getElementById("secunds<?php echo $datumi->id_dogadjaj?>");
                    var trenutoVreme1 = new Date().getFullYear();
                    var datum<?php echo $datumi->id_dogadjaj?> = "<?php echo $datumi->datum?>";
                    var ocekivanoVreme<?php echo $datumi->id_dogadjaj?> = new Date(datum<?php echo $datumi->id_dogadjaj?>)
                    
                    var interval = setInterval(updateVreme,1000);
                    function updateVreme(){
                        var vreme1 = new Date();
                        var dif<?php echo $datumi->id_dogadjaj?> = ocekivanoVreme<?php echo $datumi->id_dogadjaj?> - vreme1;
                        
                        var d<?php echo $datumi->id_dogadjaj?> = Math.floor(dif<?php echo $datumi->id_dogadjaj?> / 1000 / 60 / 60 / 24);
                        var h<?php echo $datumi->id_dogadjaj?> = Math.floor(dif<?php echo $datumi->id_dogadjaj?> / 1000 / 60 / 60) % 24;
                        var m<?php echo $datumi->id_dogadjaj?> = Math.floor(dif<?php echo $datumi->id_dogadjaj?> / 1000 / 60) % 60;
                        var s<?php echo $datumi->id_dogadjaj?> = Math.floor(dif<?php echo $datumi->id_dogadjaj?> / 1000) % 60;
                    
                      
                        if (ocekivanoVreme<?php echo $datumi->id_dogadjaj?> > vreme1){
                            days<?php echo $datumi->id_dogadjaj?>.innerHTML = d<?php echo $datumi->id_dogadjaj?> < 10 ? '0' + d<?php echo $datumi->id_dogadjaj?> : d<?php echo $datumi->id_dogadjaj?>;
                        hours<?php echo $datumi->id_dogadjaj?>.innerHTML = h<?php echo $datumi->id_dogadjaj?> < 10 ? '0' + h<?php echo $datumi->id_dogadjaj?> : h<?php echo $datumi->id_dogadjaj?>;
                        minuts<?php echo $datumi->id_dogadjaj?>.innerHTML = m<?php echo $datumi->id_dogadjaj?> < 10 ? '0' + m<?php echo $datumi->id_dogadjaj?> : m<?php echo $datumi->id_dogadjaj?>;
                        secunds<?php echo $datumi->id_dogadjaj?>.innerHTML = s<?php echo $datumi->id_dogadjaj?> < 10 ? '0' + s<?php echo $datumi->id_dogadjaj?> : s<?php echo $datumi->id_dogadjaj?>;

                        }else{ 
                            clearInterval(interval);
                        days<?php echo $datumi->id_dogadjaj?>.innerHTML = "00";
                        hours<?php echo $datumi->id_dogadjaj?>.innerHTML = "00";
                        minuts<?php echo $datumi->id_dogadjaj?>.innerHTML = "00";
                        secunds<?php echo $datumi->id_dogadjaj?>.innerHTML = "00";
                        }
                
                    }

</script>
<?php endforeach;?>
<?php endif;?>
<script src="js/animated.js"></script>
</section>
<?php
        $strana;
            if(isset($_GET['strana'])) {
            $strana = ($_GET['strana'] - 1) * 10;
        }
       ?>
   <section id="dogadjaji">
       <div class="container">
           <div class="row" style="margin-top:10px">
           <div class="col-md-6">
         <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" method="POST" action="index.php">
        <input class="form-control form-control-sm ml-3 w-75" type="text" id="search" name="search" placeholder="Search" aria-label="Search">
           <button id="search-button" type="button" class="btn btn-primary">
           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
             </button>
             
                </form>
  
        </div>
        
              
                </div>
			<div class="row">	
           <?php
               $upit="SELECT * FROM dogadjaj limit $strana, 10";
                $rez=$konekcija->query($upit)->fetchAll();
                foreach($rez as $dogadjaj):
           ?>
          
           <script>
               $(document).ready(function(){
                var today = new Date().toISOString().slice(0, 10);
console.log(today);
var datumDogadjaja = "<?php echo $dogadjaj->datum?>";
 if(today > datumDogadjaja){
    $(".omot<?php echo $dogadjaj->id_dogadjaj?>").children().css("opacity", "0.5");
}
               });
</script>
               <div class="omot<?php echo $dogadjaj->id_dogadjaj?>"> 
               <div class="col-lg-4" style="float:left;text-align:center;">
                   <div class="col">
                   <img class="img-responsive img-rounded slika" style="margin-left:auto;margin-right:auto;" src="<?=$dogadjaj->urlAvatara?>">
                </div>
                <div class="col">
                <h4><?=$dogadjaj->naziv?></h4>
                <h6>Duzina trajanja <?=$dogadjaj->duzina?></h6>
                </div>
                <div class="col">
                <h4>Opis dogadjaja</h4>
                <?php
                $opis = $dogadjaj->opis;
                $sub=substr($opis,0,20);
                ?>
                <p><?=$sub." ..."?><p>
                </div>
                <div class="col">
                <h4>Datum odrzavanja</h4>
                <?php 
                $datum = $dogadjaj->datum;
                $changeDate = date("d.m.Y.", strtotime($datum));
                $datumZaLink = date("Y-m-d", strtotime($datum));
                $vremeZaLink = date("H:i:s", strtotime($datum));
                ?>
                <p><?=$changeDate. " godine."?><p>
                </div>
                <div class="col">
                <h4>Mesto odrzavanja</h4>
                <?php 
                    $id = $dogadjaj->id_objekat;
                    $upit1="select naziv, lokacija from objekat where id_objekat =$id ";
                    $rez1=$konekcija->query($upit1)->fetchAll();
                    foreach($rez1 as $objekat):?>
                <p><?=$objekat->naziv?><p>
                <p><?=$objekat->lokacija?><p>
                <?php endforeach;?>
                </div>
                <?php
                if(isset($_SESSION['korisnik'])):?>
                <div class="col dogadjaji">
                <button type="button" class="btn btn-secondary dogadjaj" ><a style="color:black;" href="dogadjaj.php?idDogadjaja=<?=$dogadjaj->id_dogadjaj?>&datum=<?php echo $datumZaLink;?>&vreme=<?php echo $vremeZaLink;?>">Pogledaj detaljnije</a></button>
               <?php if($_SESSION['korisnik']->id_uloga == 2 && $_SESSION['korisnik']->id_korisnik == $dogadjaj->id_blagajnik):?>
                <button type="button" class="btn btn-secondary delete" ><a style="color:black;" href="delete.php?idDogadjaja=<?=$dogadjaj->id_dogadjaj?>">Izbrisi dogadjaj</a></button>
                <?php endif;?>
				</div>
                <?php endif;?>
                </div>
                </div>
                <?php endforeach;?>
                </div>
                <div class="row m-0 p-0">
        <div class="col-md-12" style="text-align:center;">
            <ul style="list-style: none;padding-top:10px;">
                <?php
                $upit1 = "SELECT COUNT(*) as brPrikaza FROM dogadjaj";
                $rez1 = $konekcija->query($upit1)->fetch();
                $brPrikaza = $rez1->brPrikaza;
                $brLinkova = ceil($brPrikaza / 10);
                for($i=1; $i <= $brLinkova; $i++):?>
                    <li class="page-item" style="display:inline;"><a class="page-link" href="index.php?strana=<?=$i?>" style="color:#222"><?=$i?></a></li>
                <?php endfor;?>
                </ul>
                </div>
                </div>
				</div>
</section>


        
        <?php
include("views/footer.php");
?>
 <script>
$('.sliders').bxSlider({
        auto: true,
        pager: true,
        mode: 'fade',
        captions: true,
        speed: 2000
            });


        </script>