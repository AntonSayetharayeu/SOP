<!-- <div class="container d-flex justify-content-center align-items-center" style="height: 500px;">
    <form method="post" action="index.php">
        <button class="btn btn-primary btn-dark" type="submit" name="value" value="offer">Get Started</button>
    </form>
</div> -->
<?php
$allOffers = [
    "Oferta 1", "Oferta 2", "Oferta 3", "Oferta 4", "Oferta 5", 
    "Oferta 6", "Oferta 7", "Oferta 8", "Oferta 9", "Oferta 10",
    // ... kolejne oferty ...
];

// Liczba ofert na stronę
$offersPerPage = 5;

// Oblicz całkowitą liczbę ofert
$totalOffers = count($allOffers);

// Oblicz liczbę stron
$totalPages = ceil($totalOffers / $offersPerPage);

// Pobierz numer bieżącej strony (domyślnie pierwsza strona)
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Oblicz indeks początkowy i końcowy ofert dla bieżącej strony
$startIndex = ($currentPage - 1) * $offersPerPage;
$endIndex = $startIndex + $offersPerPage - 1;
$endIndex = min($endIndex, $totalOffers - 1); // Zapobieganie wyjściu poza zakres

// Pobierz tylko oferty dla bieżącej strony
$currentOffers = array_slice($allOffers, $startIndex, $offersPerPage);

// Wyświetl oferty
foreach ($currentOffers as $offer) {
    echo $offer . "<br>";
}

// Generuj nawigację

echo "<br>";

// Przycisk poprzedniej strony
if ($currentPage > 1) {
    $prevPage = $currentPage - 1;
    echo "<a href=\"?page=$prevPage\">Poprzednia</a> ";
}

// Wyświetl numery stron
for ($page = 1; $page <= $totalPages; $page++) {
    echo "<a href=\"?page=$page\">$page</a> ";
}

// Przycisk następnej strony
if ($currentPage < $totalPages) {
    $nextPage = $currentPage + 1;
    echo "<a href=\"?page=$nextPage\">Następna</a>";
}
?>