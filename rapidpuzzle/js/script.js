let timeLeft = 60;
let score = 0;
let level = 1;

const questionElement = document.getElementById("question");
const answerInput = document.getElementById("answer");
const submitButton = document.getElementById("submit");
const timeLeftElement = document.getElementById("time-left");
const scoreElement = document.getElementById("score");
const levelElement = document.getElementById("level");
const leaderboardElement = document.getElementById("leaderboard");

let currentQuestion = {};

function generateQuestion() {
    let num1, num2, operator, correctAnswer;

    if (level === 1) {
        // Level 1: Addition
        num1 = Math.floor(Math.random() * 10);
        num2 = Math.floor(Math.random() * 10);
        operator = "+";
        correctAnswer = num1 + num2;
    } else if (level === 2) {
        // Level 2: Addition and Subtraction
        num1 = Math.floor(Math.random() * 20);
        num2 = Math.floor(Math.random() * 20);
        operator = Math.random() > 0.5 ? "+" : "-";
        correctAnswer = operator === "+" ? num1 + num2 : num1 - num2;
    } else {
        // Level 3: Multiplication and Division
        num1 = Math.floor(Math.random() * 12) + 1;
        num2 = Math.floor(Math.random() * 12) + 1;
        operator = Math.random() > 0.5 ? "*" : "/";
        correctAnswer = operator === "*" ? num1 * num2 : Math.floor(num1 / num2);
    }

    currentQuestion = { num1, num2, operator, correctAnswer };
    questionElement.textContent = `What is ${num1} ${operator} ${num2}?`;
}

function updateLeaderboard() {
    const leaderboard = JSON.parse(localStorage.getItem("leaderboard")) || [];
    leaderboardElement.innerHTML = "";
    leaderboard
        .sort((a, b) => b.score - a.score)
        .slice(0, 5)
        .forEach((entry, index) => {
            leaderboardElement.innerHTML += `<li>${index + 1}. ${entry.name}: ${entry.score}</li>`;
        });
}

function saveScore() {
    const name = prompt("Game over! Enter your name:");
    if (name) {
        const leaderboard = JSON.parse(localStorage.getItem("leaderboard")) || [];
        leaderboard.push({ name, score });
        localStorage.setItem("leaderboard", JSON.stringify(leaderboard));
    }
}

function endGame() {
    clearInterval(timer);
    saveScore();
    updateLeaderboard();
    alert(`Game over! Your score is ${score}`);
}

submitButton.addEventListener("click", () => {
    const userAnswer = parseInt(answerInput.value, 10);
    if (userAnswer === currentQuestion.correctAnswer) {
        score += 10;
        scoreElement.textContent = score;

        if (score % 50 === 0) {
            level++;
            levelElement.textContent = level;
        }
        generateQuestion();
        answerInput.value = "";
    }
});

function countdown() {
    if (timeLeft <= 0) {
        endGame();
    } else {
        timeLeft--;
        timeLeftElement.textContent = timeLeft;
    }
}

generateQuestion();
updateLeaderboard();
const timer = setInterval(countdown, 1000);
