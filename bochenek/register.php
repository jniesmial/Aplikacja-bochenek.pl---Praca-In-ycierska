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
        $username =  $_REQUEST['username'];
        $email = $_REQUEST['email'];
		$password = $_REQUEST['password'];
		$confirm = $_REQUEST['confirm'];

        $check_username = $connect->query("SELECT * FROM users WHERE username LIKE '".$username."'");
        $check_email = $connect->query("SELECT * FROM users WHERE email LIKE '".$email."'");
		
        //sprawdza czy zmienna $check_username nie jest pusta oraz czy ilosc jej wierszy jest wieksza od zera
        if ($check_username && $check_username->num_rows > 0) {
            echo '<script>alert("Konto o tej nazwie użytkownika już istnieje");</script>';
            echo '<script>window.location.href = "rejestracja.php";</script>';
        }
        //sprawdza czy zmienna $check_email nie jest pusta oraz czy ilosc jej wierszy jest wieksza od zera
        elseif ($check_email && $check_email->num_rows > 0) {
            echo '<script>alert("Konto z tym adresem e-mail już istnieje");</script>';
            echo '<script>window.location.href = "rejestracja.php";</script>';
        }
        //sprawdza czy haslo i potwierdzenie hasla sa takie same
        elseif ($password !== $confirm) {
			echo '<script>alert("Hasla nie sa takie same!");</script>';
            echo '<script>window.location.href = "rejestracja.php";</script>';
        }
        //jesli username oraz email nie sa zajete oraz haslo i confirm sa takie same to
        else {
            //zabezpieczenie hasla
            $password = password_hash($password,PASSWORD_BCRYPT);
            //utworzenie zapytania sql z danymi użytkownika
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

            if(mysqli_query($connect, $sql)){
                header('Location: zarejestrowano.php');
                // echo '<script>alert("Twoje konto zostało utworzone");</script>';
                // echo '<script>window.location.href = "index.php";</script>'; // Przekierowanie po wyświetleniu alertu
            } else{
                echo "Error $sql. "
                    . mysqli_error($connect);
            }

        }

        $connect->close();
		$_SESSION['username'] = $username;
        $_SESSION['role'] = 0;
    }
?>

