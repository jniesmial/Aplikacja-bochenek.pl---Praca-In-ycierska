<?php
    $zamowienie_id = $_GET['anulujid'];

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
	else //polaczenie OK
    {
      $query = "UPDATE zamowienia SET status=1 WHERE zamowienie_id = $zamowienie_id";
      if($result = $connect->query($query))
      {
        echo "anulowano poprawnie";
        header("Location: profil.php");
      }
      else
      {
        echo "blad anulowania";
      }
		  $connect->close();
    }
?>