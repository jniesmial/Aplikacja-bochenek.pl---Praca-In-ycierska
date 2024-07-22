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
    <link rel="StyleSheet" type="text/css" href="styles/koszyk-style.css">

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
            <div class="koszyk">
                <h1>TWÓJ KOSZYK</h1>
                <table id="tab_koszyk">
                    <thead>
                        <tr>
                            <th>Nazwa produktu</th>
                            <th>Cena</th>
                            <th>Ilość</th>
                            <th>Razem</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            if(isset($_GET['action']))
                            {
                                $action = $_GET['action'];
                            }
                            else
                            {
                                $action = "view";
                            }
                            if(!isset($_SESSION['item']))
                            {
                                $action="view";
                            }

                            switch($action)
                            {
                                case "add":
                                    //
                                    $newitem = $_SESSION['item'];
                                    array_push($newitem,$_GET['ilosc']);

                                    //IF istnieja juz jakies produkty w koszyku
                                    if(isset($_SESSION['cart_items']))
                                    {
                                        $items = $_SESSION['cart_items'];
									    array_push($items,$newitem);
									    $_SESSION['cart_items'] = $items;
									    foreach($items as $item)
                                        {
                                            echo 
                                            "<tr>
                                                <td>".$item['nazwa_produktu']."</td>
                                                <td>".$item['cena']."</td>
                                                <td>".$item[0]."</td>
                                                <td>".($item[0]*$item['cena'])."</td>
                                            </tr>";
                                        }
                                    }
                                    //IF koszyk jest pusty - dodajesz pierwszy przedmiot
                                    else
                                    {
                                        $newitem = $_SESSION['item'];
                                        array_push($newitem,$_GET['ilosc']);
                                        $_SESSION['cart_items'] = array($newitem);
                                        echo 
                                            "<tr>
                                                <td>".$newitem['nazwa_produktu']."</td>
                                                <td>".$newitem['cena']."</td>
                                                <td>".$newitem[0]."</td>
                                                <td>".($newitem[0]*$newitem['cena'])."</td>
                                            </tr>";
                                    }
                                    unset($_SESSION['item']);
                                    header('Location: produkty.php');
                                    break;

                                case "view":
                                    //IF przedmioty w koszyku istnieja
                                    if(isset($_SESSION['cart_items']))
                                    {
                                        $items = $_SESSION['cart_items'];
                                        foreach($items as $item)
                                        {
                                            echo
                                            "<tr>
											    <td>".$item['nazwa_produktu']."</td>
											    <td>".$item['cena']."</td>
											    <td>".$item[0]."</td>
											    <td>".($item[0]*$item['cena'])."</td>
										    </tr>";
                                        }
                                    }
                                    //IF brak przedmiotow w koszyku
                                    else
                                    {
                                        echo "<tr><td colspan=\"4\"><center><h2>Twój koszyk jest pusty</h2></center></td></tr>";
                                    }
                                    break;
                            }
                        ?>





                        <!-- <tr>
							<td>Goraca buleczka</td>
							<td>99.99</td>
							<td>5</td>
							<td>99.99 * 5</td>
						</tr> -->

                    </tbody>
                </table>
                
                <div id="suma">
                    <b>Suma: <?php
                        $suma=0;
                        if(isset($_SESSION['cart_items']))
                        {
                            foreach($_SESSION['cart_items'] as $item)
                            {
                                $suma += ($item['cena']*$item[0]);
                            }
                        }
                        echo $suma;
                        $_SESSION['suma'] = $suma;
                    ?> zł</b>
                </div>

                <div class="koszyk_btns">
                    <!-- usuwanie zawartosci koszyka -->
                    <div class="koszyk_btn1">
                        <form method="post">
                            <?php 
                                if(array_key_exists('reset', $_POST))
                                {
                                    unset($_SESSION['cart_items']);
                                    header('Location: koszyk.php?action=view'); //----------------------------------
                                    exit;
                                }
                            ?>
                            <button class="kosz-btn1" type="submit" name="reset">Usuń zawartość</button>
                        </form>
                    </div>

                    <div class="koszyk_btn2">
                        <form method="post" action="koszyk-dane.php">
                            <a href="koszyk-dane.php">
                                <button class="kosz-btn1" type="submit">Zamawiam</button>
                            </a>
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

</body>


</html>