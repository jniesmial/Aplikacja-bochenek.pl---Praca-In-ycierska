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
    <link rel="StyleSheet" type="text/css" href="styles/produkty-style.css">
    <link rel="StyleSheet" type="text/css" href="styles/koszyk-style.css">
    <link rel="StyleSheet" type="text/css" href="styles/zarzadzaj-style.css">
    <link rel="StyleSheet" type="text/css" href="styles/pracownicy-style.css">
    <link rel="StyleSheet" type="text/css" href="styles/kontakt-style.css">

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
            <a href="index.php" id="logo"> <img src="images/logo-bochenek.svg" alt="logo-bochenek"> </a>

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

    <!--STERT HERE-->
    <div class="box">
        <div class="wrapper">

        <?php
            if(isset($_SESSION['role']))
            {
                if($_SESSION['role']==2)
                {
                    echo '<div id="do-wiadomosci" ><a class="button-1" href="wiadomosci.php">Zobacz wiadomości</a></div>';
                }
                
            }
        ?>

            <h1><span style="color: #000000">Zapraszamy do</span> KONTAKTU</h1>
            
            <div class="kontakt-box">
                <p>Chcesz nam zadać jakies <span>pytanie</span>? 
                Masz <span>opinie</span> którą chciałbyś się z nami podzielić?<br>
                Szukasz przyjaznego <span>miejsca pracy</span>,
                a może masz lokal do <span>wynajęcia</span>?</p>
                <h2><br><b>Skontaktuj się z nami przez <span>formularz</span> poniżej</b></h2>


                <div class="flex-boxy">
                    <div class="box-left">
                        <h2>Znajdziesz nasz <span>lokal</span> tutaj</h2>

                        <p>ul. Prószkowska 76<br>
                        45-758 Opole<br>
                        tel. 123 456 789<br>
                        e-mail: piekarnia-bochenek@gmail.com</p>

                        <div id="map"></div>
                    </div>

                    <div class="box-right">
                        <form action="przeslij-wiad.php" method="post" onsubmit="return confirm('Czy na pewno chcesz wysłać wiadomość?')" >
                            <div class="dwa-w-rzedzie">

                                <div class="input-box">
                                    <input type="text" placeholder="Imie" name="imie"> <!-- required --> 
                                </div>

                                <div class="input-box">
                                    <input type="text" placeholder="Nazwisko" name="nazwisko"> <!-- required --> 
                                </div>

                                <div class="input-box">
                                    <input type="text" placeholder="Tr tel" name="nr_tel" required pattern="[0-9]{9}">
                                </div>

                                <div class="input-box">
                                    <input type="email" placeholder="E-mail" name="email"> <!-- required --> 
                                </div>

                            </div>

                            <div class="input-box">
                                <input type="text" placeholder="Temat" name="temat"> <!-- required --> 
                            </div>

                            <div class="input-box">
                                <textarea placeholder="Wiadomość" name="wiadomosc" cols="100%" rows="15" name="wiadomosc"></textarea>
                            </div>

                            <input type="submit" class="button-1" value="Prześlij">
                            
                        </form>
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


    <!-- MOJ KLUCZ API -->
    <!-- AIzaSyCklTPtcj2JED6ouMLdbOhjZlBmDB3iXuk -->
    
    <script>
        function initMap() {
            var mapOptions = {
                // 50.654489094288024, 17.90516417266743
                center: { lat: 50.654489094288024, lng: 17.90516417266743 }, //  współrzędne geograficzne
                zoom: 15, // poziom zbliżenia
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            //pinezka
            addMarker(map, 50.654489094288024, 17.90516417266743);
        }

        function addMarker(map, lat, lng) {
        var marker = new google.maps.Marker({
            position: { lat: lat, lng: lng }, // Współrzędne geograficzne pinezki
            map: map, // Mapa, na której ma być wyświetlona pinezka
            title: 'Piekarnia Bochenek' // Tytuł pinezki (opcjonalny)
        });
}
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCklTPtcj2JED6ouMLdbOhjZlBmDB3iXuk&callback=initMap" async defer></script>

</body>


</html>