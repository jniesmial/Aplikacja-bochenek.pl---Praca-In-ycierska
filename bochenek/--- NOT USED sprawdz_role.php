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
        $username = $_SESSION['username'];
        $sql = "SELECT role FROM users WHERE username = '$username'";
        $result = mysqli_query($connect, $sql);

        if (!$result) {
            die("Błąd zapytania SQL: " . mysqli_error($connect));
        }
        else if($row = mysqli_fetch_assoc($result))
        {
            $role = $row['role'];
            echo "$role";
        }
    }

    mysqli_close($connect);
?>