<!doctype html>
<?php
    session_start();
?>
<html lang="pl">

<head> 
    <!--META-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>piekarniabochenek.pl</title>

    <!--Link Style-->
	<link rel="StyleSheet" type="text/css" href="styles/style.css">
    <link rel="StyleSheet" type="text/css" href="styles/login-style.css">

    <!--Link Fonts - Roboto (regular, medium, bold, black)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!--Link Icons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    
    <!-- <script>
        setTimeout(function() {
            // Po 4 sekundach przekieruj użytkownika na inną stronę
            window.location.href = "index.php";
        }, 4000); // 4000 milisekund (czyli 4 sekundy)
    </script> -->



</head>

<body>
    <header>
        <div class="wrapper">
            <a href="index.php" id="logo">
                <img src="images/logo-bochenek.svg" alt="logo-bochenek">
            </a>

            <nav>
                <a href="#" id="menu-icon">
                    <div class="burger-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                      </div>
                </a>

                <ul>
                    <li><a href="#">PRODUKTY</a></li>
                    <li><a href="#">O FIRMIE</a></li>
                    <li><a href="#">KONTAKT</a></li>
                    <li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                    <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>
                </ul>
            </nav>



        </div>
    </header>

    <!--STERT HERE-->
    <div class="bg-login-register">
        <div class="wrapper" id="zalogowano">
            <h1>Wystąpił błąd</h1>
        </div>
    </div>



    <div class="footer">
        <div class="wrapper">
            <div class="footer-items">
                <div class="left">
                    <ul>
                        <li><a href="index.php">STRONA GŁÓWNA</a></li>
                        <li><a href="#">PRODUKTY</a></li>
                        <li><a href="#">O FIRMIE</a></li>
                        <li><a href="#">KONTAKT</a></li>
                        <li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                        <li><a href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>
                    </ul>
                </div>
        
                <div class="right">
                    <hf>SKONTAKTUJ SIĘ Z NAMI BEZPOŚREDNIO NA:</hf>
                    <p>piekarnia-bochenek@gmail.com <br> tel. 123 456 789 </p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>

</body>





</html>