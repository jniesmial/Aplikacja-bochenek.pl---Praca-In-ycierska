<!doctype html>

<?php
    session_start();
    require_once 'db_connect.php';
    $connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

	if (!$connect) 
    {
		die("Connection failed: " . mysqli_connect_error());
	}

    // ACTION TYPES
    // 1 -nazwa 
    // 2 - opis
    // 3 - cena 
    // 4 - widocznosc
    $action = $_GET['action'];
    $produkt_id = $_GET['id'];
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
    <link rel="StyleSheet" type="text/css" href="styles/profil-style.css">
    <link rel="StyleSheet" type="text/css" href="styles/koszyk-style.css">
    <link rel="StyleSheet" type="text/css" href="styles/zarzadzaj-style.css">

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
            <h1>Zarządzaj ofertami na stronie</h1>


            <div class="profil">
                
                <div class="section"> <!-- zmiana danych oferty -->
                    <h2>Wprowadz nowe dane
                        <?php //switch naglowka
                            switch($action)
                            {
                                case 1:
                                    echo " dla nazwy produktu";
                                    break;

                                case 2:
                                    echo " dla opisu produktu";
                                    break;

                                case 3:
                                    echo " dla ceny produktu";
                                    break;

                                default:
                                    echo "Nieznana akcja";
                            }
                        ?>
                    </h2>

                    <!-- <form method="post" action="zmiana-produktu.php">

                        <div class="input-box">
                            <input type="text" id="inputText" name="inputText" maxlength="50" required>
                        </div>

                        <label for="inputDecimal">Liczba dziesiętna (maks. 10 cyfr przed kropką, 2 po kropce):</label>
                        <input type="number" id="inputDecimal" name="inputDecimal" step="0.01" min="0" max="9999999999.99" required>
                        <br>
                        <input type="submit" class="button-1 zmiana-dane-btn" value="Zmień dane">
                    </form> -->
                    
                    <?php //switch
                        // ACTION TYPES
                        // 1 -nazwa 
                        // 2 - opis
                        // 3 - cena 
                        // 4 - widocznosc
                        switch($action)
                        {
                            case 1:
                                echo "
                                    <form method=\"post\" action=\"zmiana-produktu.php?action=$action&id=$produkt_id\"
                                    onsubmit=\"return confirm('Czy na pewno chcesz zmienić dane?')\">
                                        <div class=\"input-box\">
                                            <input type=\"text\" name=\"inputText\" maxlength=\"50\" required>
                                        </div>
                                        <input type=\"submit\" class=\"button-1 zmiana-dane-btn\" value=\"Zmień dane\">
                                    </form>
                                ";
                                break;

                            case 2:
                                echo "
                                    <form method=\"post\" action=\"zmiana-produktu.php?action=$action&id=$produkt_id\"
                                    onsubmit=\"return confirm('Czy na pewno chcesz zmienić dane?')\">
                                        <div class=\"input-box\">
                                            <textarea name=\"inputText\" rows=\"4\" cols=\"50\" maxlength=\"1000\" required></textarea>
                                        </div>
                                        <input type=\"submit\" class=\"button-1 zmiana-dane-btn\" value=\"Zmień dane\">
                                    </form>
";
                                break;

                            case 3:
                                echo "
                                    <form method=\"post\" action=\"zmiana-produktu.php?action=$action&id=$produkt_id\"
                                    onsubmit=\"return confirm('Czy na pewno chcesz zmienić dane?')\">
                                        <div class=\"input-box\">
                                            <input type=\"number\" name=\"inputDecimal\" step=\"0.01\" min=\"0\" max=\"9999999999.99\" required>
                                        </div>
                                        <input type=\"submit\" class=\"button-1 zmiana-dane-btn\" value=\"Zmień dane\">
                                    </form>
                                ";
                                break;

                            default:
                                echo "Nieznana akcja";
                        }
                    ?>
                    

                </div> <!-- end of section -->

                
            </div> <!-- end of profil -->

        </div> <!-- end of wrapper -->
    </div> <!-- end of box -->



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