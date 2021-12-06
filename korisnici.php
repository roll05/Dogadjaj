<?php
 include("views/head.php");
 include("views/header.php");
if(isset($_SESSION['korisnik'])){
        if($_SESSION['korisnik']->id_uloga != 1){
            header("Location: index.php");
        }
    }
    ?>

<main class="container">
    <h1 class="naslov"> Korisnici </h1>
    <form method="post" action="korisnici.php">
    <select name="ddlistFilter" id="ddlistFilter"> 
    <option value="0">Sortiraj</option>
    <option value="1">A-Z</option>
    <option value="2">Z-A</option>
    <option value="3">Korisnici</option>
    <option value="4">Blagajnici</option>
</select>
<input type="submit" id="filter" name="filter" value="Primeni Filter" class="btn btn-xs btn-primary">
</form>
    <hr class="hrNaslov"/>
    <table class="table table-striped korisnici">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Ime</th>
            <th scope="col">Prezime</th>
            <th scope="col">Phone Number</th>
            <th scope="col">E-mail</th>
            <th scope="col">Uloga</th>
            <th scope="col">verification</th>
            <th scope="col">Edituj</th>
            <th scope="col">Obriši</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($_POST["filter"])){
            $ddlista = $_POST["ddlistFilter"];
            if($ddlista == 1){
                 $upit="SELECT * FROM uloga u INNER JOIN korisnik k ON u.id_uloga=k.id_uloga ORDER BY ime, prezime ASC";
            }elseif($ddlista == 2){
                 $upit="SELECT * FROM uloga u INNER JOIN korisnik k ON u.id_uloga=k.id_uloga ORDER BY ime, prezime DESC";
            }elseif ($ddlista == 3){
                $upit="SELECT * FROM uloga u INNER JOIN korisnik k ON u.id_uloga=k.id_uloga WHERE u.id_uloga = 3";
            }
            elseif ($ddlista == 4){
                $upit="SELECT * FROM uloga u INNER JOIN korisnik k ON u.id_uloga=k.id_uloga WHERE u.id_uloga = 2";
           }else{
            $upit="SELECT * FROM uloga u INNER JOIN korisnik k ON u.id_uloga=k.id_uloga";
                    
            }
        }else{
            $upit="SELECT * FROM uloga u INNER JOIN korisnik k ON u.id_uloga=k.id_uloga";
        }
        $rez=$konekcija->query($upit)->fetchAll();
        foreach($rez as $kor):
        ?>
        <tr>
            <th scope="row"><?=$kor->id_korisnik?></th>
            <td><?=$kor->ime?></td>
            <td><?=$kor->prezime?></td>
            <td><?=$kor->br_telefona?></td>
            <td><?=$kor->email?></td>
            <td><?=$kor->naziv?></td>
            <td><?=$kor->verification?></td>
            <td><a href="updateKorisnika.php?id=<?=$kor->id_korisnik ?>" title="Ubdate korisnika"  data-id="<?=$kor->id_korisnik ?>" class="btn btn-primary update">Update </a></td>
            <td><a class="btn btn-primary delete" data-id="<?=$kor->id_korisnik ?>" title="Izbriši korisnika">Delete</a></td>
        <script>
            window.onload=function () {
                $(".delete").click(function(){
                    let id=$(this).data('id');

                    $.ajax({
                        method:"POST",
                        url:"http://localhost/proba/php/deleteKorisnik.php",
                        data:{
                            id:id,
                            dugme:true
                        },
                        success: function () {
                        alert("Uspesno ste izbrisali korisnika");
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
            })}
        </script>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>