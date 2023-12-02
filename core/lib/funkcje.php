<?php
function get_table($tabela, $tabelaDruga)
{
    global $prefix, $link;

    $query = "SELECT * FROM " . $prefix . "_" . $tabela . " AS a, " . $prefix . "_" . $tabelaDruga . " AS u WHERE a.ID = u.ID";
    $wynik = mysqli_query($link, $query);
    echo "<h3>" . ucfirst($tabela) . "</h3>";
    echo "<table class='table table-bordered'>\n";
    echo "<tr>\n";
    echo "<th>" . "Imię" . "</th>\n";
    echo "<th>" . "Nazwisko" . "</th>\n";
    echo "<th>" . "Login" . "</th>\n";
    echo "<th>" . "Nazwa drużyny" . "</th>\n";
    echo "<tr>";
    while ($wiersz = mysqli_fetch_array($wynik)) {
        echo "\t<tr>\n";
        echo "\t\t<td>" . $wiersz['Name'] . "</td>\n";
        echo "\t\t<td>" . $wiersz['Surname'] . "</td>\n";
        echo "\t\t<td>" . $wiersz['Login'] . "</td>\n";
        echo "\t\t<td>" . $wiersz['Name_team'] . "</td>\n";
        echo "\t</tr>\n";
    }
    echo "</table>\n";
}

function load_offers($kind)
{
    global $prefix;
    global $link;

    $query = "";

    switch ($kind) {
        case "ships":
            $query = "SELECT s.Name AS Name, p.Picture Picture, s.Price Price, c.Name CategoryName, s.Description AS Description, s.ID id FROM " . $prefix . "_Picture_of_Ships AS p, " . $prefix . "_Ships AS s, " . $prefix . "_Categories_of_Ships AS c WHERE c.ID = s.Category_id AND p.Ship_id = s.ID AND p.Status = '2'";
            break;
        case "equipment":
            $query = "SELECT e.Name AS Name, p.Picture Picture, e.Price Price, c.Name CategoryName, e.Description AS Description, e.ID id FROM " . $prefix . "_Picture_of_Equipment AS p, " . $prefix . "_Equipment AS e, " . $prefix . "_Categories_of_Equipment AS c WHERE c.ID = e.Category_id AND p.Equipment_id = e.ID AND p.Status = '2'";
            break;
    }

    $wynik = mysqli_query($link, $query);

    while ($wiersz = mysqli_fetch_array($wynik)) {
        echo "<form action=\"index.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"offerId\" value=\"" . $wiersz['id'] . "\">";
        echo "<input type=\"hidden\" name=\"offerKind\" value=\"" . $kind . "\">";
        echo "<button class=\"card-button\" type= \"submit\" style=\"border: none; width: 100%; background-color: transparent; user-select: auto;\" name=\"value\" value=\"offer-page\" >";
        echo "<div class=\"card mb-3\">";
        echo "<div class=\"row g-0\">";
        echo "<div class=\"col-md-4\">";
        echo "<img src=\"public/images/" . str_replace("/", "-", $wiersz['Name']) . "/" . $wiersz['Picture'] . "\"
                    class=\"img-fluid rounded-start\" style=\"background-color: black\" alt=\"...\">";
        echo "</div>";
        echo "<div class=\"col-md-8\">";
        echo "<div class=\"card-body\">";
        echo "<h5 class=\"card-title text-start\">" . $wiersz['Name'] . "</h5>";
        echo "<p class=\"card-text text-start\">" . $wiersz['Description'] . "</p>";
        echo "<p class=\"card-text text-start\"><span style=\"font-size: 20px; font-weight: bold;\">Price:</span> " . $wiersz['Price'] . "</p>";
        echo "<p class=\"card-text text-center\"><small class=\"text-body-secondary\">" . $wiersz['CategoryName'] . "</small></p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</button>";
        echo "</form>";
    }
}

