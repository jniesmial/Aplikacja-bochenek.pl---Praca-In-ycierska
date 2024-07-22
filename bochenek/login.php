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
        $email = $_POST['email'];
		$password = $_POST['password'];

        // Pobierz zahaszowane hasło z bazy danych na podstawie adresu e-mail
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $sql);

        if ($row = mysqli_fetch_assoc($result)) 
        {
            $role = $row['role'];
            $username = $row['username'];
            $hashedPasswordFromDatabase = $row['password'];

            // Porównaj wprowadzone hasło z zahaszowanym hasłem z bazy danych
            if (password_verify($password, $hashedPasswordFromDatabase)) 
            {
                // Hasła pasują - użytkownik jest zalogowany
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                header("Location: zalogowano.php");
            } 
            else 
            {
                // Hasła nie pasują - błąd logowania
                header("Location: blednehaslo.php");
            }
        } 
        else 
        {
            // Brak użytkownika o podanym adresie e-mail - na stronie logowania AJAX sprawdza czy dany email jest w bazie i blokuje przycisk
            echo '<script>alert("123 cos nie tak");</script>';
            echo '<script>window.location.href = "logowanie.php";</script>';
        }

        $result->free_result();
		$connect->close();
    }
?>