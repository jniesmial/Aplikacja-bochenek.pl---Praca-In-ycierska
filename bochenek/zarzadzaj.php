<!doctype html>

<?php
    session_start();
    require_once 'db_connect.php';
    $connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

	if (!$connect) 
    {
		die("Connection failed: " . mysqli_connect_error());
	}
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

            <div class="search-box">
                <div class="wrapper" id="search-wrapper">

                    <form action="zarzadzaj.php" method="get" class="form-grid">

                        <!-- wyszukiwarka produktow -->
                        <div class="input-box">
                            <input type="text" name="search_bar" placeholder="Wyszukaj produkt" >
                        </div>

                        <!-- przycisk wyszukj -->
                        <div class="input-box">
                            <input class="btn-search" type="submit" value="Wyszukaj">
                        </div>
                    </form>
                </div>
            </div> <!-- end of search-box -->


            <div class="profil">

                <a href="dodaj-dane.php" class="button-1">Dodaj nowy produkt</a>
                
                <div class="section"> <!-- widoczne -->
                    <h2>Widoczne</h2>
                    
                    <?php
                        if($connect->connect_errno!=0)
                        {
                            echo "Błąd: ".$connect->connect_errno."<br>".$connect->connect_error;
                        }
                        else // if connection OK
                        {
                            $search = "";

                            // Pobieranie zawartosci searchbar
                            if(isset($_GET['search_bar']))
                            {
                                $search=$_GET['search_bar'];
                            }

                            if($search =="") //IF serchbar pusty
                            {
                                // echo"IF serchbar pusty";

                                $query = "SELECT produkt_id, nazwa_produktu, opis_produktu, cena FROM produkty WHERE widocznosc = 1";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa produktu</th>
                                                        <th id=\"opis-prod\">Opis produktu</th>
                                                        <th>Cena</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $produkt_id = $row['produkt_id'];
                                            $nazwa = $row['nazwa_produktu'];
                                            $opis = $row['opis_produktu'];
                                            $cena = $row['cena'];

                                            echo "
                                                <tr>
                                                    <td>$produkt_id</td>
                                                    <td>$nazwa</td>
                                                    <td>$opis</td>
                                                    <td>$cena zł</td>
                                                    <td><a href=\"zmien-produkt.php?action=1&id=$produkt_id\">Zmień nazwe</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=2&id=$produkt_id\">Zmień opis</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=3&id=$produkt_id\">Zmień cene</a></td>
                                                    <td><a href=\"zmiana-produktu.php?action=4&id=$produkt_id\" onclick=\"return confirm('Czy na pewno chcesz zmienić widoczność tego produktu?')\">Zmień widoczność</a></td>
                                                </tr>
                                            ";
                                        }
                                        echo "
                                                </tbody>
                                            </table>
                                        ";
                                        $result->free_result();
                                    }
                                    else
                                    {
                                        echo 'Nie znaleziono produktów spełniających kryteria';
                                    }
                                }
                            }
                            elseif($search !="") //IF serchbar jest
                            {
                                // echo"<br>IF serchbar jest<br>";

                                $query = "SELECT produkt_id, nazwa_produktu, opis_produktu, cena FROM produkty WHERE widocznosc = 1 AND nazwa_produktu LIKE '%".$_GET['search_bar']."%';";

                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0)
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa produktu</th>
                                                        <th id=\"opis-prod\">Opis produktu</th>
                                                        <th>Cena</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $produkt_id = $row['produkt_id'];
                                            $nazwa = $row['nazwa_produktu'];
                                            $opis = $row['opis_produktu'];
                                            $cena = $row['cena'];

                                            echo "
                                                <tr>
                                                    <td>$produkt_id</td>
                                                    <td>$nazwa</td>
                                                    <td>$opis</td>
                                                    <td>$cena zł</td>
                                                    <td><a href=\"zmien-produkt.php?action=1&id=$produkt_id\">Zmień nazwe</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=2&id=$produkt_id\">Zmień opis</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=3&id=$produkt_id\">Zmień cene</a></td>
                                                    <td><a href=\"zmiana-produktu.php?action=4&id=$produkt_id\" onclick=\"return confirm('Czy na pewno chcesz zmienić widoczność tego produktu?')\">Zmień widoczność</a></td>
                                                </tr>
                                            ";
                                        }
                                        echo "
                                                </tbody>
                                            </table>
                                        ";
                                        $result->free_result();
                                    }
                                    else
                                    {
                                        echo 'Nie znaleziono produktów spełniających kryteria';
                                    }
                                }
                            }
                        
                        }
                    ?>

                </div> <!-- end of section -->

                <div class="section"> <!-- ukryte -->
                    <h2>Ukryte</h2> 

                    <?php
                        if($connect->connect_errno!=0)
                        {
                            echo "Błąd: ".$connect->connect_errno."<br>".$connect->connect_error;
                        }
                        else // if connection OK
                        {
                            $search = "";

                            // Pobieranie zawartosci searchbar
                            if(isset($_GET['search_bar']))
                            {
                                $search=$_GET['search_bar'];
                            }

                            if($search =="") //IF serchbar pusty
                            {
                                // echo"IF serchbar pusty";

                                $query = "SELECT produkt_id, nazwa_produktu, opis_produktu, cena FROM produkty WHERE widocznosc = 0";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa produktu</th>
                                                        <th id=\"opis-prod\">Opis produktu</th>
                                                        <th>Cena</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $produkt_id = $row['produkt_id'];
                                            $nazwa = $row['nazwa_produktu'];
                                            $opis = $row['opis_produktu'];
                                            $cena = $row['cena'];

                                            echo "
                                                <tr>
                                                    <td>$produkt_id</td>
                                                    <td>$nazwa</td>
                                                    <td>$opis</td>
                                                    <td>$cena zł</td>
                                                    <td><a href=\"zmien-produkt.php?action=1&id=$produkt_id\">Zmień nazwe</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=2&id=$produkt_id\">Zmień opis</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=3&id=$produkt_id\">Zmień cene</a></td>
                                                    <td><a href=\"zmiana-produktu.php?action=4&id=$produkt_id\" onclick=\"return confirm('Czy na pewno chcesz zmienić widoczność tego produktu?')\">Zmień widoczność</a></td>
                                                </tr>
                                            ";
                                        }
                                        echo "
                                                </tbody>
                                            </table>
                                        ";
                                        $result->free_result();
                                    }
                                    else
                                    {
                                        echo 'Nie znaleziono produktów spełniających kryteria';
                                    }
                                }
                            }
                            elseif($search !="") //IF serchbar jest
                            {
                                // echo"<br>IF serchbar jest<br>";

                                $query = "SELECT produkt_id, nazwa_produktu, opis_produktu, cena FROM produkty WHERE widocznosc = 0 AND nazwa_produktu LIKE '%".$_GET['search_bar']."%';";

                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0)
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa produktu</th>
                                                        <th id=\"opis-prod\">Opis produktu</th>
                                                        <th>Cena</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                        <th>-</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $produkt_id = $row['produkt_id'];
                                            $nazwa = $row['nazwa_produktu'];
                                            $opis = $row['opis_produktu'];
                                            $cena = $row['cena'];

                                            echo "
                                                <tr>
                                                    <td>$produkt_id</td>
                                                    <td>$nazwa</td>
                                                    <td>$opis</td>
                                                    <td>$cena zł</td>
                                                    <td><a href=\"zmien-produkt.php?action=1&id=$produkt_id\">Zmień nazwe</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=2&id=$produkt_id\">Zmień opis</a></td>
                                                    <td><a href=\"zmien-produkt.php?action=3&id=$produkt_id\">Zmień cene</a></td>
                                                    <td><a href=\"zmiana-produktu.php?action=4&id=$produkt_id\" onclick=\"return confirm('Czy na pewno chcesz zmienić widoczność tego produktu?')\">Zmień widoczność</a></td>
                                                </tr>
                                            ";
                                        }
                                        echo "
                                                </tbody>
                                            </table>
                                        ";
                                        $result->free_result();
                                    }
                                    else
                                    {
                                        echo 'Nie znaleziono produktów spełniających kryteria';
                                    }
                                }
                            }
                        
                        }
                    ?>

                </div> <!-- end of section -->




                <!-- template sekcji -->
                <!-- <div class="section">
                    <h2>Ukryte</h2> 

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa produktu</th>
                                <th id="opis-prod">Opis produktu</th>
                                <th>Cena</th>
                                <th>-</th>
                                <th>-</th>
                                <th>-</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>13</td>
                                <td>Bułeczka gorąca</td>
                                <td>Lorem ipsum post mortem twoja stara lorem ipsum post mortem twoja stara lorem ipsum post mortem twoja stara lorem ipsum post mortem twoja stara</td>
                                <td>9.99 zł</td>
                                <td><a href="zmien-produkt.php">Zmień nazwe</a></td>
                                <td><a href="zmien-produkt.php">Zmień opis</a></td>
                                <td><a href="zmien-produkt.php">Zmień cene</a></td>
                                <td><a href="zmien-produkt.php">Zmień widoczność</a></td>
                            </tr>

                            <tr>
                                <td>99</td>
                                <td>Gorący bochenek</td>
                                <td>Lorem ipsum post mortem twoja stara lorem ipsum post mortem twoja stara lorem ipsum post mortem twoja stara lorem ipsum post mortem twoja stara</td>
                                <td>99.99 zł</td>
                                <td><a href="zmien-produkt.php">Zmień nazwe</a></td>
                                <td><a href="zmien-produkt.php">Zmień opis</a></td>
                                <td><a href="zmien-produkt.php">Zmień cene</a></td>
                                <td><a href="zmien-produkt.php">Zmień widoczność</a></td>
                            </tr>
                        </tbody>
                    </table>

                </div>  --> 
                <!-- end of section -->

                
                
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