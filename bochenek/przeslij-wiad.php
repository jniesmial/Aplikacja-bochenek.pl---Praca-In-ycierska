<?php
    session_start();
    require_once("db_connect.php");

    $connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

    if (!$connect) 
	{
	  die("Connection failed: " . mysqli_connect_error());
	}
	if($connect->connect_errno!=0)
	{
		echo "Błąd: ".$connect->connect_errno."<br>".$connect->connect_error;
	}
	else
    {
        $imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
        $nr_tel = $_POST['nr_tel'];
        $email = $_POST['email'];
        $temat = $_POST['temat'];
        $wiadomosc = $_POST['wiadomosc'];

        $query = "INSERT INTO wiadomosci(imie, nazwisko, nr_tel, email, temat, wiadomosc) 
        VALUES('$imie', '$nazwisko', '$nr_tel', '$email', '$temat', '$wiadomosc')";
        if($connect ->query($query))
        {
            header("Location: kontakt.php");
        }
        else
        {
            echo "Błąd wysyłania wiadomości";
        }

		$connect->close();
    }
?>