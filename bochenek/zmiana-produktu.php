<?php
    session_start();
    require_once 'db_connect.php';
    $connect = mysqli_connect($db_host, $db_username, $db_password, $db_name);

	if (!$connect) 
    {
		die("Connection failed: " . mysqli_connect_error());
	}

    // ACTION TYPES
    // 1 -nazwa 
    // 2 - opis
    // 3 - cena 
    // 4 - widocznosc
    $action = $_GET['action'];
    $produkt_id = $_GET['id'];

    $inputDecimal = 0.0;
    if(isset($_POST['inputDecimal']))
    {
        $inputDecimal = $_POST['inputDecimal'];
    }

    $inputText = "";
    if(isset($_POST['inputText']))
    {
        $inputText = $_POST['inputText'];
    }

    switch($action)
    {
        case 1: //dla nazwy produktu   
            $query = "UPDATE produkty SET nazwa_produktu = '$inputText' WHERE produkt_id = $produkt_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: zarzadzaj.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany danych ".$connect->error;
            }

            break;                                                

        case 2: //dla opisu produktu
            $query = "UPDATE produkty SET opis_produktu = '$inputText' WHERE produkt_id = $produkt_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: zarzadzaj.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany danych ".$connect->error;
            }                  
            
            break;

        case 3: //dla ceny produktu
            $query = "UPDATE produkty SET cena = $inputDecimal WHERE produkt_id = $produkt_id";
            if($connect->query($query)===TRUE)
            {
                header("Location: zarzadzaj.php");
                echo "zmieniono pomyślnie";
            }
            else
            {
                echo "Błąd zmiany danych ".$connect->error;
            } 

            break;

        case 4: //zmiana widocznosci
            $query = "SELECT widocznosc FROM produkty WHERE produkt_id = $produkt_id";
            if($result = $connect->query($query))
            {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $aktualna_widocznosc = $row['widocznosc'];
                // echo "<br>******************* aktualna_widocznosc = $aktualna_widocznosc<br>";
                $nowa_widocznosc = -1;
                if($aktualna_widocznosc == 1)
                {
                    $nowa_widocznosc = 0;
                }
                elseif ($aktualna_widocznosc == 0)
                {
                    $nowa_widocznosc = 1;
                }

                $query = "UPDATE produkty SET widocznosc = $nowa_widocznosc WHERE produkt_id = $produkt_id";
                if($connect->query($query)===TRUE)
                {
                    header("Location: zarzadzaj.php");
                    echo "zmieniono pomyślnie";
                }
                else
                {
                    echo "Błąd zmiany danych ".$connect->error;
                } 
            }

            $result->free_result();

            break;

        default: //Nieznana akcja

            echo "Nieznana akcja";
    }                    
    
    $connect->close();

    //echo "<br><br>akcja = $action<br>produkt_id = $produkt_id<br>inputText = <br>$inputText<br>inputDecimal = $inputDecimal";
?>