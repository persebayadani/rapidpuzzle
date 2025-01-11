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
        <title>Math Race</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
        <style>
            /* Global Styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "Poppins", sans-serif;
            }

            body {
                width: 100%;
                line-height: 1.5;
                background: linear-gradient(135deg, #8e44ad, #3498db);
                color: #fff;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            /* Navbar Styling */
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

            .brand {
                color: #fff;
                font-size: 1.5rem;
                font-weight: 700;
                text-transform: uppercase;
                text-decoration: none;
            }

            .navigation {
                display: flex;
                align-items: center;
            }

            .navigation-items a {
                color: #fff;
                font-size: 1rem;
                font-weight: 500;
                text-decoration: none;
                margin-left: 30px;
            }

            .leaderboard-button {
                padding: 10px 20px;
                background-color: #f1c40f;
                color: #333;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                margin-right: 20px;
            }

            .user-menu {
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                position: relative;
            }

            .user-menu img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
            }

            .dropdown {
                display: none;
                position: absolute;
                top: 50px;
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

            .dropdown a {
                color: #fff;
                padding: 10px 15px;
                text-decoration: none;
                display: block;
            }

            .dropdown a:hover {
                background-color: #4a90e2;
            }

            /* Game Container */
            .container {
                background: #ffffff;
                color: #333333;
                border-radius: 20px;
                max-width: 600px;
                width: 90%;
                text-align: center;
                padding: 30px 20px;
                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            }

            .container:hover {
                transform: scale(1.02);
            }

            h1 {
                font-size: 28px;
                font-weight: 700;
                color: #4a00e0;
                margin-bottom: 10px;
            }

            p {
                font-size: 18px;
                margin: 5px 0;
            }

            #question {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            #answer {
                padding: 12px 15px;
                font-size: 16px;
                width: 85%;
                border: 2px solid #ddd;
                border-radius: 8px;
                margin-bottom: 20px;
            }

            #answer:focus {
                border-color: #4a00e0;
                outline: none;
                box-shadow: 0px 4px 8px rgba(74, 0, 224, 0.2);
            }

            button {
                padding: 10px 25px;
                font-size: 16px;
                font-weight: bold;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                text-transform: uppercase;
                transition: all 0.3s ease;
            }

            button:disabled {
                cursor: not-allowed;
                opacity: 0.5;
            }

            #submit {
                background: linear-gradient(90deg, #6a11cb, #2575fc);
                color: #fff;
            }

            #submit:hover {
                background: linear-gradient(90deg, #5148cf, #1f5fca);
            }

            #start {
                background: linear-gradient(90deg, #43e97b, #38f9d7);
                color: #fff;
            }

            #start:hover {
                background: linear-gradient(90deg, #33cc66, #2ed1c1);
            }

            .notification {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgba(0, 0, 0, 0.8);
                color: #fff;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
                width: 90%;
                max-width: 400px;
                display: none;
                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.5);
            }

            .notification.active {
                display: block;
            }

            .notification h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                color: #fff;
            }

            .notification p {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            .notification button {
                background-color: #3498db;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                cursor: pointer;
            }

            .notification button:hover {
                background-color: #2980b9;
            }

            @media (max-width: 768px) {
                .container h1 {
                    font-size: 1.5rem;
                }

                .notification h2 {
                    font-size: 1.2rem;
                }
            }
            #player-name {
    padding: 12px 15px;
    font-size: 16px;
    width: 85%;
    border: 2px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
}

#player-name:focus {
    border-color: #4a00e0;
    outline: none;
    box-shadow: 0px 4px 8px rgba(74, 0, 224, 0.2);
}

        </style>
    </head>
    <body>
    <header>
        <a href="index.php" class="brand">Math Race</a>
        <div class="navigation">
            <a href="index.php" class="leaderboard-button">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="leaderboard2.php" class="leaderboard-button">
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
    </header>

    <div class="container">
    <h1>Math Race</h1>
    <p id="time-left">60 detik</p>
    <p id="score">Skor: 0</p>
    <p id="level">Level: 1</p>
    <p id="question">Masukkan nama Anda untuk memulai permainan.</p>
    <input type="text" id="player-name" placeholder="Masukkan nama Anda">
    <input type="text" id="answer" placeholder="Masukkan jawaban" disabled>
    <div>
        <button id="submit" disabled>Kirim</button>
        <button id="start" disabled>Mulai</button>
    </div>
