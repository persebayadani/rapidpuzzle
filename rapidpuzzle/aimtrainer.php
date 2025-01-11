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
    <title>Aim Trainer Game</title>
    
    <!-- Link Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <style>
        /* Reset default margins dan paddings */
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
body{
    width: 100%;
    align-items: center;
    justify-content: center;
    line-height: 1.5;
    background: #5e5f60;
}
/* Header */
header {
    z-index: 999;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 50px;
    background: #353738;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Leaderboard Button in Header */
.leaderboard-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #f1c40f;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    font-size: 1rem;
    transition: background-color 0.3s, transform 0.2s;
    margin-right: 20px; /* Beri jarak antar elemen */
}

.leaderboard-button:hover {
    background-color: #e1b90e;
    transform: scale(1.05);
}

.leaderboard-button i {
    margin-right: 8px; /* Jarak antara ikon dan teks */
}

.navigation-items {
    display: flex;
    align-items: center;
}


        header .brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
        }

        header .brand:hover {
            color: #2d3335;
            transition: 0.3s ease;
        }

        header .navigation {
    position: relative;
    display: flex;
    align-items: center;
}

header .navigation .navigation-items {
    display: flex;
    align-items: center;
    margin-left: auto; /* Tambahkan ini agar bergeser ke kiri */
}

        header .navigation .navigation-items a {
            position: relative;
            color: #fff;
            font-size: 1em;
            font-weight: 500;
            text-decoration: none;
            margin-left: 30px;
            transition: 0.3s ease;
        }

        header .navigation .navigation-items a:hover {
            color: #4a90e2;
        }

        /* Styling user menu */
        /* User menu styling */
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.user-menu img:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.user-menu span {
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
}

        .user-menu .dropdown {
            display: none;
            position: absolute;
            top: 50px; /* Sesuaikan dengan tinggi navbar */
            right: 0;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 10px 0;
            min-width: 120px;
        }

        .user-menu.active .dropdown {
            display: block;
        }

        .user-menu .dropdown a {
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            font-size: 1rem;
        }

        .user-menu .dropdown a:hover {
            background-color: #4a90e2;
        }

        /* Styling main content */
        .main-content {
    position: relative; /* Ubah dari absolute ke relative */
    top: 80px; /* Tambahkan jarak dari header */
    padding: 20px 20px 50px; /* Berikan padding bawah agar tidak menempel */
    width: 100%;
    min-height: calc(100vh - 80px); /* Pastikan kontainer memakan tinggi penuh kecuali header */
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    overflow: hidden; /* Mencegah elemen keluar dari kontainer */
}


        .container {
            text-align: center;
            margin-bottom: 50px;
            
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            color: #bbb;
            transition: color 0.3s, border-bottom 0.3s;
        }

        .tab.active {
            color: orange;
            border-bottom: 2px solid orange;
        }

        .tab-content {
            display: none;
            margin-top: 10px;
        }

        .tab-content.active {
            display: block;
        }

        .mode-button, .time-button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #333;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .mode-button:hover, .time-button:hover {
            background-color: #555;
        }

        .mode-button.active, .time-button.active {
            background-color: orange;
            color: white;
        }

        #start-button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1em;
        }

        #start-button:disabled {
            background-color: #888;
            cursor: not-allowed;
        }

        #start-button:hover:enabled {
            background-color: #45a049;
        }

        .info {
            font-size: 20px;
            margin-top: 10px;
        }

        #game-area {
    width: 600px;
    height: 400px;
    background-color: #444;
    position: relative; /* Pastikan tidak menggunakan absolute */
    margin-top: 20px; /* Jarak dari elemen di atas */
    margin-bottom: 20px; /* Tambahkan margin bawah agar tidak menempel */
    border-radius: 10px;
    overflow: hidden;
}


        .target {
    width: 50px;
    height: 50px;
    background-image: url('image/wow.png'); /* Path ke gambar */
    background-size: cover;
    background-position: center;
    border-radius: 50%;
    position: absolute;
    cursor: pointer;
    pointer-events: none; /* Nonaktifkan klik secara default */
    visibility: hidden; /* Tidak terlihat sebelum permainan dimulai */
}


