<?php

// utworzyć plik konfiguracyjny (con.fig.php) (najlepiej jeżeli plik będzie znajdował się po za aplikacją, np. po za katalogiem public_html), którego zawartością będą:
// adres serwera MySQL: localhost
// login
// hasło
// nazwa bazy danych
// jako opcja może być stworzony również w tym pliku identyfikator połączenia - wynik działania funkcji  mysqli_connect;
// oraz może być wybrana baza danych funkcją mysqli_select_db();

$hostname = "localhost";
$username = "2024_asayetha";
$password = "20040813";
$dbname = "2024_asayetha";
$prefix = "pr";

$link = mysqli_connect($hostname, $username, $password) or die('Could not connect: ' . mysqli_connect_error());
mysqli_select_db($link, $dbname) or die('Could not select database: ' . mysqli_connect_error());
mysqli_query($link, "SET NAMES UTF8");

?>