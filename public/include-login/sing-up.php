<?php
if (file_exists("../../core/.config/con.fig.php"))
    require("../../core/.config/con.fig.php");

if (file_exists("../../core/lib/funkcje.php"))
    include("../../core/lib/funkcje.php");

if (file_exists("../include-base/head.php"))
    include("../include-base/head.php");

generate_form("sing-up");

if (isset($_POST['registration'])) {

    $error = false;

    if ($_POST['password'] != $_POST['repeatPassword']) {
        echo "<p class=\"text-center\">Repeat password, please!</p>";
        $error = true;
    }

    if (check_if_login_already_used($_POST['login'])) {
        echo "<p class=\"text-center\">Login is already used, use enother one, please!</p>";
        $error = true;
    }

    if (!$error) {
        $query = "INSERT INTO " . $prefix . "_Accounts(Name, Surname, Communicator_contact_number) 
    VALUES ('" . $_POST['name'] . "','" . $_POST['surname'] . "','" . $_POST['number'] . "')";

        $result = mysqli_query($link, $query);

        $query = "INSERT INTO " . $prefix . "_Users(Login, Password, Account_id, Access_level, Status) 
    SELECT '" . $_POST['login'] . "','" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', a.ID, 0, '0'
    FROM " . $prefix . "_Accounts a
    WHERE Name = '" . $_POST['name'] . "' AND Surname = '" . $_POST['surname'] . "' AND Communicator_contact_number= '" . $_POST['number'] . "'";

        $result = $result && mysqli_query($link, $query);

        if ($result) {
            session_start();
            $_SESSION['email'] = $_POST['login'];
            $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $_SESSION['name'] = $_POST['name'];

            $query = "SELECT ID, Access_level
        FROM " . $prefix . "_Users
        WHERE Login = '" . $_POST['login'] . "'";

            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);

            $_SESSION['u_id'] = $row['ID'];
            $_SESSION['Access_level'] = $row['Access_level'];


            header("Location: ../../index.php");
        } else {
            echo "Error: " . $query;
        }
    }
}

if (file_exists("../include-base/footer.php"))
    include("../include-base/footer.php");
?>