#end-frame {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            z-index: 1001;
        }

        #end-frame button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #end-frame button:hover {
            background-color: #45a049;
        }


        /* Mencegah body dan html bisa digeser */
        html, body {
            height: 100%;
            overflow: auto;
        }
        .target {
    width: 50px; /* Lebar target */
    height: 50px; /* Tinggi target */
    background-image: url('image/wow.png'); /* Path ke gambar */
    background-size: cover; /* Pastikan gambar menyesuaikan ukuran target */
    background-position: center; /* Pusatkan gambar */
    border-radius: 50%; /* Tetap membuatnya berbentuk bulat */
    position: absolute; /* Agar dapat diposisikan di area permainan */
    cursor: pointer; /* Menunjukkan bahwa ini elemen yang dapat diklik */
    pointer-events: none; /* Nonaktifkan klik secara default */
}
.target {
    transition: opacity 0.2s ease, transform 0.2s ease;
}
#reset-button {
    margin-top: 20px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

#reset-button:hover {
    background-color: #0056b3;
}

/* Tombol Home */
.leaderboard-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #f1c40f;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    font-size: 1rem;
    transition: background-color 0.3s, transform 0.2s;
    margin-right: 20px;
}

.leaderboard-button:hover {
    background-color: #e1b90e;
    transform: scale(1.05);
}

.leaderboard-button i {
    margin-right: 8px;
}



    </style>
</head>
<body>

<header>
    <a href="index.php" class="brand">AIM TRAINER</a>
    <div class="navigation">
        <div class="navigation-items">
            <!-- Tombol Back to Home -->
            <a href="index.php" class="leaderboard-button">
                <i class="fas fa-home"></i> Home
            </a>
            <!-- Tombol Leaderboard -->
            <a href="leaderboard.php" class="leaderboard-button">
                <i class="fas fa-trophy"></i> Leaderboard
            </a>
            <?php if (isset($user)): ?>
                <div class="user-menu" onclick="toggleDropdown()">
                    <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image">
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
</header>



<div id="usernameModal" style="display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background-color: #333; padding: 20px; border-radius: 10px; width: 300px; text-align: center;">
        <h3 style="color: white;">Masukkan Nama</h3>
        <input type="text" id="usernameInput" placeholder="Nama Anda" style="padding: 10px; width: 100%; border-radius: 5px;">
        <button onclick="saveUsername()" style="margin-top: 10px; padding: 10px 20px; cursor: pointer; background-color: #4CAF50; color: white; border: none; border-radius: 5px;">Start Game</button>
    </div>
</div>


<div class="main-content">
    <div class="container">
        <div class="tabs">
            <div class="tab active" onclick="showTab('main')">Main</div>
            <div class="tab" onclick="showTab('time')">Time</div>
            
        </div>

        <div id="main" class="tab-content active">
            <button class="mode-button" onclick="selectMode('easy')">Easy</button>
            <button class="mode-button" onclick="selectMode('medium')">Medium</button>
            <button class="mode-button" onclick="selectMode('hard')">Hard</button>
        </div>

        <div id="time" class="tab-content">
            <button class="time-button" onclick="selectTime(30)">30 Detik</button>
            <button class="time-button" onclick="selectTime(60)">60 Detik</button>
            <button class="time-button" onclick="selectTime(90)">90 Detik</button>
        </div>

        
        

        <button id="reset-button" onclick="resetGame()" style="margin-left: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer;">
    <i class="fas fa-sync-alt"></i> Ulang
