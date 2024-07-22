<!doctype html>
<?php
    session_start();

    // ustawienie maksymalnego czasu sesji - na razie OFF
    //$_SESSION['session_start_time'] = time();


    // ------------- Sprawdzenie ile czasu aktywnej sesji zostalo -------------

    // if (isset($_SESSION['session_start_time'])) {
    //     // Pobierz czas rozpoczęcia sesji
    //     $sessionStartTime = $_SESSION['session_start_time'];
    
    //     // Pobierz maksymalny czas trwania sesji
    //     $maxSessionLifetime = ini_get('session.gc_maxlifetime');
    
    //     // Oblicz pozostały czas
    //     $currentTime = time();
    //     $sessionExpirationTime = $sessionStartTime + $maxSessionLifetime;
    //     $timeRemaining = $sessionExpirationTime - $currentTime;
    
    //     // Wyświetl pozostały czas
    //     echo '<script>';
    //     echo 'alert("Czas pozostały w sesji: ' . $timeRemaining . ' sekund");';
    //     echo '</script>';
    // } else {
    //     echo '<script>';
    //     echo 'alert("Sesja nie została jeszcze rozpoczęta.");';
    //     echo '</script>';
    // }
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

    <!--Link Fonts - Roboto (regular, medium, bold, black)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- ---------------------------------------------------------------------- DODAC WSZEDZIE -->

    <!--Link Icons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>
    <header>
        <div class="wrapper">
            <a href="index.php" id="logo"> <img src="images/logo-bochenek.svg"> </a>

            <?php
				if(!isset($_SESSION['username']))
				{
					$user_display = "none";
				}
				else
				{
					$user_display = "flex";
				}
			?>

            <div class="logged-user" style="display: <?php echo $user_display; ?> ">
                    <p>Zalogowano jako <?php echo $_SESSION['username']; ?>
                        <form method="get" action="koszyk.php">
                            <input type="hidden" name="action" value="view">
                            <button type="submit" title="Przejdź do koszyka">

                            <!--Zagnieżdzenie ikony jako tekstu-->
                            <i class='bx bxs-cart'></i>

                            </button>
                        </form>



                        <!-- <a href="koszyk.php" title="Przejdź do koszyka"><i class='bx bxs-cart'></i></a>  -->
                        <!-- <a href="#" title="Przejdz do profilu"><i class='bx bxs-user-circle'></i></a> ikona usera w okregu
                        <a href="logout.php" title="Wyloguj się"><i class='bx bx-log-out'></i></a> ikona wylogowania -->
                    </p>
            </div>



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
                    <?php
                        if(!isset($_SESSION['username']))
                        {
                            echo '<li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                            <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="profil.php">PROFIL</a></li>
                            <li><a class="button-1" href="logout.php">WYLOGUJ SIĘ</a></li>';
                        }

                        if(isset($_SESSION['role']))
                        {
                            if($_SESSION['role']==1)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>';
                            }
                            else if($_SESSION['role']==2)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>
                                <li> <a href="pracownicy.php">PRACOWNICY</a> </li>';
                            }
                        }
                    ?>
                    
                </ul>
            </nav>
        </div>
    </header>

    <!--SECTION ONE-->
    <div class="section-one">
        <div class="wrapper">
            <img id='img-1' src="images/img-pozwol.png">
        </div>
    </div>

    <!--SECTION TWO-->
    <div class="section-two">
        <div class="wrapper">
            <h1> <span>Poznaj naszą </span> HISTORIĘ
            </h1>
            <div class="columns">
                <div class="left-column">
                    <p>Piekarnia "Bochenek" została założona przez braci, Tomka i Michała, którzy od dzieciństwa kształtowali swoją pasję do pieczenia pod czujnym okiem babci. Po latach nauki i doskonalenia swojego rzemiosła, otworzyli piekarnię w 2005 roku, nazwaną "Bochenek" na cześć pierwszego sprzedanego chleba w rodzinie.</p>
                    <p>Piekarnia oferuje szeroki wybór tradycyjnych i smacznych produktów, wyrabianych ręcznie z najwyższej jakości składników. </p>
                    <p>To miejsce, gdzie smak i tradycja spotykają się na nowo, przyciągając klientów swoją autentycznością i pasją do pieczenia.</p>
                    
                    <a href="ofirmie.php"><div class="button-1" id="button-section2" >Zobacz więcej</div></a>
                </div>
                <div class="right-column">
                    <img src="images/img-main2.jpg">
                </div>
            </div>
        </div>
    </div>

    <!--SECTION THREE-->
    <div class="section-three">
        <div class="wrapper">
            <h1>Co nas <span>wyróżnia</span>? </h1>

            <div class="advantages">
                <div class="advantage">
                    <img src="images/zawsze-swiezo.jpg">
                    Zawsze świeże produkty
                </div>
                <div class="advantage">
                    <img src="images/szeroki-wybor.jpg">
                    Szeroki wybór
                </div>
                <div class="advantage">
                    <img src="images/tradycyjny-przepis.jpg">
                    Tradycyjny smak
                </div>
                <div class="advantage">
                    <img src="images/konkurencyjne-ceny.jpg">
                    Konkurencyjne ceny
                </div>
            </div>
            </div>
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
                        
                        <?php
                        if(!isset($_SESSION['username']))
                        {
                            echo '<li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                            <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="profil.php">PROFIL</a></li>
                            <li><a href="logout.php">WYLOGUJ SIĘ</a></li>';
                        }

                        if(isset($_SESSION['role']))
                        {
                            if($_SESSION['role']==1)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>';
                            }
                            else if($_SESSION['role']==2)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>
                                <li> <a href="pracownicy.php">PRACOWNICY</a> </li>';
                            }
                        }
                    ?>
                    
                    </ul>
                </div>
        
                <div class="right">
                    <hf>SKONTAKTUJ SIĘ Z NAMI BEZPOŚREDNIO NA:</hf>
                    <p>piekarnia-bochenek@gmail.com <br> tel. 123 456 789 </p>
                </div>
            </div>
        </div>
    </div>




</body>





</html>