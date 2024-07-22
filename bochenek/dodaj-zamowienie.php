<?php
    session_start();
    $items = $_SESSION['cart_items'];
	$suma = 0;
	foreach($items as $item)
	{
		echo $item['nazwa_produktu']."<br>";
		echo $item['cena']."<br>";
		echo $item[0]."<br>";
		echo $item['produkt_id']."<br>********<br>";
		$suma += $item[0] * $item['cena'];
        echo $suma."<br>";
	}

    // zmienne z formularza koszyk-dane.php
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $nr_tel = $_POST['nr_tel'];

    echo $imie."<br>";
    echo $nazwisko."<br>";
    echo $nr_tel."<br>";


    // CONTROL MESSAGE -----------------------------------------------
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
        $username = $_SESSION['username'];
        $userid = 0;
		$date = date("Y/m/d H:i");

        // Pobieranie user_id zalogowanego uzytkownika z bazy
		$query = "select user_id from users where username = '$username'";
        if($result = @$connect->query($query))
        {
            if ($result->num_rows > 0)
            {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				$userid = $row['user_id'];

				$result->free_result();
            }
            else
			{
				echo 'Uzupełnij bazę bo coś pusto';
			}
        }
        echo "user_id: ".$userid; // CONTROL MESSAGE -----------------

    
        // sprawdzenie czy w bazie wystepuje juz zestaw danych do odbioru aby ich nie powielac
        $daneid=-1;
        $query = "SELECT dane_id FROM dane_odbioru WHERE imie='$imie' AND nazwisko='$nazwisko' AND nr_tel='$nr_tel';";
        if($result = $connect->query($query))//udane zapytanie
        {
            //If w bazie znajduja sie juz identyczne dane odbioru to zapisz dane_id
            if ($result->num_rows > 0)
            {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $daneid = $row['dane_id'];

                echo "<br> dane_odbioru.dane_id = ".$daneid; // CONTROL MESSAGE -----------------
            }
            // w bazie nie znaleziono podanych danych odbioru, nalezy je dodac i zapisac dane_id
            else
            {
                echo "<br>nie znaleziono danych odbioru"; // CONTROL MESSAGE -----------------
                $query = "INSERT INTO dane_odbioru(imie, nazwisko, nr_tel) VALUES('$imie', '$nazwisko', '$nr_tel')";
                if($connect->query($query) === true)
                //If dodanie sie uda
                {
                    $daneid = mysqli_insert_id($connect);
                    echo "<br>dodano dane odbioru. dane_id = ".$daneid; // CONTROL MESSAGE -----------------
                }
                else //nie udalo sie dodac danych odbioru
                {
                    header('Location: blad.php');
                }
            
            }
        }
        // $daneid powinno miec id istniejacego zestawu danych odbioru lub przypisany nowo utworzonego recordu
        else // blad nadania id danych do odbioru
        {
            header('Location: blad.php');
        }

        //dodanie zamowienia (z role=0) i pobranie zamowienie_id dodanego recordu
        $query = "INSERT INTO zamowienia(klient, data, suma, odbior_id) VALUES($userid, '$date', $suma, $daneid)";
        if($connect->query($query) === true)
        {
            echo "<br>dodano zamowienie"; // CONTROL MESSAGE -----------------
            $zamowienieid = mysqli_insert_id($connect);
            foreach($items as $item)
            {
                $query = "INSERT INTO do_zamowienia(zamowienie_id, produkt_id, ilosc) VALUES($zamowienieid, ".$item['produkt_id'].", ".$item[0].")";
                if($connect->query($query) === true)
                {
                    echo "<br>dodano produkt/produkty do zamowienia"; // CONTROL MESSAGE -----------------
                    unset($_SESSION['cart_items']);
                    echo "<br>wyczyszczono koszyk"; // CONTROL MESSAGE -----------------

                    header('Location: zamowiono.php');
                }
                else
                {
                    header('Location: blad.php');
                    echo "<br>NIE dodano produktu/produktow do zamowienia"; // CONTROL MESSAGE -----------------
                }
            }
        }
        else
        {
            header('Location: blad.php');
            //echo "<br>nie dodano zamowienia"; // CONTROL MESSAGE -----------------
        }


    }

    $connect -> close();

?>