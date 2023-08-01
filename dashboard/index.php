<?php
require_once "../config/conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'layout/head.php' ?>
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php' ?>
        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome Back</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
                </div>

            </div>

            <!-- Footer -->
            <?php require_once 'layout/footer.php' ?>
            <!-- End of Footer -->

        </div>
    </div>

    <?php require_once 'layout/javascript.php' ?>

</body>

</html>