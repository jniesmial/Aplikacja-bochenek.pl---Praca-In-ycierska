<!doctype html>
<?php
    session_start();


    if(isset($_SESSION['role']))
    {
        if($_SESSION['role']==2)
        {
            // OK
        }
        else 
        {
            die("Brak dostępu!");
        }
    }
    else 
    {
        die("Brak dostępu!");
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
    <link rel="StyleSheet" type="text/css" href="styles/pracownicy-style.css">

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
            <div class="profil">
                <h1>Zarządzaj uprawnieniami użytkowników</h1>

                <div class="search-box">
                    <div class="wrapper" id="search-wrapper">
                        <form action="pracownicy.php" method="get" class="form-grid">
                            <!-- wyszukiwarka produktow -->
                            <div class="input-box">
                                <input type="text" name="search_bar" placeholder="Wyszukaj użytkownika" >
                            </div>

                            <!-- przycisk wyszukj -->
                            <div class="input-box">
                                <input class="btn-search" type="submit" value="Wyszukaj">
                            </div>

                        </form>
                    </div>
                </div>

                <div class="section"> <!-- ADMINISTRATORZY -->
                    <h2>Administratorzy</h2>

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
                            $search = "";

                            // Pobieranie zawartosci searchbar
                            if(isset($_GET['search_bar']))
                            {
                                $search=$_GET['search_bar'];
                            }

                            if($search =="") //IF serchbar pusty
                            {
                                $query = "SELECT user_id, username, email FROM users WHERE role=2";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa użytkownika</th>
                                                        <th>E-mail</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $id = $row['user_id'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            echo "
                                                <tr>
                                                    <td>$id</td>
                                                    <td>$username";
                                                        if($username == $_SESSION['username'])
                                                        {
                                                            echo " (Ty)";
                                                        }
                                                    echo "</td>
                                                    <td>$email</td>
                                                    <td><a href=\"zmien-user-status.php?action=1&id=$id\" onclick=\"return confirm('Czy na pewno chcesz zabrać uprawnienia administratora temu użytkownikowi?')\">Usuń administratora</a></td>
                                                    <td></td>
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
                                        echo 'Brak administratorów';
                                    }
                                }
                            }
                            elseif($search !="")//IF serchbar jest
                            {
                                $query = "SELECT user_id, username, email FROM users WHERE role=2 AND username LIKE '%$search%'";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa użytkownika</th>
                                                        <th>E-mail</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $id = $row['user_id'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            echo "
                                                <tr>
                                                    <td>$id</td>
                                                    <td>$username";
                                                        if($username == $_SESSION['username'])
                                                        {
                                                            echo " (Ty)";
                                                        }
                                                    echo "</td>
                                                    <td>$email</td>
                                                    <td><a href=\"zmien-user-status.php?action=1&id=$id\" onclick=\"return confirm('Czy na pewno chcesz zabrać uprawnienia administratora temu użytkownikowi?')\">Usuń administratora</a></td>
                                                    <td></td>
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
                                        echo 'Brak administratorów';
                                    }
                                }
                            }
                        }
                    ?>

                </div>

                <div class="section"> <!-- Zatrudnieni pracownicy -->
                    <h2>Zatrudnieni pracownicy</h2>

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
                            $search = "";

                            // Pobieranie zawartosci searchbar
                            if(isset($_GET['search_bar']))
                            {
                                $search=$_GET['search_bar'];
                            }

                            if($search =="") //IF serchbar pusty
                            {
                                $query = "SELECT user_id, username, email FROM users WHERE role=1";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa użytkownika</th>
                                                        <th>E-mail</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $id = $row['user_id'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            echo "
                                                <tr>
                                                    <td>$id</td>
                                                    <td>$username</td>
                                                    <td>$email</td>
                                                    <td><a href=\"zmien-user-status.php?action=1&id=$id\" onclick=\"return confirm('Czy na pewno chcesz zabrać uprawnienia pracownika temu użytkownikowi?')\">Zabierz dostęp</a></td>
                                                    <td><a href=\"zmien-user-status.php?action=2&id=$id\" onclick=\"return confirm('Czy na pewno chcesz nadać uprawnienia administratora temu użytkownikowi?')\">Administrator</a></td>
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
                                        echo 'Brak zatrudnionych użytkowników';
                                    }
                                }
                            }
                            elseif($search !="")//IF serchbar jest
                            {
                                $query = "SELECT user_id, username, email FROM users WHERE role=1 AND username LIKE '%$search%'";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa użytkownika</th>
                                                        <th>E-mail</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $id = $row['user_id'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            echo "
                                                <tr>
                                                    <td>$id</td>
                                                    <td>$username</td>
                                                    <td>$email</td>
                                                    <td><a href=\"zmien-user-status.php?action=1&id=$id\" onclick=\"return confirm('Czy na pewno chcesz zabrać uprawnienia pracownika temu użytkownikowi?')\">Zabierz dostęp</a></td>
                                                    <td><a href=\"zmien-user-status.php?action=2&id=$id\" onclick=\"return confirm('Czy na pewno chcesz nadać uprawnienia administratora temu użytkownikowi?')\">Administrator</a></td>
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
                                        echo 'Brak zatrudnionych użytkowników';
                                    }
                                }
                            }
                        }

                        $connect -> close();

                    ?>

                </div>


                <div class="section"> <!-- Wszyscy uzytkownicy -->
                    <h2>Wszyscy uzytkownicy</h2>

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
                            $search = "";

                            // Pobieranie zawartosci searchbar
                            if(isset($_GET['search_bar']))
                            {
                                $search=$_GET['search_bar'];
                            }

                            if($search =="") //IF serchbar pusty
                            {
                                $query = "SELECT user_id, username, email FROM users WHERE role=0";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa użytkownika</th>
                                                        <th>E-mail</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $id = $row['user_id'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            echo "
                                                <tr>
                                                    <td>$id</td>
                                                    <td>$username</td>
                                                    <td>$email</td>
                                                    <td></td>
                                                    <td><a href=\"zmien-user-status.php?action=3&id=$id\" onclick=\"return confirm('Czy na pewno chcesz nadać uprawnienia pracownika temu użytkownikowi?')\">Pracownik</a></td>
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
                                        echo 'Brak użytkowników';
                                    }
                                }
                            }
                            elseif($search !="")//IF serchbar jest
                            {
                                $query = "SELECT user_id, username, email FROM users WHERE role=0 AND username LIKE '%$search%'";
                                if($result = $connect->query($query))
                                {
                                    if($result->num_rows>0) // IF sa wyniki wyszukiwania bez searchbar
                                    {
                                        echo "
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nazwa użytkownika</th>
                                                        <th>E-mail</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                        ";

                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $id = $row['user_id'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            echo "
                                                <tr>
                                                    <td>$id</td>
                                                    <td>$username</td>
                                                    <td>$email</td>
                                                    <td></td>
                                                    <td><a href=\"zmien-user-status.php?action=3&id=$id\" onclick=\"return confirm('Czy na pewno chcesz nadać uprawnienia pracownika temu użytkownikowi?')\">Pracownik</a></td>
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
                                        echo 'Brak użytkowników';
                                    }
                                }
                            }
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