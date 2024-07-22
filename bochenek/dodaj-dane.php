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

    <link rel="StyleSheet" type="text/css" href="styles/dodaj-dane-style.css">

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
                    <li><a href="#">O FIRMIE</a></li>
                    <li><a href="#">KONTAKT</a></li>
                    
                    <?php
                        if(!isset($_SESSION['username']))
                        {
                            echo '<li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                            <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="#">PROFIL</a></li>
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
            <h1>Dodawanie nowego produktu</h1>


            <div class="profil">
                
                <div class="section">
                    <h2>Podaj dane nowego produktu</h2>

                    <form method="post" action="dodaj.php" enctype="multipart/form-data" onsubmit="return confirm('Czy na pewno chcesz dodać ten produkt?')">

                        <div class="input-box">
                            <label>Nazwa produktu</label>
                            <input type="text" placeholder="Nazwa produktu" name="nazwa" maxlength="50" required>
                        </div>

                        <div class="input-box">
                            <label>Opis produktu</label>
                            <textarea placeholder="Opis produktu" name="opis" rows="4" cols="50" maxlength="1000" required></textarea>
                        </div>

                        <div class="input-box">
                            <label>Składniki</label>
                            <textarea placeholder="Składniki" name="skladniki" rows="3" cols="50" maxlength="500" required></textarea>
                        </div>

                        <div class="input-box">
                            <label>Dodatkowe informacje</label>
                            <textarea placeholder="Dodatkowe informacje" name="dodatkowe_info" rows="2" cols="50" maxlength="200"></textarea>
                        </div>

                        <div class="input-box">
                            <label>Cena</label>
                            <input placeholder="Cena" type="number" name="cena" step="0.01" min="0" max="9999999999.99" required>
                        </div>

                        <div class="input-box">
                            <label>Kategoria</label>
                            <select name="kategoria">

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
                                                echo 'Uzupełnij bazę bo coś pusto';
                                            }
                                        }
                                    }

                                    $connect->close();

                                ?>

                                <!-- <option value="kategoria1">Kategoria 1</option>
                                <option value="kategoria2">Kategoria 2</option> -->
                                <!-- Dodaj więcej opcji kategorii -->
                            </select>
                        </div>

                        <div class="input-box">
                            <label>Zdjęcie</label>
                            <input type="file" name="fileInput" accept=".jpg, .jpeg, .png" required>
                        </div>

                        <br>
                        <input type="submit" class="button-1" value="Dodaj">
                    </form>
                    
                    

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
                        <li><a href="#">O FIRMIE</a></li>
                        <li><a href="#">KONTAKT</a></li>

                        <?php
                        if(!isset($_SESSION['username']))
                        {
                            echo '<li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                            <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="#">PROFIL</a></li>
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