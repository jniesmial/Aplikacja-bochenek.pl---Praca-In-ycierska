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
    <div class="wrapper" id="body-wrapper">
        
        <?php
            if(isset($_SESSION['username']))
            {
                if(isset($_SESSION['role']))
                {
                    if($_SESSION['role']==1 || $_SESSION['role']==2)
                    {
                        echo '<div id="zarzadzaj-btn"><a href="zarzadzaj.php" class="button-1">Zarządzaj ofertami na stronie</a></div>';
                    }
                }
            }
        ?>

        <h1>Zamów swoje ulubione pieczywo i odbierz w lokalu bez czekania!</h1>

        <div class="search-box">
            <div class="wrapper" id="search-wrapper">

                <form action="produkty.php" method="get" class="form-grid">

                    <!-- wyszukiwarka produktow -->
                    <div class="input-box">
                        <input type="text" name="search_bar" placeholder="Wyszukaj produkt" >
                    </div>

                    <!-- przycisk wyszukj -->
                    <div class="input-box">
                        <input class="btn-search" type="submit" value="Wyszukaj">
                    </div>

                    <!-- wybieranie kategorii -->
                    <div class="input-box">
                        <select name="kategorie">

                            <?php
                                if($connect->connect_errno!=0)
                                {
                                    echo "Błąd: ".$connect->connect_errno."<br>".$connect->connect_error;
                                }
                                else
                                {
                                    $query = "SELECT nazwa_kategorii from kategorie;";
                                    if($result = @$connect->query($query))
                                    {
                                        if ($result->num_rows > 0)
                                        {
                                            echo "<option>-- Wybierz kategorie --</option>";
                                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                            {
                                                $nazwa_kategorii = $row['nazwa_kategorii'];
                                                echo "<option>$nazwa_kategorii</option>";
                                            }

                                            $result->free_result();
                                        }
                                        else
                                        {
                                            echo 'Brak kategorii w bazie danych.';
                                        }
                                    }
                                }
                            ?>

                            <!-- <option value="kategoria1">Kategoria 1</option>
                            <option value="kategoria2">Kategoria 2</option> -->
                            <!-- Dodaj więcej opcji kategorii -->
                        </select>
                    </div>

                    <!-- opcje sortowania wynikow OPCJONALNE -->
                    <div class="input-box">
                        <select>
                            <option value="opcja1">-- Opcje sortowania --</option>
                            <option value="opcja1">Opcja 1</option>
                            <option value="opcja2">Opcja 2</option>
                        </select>
                    </div>

                </form>
            </div>
        </div> <!-- end of search-box -->


        <div class="products">

            <?php

                if($connect->connect_errno!=0)
                {
                    echo "Błąd: ".$connect->connect_errno."<br>".$connect->connect_error;
                }
                else // if connection OK
                {
                    if(isset($_GET['kategorie'])) //select zawsze cos zawiera (zawsze jest wartosc domyslna)
                    {
                        $kategoriaid = -1;
                        $search="";

                        // IF select inny niz domyslny przypisz do $kategoriaid odpowiednie ID kategorii z bazy danych
                        // ELSE pozostaw = -1
                        if($_GET['kategorie']!="-- Wybierz kategorie --") 
                        {
                            $query = "SELECT kategoria_id FROM kategorie WHERE nazwa_kategorii LIKE '".$_GET['kategorie']."';";
                            if($result = @$connect->query($query)) // IF znajdzie w bazie wybrana kategorie ustaw jego id ELSE pozostaje = -1
                            {
                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                $kategoriaid = $row['kategoria_id'];
                            }
                            $result->free_result();
                        }

                        // Pobieranie zawartosci searchbar
                        if(isset($_GET['search_bar']))
                        {
                            $search=$_GET['search_bar'];
                        }



                        // IF searchbar pusty AND kategoria brak - DONE
                        if($search=="" && $kategoriaid==-1)
                        {
                            $query = "SELECT produkty.nazwa_produktu, produkty.file_name, produkty.cena FROM produkty WHERE widocznosc=1";

                            if($result = $connect->query($query))
                            {
                                if($result->num_rows>0)
                                {
                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                    {
                                        echo"<div class=\"product\">
                                                <img src=\"images/products_img/".$row['file_name']."\">
                                                <h2>".$row['nazwa_produktu']."</h2>
                                                <h2>".$row['cena']." zł</h2>
                                                <a href=\"view.php?type=1&name=".$row['nazwa_produktu']."\">
                                                    <span class=\"link\"></span>
                                                </a>
                                            </div>";
                                    }
                                    $result->free_result();
                                }
                                else
                                {
                                    echo 'Nie znaleziono produktów spełniających kryteria';
                                }
                            }

                        }
                        // IF searchbar jest AND kategoria jest - DONE
                        elseif ($search!="" && $kategoriaid!=-1)
                        {
                            $query = "SELECT produkty.nazwa_produktu, produkty.file_name, produkty.cena FROM produkty WHERE produkty.kategoria=".$kategoriaid." AND widocznosc=1 AND produkty.nazwa_produktu LIKE '%".$_GET['search_bar']."%';";

                            if($result = $connect->query($query))
                            {
                                if($result->num_rows>0)
                                {
                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                    {
                                        echo"<div class=\"product\">
                                                <img src=\"images/products_img/".$row['file_name']."\">
                                                <h2>".$row['nazwa_produktu']."</h2>
                                                <h2>".$row['cena']." zł</h2>
                                                <a href=\"view.php?type=1&name=".$row['nazwa_produktu']."\">
                                                    <span class=\"link\"></span>
                                                </a>
                                            </div>";
                                    }
                                    $result->free_result();
                                }
                                else
                                {
                                    echo 'Nie znaleziono produktów spełniających kryteria';
                                }
                            }

                        }
                        // IF searchbar jest AND kategoria brak - DONE
                        elseif ($search!="" && $kategoriaid==-1)
                        {
                            $query = "SELECT produkty.nazwa_produktu, produkty.file_name, produkty.cena FROM produkty WHERE widocznosc=1 AND produkty.nazwa_produktu LIKE '%".$_GET['search_bar']."%';";

                            if($result = $connect->query($query))
                            {
                                if($result->num_rows>0)
                                {
                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                    {
                                        echo"<div class=\"product\">
                                                <img src=\"images/products_img/".$row['file_name']."\">
                                                <h2>".$row['nazwa_produktu']."</h2>
                                                <h2>".$row['cena']." zł</h2>
                                                <a href=\"view.php?type=1&name=".$row['nazwa_produktu']."\">
                                                    <span class=\"link\"></span>
                                                </a>
                                            </div>";
                                    }
                                    $result->free_result();
                                }
                                else
                                {
                                    echo 'Nie znaleziono produktów spełniających kryteria';
                                }
                            }
                        
                        }
                        // IF searchbar pusty AND kategoria jest - DONE
                        elseif ($search=="" && $kategoriaid!=-1)
                        {
                            $query = "SELECT produkty.nazwa_produktu, produkty.file_name, produkty.cena FROM produkty WHERE widocznosc=1 AND produkty.kategoria=".$kategoriaid.";";

                            if($result = $connect->query($query))
                            {
                                if($result->num_rows>0)
                                {
                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                    {
                                        echo"<div class=\"product\">
                                                <img src=\"images/products_img/".$row['file_name']."\">
                                                <h2>".$row['nazwa_produktu']."</h2>
                                                <h2>".$row['cena']." zł</h2>
                                                <a href=\"view.php?type=1&name=".$row['nazwa_produktu']."\">
                                                    <span class=\"link\"></span>
                                                </a>
                                            </div>";
                                    }
                                    $result->free_result();
                                }
                                else
                                {
                                    echo 'Nie znaleziono produktów spełniających kryteria';
                                }
                            }
                        }



                    }
                    else //pierwszy raz po odpaleniu strony kiedy skrypt nie wysłał danych method:GET
                    {
                        $query = "SELECT produkty.nazwa_produktu, produkty.file_name, produkty.cena FROM produkty WHERE widocznosc=1";

                        if($result = $connect->query($query))
                        {
                            if($result->num_rows>0)
                            {
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                {
                                    echo"<div class=\"product\">
                                            <img src=\"images/products_img/".$row['file_name']."\">
                                            <h2>".$row['nazwa_produktu']."</h2>
                                            <h2>".$row['cena']." zł</h2>
                                            <a href=\"view.php?type=1&name=".$row['nazwa_produktu']."\">
                                                <span class=\"link\"></span>
                                            </a>
                                        </div>";
                                }
                                $result->free_result();
                            }
                            else
                            {
                                echo 'Nie znaleziono produktów spełniających kryteria';
                            }
                        }
                    }


                    $connect->close();
                }

            ?>

                <!-- PRODUCT TEMPLATE -->

                <!-- <div class="product">
                    <img src="images/products_img/bulka_mazurska.jpg">
                    <h2>Bułka mazurska 80 g</h2>
                    <h2>0.80zł/szt.</h2>
                    <a href="#">
                        <span class="link"></span>
                    </a>
                </div>




                <div class="product"><h1>LOREM IPSUM BOX 2</h1></div>
                <div class="product"><h1>LOREM IPSUM BOX 3</h1></div>
                <div class="product"><h1>LOREM IPSUM BOX 4</h1></div>
                <div class="product"><h1>LOREM IPSUM BOX 5</h1></div>
                <div class="product"><h1>LOREM IPSUM BOX 6</h1></div>
                <div class="product"><h1>LOREM IPSUM BOX 6</h1></div> -->
            
            </div>

    </div> <!-- end of products -->

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