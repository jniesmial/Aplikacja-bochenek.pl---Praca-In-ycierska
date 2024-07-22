<?php
    session_start();
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
    else //IF connection OK
    {
        $sciezka_zdj="images/products_img/";
        $file_name="";

        $nazwa=$_POST['nazwa'];
        $opis=$_POST['opis'];
        $skladniki=$_POST['skladniki'];

        $dodatkowe_info="";
        if(isset($_POST['dodatkowe_info']))
        {
            $dodatkowe_info=$_POST['dodatkowe_info'];
        }

        $cena=$_POST['cena'];

        $kategoria_name=$_POST['kategoria'];
        $kategoria_id=-1;
        $query = "SELECT kategoria_id FROM kategorie WHERE nazwa_kategorii LIKE '".$kategoria_name."'";
        if($result = $connect->query($query))
        {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $kategoria_id = $row['kategoria_id'];
        }
        $result->free_result();


        // Obsługa przesłanego zdjęcia
        if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) 
        {
            $uploadDir = 'images/products_img/';
            $fileName = $_FILES['fileInput']['name'];

            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '.' . $fileExtension;

            $targetPath = $uploadDir . $uniqueFileName;

            if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $targetPath)) 
            {
                $file_name = $uniqueFileName;
            } else 
            {
                echo "Błąd podczas przesyłania zdjęcia.";
            }
        } else 
        {
            echo "Nie przesłano zdjęcia lub wystąpił błąd podczas przesyłania.";
        }

        // Zabezpiecz dane przed atakami SQL Injection
        // $nazwa = $conn->real_escape_string($nazwa);
        // $opis = $conn->real_escape_string($opis);
        // $skladniki = $conn->real_escape_string($skladniki);
        // $dodatkowe_info = $conn->real_escape_string($dodatkowe_info);
        // $file_name = $conn->real_escape_string($file_name);
        // $kategoria_id = $conn->real_escape_string($kategoria_id);

        // Stworzenie i przeslanie zapytania
        $query = "INSERT INTO produkty (nazwa_produktu, opis_produktu, skladniki, dodatkowe_info, cena, file_name, kategoria) 
        VALUES('$nazwa', '$opis', '$skladniki', '$dodatkowe_info', $cena, '$file_name', '$kategoria_id')";
        if($connect->query($query)===TRUE)
        {
            header("Location: zarzadzaj.php");
            echo "dodano produkt";
        }
        else
        {
            echo "blad dodawania".$connect->error;
        }

        
        
    }

    $connect->close();

?>