<header id="header">
    <div class="cistac"></div>
    <div class="container">
        <div class="row">
<div class="topnav">
  <a class="active" href="index.php">Home</a>
  <a href="cinemas.php">Cinemas</a>
  <a href="">Contact</a>
  <a href="registracija.php">Registration</a>
    <div class="serch-container">

    </div>
     <?php if(!isset($_SESSION['korisnik'])):?>
    
  <div class="login-container">
    <form>
      <input type="text" placeholder="Username" id="mail" name="mail">
      <input type="password" placeholder="Password" id="psw" name="psw">
      <button type="button" class="btn btn-secondary" id="login" name="login" onclick="prijava()">Login</button>
    </form>
    <div class="cistac">
    <div class="popup" id="popup-1">
        <div class="overlay"></div>
        <div class="content">
        <div class="close-btn" onclick="togglePopup()">&times;</div>
        <h4>Unesite vase korisnicko ime ili email</h4>
        <form method="POST" action ="php/restartPassword.php">
        <input type="text" class="form-control resetpassword" id="text" name="text" ></br></br>
        <input type="submit" class="btn btn-secondary" id="resetujPassword" name="resetujPasswotd" value="Resetuj password">
     </form>
</div>
</div>
<a id="fpw" onclick="togglePopup()">Zaboravio sam lozinku</a>
     </div>
  </div>
  <script>
    function togglePopup(){
        document.getElementById("popup-1").classList.toggle("active");
    }
</script>
  <?php endif; ?>
<?php if(isset($_SESSION['korisnik'])):
  ?>
  <div class="login-container">
  <a href="php/logout.php">Odjavi se</a>
  
                            
                           
                            <?php

                                            $upit = "SELECT ime, prezime FROM korisnik WHERE id_korisnik = :id_korisnik";
                                            $priprema = $konekcija->prepare($upit);

                                            $id = $_SESSION['id_korisnik'];
                                            $priprema->bindParam(':id_korisnik',$id);

                                            $rez = $priprema->execute();

                                            if($rez){
                                            $korisnik = $priprema->fetch();
                                            echo "<a>". $korisnik->ime. " " . $korisnik->prezime ."</a>";
                                }
                                            ?>
                        </li>
                        <a href="rezervacije.php?idKorisnik=<?=$_SESSION['id_korisnik']?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
  <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
</svg></a>
                              </div>
                    <?php endif; ?>

</div>
</div>
</div>
</header>