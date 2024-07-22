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
    <link rel="StyleSheet" type="text/css" href="styles/profil-style.css">

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
            <h1>Sprawdź czy ktoś złożył zamówienie</h1>
            <div class="profil">
                <div class="section"> <!-- OCZEKUJACE yellow DONE-->
                    <h2>Oczekujące na przyjęcie</h2>

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
                            $status_zamowienia = 0; // ----------------------------------------- TUTAJ STATUS ZAMOWIENIA DO ODPOWIEDNIEJ SEKCJI -----------------------------------------

                            $query = "SELECT zamowienie_id, klient, data, suma, odbior_id FROM zamowienia WHERE zamowienia.status=$status_zamowienia ORDER BY zamowienie_id DESC";
                                if($result = $connect->query($query))
                                {
                                    if ($result->num_rows > 0) //IF sa zamowienia o tych kryteriach
                                    {
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))//dla kazdego zamowienia o kryteriach
                                        {
                                            $zamowienie_id = $row['zamowienie_id'];
								            $date = substr($row['data'],0,16);
								            $suma = $row['suma'];
                                            $odbior_id = $row['odbior_id'];

                                            $query = "SELECT imie, nazwisko, nr_tel FROM dane_odbioru WHERE dane_id = $odbior_id";
                                            if($result1 = @$connect->query($query)) //IF czy sa dane_odbioru do zamowienia
                                            {
                                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                                $imie = $row['imie'];
                                                $nazwisko = $row['nazwisko'];
                                                $nr_tel = $row['nr_tel'];

                                                echo "
                                                    <div class=\"zamowienie\">
                                                        <div class=\"dane-zamawiajacego\">
                                                            <p class=\"nr-zamowienia\">Numer zamówienia: $zamowienie_id</p>
                                                            <p class=\"data-zamowienia\">$date</p>
                                                            <p class=\"z_wielkich\">$imie $nazwisko</p>
                                                            <p>$nr_tel</p>
                                                        </div>
                        
                                                        <div class=\"produkty-zamowienia\">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nazwa produktu</th>
                                                                        <th>Cena</th>
                                                                        <th>Ilość</th>
                                                                        <th>Razem</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                ";

                                                $query = "SELECT produkt_id, ilosc FROM do_zamowienia WHERE zamowienie_id = $zamowienie_id";
                                                if($result2 = $connect->query($query))// IF zapytanie o do_zamowienie sie uda
                                                {
                                                    while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC))//iteracja po wynikach do_zamowienia do danego zamowienia
                                                    {
                                                        $ilosc = $row['ilosc'];
                                                        $produkt_id = $row['produkt_id'];

                                                        $query = "SELECT nazwa_produktu, cena FROM produkty WHERE produkt_id = $produkt_id";
                                                        if($result3 = $connect->query($query)) //IF zapytanie o sam produkt z produkt_id z tabeli do_zamowienia
                                                        {
                                                            $row = mysqli_fetch_array($result3, MYSQLI_ASSOC);
											                $nazwa = $row['nazwa_produktu'];
											                $cena = $row['cena'];

                                                            echo "
                                                                <tr>
                                                                    <td>$nazwa</td>
                                                                    <td>$cena</td>
                                                                    <td>$ilosc</td>
                                                                    <td>".($cena * $ilosc)."</td>
                                                                </tr>
                                                            ";
                                                            $result3 -> free_result();
                                                        }
                                                    }
                                                    $result2 -> free_result();
                                                }
                                                $result1 -> free_result();

                                                echo"
                                                        </tbody>
                                                    </table>

                                                    <div id=\"sum-zam-oczekujace\" class=\"suma-zamowienia\">
                                                        <a href='odrzuc.php?anulujid=$zamowienie_id'><div onclick=\"return confirm('Czy na pewno chcesz odrzucić to zamówienie?')\">Odrzuć zamówienie</div></a>
                                                        <a href='przyjmij.php?przyjmijid=$zamowienie_id'><div onclick=\"return confirm('Czy na pewno chcesz przyjąć to zamówienie?')\">Przyjmij zamówienie</div></a>
                                                        <p><b>Do zapłaty: $suma zł</b></p>
                                                    </div>
                                                </div>  <!-- end of div produkty-zamowienia -->
                                                ";




                                            }//END of IF czy sa dane_odbioru do zamowienia

                                            echo "</div>"; //end of div zamowienie

                                        } //end of WHILE iteracji po zamowieniach o danych kryteriach
                                    } //end of IF czy sa zamowienia o tych kryteriach
                                    else //IF nie ma zamowien o tych kryteriach
                                    {
                                        echo "<h3>Brak oczekujących zamówień</h3>"; // ---------------------------- WIADOMOSC ALTERNATYWNA
                                    }
                                }//end  of IF zapytania o zamowienia z status=X AND klient=$userid

                                $result -> free_result();
                            
                        }

                        $connect -> close();

                    ?>

                </div>

                <div class="section"> <!-- PRZYJETE DO REALIZACJI orange DONE -->
                    <h2>Przyjęte do realizacji</h2>

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
                            $status_zamowienia = 2; // ----------------------------------------- TUTAJ STATUS ZAMOWIENIA DO ODPOWIEDNIEJ SEKCJI -----------------------------------------

                            $query = "SELECT zamowienie_id, klient, data, suma, odbior_id FROM zamowienia WHERE zamowienia.status=$status_zamowienia ORDER BY zamowienie_id DESC";
                                if($result = $connect->query($query))
                                {
                                    if ($result->num_rows > 0) //IF sa zamowienia o tych kryteriach
                                    {
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))//dla kazdego zamowienia o kryteriach
                                        {
                                            $zamowienie_id = $row['zamowienie_id'];
								            $date = substr($row['data'],0,16);
								            $suma = $row['suma'];
                                            $odbior_id = $row['odbior_id'];

                                            $query = "SELECT imie, nazwisko, nr_tel FROM dane_odbioru WHERE dane_id = $odbior_id";
                                            if($result1 = @$connect->query($query)) //IF czy sa dane_odbioru do zamowienia
                                            {
                                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                                $imie = $row['imie'];
                                                $nazwisko = $row['nazwisko'];
                                                $nr_tel = $row['nr_tel'];

                                                echo "
                                                    <div class=\"zamowienie\">
                                                        <div class=\"dane-zamawiajacego\">
                                                            <p class=\"nr-zamowienia\">Numer zamówienia: $zamowienie_id</p>
                                                            <p class=\"data-zamowienia\">$date</p>
                                                            <p class=\"z_wielkich\">$imie $nazwisko</p>
                                                            <p>$nr_tel</p>
                                                        </div>
                        
                                                        <div class=\"produkty-zamowienia\">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nazwa produktu</th>
                                                                        <th>Cena</th>
                                                                        <th>Ilość</th>
                                                                        <th>Razem</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                ";

                                                $query = "SELECT produkt_id, ilosc FROM do_zamowienia WHERE zamowienie_id = $zamowienie_id";
                                                if($result2 = $connect->query($query))// IF zapytanie o do_zamowienie sie uda
                                                {
                                                    while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC))//iteracja po wynikach do_zamowienia do danego zamowienia
                                                    {
                                                        $ilosc = $row['ilosc'];
                                                        $produkt_id = $row['produkt_id'];

                                                        $query = "SELECT nazwa_produktu, cena FROM produkty WHERE produkt_id = $produkt_id";
                                                        if($result3 = $connect->query($query)) //IF zapytanie o sam produkt z produkt_id z tabeli do_zamowienia
                                                        {
                                                            $row = mysqli_fetch_array($result3, MYSQLI_ASSOC);
											                $nazwa = $row['nazwa_produktu'];
											                $cena = $row['cena'];

                                                            echo "
                                                                <tr>
                                                                    <td>$nazwa</td>
                                                                    <td>$cena</td>
                                                                    <td>$ilosc</td>
                                                                    <td>".($cena * $ilosc)."</td>
                                                                </tr>
                                                            ";
                                                            $result3 -> free_result();
                                                        }
                                                    }
                                                    $result2 -> free_result();
                                                }
                                                $result1 -> free_result();

                                                echo"
                                                        </tbody>
                                                    </table>

                                                    <div id=\"sum-zam-oczekujace\" class=\"suma-zamowienia\">
                                                        <a href='do-oczekujacych.php?dooczekid=$zamowienie_id'><div onclick=\"return confirm('Czy na pewno chcesz przenieść do oczekujących to zamówienie?')\">Przenieś do oczekujących</div></a>
                                                        <a href='do-odbioru.php?doodbid=$zamowienie_id'><div onclick=\"return confirm('Czy na pewno chcesz przenieść do gotowych do odbioru to zamówienie?')\">Gotowe do odbioru</div></a>
                                                        <p><b>Do zapłaty: $suma zł</b></p>
                                                    </div>
                                                </div>  <!-- end of div produkty-zamowienia -->
                                                ";




                                            }//END of IF czy sa dane_odbioru do zamowienia

                                            echo "</div>"; //end of div zamowienie

                                        } //end of WHILE iteracji po zamowieniach o danych kryteriach
                                    } //end of IF czy sa zamowienia o tych kryteriach
                                    else //IF nie ma zamowien o tych kryteriach
                                    {
                                        echo "<h3>Brak zamówień przyjętych do realizacji</h3>"; // ---------------------------- WIADOMOSC ALTERNATYWNA
                                    }
                                }//end  of IF zapytania o zamowienia z status=X AND klient=$userid

                                $result -> free_result();
                            
                        }

                        $connect -> close();

                    ?>

                </div>

                <div class="section"> <!-- GOTOWE DO ODBIORU green DONE -->
                    <h2>Gotowe do odbioru</h2>

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
                            $status_zamowienia = 3; // ----------------------------------------- TUTAJ STATUS ZAMOWIENIA DO ODPOWIEDNIEJ SEKCJI -----------------------------------------

                            $query = "SELECT zamowienie_id, klient, data, suma, odbior_id FROM zamowienia WHERE zamowienia.status=$status_zamowienia ORDER BY zamowienie_id DESC";
                                if($result = $connect->query($query))
                                {
                                    if ($result->num_rows > 0) //IF sa zamowienia o tych kryteriach
                                    {
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))//dla kazdego zamowienia o kryteriach
                                        {
                                            $zamowienie_id = $row['zamowienie_id'];
								            $date = substr($row['data'],0,16);
								            $suma = $row['suma'];
                                            $odbior_id = $row['odbior_id'];

                                            $query = "SELECT imie, nazwisko, nr_tel FROM dane_odbioru WHERE dane_id = $odbior_id";
                                            if($result1 = @$connect->query($query)) //IF czy sa dane_odbioru do zamowienia
                                            {
                                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                                $imie = $row['imie'];
                                                $nazwisko = $row['nazwisko'];
                                                $nr_tel = $row['nr_tel'];

                                                echo "
                                                    <div class=\"zamowienie\">
                                                        <div class=\"dane-zamawiajacego\">
                                                            <p class=\"nr-zamowienia\">Numer zamówienia: $zamowienie_id</p>
                                                            <p class=\"data-zamowienia\">$date</p>
                                                            <p class=\"z_wielkich\">$imie $nazwisko</p>
                                                            <p>$nr_tel</p>
                                                        </div>
                        
                                                        <div class=\"produkty-zamowienia\">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nazwa produktu</th>
                                                                        <th>Cena</th>
                                                                        <th>Ilość</th>
                                                                        <th>Razem</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                ";

                                                $query = "SELECT produkt_id, ilosc FROM do_zamowienia WHERE zamowienie_id = $zamowienie_id";
                                                if($result2 = $connect->query($query))// IF zapytanie o do_zamowienie sie uda
                                                {
                                                    while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC))//iteracja po wynikach do_zamowienia do danego zamowienia
                                                    {
                                                        $ilosc = $row['ilosc'];
                                                        $produkt_id = $row['produkt_id'];

                                                        $query = "SELECT nazwa_produktu, cena FROM produkty WHERE produkt_id = $produkt_id";
                                                        if($result3 = $connect->query($query)) //IF zapytanie o sam produkt z produkt_id z tabeli do_zamowienia
                                                        {
                                                            $row = mysqli_fetch_array($result3, MYSQLI_ASSOC);
											                $nazwa = $row['nazwa_produktu'];
											                $cena = $row['cena'];

                                                            echo "
                                                                <tr>
                                                                    <td>$nazwa</td>
                                                                    <td>$cena</td>
                                                                    <td>$ilosc</td>
                                                                    <td>".($cena * $ilosc)."</td>
                                                                </tr>
                                                            ";
                                                            $result3 -> free_result();
                                                        }
                                                    }
                                                    $result2 -> free_result();
                                                }
                                                $result1 -> free_result();

                                                echo"
                                                        </tbody>
                                                    </table>

                                                    <div id=\"sum-zam-oczekujace\" class=\"suma-zamowienia\">
                                                        <a href='przyjmij.php?przyjmijid=$zamowienie_id'><div onclick=\"return confirm('Czy na pewno chcesz przenieść do realizacji to zamówienie?')\">Przenieś do realizacji</div></a>
                                                        <a href='do-odebranych.php?odebraneid=$zamowienie_id'><div onclick=\"return confirm('Czy na pewno chcesz przenieść do odebranych to zamówienie?')\">Odebrane</div></a>
                                                        <p><b>Do zapłaty: $suma zł</b></p>
                                                    </div>
                                                </div>  <!-- end of div produkty-zamowienia -->
                                                ";




                                            }//END of IF czy sa dane_odbioru do zamowienia

                                            echo "</div>"; //end of div zamowienie

                                        } //end of WHILE iteracji po zamowieniach o danych kryteriach
                                    } //end of IF czy sa zamowienia o tych kryteriach
                                    else //IF nie ma zamowien o tych kryteriach
                                    {
                                        echo "<h3>Brak zamówień gotowych do odbioru</h3>"; // ---------------------------- WIADOMOSC ALTERNATYWNA
                                    }
                                }//end  of IF zapytania o zamowienia z status=X AND klient=$userid

                                $result -> free_result();
                            
                        }

                        $connect -> close();

                    ?>

                </div>

                <div class="section"> <!-- ANULOWANE yellow DONE -->
                    <h2>Anulowane</h2>

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
                            $status_zamowienia = 1; // ----------------------------------------- TUTAJ STATUS ZAMOWIENIA DO ODPOWIEDNIEJ SEKCJI -----------------------------------------

                            $query = "SELECT zamowienie_id, klient, data, suma, odbior_id FROM zamowienia WHERE zamowienia.status=$status_zamowienia ORDER BY zamowienie_id DESC";
                                if($result = $connect->query($query))
                                {
                                    if ($result->num_rows > 0) //IF sa zamowienia o tych kryteriach
                                    {
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))//dla kazdego zamowienia o kryteriach
                                        {
                                            $zamowienie_id = $row['zamowienie_id'];
								            $date = substr($row['data'],0,16);
								            $suma = $row['suma'];
                                            $odbior_id = $row['odbior_id'];

                                            $query = "SELECT imie, nazwisko, nr_tel FROM dane_odbioru WHERE dane_id = $odbior_id";
                                            if($result1 = @$connect->query($query)) //IF czy sa dane_odbioru do zamowienia
                                            {
                                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                                $imie = $row['imie'];
                                                $nazwisko = $row['nazwisko'];
                                                $nr_tel = $row['nr_tel'];

                                                echo "
                                                    <div class=\"zamowienie\">
                                                        <div class=\"dane-zamawiajacego\">
                                                            <p class=\"nr-zamowienia\">Numer zamówienia: $zamowienie_id</p>
                                                            <p class=\"data-zamowienia\">$date</p>
                                                            <p class=\"z_wielkich\">$imie $nazwisko</p>
                                                            <p>$nr_tel</p>
                                                        </div>
                        
                                                        <div class=\"produkty-zamowienia\">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nazwa produktu</th>
                                                                        <th>Cena</th>
                                                                        <th>Ilość</th>
                                                                        <th>Razem</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                ";

                                                $query = "SELECT produkt_id, ilosc FROM do_zamowienia WHERE zamowienie_id = $zamowienie_id";
                                                if($result2 = $connect->query($query))// IF zapytanie o do_zamowienie sie uda
                                                {
                                                    while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC))//iteracja po wynikach do_zamowienia do danego zamowienia
                                                    {
                                                        $ilosc = $row['ilosc'];
                                                        $produkt_id = $row['produkt_id'];

                                                        $query = "SELECT nazwa_produktu, cena FROM produkty WHERE produkt_id = $produkt_id";
                                                        if($result3 = $connect->query($query)) //IF zapytanie o sam produkt z produkt_id z tabeli do_zamowienia
                                                        {
                                                            $row = mysqli_fetch_array($result3, MYSQLI_ASSOC);
											                $nazwa = $row['nazwa_produktu'];
											                $cena = $row['cena'];

                                                            echo "
                                                                <tr>
                                                                    <td>$nazwa</td>
                                                                    <td>$cena</td>
                                                                    <td>$ilosc</td>
                                                                    <td>".($cena * $ilosc)."</td>
                                                                </tr>
                                                            ";
                                                            $result3 -> free_result();
                                                        }
                                                    }
                                                    $result2 -> free_result();
                                                }
                                                $result1 -> free_result();

                                                echo"
                                                        </tbody>
                                                    </table>

                                                    <div class=\"suma-zamowienia\">
                                                        <p><b>Do zapłaty: $suma zł</b></p>
                                                    </div>
                                                </div>  <!-- end of div produkty-zamowienia -->
                                                ";




                                            }//END of IF czy sa dane_odbioru do zamowienia

                                            echo "</div>"; //end of div zamowienie

                                        } //end of WHILE iteracji po zamowieniach o danych kryteriach
                                    } //end of IF czy sa zamowienia o tych kryteriach
                                    else //IF nie ma zamowien o tych kryteriach
                                    {
                                        echo "<h3>Brak anulowanych zamówień</h3>"; // ---------------------------- WIADOMOSC ALTERNATYWNA
                                    }
                                }//end  of IF zapytania o zamowienia z status=X AND klient=$userid

                                $result -> free_result();
                            
                        }

                        $connect -> close();

                    ?>

                </div>

                <div class="section"> <!-- ODEBRANE yellow DONE -->
                    <h2>Odebrane</h2>

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
                            $status_zamowienia = 4; // ----------------------------------------- TUTAJ STATUS ZAMOWIENIA DO ODPOWIEDNIEJ SEKCJI -----------------------------------------

                            $query = "SELECT zamowienie_id, klient, data, suma, odbior_id FROM zamowienia WHERE zamowienia.status=$status_zamowienia ORDER BY zamowienie_id DESC";
                                if($result = $connect->query($query))
                                {
                                    if ($result->num_rows > 0) //IF sa zamowienia o tych kryteriach
                                    {
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))//dla kazdego zamowienia o kryteriach
                                        {
                                            $zamowienie_id = $row['zamowienie_id'];
								            $date = substr($row['data'],0,16);
								            $suma = $row['suma'];
                                            $odbior_id = $row['odbior_id'];

                                            $query = "SELECT imie, nazwisko, nr_tel FROM dane_odbioru WHERE dane_id = $odbior_id";
                                            if($result1 = @$connect->query($query)) //IF czy sa dane_odbioru do zamowienia
                                            {
                                                $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                                                $imie = $row['imie'];
                                                $nazwisko = $row['nazwisko'];
                                                $nr_tel = $row['nr_tel'];

                                                echo "
                                                    <div class=\"zamowienie\">
                                                        <div class=\"dane-zamawiajacego\">
                                                            <p class=\"nr-zamowienia\">Numer zamówienia: $zamowienie_id</p>
                                                            <p class=\"data-zamowienia\">$date</p>
                                                            <p class=\"z_wielkich\">$imie $nazwisko</p>
                                                            <p>$nr_tel</p>
                                                        </div>
                        
                                                        <div class=\"produkty-zamowienia\">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nazwa produktu</th>
                                                                        <th>Cena</th>
                                                                        <th>Ilość</th>
                                                                        <th>Razem</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                ";

                                                $query = "SELECT produkt_id, ilosc FROM do_zamowienia WHERE zamowienie_id = $zamowienie_id";
                                                if($result2 = $connect->query($query))// IF zapytanie o do_zamowienie sie uda
                                                {
                                                    while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC))//iteracja po wynikach do_zamowienia do danego zamowienia
                                                    {
                                                        $ilosc = $row['ilosc'];
                                                        $produkt_id = $row['produkt_id'];

                                                        $query = "SELECT nazwa_produktu, cena FROM produkty WHERE produkt_id = $produkt_id";
                                                        if($result3 = $connect->query($query)) //IF zapytanie o sam produkt z produkt_id z tabeli do_zamowienia
                                                        {
                                                            $row = mysqli_fetch_array($result3, MYSQLI_ASSOC);
											                $nazwa = $row['nazwa_produktu'];
											                $cena = $row['cena'];

                                                            echo "
                                                                <tr>
                                                                    <td>$nazwa</td>
                                                                    <td>$cena</td>
                                                                    <td>$ilosc</td>
                                                                    <td>".($cena * $ilosc)."</td>
                                                                </tr>
                                                            ";
                                                            $result3 -> free_result();
                                                        }
                                                    }
                                                    $result2 -> free_result();
                                                }
                                                $result1 -> free_result();

                                                echo"
                                                        </tbody>
                                                    </table>

                                                    <div class=\"suma-zamowienia\">
                                                        <p><b>Do zapłaty: $suma zł</b></p>
                                                    </div>
                                                </div>  <!-- end of div produkty-zamowienia -->
                                                ";




                                            }//END of IF czy sa dane_odbioru do zamowienia

                                            echo "</div>"; //end of div zamowienie

                                        } //end of WHILE iteracji po zamowieniach o danych kryteriach
                                    } //end of IF czy sa zamowienia o tych kryteriach
                                    else //IF nie ma zamowien o tych kryteriach
                                    {
                                        echo "<h3>Brak odebranych zamówień</h3>"; // ---------------------------- WIADOMOSC ALTERNATYWNA
                                    }
                                }//end  of IF zapytania o zamowienia z status=X AND klient=$userid

                                $result -> free_result();
                            
                        }

                        $connect -> close();

                    ?>

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