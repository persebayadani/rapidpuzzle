<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Game Mode</title>
    <style>
        /* CSS Styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #282c34;
            color: white;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .game-mode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .game-mode-container button {
            background-color: #4a90e2;
            border: none;
            padding: 15px 30px;
            color: white;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .game-mode-container button:hover {
            background-color: #367bb7;
        }

        .start-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Select Game Mode</h1>
    <div class="game-mode-container">
        <form method="GET" action="bubble.php">
            <input type="hidden" name="mode" value="easy">
            <button type="submit">Easy</button>
        </form>
        <form method="GET" action="bubble.php">
            <input type="hidden" name="mode" value="normal">
            <button type="submit">Normal</button>
        </form>
        <form method="GET" action="bubble.php">
            <input type="hidden" name="mode" value="hard">
            <button type="submit">Hard</button>
        </form>
    </div>
</body>
</html>