</button>


        <button id="start-button" onclick="startGame()" disabled>Mulai Game</button>

        <div class="info">
        <div class="info">
    <span>Skor: <span id="score">0</span></span>
    <span style="margin-left: 20px;">Akurasi: <span id="accuracy">0%</span></span>
    <span style="margin-left: 20px;">Timer: <span id="timer">30</span> detik</span>
</div>

        </div>

        <div id="game-area">
            <div class="target" id="target" onclick="hitTarget()"></div>
        </div>
    </div>

    <div id="end-frame">
    <h2>Waktu habis!</h2>
    <p>Skor akhir Anda adalah <span id="final-score">0</span></p>
    <p>Akurasi akhir Anda adalah <span id="final-accuracy">0%</span></p>
    <button onclick="closeEndFrame()">Tutup</button>
</div>



</div>

<script>
    let score = 0;
    let timeLeft = 30;
    let gameInterval = null;
    let timerInterval = null;
    let gameStarted = false;
    let targetSpeed = 1000; // Default speed
    let selectedMode = '';
    let selectedTime = 0;
    let isMoving = false; // Flag untuk mencegah target berpindah terlalu cepat
    let totalClicks = 0; // New variable to track total clicks
    let accuracy = 100; // Start with 100% accuracy

    const scoreDisplay = document.getElementById("score");
    const timerDisplay = document.getElementById("timer");
    const target = document.getElementById("target");
    const gameArea = document.getElementById("game-area");
    const endFrame = document.getElementById("end-frame");
    const finalScore = document.getElementById("final-score");
    const startButton = document.getElementById("start-button");
    const modeButtons = document.querySelectorAll(".mode-button");
    const timeButtons = document.querySelectorAll(".time-button");
    const accuracyDisplay = document.getElementById("accuracy");

    function showTab(tabName) {
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        document.querySelector(`.tab[onclick="showTab('${tabName}')"]`).classList.add('active');
        document.getElementById(tabName).classList.add('active');
        checkStartButtonState();
    }
// JavaScript to save the username and show the leaderboard
let username = '';
function saveUsername() {
    username = document.getElementById('usernameInput').value;
    if (username) {
        document.getElementById('usernameModal').style.display = 'none';
    } else {
        alert('Please enter a username.');
    }
}

