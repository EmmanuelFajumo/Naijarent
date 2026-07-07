<div class="div container-fluid py-3" style="background: linear-gradient(135deg, #14213D, #1E3888);">
        <div class="row">
            <div class="col">
                <nav class="navbar navbar-expand-lg">
                    <div class="container">
                        <a class="navbar-brand text-light" href="../index.php">NaijaRent</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-end" style="width: 70%;">
                            <li class="nav-item gx-4">
                            <a class="nav-link text-light nlink" aria-current="page" href="#">For Sale</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link text-light nlink" aria-current="page" href="#">For Rent</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link text-light nlink" aria-current="page" href="#">View All  Properties</a>
                            </li>
                            <?php 
                                if(!isset($_SESSION['admin_online'])){
                            ?>
                            <li class="nav-item">
                            <a class="nav-link text-light nlink" href="login.php">Sign In</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                            <button class="btn btn-outline-light" type="submit">Search</button>
                        </form>
                        <?php } ?>
                        </div>
                    </div>
                </nav>
             </div>
        </div>
    </div>