<nav class="navbar navbar-expand-lg navbar-light fixed-top glavniNav">
    <div class="container-fluid">
        <a class="navbar-brand home" href="index.php">Pozovi</a>

        <div class="d-lg-none">                                                   <!-- sekundarna navigacija -->
            <div class="d-flex gap-2"> <!-- dodato d-flex i gap-2 za razmak -->

                <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == "admin"): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            Admin
                        </button>
                        <ul id="adminLista" class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="admin_dashboard.php">Događaji</a></li>
                            <li><a class="dropdown-item" href="admin_users.php">Korisnici</a></li>
                            <li><a class="dropdown-item" href="admin_detects.php">Tabela detekcija</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="dropdown">
                    <button class="btn btn-outline-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 14px;">
                        <img src="images/menu.png" alt="menu icon" width="23px" height="23px">
                    </button>
                    <ul id="meniLista" class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="dropdownMenuButton">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['role'] == 'user'): ?>
                                <li><a class="dropdown-item" href="dashboard.php">Događaji</a></li>
                                <li><a class="dropdown-item" href="create_event.php">Kreiraj događaj</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="help.php">Pomoć</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="login.php">Prijavi se</a></li>
                            <li><a class="dropdown-item" href="register.php">Registruj se</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if (isset($_SESSION['user_id'])):?>
                    <div class="dropdown ms-4">
                        <button class="btn btn-primary" type="button" id="userButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="images/user.png" alt="user icon" width="23px" height="23px">
                        </button>
                        <ul id="userButtonList" class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="userButton">
                            <div class="text-center" style="padding:7px; border-bottom: 1px solid #879cd5;"><?php echo $_SESSION['fname']; ?></div>
                            <li class="nav-item"><a class="dropdown-item" href="user_settings.php">Podešavanje naloga</a></li>
                            <li class="nav-item"><a class="dropdown-item" href="logout.php">Odjavi se</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="collapse navbar-collapse d-none d-lg-block" id="navbarNav">              <!-- primarna navigacija -->
            <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['user_id'])): ?>

                    <?php if($_SESSION['role'] == "admin"): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </button>
                            <ul id="adminLista" class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="admin_dashboard.php">Događaji</a></li>
                                <li><a class="dropdown-item" href="admin_users.php">Korisnici</a></li>
                                <li><a class="dropdown-item" href="admin_detects.php">Tabela detekcija</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] == 'user'): ?><li class="nav-item"><a class="nav-link" href="<?php echo ($_SESSION['role'] == 'admin') ? 'dashboard_admin.php' : 'dashboard.php'; ?>">Događaji</a></li>
                    <li class="nav-item"><a class="nav-link" href="create_event.php">Kreiraj događaj</a></li><?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="help.php">Pomoć</a></li>
                    <li class="nav-item ms-4">
                        <button class="btn btn-primary" type="button" id="userButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="images/user.png" alt="user icon" width="23px" height="23px">
                        </button>
                        <ul id="userButtonList" class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="userButton">
                            <div class="text-center" style="padding:7px; border-bottom: 1px solid #879cd5;"><?php echo $_SESSION['fname']; ?></div>
                            <li class="nav-item"><a class="dropdown-item" href="user_settings.php">Podešavanje naloga</a></li>
                            <li class="nav-item"><a class="dropdown-item" href="logout.php">Odjavi se</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Prijavi se</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Registruj se</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
