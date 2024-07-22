<!doctype html>
<?php
    session_start();
?>
<html lang="pl">

<head> 
    <!--META-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>piekarniabochenek.pl</title>

    <!--Link Style-->
	<link rel="StyleSheet" type="text/css" href="styles/style.css">
    <link rel="StyleSheet" type="text/css" href="styles/ofirmie-style.css">

    <!--Link Fonts - Roboto (regular, medium, bold, black)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!--Link Icons-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <header>
        <div class="wrapper">
            <a href="index.php" id="logo"> <img src="images/logo-bochenek.svg" alt="logo-bochenek"> </a>

            <?php
				if(!isset($_SESSION['username']))
				{
					$user_display = "none";
				}
				else
				{
					$user_display = "flex";
				}
			?>

            <div class="logged-user" style="display: <?php echo $user_display; ?> ">
                    <p>Zalogowano jako <?php echo $_SESSION['username']; ?>
                        <form method="get" action="koszyk.php">
                            <input type="hidden" name="action" value="view">
                            <button type="submit" title="Przejdź do koszyka">
                            <i class='bx bxs-cart'></i>
                            </button>
                        </form>



                        <!-- <a href="koszyk.php" title="Przejdź do koszyka"><i class='bx bxs-cart'></i></a>  -->
                        <!-- <a href="#" title="Przejdz do profilu"><i class='bx bxs-user-circle'></i></a> ikona usera w okregu
                        <a href="logout.php" title="Wyloguj się"><i class='bx bx-log-out'></i></a> ikona wylogowania -->
                    </p>
            </div>

            <nav>
                <a href="#" id="menu-icon">
                    <div class="burger-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                      </div>
                </a>

                <ul>
                    <li><a href="produkty.php">PRODUKTY</a></li>
                    <li><a href="ofirmie.php">O FIRMIE</a></li>
                    <li><a href="kontakt.php">KONTAKT</a></li>
                    
                    <?php
                        if(!isset($_SESSION['username']))
                        {
                            echo '<li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                            <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="profil.php">PROFIL</a></li>
                            <li><a class="button-1" href="logout.php">WYLOGUJ SIĘ</a></li>';
                        }

                        if(isset($_SESSION['role']))
                        {
                            if($_SESSION['role']==1)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>';
                            }
                            else if($_SESSION['role']==2)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>
                                <li> <a href="pracownicy.php">PRACOWNICY</a> </li>';
                            }
                        }
                    ?>

                </ul>
            </nav>



        </div>
    </header>

    <!--STERT HERE-->
    <div class="box">
        <div class="wrapper">

            <h1>Dowiedz się czegoś <span style="color: #B6571E">o nas</span></h1>

            <div class="ofirmie-one">
                <div class="columns1">

                    <div class="left-col1">
                        <p>Nasza historia rozpoczyna się wiele lat temu, w sercu małego miasteczka o nazwie Willowdale. 
                        W tamtych czasach, chleb był symbolem wspólnoty i tradycji, a jego aromat przyciągał ludzi z całego regionu.</p>
                        
                        <p>Właścicielami Piekarni "Bochenek" są bracia, Tomasz i Michał, którzy od dzieciństwa kształtowali swoją pasję do
                        pieczenia pod czujnym okiem swojej babci, która zawsze uczyła ich tajników wypieku chleba. To były te wspólne chwile 
                        spędzane nad mąką i drożdżami, które stały się iskrą, inspirującą do założenia własnej piekarni.</p>
                    </div>

                    <div class="right-col1">
                        <img src="images/ofirmie1.jpg">
                    </div>
                </div>
            </div>

            <div class="ofirmie-2">
                <p>W 2005 roku, po wielu latach nauki i doskonalenia swojego rzemiosła, bracia otworzyli Piekarnię "Bochenek" z zamiarem 
                    kontynuowania rodzinnego dziedzictwa wypieku chleba i cukiernictwa. Nasza piekarnia została nazwana "Bochenek" na cześć pierwszego chleba, 
                    który został upieczony przez naszych przodków w starym piecu. Ten chleb był naszą inspiracją, aby tworzyć autentyczne i smaczne produkty piekarnicze, 
                    które cieszą podniebienia naszych klientów.</p>

                <div class="zdj-2">
                        <img src="images/ofirmie2.jpg">
                </div>
            </div>

            <div class="ofirmie-3">
                <div class="columns2">
                    <div class="left-col2">
                        <img src="images/ofirmie3.jpg">
                    </div>

                    <div class="right-col2">
                        <p>Dzięki połączeniu tradycji i nowoczesności, Piekarnia "Bochenek" oferuje teraz szeroki wybór świeżo upieczonych chlebów, bułek, ciast i wypieków, 
                        które przywołują wspomnienia z dzieciństwa i tworzą nowe smakowe doświadczenia. Nasze produkty są wyrabiane ręcznie, z najwyższej jakości składników, 
                        bez dodatków chemicznych ani konserwantów.</p>

                        <p>Dzięki wsparciu naszej wspaniałej społeczności i pasji do pieczenia, Piekarnia "Bochenek" stała się miejscem, gdzie smak i tradycja spotykają się na nowo. 
                        Zapraszamy Cię na podróż przez smakowe wspomnienia i zachęcamy do odwiedzenia naszej piekarni, aby cieszyć się smakiem "Bochenka".</p>

                    </div>
                </div>
            </div>

            <h2>Dziękujemy za <span>wsparcie</span> i <span>zaufanie</span>, które nas napędza każdego dnia.</h2>

        </div>
    </div>

    <div class="footer">
        <div class="wrapper">
            <div class="footer-items">
                <div class="left">
                    <ul>
                        <li><a href="index.php">STRONA GŁÓWNA</a></li>
                        <li><a href="produkty.php">PRODUKTY</a></li>
                        <li><a href="ofirmie.php">O FIRMIE</a></li>
                        <li><a href="kontakt.php">KONTAKT</a></li>

                        <?php
                        if(!isset($_SESSION['username']))
                        {
                            echo '<li><a href="logowanie.php">ZALOGUJ SIĘ</a></li>
                            <li><a class="button-1" href="rejestracja.php">ZAREJESTRUJ SIĘ</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="profil.php">PROFIL</a></li>
                            <li><a href="logout.php">WYLOGUJ SIĘ</a></li>';
                        }

                        if(isset($_SESSION['role']))
                        {
                            if($_SESSION['role']==1)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>';
                            }
                            else if($_SESSION['role']==2)
                            {
                                echo '<li> <a href="zamowienia.php">ZAMÓWIENIA</a> </li>
                                <li> <a href="pracownicy.php">PRACOWNICY</a> </li>';
                            }
                        }
                    ?>

                    </ul>
                </div>
        
                <div class="right">
                    <hf>SKONTAKTUJ SIĘ Z NAMI BEZPOŚREDNIO NA:</hf>
                    <p>piekarnia-bochenek@gmail.com <br> tel. 123 456 789 </p>
                </div>
            </div>
        </div>
    </div> 

</body>


</html>