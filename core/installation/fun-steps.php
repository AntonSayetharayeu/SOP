<?php

function form_install_step1()
{
    //trzeba zrobić formularz
}

function step2()
{
    global $config_file;

    $file = fopen($config_file, "w");
    $config = "<?php
    \$host=\"" . $_POST['host'] . "\";
    \$user=\"" . $_POST['user'] . "\";
    \$password=\"" . $_POST['passwd'] . "\";
    \$dbname=\"" . $_POST['dbname'] . "\";
    \$prefix=\"" . $_POST['prefix'] . "\";
    \$link = mysqli_connect(\$host, \$user, \$password, \$dbname);\n";
    if (!fwrite($file, $config)) {
        print "Nie mogę zapisać do pliku ($file)";
        exit;
    }
    echo "<p>Krok 2 zakończony: \n";
    echo "Plik konfiguracyjny utworzony</p>";

    fclose($file);
}

function step3()
{

    global $dbname;
    global $link;

    global $create;

    if (file_exists("sql/sql.php")) {
        include("sql/sql.php");

        echo "Tworzę tabele bazy: " . $dbname . ".<br>\n";
        mysqli_select_db($link, $dbname) or die(mysqli_error($link));

        for ($i = 0; $i < count($create); $i++) {
            echo "<p>" . $i . ". <code>" . $create[$i] . "</code></p>\n";
            mysqli_query($link, $create[$i]);
        }
    }
}

function step4()
{

    global $dbname;
    global $link;

    global $insert;

    if (file_exists("sql/insert.php")) {
        include("sql/insert.php");
        echo "<p>Wstawiam dane do tabel bazy: " . $dbname . ".</p>\n";
        mysqli_select_db($link, $dbname) or die(mysqli_error($link));
        for ($i = 0; $i < count($insert); $i++) {
            echo "<p>" . $i . ". <code>" . $insert[$i] . "</code></p>\n";
            mysqli_query($link, $insert[$i]);
        }
    }
}

function step5()
{
    global $config_file;

    $config = "\n# konfiguracja aplikacji\n
        \$base_url=\"" . $_POST['base_url'] . "\";
        \$nazwa_aplikacji=\"" . $_POST['nazwa_aplikacji'] . "\";
        \$data_powstania=\"" . $_POST['data_powstania'] . "\";
        \$wersja=\"" . $_POST['wersja'] . "\";
        \$brand=\"" . $_POST['brand'] . "\";
        \$adres1=\"" . $_POST['adres1'] . "\";
        \$adres2=\"" . $_POST['adres2'] . "\";
        \$phone=\"" . $_POST['phone'] . "\";
        \$img_footer=\"" . $_POST['base_url'] . "img/kashyyyk.jpg\";
        ";

    if (is_writable($config_file)) {
        if (!$uchwyt = fopen($config_file, 'a')) {
            echo "Nie mogę otworzyć pliku ($config_file)";
            exit;
        }
        if (fwrite($uchwyt, $config) == FALSE) {
            echo "Nie mogę zapisać do pliku ($config_file)";
            exit;
        }
        echo "Sukces, zapisano (<code>konfigurację</code>) do pliku (" . $config_file . ")";
        fclose($uchwyt);
    } else {
        echo "Plik " . $config_file . " nie jest zapisywalny";
    }
}

?>