function load_offer_page($id, $kind)
{
    global $prefix;
    global $link;

    switch ($kind) {
        case "ships":
            $query = "SELECT s.Name AS Name, s.Capacity Capacity, s.Number_of_guns Number_of_guns, s.Max_number_of_crew Max_number_of_crew, s.Max_speed Max_speed, s.Price Price, c.Name CategoryName, s.Description AS Description 
            FROM " . $prefix . "_Ships AS s, " . $prefix . "_Categories_of_Ships AS c 
            WHERE c.ID = s.Category_id AND s.ID = " . $id;

            $wynik = mysqli_query($link, $query);

            echo '<table class="table">';

            while ($wiersz = mysqli_fetch_array($wynik)) {
                echo '<tr><th>Name</th><td>' . $wiersz['Name'] . '</td></tr>';
                echo '<tr><th>Capacity</th><td>' . $wiersz['Capacity'] . '</td></tr>';
                echo '<tr><th>Number_of_guns</th><td>' . $wiersz['Number_of_guns'] . '</td></tr>';
                echo '<tr><th>Max_number_of_crew</th><td>' . $wiersz['Max_number_of_crew'] . '</td></tr>';
                echo '<tr><th>Max_speed</th><td>' . $wiersz['Max_speed'] . '</td></tr>';
                echo '<tr><th>Price</th><td>' . $wiersz['Price'] . '</td></tr>';
                echo '<tr><th>CategoryName</th><td>' . $wiersz['CategoryName'] . '</td></tr>';
                echo '<tr><th>Description</th><td>' . $wiersz['Description'] . '</td></tr>';
            }

            break;
        case "equipment":
            $query = "SELECT e.Name AS Name, e.Price Price, c.Name CategoryName, e.Description AS Description 
            FROM " . $prefix . "_Equipment AS e, " . $prefix . "_Categories_of_Ships AS c 
            WHERE c.ID = e.Category_id AND e.ID = " . $id;

            $wynik = mysqli_query($link, $query);

            echo '<table class="table">';

            while ($wiersz = mysqli_fetch_array($wynik)) {
                echo '<tr><th>Name</th><td>' . $wiersz['Name'] . '</td></tr>';
                echo '<tr><th>Price</th><td>' . $wiersz['Price'] . '</td></tr>';
                echo '<tr><th>CategoryName</th><td>' . $wiersz['CategoryName'] . '</td></tr>';
                echo '<tr><th>Description</th><td>' . $wiersz['Description'] . '</td></tr>';
            }

            break;
    }

    if ($_SESSION['Access_level'] >= 1) {
        echo '<tr><td colspan="2">';
        echo '<button class="btn btn-dark" type="button">Edit</button>';
        echo '<button class="btn btn-danger" type="button">Delete</button>';
        echo '</td></tr>';
    } else {
        echo '<tr><td colspan="2">';
        echo '<button class="btn btn-dark" type="button">Reserve</button>';
        echo '</td></tr>';
    }

    echo '</table>';

    
    switch ($kind) {
        case "ships":
            $query = "SELECT p.Picture Picture, s.Name AS Name
            FROM " . $prefix . "_Ships AS s, " . $prefix . "_Picture_of_Ships AS p
            WHERE p.Ship_id = s.ID AND (p.Status = '1' OR p.Status = '2') AND s.ID = " . $id;
            break;
        case "equipment":
            $query = "SELECT p.Picture Picture, e.Name AS Name
            FROM " . $prefix . "_Equipment AS e, " . $prefix . "_Picture_of_Equipment AS p
            WHERE p.Equipment_id = e.ID AND (p.Status = '1' OR p.Status = '2') AND e.ID = " . $id;
            break;
    }


    $wynik = mysqli_query($link, $query);

    echo '<div class="container">';
    echo '<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">';
    echo '<div class="carousel-inner">';

    $firstSlide = true;

    while ($wiersz = mysqli_fetch_array($wynik)) {
        if ($firstSlide) {
            echo '<div class="carousel-item active">';
            $firstSlide = false;
        } else {
            echo '<div class="carousel-item">';
        }

        echo '<div class="container">';

        // Ścieżka do obrazu
        $imagePath = 'public/images/' . str_replace("/", "-", $wiersz['Name']) . '/' . $wiersz['Picture'];

        echo '<div class="image-container">';
        echo '<img src="' . $imagePath . '" class="carousel-image" alt="...">';
        echo '</div>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';

    echo '<div>';
    echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">';
    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo '<span class="visually-hidden">Previous</span>';
    echo '</button>';

    echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">';
    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo '<span class="visually-hidden">Next</span>';
    echo '</button>';

    echo '</div>';

    echo '</div>';
    echo '</div>';

}

function generate_form($kind)
{
    global $prefix;
    global $link;

    switch ($kind) {
        case "login":
            echo '<div class="container mt-5">';
            echo '<div class="row justify-content-center">';
            echo '<div class="col-md-6">';
            echo '<div class="card">';
            echo '<div class="card-header text-center fs-3">Sign in</div>';
            echo '<div class="card-body">';
            echo '<form method="POST" action="login.php">';
            echo '<div class="form-group">';
            echo '<label for="username">Login</label>';
            echo '<input type="email" class="form-control" id="username" name="login" required>';
            echo '</div>';
            echo '<div class="form-group mb-2">';
            echo '<label for="password">Password</label>';
            echo '<input type="password" class="form-control" id="password" name="password" required>';
            echo '</div>';
            echo '<div class="form-group mb-2">';
            echo '<button type="submit" class="btn btn-dark">Sign in</button></div>';
            echo '</form>';
            echo '<a href="../.." class="btn btn-dark">Return</a>';
            echo '</div>';
            echo '</div>';
            echo '<p class="text text-center">';
            echo 'If you don\'t have an account, ';
            echo '<a href="sing-up.php">create one</a>';
            echo '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            break;
        case "sing-up":
            echo '<div class="container mt-5">';
            echo '<div class="row justify-content-center">';
            echo '<div class="col-md-6">';
            echo '<div class="card">';
            echo '<div class="card-header text-center fs-3">Sign up</div>';
            echo '<div class="card-body">
                    <form method="POST" action="sing-up.php">
                        <input type="hidden" name="registration">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="surname">Surname</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="number">Comunicator number</label>
                            <input type="text" class="form-control" id="number" name="number" required>
                        </div>
                </div>';
            echo '<div class="card-body">';
            echo '<div class="form-group">';
            echo '<label for="username">Login</label>';
            echo '<input type="email" class="form-control" id="username" name="login" required>';
            echo '</div>';
            echo '<div class="form-group mb-2">';
            echo '<label for="password">Password</label>';
            echo '<input type="password" class="form-control" id="password" name="password" required>';
            echo '</div>';
            echo '<div class="form-group mb-2">';
            echo '<label for="password">Repeat password</label>';
            echo '<input type="password" class="form-control" id="password" name="repeatPassword" required>';
            echo '</div>';
            echo '<div class="form-group mb-2">';
            echo '<button type="submit" class="btn btn-dark">Sign up</button></div>';
            echo '</form>';
            echo '<a href="login.php" class="btn btn-dark">Return</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            break;

        case "confirmation":
            echo '<div class="container">';
            echo '<h2>Confirmation</h2>';
            echo '<form class="form" method="POST" action="index.php">
                <input type="hidden" name="confirmation">
                <input type="hidden" name="value" value="confirmation">
                <input type="hidden" name="table" value="' . $_POST['table'] . '">
                <input type="hidden" name="id" value="' . $_POST['id'] . '">
                <label for="username">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                <button class="btn btn-danger" type="confirm">Delete</button>
                </form>
                <form method="POST" action="index.php">
                <button class="btn btn-dark" type="confirm">Return</button>
                </form>';
            echo '</div>';

            if (isset($_POST['confirmation'])) {
                if (!password_verify($_POST['confirmPassword'], $_SESSION['password'])) {
                    echo "<p class=\"text-center\">Incorrect password.</p>";
                } else {

                    if (delete_from_db($_POST['table'], $_POST['id'])) {
                        header("Location: index.php");
                    } else {
                        echo "<p class=\"text-center\">Error in request, try again later!.</p>";
                    }
                }
            }

            break;
    }
}

function load_user_info($id)
{
    global $prefix;
    global $link;

    $query = "SELECT a.Name AS name, a.Surname surname, u.Login AS login, u.Access_level Access_level, a.Communicator_contact_number AS number
    FROM " . $prefix . "_Users u, " . $prefix . "_Accounts a
    WHERE u.ID = " . $id . " AND a.ID = u.Account_id";

    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo "<br>" . "Name" . " => " . $row['name'];
        echo "<br>" . "Surname" . " => " . $row['surname'];
        echo "<br>" . "Login" . " => " . $row['login'];
        echo "<br>" . "Access level" . " => " . $row['Access_level'];
        echo "<br>" . "Communicator number" . " => " . $row['number'];
    }
}

