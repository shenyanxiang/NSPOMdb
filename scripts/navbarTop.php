<nav class="navbar navbar-top navbar-expand-lg" id="navbarTop" style="display:none;">
    <div class="navbar-logo ms-10">
    <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopCollapse" aria-controls="navbarTopCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="index.php">
        <div class="d-flex align-items-center">
        <div class="d-flex align-items-center"><img src="assets/img/logo.png" alt="NSP-MREval" width="40" />
            <p class="logo-text ms-2 d-none d-sm-block">NSPOMdb</p>
        </div>
        </div>
    </a>
    </div>
    <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center" id="navbarTopCollapse">
    <ul class="navbar-nav navbar-nav-top" data-dropdown-on-hover="data-dropdown-on-hover">
        <li class="nav-item mx-2"><a class="nav-link lh-1" href="index.php" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-home"></span>Home</a></li>
        <li class="nav-item mx-2"><a class="nav-link lh-1" href="database.php" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-database"></span>Dataset</a></li>
        <li class="nav-item mx-2"><a class="nav-link lh-1" href="statistics.php" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-graph-bar"></span>Statistics</a></li>
        <li class="nav-item dropdown mx-2"><a class="nav-link dropdown-toggle lh-1" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-cube"></span>Tools</a>
        <ul class="dropdown-menu navbar-dropdown-caret">
            <li><a class="dropdown-item" href="ARG-VFG-finder.php">
                <div class="dropdown-item-wrapper"><span class="uil fs-0 me-2 uil-desktop"></span>ARG-VFG-finder
                </div>
            </a>
            </li>
            <li><a class="dropdown-item" href="decision_tree.php">
                <div class="dropdown-item-wrapper"><span class="me-2 uil" data-feather="git-branch"></span>Microbial risk management
                </div>
            </a>
            </li>
            <li><a class="dropdown-item" href="simulation.php">
                <div class="dropdown-item-wrapper"><span class="me-2 uil" data-feather="monitor"></span>Microbial risk assessment
                </div>
            </a>
            </li>
        </ul>
        </li>
        <li class="nav-item mx-2"><a class="nav-link lh-1" href="download.php" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-arrow-circle-down"></span>Download</a></li>
        <li class="nav-item mx-2"><a class="nav-link lh-1" href="help.php" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="fs-0 me-2" data-feather="help-circle"></span>Help</a></li>
        <!-- <li class="nav-item mx-2"><a class="nav-link lh-1" href="reference.php" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="uil fs-0 me-2 uil-document-layout-left"></span>References</a></li> -->
    </ul>
    </div>
    <ul class="navbar-nav navbar-nav-icons flex-row me-10">
    <li class="nav-item dropdown me-5"><a class="nav-link dropdown-toggle lh-1" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" data-toggle="dropdown" data-auto-close="outside" aria-haspopup="true" aria-expanded="false"><img src="assets/icons/translate.svg" alt="Translate" width="30" height="30"></a>
        <ul class="dropdown-menu navbar-dropdown-caret">
        <li><a class="dropdown-item" href="index.php">
            <div class="dropdown-item-wrapper">English
            </div>
            </a>
        </li>
        <li><a class="dropdown-item disabled" href="index.php">
            <div class="dropdown-item-wrapper">简体中文
            </div>
            </a>
        </li>
        </ul>
    </li>
    <!-- <?php
        if (!isset($_SESSION['email'])){
        echo '<li class="nav-item"><a class="nav-link lh-1" href="sign-in.html" role="button" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"><span class="me-2" data-feather="log-in"></span>Sign in</a></li>';
        } else {
        echo '
        <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-l ">
                <img class="rounded-circle " src="assets/icons/person-bounding-box.svg" alt="" />
            </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
            <div class="card position-relative border-0">
                <div class="card-body p-0">
                <div class="text-center pt-4 pb-3">
                    <div class="avatar avatar-xl ">
                    <img class="rounded-circle " src="phoenix/public/assets/img/team/72x72/30.webp" alt="" />
                    </div>
                    <h6 class="mt-2 text-black">'.$_SESSION['email'].'</h6>
                </div>
                </div>
                <div class="overflow-auto scrollbar" style="height: 10rem;">
                <ul class="nav d-flex>flex-column mb-2 pb-1">
                    <li class="nav-item"><a class="nav-link px-3" href="#!">Identity: '.$_SESSION['role'].'</a></li>
                </ul>
                <ul class="nav d-flex flex-column mb-2 pb-1">
                    <li class="nav-item"><a class="nav-link px-3" href="dashboard.php"><span class="me-2 text-900" data-feather="pie-chart"></span>Dashboard</a></li>
                </ul>
                </div>
                <div class="card-footer p-0 border-top">
                <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="scripts/sign-out.php"> <span class="me-2" data-feather="log-out"> </span>Sign out</a></div>
                </div>
            </div>
            </div>
        </li>';
        }
    ?> -->
    </ul>
</nav>