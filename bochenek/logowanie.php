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
                    <li><a href="produkty.php">PRODUKTY</a></li>
                    <li><a href="ofirmie.php">O FIRMIE</a></li>
                    <li><a href="kontakt.php">KONTAKT</a></li>
                    <li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                    <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>
                </ul>
            </nav>



        </div>
    </header>

    <!--STERT HERE-->
    <div class="bg-login-register">
        <div class="wrapper">
            <form action="login.php" method="POST">
                <h1>Zaloguj się</h1>
                <div class="input-box">
                    <input type="email" placeholder="E-mail" id="emailLog" name="email" required>
                    <i class='bx bxs-user' ></i> <!--ikona usera-->
                    <!-- <i class='bx bxs-envelope'></i> ikona koperty -->
                </div>
                <span id="emailLogKomunikat"></span>


                <div class="input-box">
                    <input type="password" placeholder="Hasło" id="passwordLog" name="password" required>
                    <i class='bx bxs-lock-alt' ></i> <!--ikona klodki-->
                </div>
    
                <button type="submit" class="btn-login" id="submitLogBtn" >Zaloguj</button>
    
                <div class="register-link">
                    <p>Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a></p>
                </div>
            </form>
        </div>
    </div>













    <div class="footer">
        <div class="wrapper">
            <div class="footer-items">
                <div class="left">
                    <ul>
                        <li><a href="index.php">STRONA GŁÓWNA</a></li>
                        <li><a href="produkty.php">PRODUKTY</a></li>
                        <li><a href="ofirmie.php">O FIRMIE</a></li>
                        <li><a href="kontakt.php">KONTAKT</a></li>
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