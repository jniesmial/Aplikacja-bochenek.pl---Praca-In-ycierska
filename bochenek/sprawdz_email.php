<?php 
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
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $check_email = mysqli_query($connect, $sql);

        if (!$check_email) {
            die("Błąd zapytania SQL: " . mysqli_error($connect));
        }

        //sprawdza czy zmienna $check_email nie jest pusta oraz czy ilosc jej wierszy jest wieksza od zera
        // $check_email && $check_email->num_rows
        if (mysqli_num_rows($check_email) > 0) 
        {
            echo "zajety";
        }
        else
        {
            echo "dostepny";
        }
    }

    mysqli_close($connect);
?>