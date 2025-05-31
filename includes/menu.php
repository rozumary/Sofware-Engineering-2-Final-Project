<nav class="navbar navbar-expand-lg mb-5">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                Menu
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>

                <?php
                //Display links based upon the login status:
                if (isset($_SESSION['user_id'])) {
                    // Get the username or first name of the logged-in user.
                    $firstName = $_SESSION['first_name'];
                    $user_level = $_SESSION['user_level'];
                    
                    echo '<li class="nav-item dropdown opacity-75">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                '.ucfirst($firstName).'
                            </a>
                            
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="admin_dashboard.php">Dashboard</a></li>
                        
                            </ul>
                        </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>';
                }
                ?>
            </ul>

                <!-- <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li> -->
        </div>
        </div>
    </nav>