// Load leaderboard based on difficulty
function loadLeaderboard(difficulty) {
    fetch(`load_leaderboard.php?difficulty=${difficulty}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('leaderboard-content').innerHTML = data;
        });
}
    function selectMode(mode) {
        selectedMode = mode;
        modeButtons.forEach(button => {
            button.classList.remove('active');
        });
        document.querySelector(`.mode-button[onclick="selectMode('${mode}')"]`).classList.add('active');
        checkStartButtonState(); // Periksa apakah tombol "Mulai Game" bisa diaktifkan
    }

    function selectTime(time) {
        selectedTime = time;
        timeButtons.forEach(button => {
            button.classList.remove('active');
        });
        document.querySelector(`.time-button[onclick="selectTime(${time})"]`).classList.add('active');

        // Perbarui tampilan timer
        timerDisplay.textContent = time;
        checkStartButtonState(); // Periksa apakah tombol "Mulai Game" bisa diaktifkan
    }

    function checkStartButtonState() {
        // Aktifkan tombol jika mode atau waktu telah dipilih
        if (selectedMode && selectedTime) {
            startButton.disabled = false;
        } else {
            startButton.disabled = true;
        }
    }

    function startGame() {
    if (gameStarted) return;

    // Set time and speed based on selected mode and time
    if (selectedTime) {
        timeLeft = selectedTime;
    }

    if (selectedMode) {
        if (selectedMode === 'easy') {
            targetSpeed = 1500;
        } else if (selectedMode === 'medium') {
            targetSpeed = 1200;
        } else if (selectedMode === 'hard') {
            targetSpeed = 1000;
        }
    }

    // Reset score, total clicks, and accuracy for a fresh start
    score = 0;
    totalClicks = 0;
    accuracy = 0; // Reset accuracy
    scoreDisplay.textContent = score;
    accuracyDisplay.textContent = '0%'; // Display 0% accuracy initially
    timerDisplay.textContent = timeLeft;
    gameStarted = true;
    isMoving = false;

    // Disable start button during gameplay
    startButton.disabled = true;

    // Enable the target to be clickable and visible
    target.style.pointerEvents = 'auto';
    target.style.visibility = 'visible';

    // Clear any previous intervals and start new ones
    clearInterval(timerInterval);
    clearInterval(gameInterval);

    timerInterval = setInterval(updateTimer, 1000);
    gameInterval = setInterval(() => {
        if (!isMoving) {
            moveTarget();
        }
    }, targetSpeed);

    moveTarget();
}


    function updateTimer() {
        timeLeft--;
        timerDisplay.textContent = timeLeft;
        if (timeLeft <= 0) {
            endGame();
        }
    }

    function moveTarget() {
    const areaWidth = gameArea.offsetWidth - target.offsetWidth;
    const areaHeight = gameArea.offsetHeight - target.offsetHeight;

    const randomX = Math.floor(Math.random() * areaWidth);
    const randomY = Math.floor(Math.random() * areaHeight);

    target.style.left = `${randomX}px`;
    target.style.top = `${randomY}px`;
}

    function hitTarget() {
    if (!gameStarted) return;

    score++;
    scoreDisplay.textContent = score;
    totalClicks++; // Increment total clicks on successful hit
    updateAccuracy(); // Update accuracy after each click

    // Disable automatic movement temporarily
    isMoving = true;
    moveTarget(1000);
    setTimeout(() => {
        isMoving = false;
    }, targetSpeed);
}

function updateAccuracy() {
    // Calculate accuracy based on total clicks and successful hits
    if (totalClicks > 0) {
        accuracy = (score / totalClicks) * 100;
        accuracy = Math.min(accuracy, 100); // Cap at 100%
    } else {
        accuracy = 0; // If no clicks yet, accuracy is 0
    }
    accuracyDisplay.textContent = `${accuracy.toFixed(2)}%`;
}



gameArea.addEventListener("click", function (event) {
    if (!gameStarted) return;

    // Only count clicks outside the target if they miss
    if (!event.target.classList.contains("target")) {
        totalClicks++; // Increment only on a miss
        updateAccuracy();
    }
});

function endGame() {
    clearInterval(timerInterval);
    clearInterval(gameInterval);
    gameStarted = false;

    finalScore.textContent = score;
    document.getElementById("final-accuracy").textContent = `${accuracy.toFixed(2)}%`;
    endFrame.style.display = 'block';

    // Send score to server
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_score.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`username=${username}&score=${score}&accuracy=${accuracy.toFixed(2)}&difficulty=${selectedMode}`);
}



    function closeEndFrame() {
        endFrame.style.display = 'none';
    }

    // JavaScript untuk dropdown
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
    function resetGame() {
    // Stop all intervals
    clearInterval(timerInterval);
    clearInterval(gameInterval);

    // Reset game variables
    score = 0;
    totalClicks = 0; // Reset total clicks
    timeLeft = 30;
    gameStarted = false;
    selectedMode = '';
    selectedTime = 0;
    isMoving = false;
    accuracy = 0; // Reset accuracy

    // Reset display
    scoreDisplay.textContent = score;
    accuracyDisplay.textContent = '0%'; // Ensure accuracy display is 0%
    timerDisplay.textContent = '30'; // Default timer
    startButton.disabled = true; // Disable start button until mode and time are selected
    target.style.pointerEvents = 'none'; // Disable target until game starts
    target.style.visibility = 'hidden'; // Hide target
    endFrame.style.display = 'none'; // Hide end frame

    // Reset mode and time buttons
    modeButtons.forEach(button => button.classList.remove('active'));
    timeButtons.forEach(button => button.classList.remove('active'));
}


</script>




</body>
</html>