function delete_from_db($table, $id)
{
    global $prefix;
    global $link;

    switch ($table) {
        case "users":

            $query = "SELECT Account_id
            FROM " . $prefix . "_Users
            WHERE ID = " . $id;

            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);

            mysqli_query($link, "DELETE FROM " . $prefix . "_Accounts
            WHERE ID = " . $row['Account_id']);

            mysqli_query($link, "DELETE FROM " . $prefix . "_Users
            WHERE ID = " . $id);

            return true;


        case "ships":

            mysqli_query($link, "DELETE FROM " . $prefix . "_Ships
            WHERE ID = " . $id);

            return true;

        case "equipment":

            mysqli_query($link, "DELETE FROM " . $prefix . "_Equipment
            WHERE ID = " . $id);

            return true;
        case "treasure":

            mysqli_query($link, "DELETE FROM " . $prefix . "_Treasure
            WHERE ID = " . $id);

            return true;

    }

    return false;
}

function load_user_treasure($id)
{
    global $prefix;
    global $link;

    $query = "SELECT Name AS name, Place place, Total_cost cost, Description AS description, ID AS id
    FROM " . $prefix . "_Treasure
    WHERE User_id = " . $id;

    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo "<div class=\"card mb-3\">";
        echo "<div class=\"row g-0\">";
        echo "<div class=\"col-md-10\">";
        echo "<div class=\"card-body\">";
        echo "<h5 class=\"card-title text-start\">" . $row['name'] . "</h5>";
        echo "<p class=\"card-text text-start\">" . $row['description'] . "</p>";
        echo "<p class=\"card-text text-start\"><span style=\"font-size: 20px; font-weight: bold;\">Total cost:</span> " . $row['cost'] . "</p>";
        echo "<p class=\"card-text text-end\"><small class=\"text-body-secondary\"><span style=\"font-weight: bold;\">Place:</span>" . $row['place'] . "</small></p>";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"col-md-2 text-center bg-secondary\">";
        echo '<form method="post" action="index.php">';
        echo '<input type="hidden" name="value" value="treasure-page">';
        echo '<button type="submit" name="treasureId" value="' . $row['id'] . '" class="btn btn-dark">Edit</button>';
        echo '</form>';
        echo "<br>";
        echo '<form method="post" action="index.php">';
        echo '<input type="hidden" name="value" value="confirmation">';
        echo '<input type="hidden" name="table" value="treasure">';
        echo '<button type="submit" name="id" value="' . $row['id'] . '" class="btn btn-danger">Delete</button>';
        echo '</form>';
        echo "</div>";
        echo "</div>";
        echo "</div>";

    }
}

function load_data_for_admin($kind)
{
    global $prefix;
    global $link;

    switch ($kind) {
        case "users":

            $query = "SELECT u.ID id, a.Name AS name, a.Surname surname, u.Login AS login, u.Access_level Access_level, (SELECT Name AS name FROM pr_Teams WHERE a.Team_id = ID) AS team
            FROM " . $prefix . "_Users u, " . $prefix . "_Accounts a, " . $prefix . "_Teams t
            WHERE a.ID = u.Account_id";

            $result = mysqli_query($link, $query);

            while ($row = mysqli_fetch_array($result)) {
                echo "<div class=\"card mb-3\">";
                echo "<div class=\"row g-0\">";
                echo "<div class=\"col-md-10\">";
                echo "<div class=\"card-body\">";
                echo "<h5 class=\"card-title text-start\">" . $row['name'] . " " . $row['surname'] . "</h5>";
                echo "<p class=\"card-text text-start\">" . $row['login'] . "</p>";
                echo "<p class=\"card-text text-start\"><span style=\"font-weight: bold;\">Access level: </span> " . ($row['Access_level'] == 2 ? "Main administrator" : ($row['Access_level'] == 1 ? "Administrator" : "User")) . "</p>";
                if (isset($row['team'])) {
                    echo "<p class=\"card-text text-start\"><span style=\"font-weight: bold;\">The name of team: </span> " . $row['team'] . "</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "<div class=\"col-md-2 text-center align-middle bg-secondary\">";
                echo '<form method="post" action="index.php">';
                echo '<input type="hidden" name="value" value="user-info">';
                echo '<button type="submit" name="userId" value="' . $row['id'] . '" class="btn btn-dark">Edit</button>';
                echo '</form>';
                echo "<br>";
                echo '<form method="post" action="index.php">';
                echo '<input type="hidden" name="value" value="confirmation">';
                echo '<input type="hidden" name="table" value="' . $kind . '">';
                echo '<button type="submit" name="id" value="' . $row['id'] . '" class="btn btn-danger">Delete</button>';
                echo '</form>';
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }

            break;

        case "orders":

            break;

        case "ships":

            $query = "SELECT s.Name AS name, s.Price price, c.Name categoryName, s.Description AS description, s.ID id
            FROM " . $prefix . "_Ships s, " . $prefix . "_Categories_of_Ships c
            WHERE s.Category_id = c.ID";

            $result = mysqli_query($link, $query);

            while ($row = mysqli_fetch_array($result)) {
                echo "<div class=\"card mb-3\">";
                echo "<div class=\"row g-0\">";
                echo "<div class=\"col-md-10\">";
                echo "<div class=\"card-body\">";
                echo "<h5 class=\"card-title text-start\">" . $row['name'] . "</h5>";
                echo "<p class=\"card-text text-start\">" . $row['description'] . "</p>";
                echo "<p class=\"card-text text-start\"><span style=\"font-weight: bold;\">Price: </span> " . $row['price'] . "</p>";
                echo "<p class=\"card-text text-start\"><span style=\"font-weight: bold;\">Category: </span> " . $row['categoryName'] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "<div class=\"col-md-2 text-center align-middle bg-secondary\">";
                echo '<form method="post" action="index.php">';
                echo '<input type="hidden" name="value" value="offer-page">';
                echo '<input type="hidden" name="offerKind" value="' . $kind . '">';
                echo '<button type="submit" name="offerId" value="' . $row['id'] . '" class="btn btn-dark">Edit</button>';
                echo '</form>';
                echo "<br>";
                echo '<form method="post" action="index.php">';
                echo '<input type="hidden" name="value" value="confirmation">';
                echo '<input type="hidden" name="table" value="' . $kind . '">';
                echo '<button type="submit" name="id" value="' . $row['id'] . '" class="btn btn-danger">Delete</button>';
                echo '</form>';
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }

            break;

        case "equipment":

            $query = "SELECT e.Name AS name, e.Price price, c.Name categoryName, e.Description AS description, e.ID id 
            FROM " . $prefix . "_Equipment AS e, " . $prefix . "_Categories_of_Equipment AS c 
            WHERE c.ID = e.Category_id";

            $result = mysqli_query($link, $query);

            while ($row = mysqli_fetch_array($result)) {
                echo "<div class=\"card mb-3\">";
                echo "<div class=\"row g-0\">";
                echo "<div class=\"col-md-10\">";
                echo "<div class=\"card-body\">";
                echo "<h5 class=\"card-title text-start\">" . $row['name'] . "</h5>";
                echo "<p class=\"card-text text-start\">" . $row['description'] . "</p>";
                echo "<p class=\"card-text text-start\"><span style=\"font-weight: bold;\">Price: </span> " . $row['price'] . "</p>";
                echo "<p class=\"card-text text-start\"><span style=\"font-weight: bold;\">Category: </span> " . $row['categoryName'] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "<div class=\"col-md-2 text-center align-middle bg-secondary\">";
                echo '<form method="post" action="index.php">';
                echo '<input type="hidden" name="value" value="offer-page">';
                echo '<input type="hidden" name="offerKind" value="' . $kind . '">';
                echo '<button type="submit" name="offerId" value="' . $row['id'] . '" class="btn btn-dark">Edit</button>';
                echo '</form>';
                echo "<br>";
                echo '<form method="post" action="index.php">';
                echo '<input type="hidden" name="value" value="confirmation">';
                echo '<input type="hidden" name="table" value="' . $kind . '">';
                echo '<button type="submit" name="id" value="' . $row['id'] . '" class="btn btn-danger">Delete</button>';
                echo '</form>';
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }

            break;
    }
}

function load_treasure_page($id)
{
    global $prefix;
    global $link;


    $query = "SELECT Name AS name, Total_cost cost, Description AS description, Place place, Status AS status
    FROM " . $prefix . "_Treasure 
    WHERE ID = " . $id;

    $result = mysqli_query($link, $query);

    echo '<table class="table">';

    while ($row = mysqli_fetch_array($result)) {
        echo '<tr><th>Name</th><td>' . $row['name'] . '</td></tr>';
        echo '<tr><th>Total cost</th><td>' . $row['cost'] . '</td></tr>';
        echo '<tr><th>Description</th><td>' . $row['description'] . '</td></tr>';
        echo '<tr><th>Place</th><td>' . $row['place'] . '</td></tr>';
        if ($_SESSION['Access_level'] >= 1)
            echo '<tr><th>Status</th><td>' . $row['status'] . '</td></tr>';
    }

    if ($_SESSION['Access_level'] == 0) {
        echo '<tr><td colspan="2">';
        echo '<button class="btn btn-dark" type="button">Edit</button>';
        echo '<form method="post" action="index.php">';
        echo '<input type="hidden" name="value" value="confirmation">';
        echo '<button class="btn btn-danger" type="button">Delete</button>';
        echo '</form>';
        echo '</td></tr>';
    }

    echo '</table>';
}

function check_if_login_already_used($login)
{
    global $prefix;
    global $link;

    $query = "SELECT *
    FROM " . $prefix . "_Users
    WHERE Login = '" . $login . "'";

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) >= 1) {
        return true;
    } else {
        return false;
    }
}

function get_all_form_POST()
{
    foreach ($_POST as $var => $value) {
        // if (is_array($value)) {
        //   for ($i = 0; $i < sizeof($value); $i++) {
        //     echo "<br>" . $var . "[" . $i . "] => " . $value[$i];
        //   }
        //   continue;
        // }
        echo "<br>" . $var . " => " . $value;
    }
}
?>