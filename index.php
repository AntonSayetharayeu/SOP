<?php
if (file_exists("core/.config/config.php")) {
    require("core/.config/config.php");
} else {
    // echo "<body>\n<h1>Error 1</h1>\n<p>Brak konfiguracji aplikacji</p>\n</body>";
    include("installer.php");
    exit;
}

if (file_exists("core/.config/con.fig.php")) {
    require("core/.config/con.fig.php");
} else {
    echo "<body>\n<h1>Error 2</h1>\n<p>Brak konfiguracji połączenia z serweram bazy danych</p>\n</body>";
    exit;
}

if (file_exists("core/lib/funkcje.php")) {
    include("core/lib/funkcje.php");
} else {
    echo "<body>\n<h1>Error 3</h1>\n<p>Brak siłnika apliakcji, nie ma funkcji</p>\n</body>";
    exit;
}

if ($dev == 1) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
}

if (file_exists("public/include-base/head.php"))
    include("public/include-base/head.php");
if (file_exists("public/include-base/nav.php"))
    include("public/include-base/nav.php");
if (file_exists("public/include-base/body.php"))
    include("public/include-base/body.php");
if (file_exists("public/include-base/footer.php"))
    include("public/include-base/footer.php");
?>