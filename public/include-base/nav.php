<?php
session_start();
?>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            SOP
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php
                if ($_SESSION['Access_level'] == 0 || !isset($_SESSION['Access_level'])) {

                    echo '<li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" id="navbarDropdown" href="?value=orders" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Offers
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="?value=offer">Ships</a>
                        </li>
                        <li><a class="dropdown-item" href="?value=offer-equipment">Equipment</a></li>';
                    if (isset($_SESSION['u_id'])) {
                        echo '<li>
                                <hr class="dropdown-divider" />
                                </li>';
                        echo '<li>';
                        echo '<a class="dropdown-item" href="?value=treasure">Treasure</a>';
                        echo '</li>';
                    }

                    echo '</ul>';
                    echo '</li>';
                }
                ?>
                <?php
                if (isset($_SESSION['name'])) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link active dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">' . $_SESSION['name'] . '</a>';
                    echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">';
                    echo '<li>';
                    echo "<a class=\"dropdown-item\" href=\"?value=user-info\">";
                    echo 'Info';
                    echo "</a>";
                    echo '</li>';
                    echo '<li>
                        <hr class="dropdown-divider" />
                        </li>';
                    echo '<li>';
                    echo '<a class="dropdown-item" href="public/include-login/logout.php">Logout</a>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</li>';
                } else {
                    echo "<li class=\"nav-item\">";
                    echo "<a class=\"nav-link active\" href=\"public/include-login/login.php\">";
                    echo "Sign in";
                    echo "</a>";
                }
                ?>
                </li>
            </ul>
        </div>
    </div>
</nav>