</div>


    <div class="notification" id="notification">
        <h2 id="notification-title"></h2>
        <p id="notification-message"></p>
        <button onclick="closeNotification()">Tutup</button>
    </div>

    <script>
        let waktuSisa = 60;
        let skor = 0;
        let level = 1;
        let timer;
        let pertanyaanSaatIni = {};
        let namaPemain = "";

        const timeLeft = document.getElementById('time-left');
        const score = document.getElementById('score');
        const levelDisplay = document.getElementById('level');
        const question = document.getElementById('question');
        const answerInput = document.getElementById('answer');
        const submitButton = document.getElementById('submit');
        const startButton = document.getElementById('start');
        const notification = document.getElementById('notification');
        const notificationTitle = document.getElementById('notification-title');
        const notificationMessage = document.getElementById('notification-message');

        function angkaAcak(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        document.getElementById("player-name").addEventListener("input", (event) => {
    namaPemain = event.target.value.trim();
    document.getElementById("start").disabled = namaPemain === "";
});

        function buatPertanyaan() {
            let angka1, angka2, operatorList, jawabanBenar;
            if (level === 1) {
                operatorList = ["+", "-"];
                angka1 = angkaAcak(1, 10);
                angka2 = angkaAcak(1, 10);
            } else if (level <= 3) {
                operatorList = ["+", "-", "*"];
                angka1 = angkaAcak(1, 20);
                angka2 = angkaAcak(1, 20);
            } else {
                operatorList = ["+", "-", "*", "/"];
                angka1 = angkaAcak(10, 50);
                angka2 = angkaAcak(1, 10);
            }

            const operator = operatorList[angkaAcak(0, operatorList.length - 1)];
            if (operator === "+") jawabanBenar = angka1 + angka2;
            if (operator === "-") jawabanBenar = angka1 - angka2;
            if (operator === "*") jawabanBenar = angka1 * angka2;
            if (operator === "/") jawabanBenar = Math.floor(angka1 / angka2);

            pertanyaanSaatIni = { pertanyaan: `${angka1} ${operator} ${angka2}`, jawaban: jawabanBenar };
            question.textContent = `Berapa hasil dari: ${pertanyaanSaatIni.pertanyaan}?`;
        }

        function mulaiPermainan() {
    if (!namaPemain) {
        alert("Masukkan nama Anda untuk memulai!");
        return;
    }
    waktuSisa = 60;
    skor = 0;
    level = 1;
    timeLeft.textContent = `${waktuSisa} detik`;
    score.textContent = `Skor: ${skor}`;
    levelDisplay.textContent = `Level: ${level}`;
    answerInput.disabled = false;
    submitButton.disabled = false;
    startButton.disabled = true;

    buatPertanyaan();
    timer = setInterval(() => {
        waktuSisa--;
        timeLeft.textContent = `${waktuSisa} detik`;
        if (waktuSisa <= 0) {
            clearInterval(timer);
            kirimKeLeaderboard(namaPemain, skor);
            showNotification("Waktu Habis!", `Skor akhir Anda adalah ${skor}.`);
            resetPermainan();
        }
    }, 1000);
}
function kirimKeLeaderboard(nama, skor) {
    fetch("save_leaderboard.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ nama: nama, skor: skor }),
    })
        .then((response) => response.text())
        .then((data) => {
            console.log("Berhasil disimpan ke leaderboard:", data);
        })
        .catch((error) => {
            console.error("Gagal menyimpan data ke leaderboard:", error);
        });
}

        function kirimJawaban() {
            const jawabanPengguna = Number(answerInput.value);
            if (jawabanPengguna === pertanyaanSaatIni.jawaban) {
                skor += 10;
                if (skor % 50 === 0) level++;
            } else {
                showNotification("Jawaban Salah", "Coba lagi pertanyaan berikut.");
            }

            score.textContent = `Skor: ${skor}`;
            levelDisplay.textContent = `Level: ${level}`;
            answerInput.value = "";
            buatPertanyaan();
        }

        function resetPermainan() {
            clearInterval(timer);
            answerInput.disabled = true;
            submitButton.disabled = true;
            startButton.disabled = false;
            question.textContent = 'Tekan "Mulai" untuk memulai permainan.';
        }

        function showNotification(title, message) {
            notificationTitle.textContent = title;
            notificationMessage.textContent = message;
            notification.classList.add("active");
        }

        function closeNotification() {
            notification.classList.remove("active");
        }

        answerInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !answerInput.disabled) {
                kirimJawaban();
            }
        });

        startButton.addEventListener('click', mulaiPermainan);
        submitButton.addEventListener('click', kirimJawaban);

        function toggleDropdown() {
            const userMenu = document.querySelector('.user-menu');
            userMenu.classList.toggle('active');
        }

        window.addEventListener('click', function (e) {
            const userMenu = document.querySelector('.user-menu');
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove('active');
            }
        });
    </script>
    </body>
    </html>
