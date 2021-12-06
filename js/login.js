function prijava() {

    var username = $("#mail").val();
    var password = $("#psw").val();

    var errors = new Array();

    var reUsername = /^(?!(.*[_].*){2,}$)(?!(.*[0-9].*){4,}$)(?=.{6,20}$)(?![_])[a-zA-Z0-9çÇ_]+(?<![_])$/;
    var rePassword = /^[A-z0-9]{8,}$/;

    if (!reUsername.test(username)) {
        errors.push("Niste dobro uneli username u dobrom formatu");
        document.querySelector("#mail").style.border = "1px solid red";
    }
    if (!rePassword.test(password)) {
        errors.push("Ne postoji korisnik sa ovom sifrom adresom");
        document.querySelector("#psw").style.border = "1px solid red";
    }

    if (errors.length != 0) {
        alert("Nisu dobro uneti parametri.");
    } else {
        $.ajax({
            url: "http://localhost/proba/php/login.php",
            method: "post",
            data: {
                username: username,
                password: password,
                btnLog: true
            },
            success: function (podaci) {
                if (podaci == "") {
                    alert("Uspesno ste se ulogovali!");
                    window.location = "index.php";
                }
                else {
                    
                    console.log(podaci);
                   // window.location = "index.php";
                }

            },
            error: function (xhr, statuss) {
                let status = xhr.status;
                if (status == 500) {
                    alert("Problem prilikom logovanja!");
                } else if (status == 400) {
                    alert("Nisu dobro uneti parametri!");
                }
                else {
                    window.location.href="index.php";
                    alert("greska" + statuss + status);
                }
            }

        })
    }
}
