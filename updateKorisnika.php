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
<?php 
if(isset($_GET["id"])){
	
	$idkorisnika = $_GET["id"];
	$upit = "SELECT * FROM korisnik WHERE id_korisnik = $idkorisnika";
	$rez=$konekcija->query($upit)->fetch();
	?>

	<main class="container ubdateKorisnik" style="text-align:center;">
    <h1 class="naslov"> Update korisnika </h1>
    <hr class="hrNaslov"/>
 
    <form method="post" action="php/updateKorisnik.php?idkorisnika=<?=$idkorisnika?>">
    <table>
        
            <?php
            foreach ($rez as $item => $k):
            ?>
         
            <tr><td style="text-align:left;"> <?=$item?></td><td><input type="text" id="<?=$item?>" name="<?=$item?>" value="<?=$k?>"></tr>
         
            <?php
            endforeach;
            ?>
           
           <tr> <td > <input type="submit" class="btn btn-secondary" value="Izmeni"> </td></tr>
        
    </table>
    </form>
    <script>
        $(document).ready(function(){
            
        $("#id_korisnik").prop("readonly", true);
         $("#vkey").prop("readonly", true);
        $("#password").prop("readonly", true);


		})


    </script>
</main>
	<?php
}
?>