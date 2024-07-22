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
    <link rel="StyleSheet" type="text/css" href="styles/view-style.css">

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
                    // IF prawidlowo przeslane type AND name - metoda get
                    if(isset($_GET["type"]) && isset($_GET["name"]))
                    {
                        $type = $_GET["type"];
                        $name = "'".$_GET["name"]."'";
                        if($type == 1)
                        {
                            //echo "dziala heh";

                            $query = "SELECT produkt_id, nazwa_produktu, opis_produktu, skladniki, dodatkowe_info, cena, file_name FROM produkty WHERE nazwa_produktu LIKE $name;";

                            if($result = @$connect->query($query))
                            {
                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                echo"
                                    <div class=\"produkt\">
                                        <div class=\"tytul\">
                                            <h1>".$row['nazwa_produktu']."</h1>
                                        </div>
                                        <div class=\"columns\">
                                            <div class=\"produkt_img\"><img src=\"images/products_img/".$row['file_name']."\"></div>
                                            <div class=\"opis\">
                                                <p>
                                                ".$row['opis_produktu']."
                                                </p>
                                                <p>
                                                    <b>Składniki</b>: ".$row['skladniki']."
                                                </p>";
                                                if($row['dodatkowe_info'] !="")//kiedy dodatkowe informacje istnieja
                                                {
                                                    echo "<p id=\"dodatkowe_info\">".$row['dodatkowe_info']."</p>";
                                                } 
                                                echo"<h3>".$row['cena']." zł / szt</h3>
                                                <div class=\"dodajdokoszyka\">
                                                    <form action=\"koszyk.php\" method=\"get\">
                                                        <input type=\"number\" name=\"ilosc\" min=1 max=99 value=1>
                                                        <input type=\"hidden\" name=\"action\" value=\"add\">
                                                        <input type=\"submit\" class=\"add\" value=\"Dodaj do koszyka\">
                                                    </form>
                                                </div>
                                                <div class=\"spec\">
                                                    <img src=\"images/spec1.png\">
                                                    <img src=\"images/spec2.png\">
                                                    <img src=\"images/spec3.png\">
                                                </div>
                                            </div>
                                        </div>
                                    </div>";

                                $_SESSION['item'] = $row;
                            }
                            

                        }

                    }
                    else //Nieprawidlowo przeslane dane metoda get
                    {
                        echo "<h1>Błąd przesyłania danych</h1>";
                    }




                }
                $connect -> close();
            ?>

            <!-- <div class="produkt">
                <div class="tytul">
                    <h1>GORĄCE BUŁECZKI W TWOJEJ OKOLICY</h1>
                </div>
                <div class="columns">
                    <div class="produkt_img"><img src="images/products_img/kajzerka.jpg"></div>
                    <div class="opis">
                        <p>
                            Atrakcyjny opis goracych buleczek
                        </p>
                        <p>
                            <b>Składniki</b>: raz dwa trzy skladniki
                        </p>
                        <h3>9.99 zł / szt</h3>
                        <div class="dodajdokoszyka">
                            <form action="#" method="#">
                                <input type="number" name="ilosc" min=1 max=99 value=1>
                                <input type="submit" value="Dodaj do koszyka">
                            </form>
                        </div>
                        <div class="spec">
                            <img src="images/spec1.png">
                            <img src="images/spec2.png">
                            <img src="images/spec3.png">
                        </div>
                    </div>
                </div>
            </div> -->






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