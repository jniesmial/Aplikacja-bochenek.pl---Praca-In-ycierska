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

            <h1>Wiadmości<span style="color: #000000"> od użytkowników</span></h1>
            
            <div class="kontakt-box">
                <?php
                    require_once 'db_connect.php';
                    $connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);
                
                    if (!$connect) 
                    {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    if($connect->connect_errno!=0)
                    {
                        echo "Błąd: ".$connect->connect_errno."<br>".$connect->connect_error;
                    }
                    else // if connection OK
                    {
                        $query = "SELECT imie, nazwisko, email, nr_tel, temat, wiadomosc FROM wiadomosci";

                        if($result = $connect->query($query)) //jesli zapytanie sie uda
                        {
                            if($result->num_rows>0) //jesli sa recordy
                            {
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))//dla kazdego recordu
                                {
                                    $imie = $row['imie'];
                                    $nazwisko = $row['nazwisko'];
                                    $email = $row['email'];
                                    $nr_tel = $row['nr_tel'];
                                    $temat = $row['temat'];
                                    $wiadomosc = $row['wiadomosc'];

                                    echo "
                                        <div class=\"wiadomosc\">
                                            <div class=\"dane\">$imie $nazwisko <br>$email<br>$nr_tel</div>
                                            
                                            <div class=\"tresc-wiad\">
                                                <p><b>$temat</b></p><br>
                                                $wiadomosc
                                            </div>
                                        </div>
                                    ";
                                }
                                $result->free_result();
                            }
                            else
                            {
                                echo "Brak wiadomości";
                            }
                        }
                        $connect->close();
                    }
                ?>



                <!-- TEMPLATE -->

                <!-- <div class="wiadomosc">
                    <div class="dane">Imie Nazwisko <br>klient@gmail.com<br>123456789</div>
                    
                    <div class="tresc-wiad">
                        <p><b>Wykurwiste macie te bułeczki</b></p><br>
                        asjdhaildhl;asod
                    </div>
                </div> -->

                


             
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
                center: { lat: 50.654489094288024, lng: 17.90516417266743 }, // Wprowadź współrzędne geograficzne swojej lokalizacji
                zoom: 15, // Ustaw poziom zbliżenia
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