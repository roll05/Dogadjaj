<!-- =========================
                 CONTACT
        ========================== -->

        <section id="contact" class="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h4>Ostani u kontaktu</h4>
                        <div class="line-separate line-white text-center"><span></span></div>
                        <p></p>
                    </div> <!-- end Our Location -->
                </div> <!-- end row -->
                <!-- CONTACT FORM -->
                <div id="cformSuccessMsg" style="display: none;" class="confirm-message"></div>
                <form id="" name="contactForm">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-lg-offset-2 col-md-offset-2">
                        <?php 
                            if(isset($_SESSION['korisnik'])){
                            ?>
                            <input class="" type="text" name="name" id="name" value="<?php echo $_SESSION['korisnik']->ime ?>" placeholder="Name" />
                        </div> <!-- end Name -->
                        <div class="col-lg-4 col-md-4">
                           
                            <input class="" type="text" name="email" id="email" value="<?php echo $_SESSION['korisnik']->email?>" placeholder="Email" />
                            <script>
                                $(document).ready(function(){
                                    $("#contact_email").prop( "disabled", true );
                                $("#contact_name").prop( "disabled", true );  
                                });
                                </script>
                            <?php
                            }else{?>
                             <input class="" type="text" name="name" id="name"  placeholder="Name" />
                        </div> <!-- end Name -->
                        <div class="col-lg-4 col-md-4">
                            <input class="" type="email" name="email" id="email"  placeholder="Email" />
                            <?php
                            }?>
                        </div> <!-- end Email -->
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-lg-offet-2 col-md-offset-2">
                            <textarea name="message" id="message" placeholder="Message"></textarea>
                        </div>
                    </div> <!-- end Message -->
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="text-right">
                                <input type="button" name="cocontact_submit_btnntactBtn" class="btn" id="cocontact_submit_btnntactBtn" value="Posalji e-mail">
                            </div>
                        </div>
                    </div> <!-- end button -->
                </form><!-- END FORM -->
            </div> <!-- end container -->
        </section> <!-- end Contact -->
        <script>
        $(document).ready(function(){
                $("#cocontact_submit_btnntactBtn").click(function(){
                 var ime = $("#name").val();
                 var email = $("#email").val();
                 var poruka = $("#message").val();
                var error = [];
                var reEmail=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(poruka == ''){
                    error.push("Molim vas unestie poruku koju zelite da posaljete");
                }
                if(!reEmail.test(email)){
                    error.push("Molim vas unestie validan Email");
                }
                if(error.length == 0){
                 $.ajax({
                                url: "php/sendEmail.php",
                                method: "post",
                                data: {
                                    email: email,
                                    ime: ime,
                                    poruka:poruka,
                                    btnReg:true
                                },
                                success: function (podaci) {
                                    if (podaci == "") {
                                        alert("Uspesno ste poslali email!")
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
                                        alert("Nije moguce promeniti sifru ovom korisniku,kontaktirajte administratora za vise informacija");
                                    }
                                    else {
                                        alert("greska" + statuss + status);
                                    }
                                }

                            });
                        }



                })
            })
        </script>
        <!-- =========================
                 FOOTER
        ========================== -->

        <footer class="footer">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="social list-inline">
                            <li class="social-btn" id="fb"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="social-btn" id="tw"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="social-btn" id="tbl"><a href="#"><i class="fa fa-tumblr"></i></a></li>
                            <li class="social-btn" id="pin"><a href="#"><i class="fa  fa-pinterest"></i></a></li>
                            <li class="social-btn" id="flk"><a href="#"><i class="fa  fa-flickr"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
            
        <!-- JAVASCRIPTS -->
        <script src="js/jquery.bxslider.min.js"></script>
        <script src="js/jquery.bxslider.js"></script>
        <script src="js/jquery.lwtCountdown-1.0.js"></script>
        <script src="js/jquery.stellar.min.js"></script>
        <script src="js/jquery.nicescroll.min.js"></script>
        <script src="js/login.js"></script>
       
	</body>
</html>