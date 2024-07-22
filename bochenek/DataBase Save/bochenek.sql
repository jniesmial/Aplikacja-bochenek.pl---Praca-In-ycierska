-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Paź 2023, 12:24
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bochenek`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dane_odbioru`
--

CREATE TABLE `dane_odbioru` (
  `dane_id` int(11) NOT NULL,
  `imie` varchar(50) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `nazwisko` varchar(50) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL,
  `nr_tel` varchar(9) CHARACTER SET utf16 COLLATE utf16_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `dane_odbioru`
--

INSERT INTO `dane_odbioru` (`dane_id`, `imie`, `nazwisko`, `nr_tel`) VALUES
(1, 'Andrzej', 'Dupa', '111222333'),
(2, 'Kurowa', 'Kucy', '999999999'),
(3, 'a', 'a', '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `do_zamowienia`
--

CREATE TABLE `do_zamowienia` (
  `zamowienie_id` int(11) NOT NULL,
  `produkt_id` int(11) NOT NULL,
  `ilosc` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `do_zamowienia`
--

INSERT INTO `do_zamowienia` (`zamowienie_id`, `produkt_id`, `ilosc`) VALUES
(1, 1, 7),
(2, 3, 1),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `kategoria_id` int(11) NOT NULL,
  `nazwa_kategorii` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`kategoria_id`, `nazwa_kategorii`) VALUES
(0, 'Bułka'),
(1, 'Chleb');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `produkt_id` int(11) NOT NULL,
  `nazwa_produktu` varchar(50) NOT NULL,
  `opis_produktu` varchar(1000) NOT NULL,
  `skladniki` varchar(500) NOT NULL,
  `dodatkowe_info` varchar(200) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `kategoria` int(11) NOT NULL,
  `widocznosc` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`produkt_id`, `nazwa_produktu`, `opis_produktu`, `skladniki`, `dodatkowe_info`, `cena`, `file_name`, `kategoria`, `widocznosc`) VALUES
(1, 'Bułka mazurska 80 g', 'Rustykalna bułka o twardej, spękanej skórce, produkowana metodą naturalnej fermentacji ciasta.', 'mąka PSZENNA, woda, naturalny zakwas PSZENNY (mąka PSZENNA, woda, drożdże), sól.', '', '1.29', 'bulka_mazurska.jpg', 0, 1),
(2, 'Bułka Tyrolska 90 g', 'Bułka pszenna z dodatkiem nasion chia oraz mąk z pradawnych odmian pszenicy (płaskurki i orkiszu), posypana mieszanką ziaren.', 'mąka PSZENNA, woda, mąka PSZENNA płaskurka, mąka PSZENNA orkiszowa, nasiona słonecznika, siemię lniane, nasiona chia, SEZAM, kasza jaglana, ziarno komosy ryżowej, drożdże, miód, słód JĘCZMIENNY, sól, cukier, zioła prowansalskie.', '', '1.00', 'bulka_tyrolska.jpg', 0, 1),
(3, 'Bułka Rustiko  70 g', 'Wieloziarnista bułka z otrębami.', 'mąka PSZENNA, woda, otręby PSZENNE, nasiona słonecznika, siemię lniane, SEZAM, słód JĘCZMIENNY, drożdże, płatki OWSIANE, sól, serwatka (z MLEKA), przyprawy.', '', '1.04', 'bulka_rustiko.jpg', 0, 1),
(4, 'Bułka Beta 120 g', 'Bułka pszenna o niskim indeksie glikemicznym (IG 49) z dodatkiem ziaren owsa oraz mąki uzyskanej z zewnętrznej warstwy ziaren owsa. \r\n\r\nBułka Beta zawiera rozpuszczalny błonnik pokarmowy - beta-glukan, który ma dobroczynny wpływ na organizm: m.in. obniża poziom cholesterolu, zmniejsza wchłanianie tłuszczów, wywołuje uczucie sytości. \r\n\r\nBułka powstała z myślą o najmłodszych oraz konsumentach zmagających się z nadwagą i cukrzycą.', 'mąka PSZENNA, woda, ziarna OWSA (5%), skondensowana mąka OWSIANA z otoczki ziarna OWSA (5%), płatki OWSIANE (2%) drożdże, sól.', '', '1.99', 'bulka_beta.jpg', 0, 1),
(5, 'Bułka Wrocławska 300 g', 'Podłużna bułka pszenna o delikatnej strukturze.', 'mąka PSZENNA, woda, olej rzepakowy, drożdże, sól, cukier.', '', '7.49', 'bulka_wroclawska.jpg', 0, 1),
(6, 'BEZGLUTENOWA Bułka Szkolna 150 g', 'Bułka z mąki ryżowej posypana makiem.', 'mąka ryżowa, skrobia ryżowa, skrobia z tapioki, woda, mak niebieski (9%), cukier, olej rzepakowy, drożdże, sól.', 'Numer rejestracyjny produktu: PL-033-066\r\n\r\nTermin przydatności: 6 dni', '2.49', 'bg_bulka_szkolna.jpg', 0, 1),
(7, 'Kajzerka 55 g', 'Delikatna, okrągła bułka pszenna. ', 'mąka PSZENNA, woda, olej rzepakowy, drożdże, sól, cukier.', '', '0.69', 'kajzerka.jpg', 0, 1),
(8, 'Ciabatka 60 g', 'Lekka bułka z włoskim rodowodem produkowana metodą naturalnej fermentacji ciasta.', 'mąka PSZENNA, naturalny zakwas PSZENNY (mąka PSZENNA, woda, drożdże), woda, drożdże, sól, cukier.', '', '0.89', 'ciabatka.jpg', 0, 1),
(10, 'Grahamka 65 g', 'Okrągła bułka z mąki graham.', 'mąka PSZENNA graham (43%), mąka PSZENNA, woda, drożdże, cukier, sól, serwatka (z MLEKA).', '', '0.89', 'grahamka.jpg', 0, 1),
(11, 'Grahamka Słonecznikowa 70 g', 'Grahamka z nasionami słonecznika.', 'mąka PSZENNA graham (32%), mąka PSZENNA, woda, nasiona słonecznika (10%), drożdże, olej rzepakowy, cukier, sól, słód JĘCZMIENNY, serwatka (z MLEKA).', '', '1.29', 'grahamka_slonecznikowa.jpg', 0, 1),
(12, 'Chleb Wieloziarnisty 450 g', 'Chleb pszenno-żytni z dodatkiem ziaren żyta, jęczmienia, soi, siemienia lnianego, nasion słonecznika i sezamu.', 'mąka PSZENNA, naturalny zakwas ŻYTNI (mąka ŻYTNIA, woda), mieszanka ziaren (ŻYTO, PSZENICA, JĘCZMIEŃ, SOJA, siemię lniane, SEZAM), woda, nasiona słonecznika, słód JĘCZMIENNY, drożdże, sól, otręby PSZENNE, płatki OWSIANE, serwatka (z MLEKA), słód ŻYTNI.', '', '6.49', 'chleb_wieloziarnisty.jpg', 1, 1),
(13, 'Chleb Piastowski 900 g', 'Chleb pszenno-żytni z charakterystyczną spękaną skórką, oprószony mąką. ', 'mąka PSZENNA (50 %), naturalny zakwas ŻYTNI (36 %) (mąka ŻYTNIA, woda), woda, sól, drożdże, mąka SOJOWA.', '', '11.79', 'chleb_piastowski.jpg', 1, 1),
(14, 'Chleb Pasterski 400 g', 'Chleb w stylu włoskim z grubą, z chrupiąca skórką.', 'mąka PSZENNA, woda, naturalny zakwas PSZENNY (mąka PSZENNA, woda, drożdże), gluten PSZENNY, sól, słód JĘCZMIENNY, słód ŻYTNI, mąka z PSZENICY durum, przyprawy.', '', '7.09', 'chleb_pasterski.jpg', 1, 1),
(15, 'Chleb Orkiszowy 500 g', 'Chleb wypieczony w 100% z mąki orkiszowej. Charakteryzuje się apetyczną wypieczoną skórką i wyrazistym smakiem.', 'mąka PSZENNA orkiszowa (58%), woda, otręby ORKISZOWE (4%) kiełki ORKISZOWE (3%), zakwas ORKISZOWY (3%) (mąka ORKISZOWA pełnoziarnista, woda), mąka z PSZENICY durum, gluten PSZENNY, słód JĘCZMIENNY, sól, drożdże, inulina, ocet winny. ', '', '9.29', 'chleb_orkiszowy.jpg', 1, 1),
(16, 'Chleb Szwajcarski 350 g', 'Ręcznie formowany pszenny chleb o delikatnej strukturze miękiszu.', 'mąka PSZENNA, woda, naturalny zakwas PSZENNY (mąka PSZENNA, woda, drożdże), cukier, olej rzepakowy, sól.', 'WYPRODUKOWANO W POLSCE.', '6.19', 'chleb_szwajcarski.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `nazwa_roli` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`role_id`, `nazwa_roli`) VALUES
(0, 'klient'),
(1, 'pracownik'),
(2, 'administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `role` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`) VALUES
(0, 'admin', 'admin@gmail.com', '$2y$10$8npN50rVQpVViNp19IBBauG4w4ryFH50lkHnRoU9vswH4Zxu1M04m', 2),
(1, 'test', 'test@gmail.com', '$2y$10$1HgTcbbCU1jCX6yt9lcvHe3PPHAQjzNgvKCiREsaLO1d1Yx96HMIG', 0),
(2, 'pracownik01', 'pracownik01@gmail.com', '$2y$10$Bzmn/gppzxq/i9KzJPVZ2.qvM91CxrY450V5G2jJrMD8KJYcJB3o.', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `zamowienie_id` int(11) NOT NULL,
  `klient` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `suma` decimal(10,2) NOT NULL,
  `status` int(1) NOT NULL,
  `odbior_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`zamowienie_id`, `klient`, `data`, `suma`, `status`, `odbior_id`) VALUES
(1, 1, '2023-09-30 02:41:00', '7.63', 4, 1),
(2, 2, '2023-09-30 02:44:00', '1.04', 1, 2),
(3, 2, '2023-09-30 02:50:00', '1.09', 2, 3);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dane_odbioru`
--
ALTER TABLE `dane_odbioru`
  ADD PRIMARY KEY (`dane_id`);

--
-- Indeksy dla tabeli `do_zamowienia`
--
ALTER TABLE `do_zamowienia`
  ADD KEY `produkt11` (`produkt_id`),
  ADD KEY `zamowienie11` (`zamowienie_id`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kategoria_id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`produkt_id`),
  ADD KEY `kategoria` (`kategoria`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD KEY `user_role` (`role`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`zamowienie_id`),
  ADD KEY `klient11` (`klient`),
  ADD KEY `dane_odbioru11` (`odbior_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `dane_odbioru`
--
ALTER TABLE `dane_odbioru`
  MODIFY `dane_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `produkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `zamowienie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `do_zamowienia`
--
ALTER TABLE `do_zamowienia`
  ADD CONSTRAINT `produkt11` FOREIGN KEY (`produkt_id`) REFERENCES `produkty` (`produkt_id`),
  ADD CONSTRAINT `zamowienie11` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienia` (`zamowienie_id`);

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`kategoria`) REFERENCES `kategorie` (`kategoria_id`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_role` FOREIGN KEY (`role`) REFERENCES `roles` (`role_id`);

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `dane_odbioru11` FOREIGN KEY (`odbior_id`) REFERENCES `dane_odbioru` (`dane_id`),
  ADD CONSTRAINT `klient11` FOREIGN KEY (`klient`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
