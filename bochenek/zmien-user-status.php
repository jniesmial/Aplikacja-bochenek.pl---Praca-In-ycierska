<?php
    session_start();
    require_once 'db_connect.php';
    $connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

	if (!$connect) 
    {
		die("Connection failed: " . mysqli_connect_error());
	}

    // ACTION TYPES
    // 0 - A -> P
    // 1 - P -> K
    // 2 - P -> A
    // 3 - K -> P
    $action = $_GET['action'];
    $user_id = $_GET['id'];

    switch($action)
    {
        case 0:
            $query = "UPDATE users SET role=0 WHERE user_id = $user_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: pracownicy.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany uprawnień ".$connect->error;
            }
            break;

        case 3:
            $query = "UPDATE users SET role=1 WHERE user_id = $user_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: pracownicy.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany uprawnień ".$connect->error;
            }
            break;

        case 1:
            $query = "UPDATE users SET role=0 WHERE user_id = $user_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: pracownicy.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany uprawnień ".$connect->error;
            }
            break;
            break;

        case 2:
            $query = "UPDATE users SET role=2 WHERE user_id = $user_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: pracownicy.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany uprawnień ".$connect->error;
            }
            break;
            break;
        
        default:
            echo "niewlasciwe dane";
    }

    $connect->close();

?>

