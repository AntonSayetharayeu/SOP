<?php
if (isset($_GET['value']))
    $wybor = $_GET['value'];
if (isset($_POST['value']))
    $wybor = $_POST['value'];



switch ($wybor) {
    case "offer":
        if (file_exists("public/include-menu/offer.php"))
            include("public/include-menu/offer.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;

    case "offer-page":
        if (file_exists("public/include-menu/offer-page.php"))
            include("public/include-menu/offer-page.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;
    case "offer-equipment":
        if (file_exists("public/include-menu/offer-equipment.php"))
            include("public/include-menu/offer-equipment.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;
    case "user-info":
        if (file_exists("public/include-user/user-info.php"))
            include("public/include-user/user-info.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;

    case "treasure":
        if (file_exists("public/include-user/treasure.php"))
            include("public/include-user/treasure.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;

    case "treasure-page":
        if (file_exists("public/include-user/treasure-page.php"))
            include("public/include-user/treasure-page.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;

    case "confirmation":
        if (file_exists("public/include-menu/confirmation.php"))
            include("public/include-menu/confirmation.php");
        else
            echo "<p class='alert alert-warning'>Error: cannot read the file</p>\n";
        break;

    default:
        if ($_SESSION['Access_level'] >= 1) {
            if (file_exists("public/include-admin/main-menu.php"))
                include("public/include-admin/main-menu.php");
            else
                echo "<p class='alert alert-warning'>Error: there must be a menu</p>\n";
        } else {
            if (file_exists("public/include-menu/main-menu.php"))
                include("public/include-menu/main-menu.php");
            else
                echo "<p class='alert alert-warning'>Error: there must be a menu</p>\n";
        }
        break;

}