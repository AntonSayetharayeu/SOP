<?php
session_start();
if (file_exists("../../core/lib/funkcje.php"))
    include("../../core/lib/funkcje.php");

if (file_exists("../../core/.config/con.fig.php"))
    require("../../core/.config/con.fig.php");

if (file_exists("../include-base/head.php"))
    include("../include-base/head.php");


generate_form("login");

if (isset($_POST['login'])) {

    $query = "SELECT u.ID ID, a.Name AS name, u.Password AS password, u.Login AS login, u.Access_level Access_level
    FROM " . $prefix . "_Users u, " . $prefix . "_Accounts a
    WHERE Login = '" . $_POST['login'] . "' AND a.ID = u.Account_id";

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);

        if (password_verify($_POST['password'], $row['password'])) {
            $_SESSION['u_id'] = $row['ID'];
            $_SESSION['email'] = $row['login'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['Access_level'] = $row['Access_level'];

            header("Location: ../../index.php");
            exit();
        } else {
            echo "<p class=\"text-center\">Incorrect password.</p>";
        }
    } else {
        echo "<p class=\"text-center\">The user does not exist or is inactive.</p>";
    }
}

if (file_exists("../include-base/footer.php"))
    include("../include-base/footer.php");

?>