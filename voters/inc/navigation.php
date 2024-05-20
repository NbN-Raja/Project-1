<div class="row bg-green">
    <div class="col-12 bg-green">
        <nav class="navbar navbar-expand-lg navbar-light bg-green">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white mr-3" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white mr-3" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white mr-3" href="profile.php"><?php
                                                                                // Start the session


                                                                                if (isset($_SESSION['Name'])) {
                                                                                    // Get the username from the session
                                                                                    $username = $_SESSION['Name'];
                                                                                    // Use the username as needed
                                                                                    echo  $username;
                                                                                }
                                                                                ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white mr-3" href="../admin/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>