<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login dan ambil data user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM reg_op WHERE id_login = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Simpan username dan level di session
    $_SESSION['username'] = $user['username'];
    $_SESSION['level'] = $user['level'];
}
$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : 'uploads/default-profile.png';

// Fungsi untuk menampilkan username dengan (admin) jika levelnya admin
function getUsernameWithRole($username, $level) {
    return $level === 'admin' ? $username . ' (admin)' : $username;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/p.css">
</head>
<style>
.user-menu {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.user-menu img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.user-menu img:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.media-icons {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    z-index: 10;
}

.media-icons a {
    font-size: 28px;
    color: #fff;
    transition: color 0.3s, transform 0.3s;
}

.media-icons a:hover {
    color: #4a90e2;
    transform: scale(1.2);
}
</style>
<body>
    <header>
        <a href="#" class="brand">PUZZLE</a>
        <div class="menu-btn">
            <div class="navigation">
                <div class="navigation-items">
                    <?php if (isset($user)): ?>
                        <div class="user-menu" onclick="toggleDropdown()">
                            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" 
                                 alt="Profile Image">
                            <span><?php echo getUsernameWithRole($_SESSION['username'], $_SESSION['level']); ?></span>
                            <div class="dropdown">
                                <a href="profile.php">Profile</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <section class="home">
        <img decoding="async" class="img-slide active" src="image/math.webp" />
        <img decoding="async" class="img-slide" src="image/aim.webp" />

        <div class="content active">
            <h1>Rapid Puzzle<br><span>Game</span></h1>
            <a href="math.php">PLAY</a>
        </div>
        <div class="content">
            <h1>Aim Trainer<br><span>Test</span></h1>
            <a href="aimtrainer.php">PLAY</a>
        </div>

        <div class="media-icons">
            <a href="index.php"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>

        <div class="slider-navigation">
            <div class="nav-btn active"></div>
            <div class="nav-btn"></div>
        </div>
    </section>

    <script src="js/main.js" defer></script>
    <script>
        function toggleDropdown() {
            const userMenu = document.querySelector('.user-menu');
            userMenu.classList.toggle('active');
        }

        window.onclick = function(event) {
            if (!event.target.matches('.user-menu img, .user-menu span')) {
                const dropdowns = document.getElementsByClassName("user-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('active')) {
                        openDropdown.classList.remove('active');
                    }
                }
            }
        }
    </script>

    <footer class="footer">
        <div class="container1">
            <div class="row">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul>
                        
                        <li><a href="#">our services</a></li>
                        <li><a href="#">privacy policy</a></li>
                        
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">shipping</a></li>
                        <li><a href="#">returns</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>categories</h4>
                    <ul>
                        <li><a href="#">PUZZLE</a></li>
                        <li><a href="#">AIM TRAINER</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
