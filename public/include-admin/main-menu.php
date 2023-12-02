<div class="container-fluid mb-4 ">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block rounded bg-dark sidebar pt-2 pb-2">
            <div class="row">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="?kind=users">Users</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider bg-secondary" />
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="?kind=orders">Orders</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider bg-secondary" />
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Offers
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?kind=ships">Ships</a></li>
                                <li><a class="dropdown-item" href="?kind=equipment">Equipment</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="col-md-10">
            <?php
            if (isset($_GET['kind']))
                $kind = $_GET['kind'];

            echo "<h1 class=\"mb-2\">" . ucfirst($_GET['kind']) . "</h1>";
            load_data_for_admin($kind);
            ?>
        </main>
    </div>
</div>