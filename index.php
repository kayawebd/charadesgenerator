<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Generate random words for charades. Choose the difficulty level and have fun playing with friends and family!">
    <meta name="keywords" content="charades, word generator, game, fun, easy, medium, hard, word list">
    <meta name="author" content="Ricky Wu">
    <title>Charades Word Generator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
        }

        .sr-only:not(:focus) {
            overflow: hidden;
            position: absolute;
            height: 1px;
            width: 1px;
            padding: 0;
            border: 0;
        }

        .word-display {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            text-align: center;
            font-size: clamp(2.6rem, 2.1509rem + 2.566vw, 6rem);
        }

        .control {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 480px) {
            .control {
                width: 480px
            }
        }

        .control_button {
            width: 100%;
            padding: 15px 20px;
            font-size: 1.1em;
            color: #fff;
            background-color: #3f51b5;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .control_button:hover {
            background-color: rgb(45, 58, 133)
        }

        .control__difficulty-select {
            padding: 10px;
            font-size: 16px;
        }

        .footer {
            width: 100%;
            padding-top: 2rem;
            text-align: center;
        }

        h1 {
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <div id="wordDisplay" class="word-display">Loading...</div>
    <div class="control">
        <button id="generateButton" class="control_button">Next Word</button>
        <div class="control__difficulty">
            <label for="difficulty" class="sr-only">Select Difficulty Level:</label>
            <select id="difficulty" class="control__difficulty-select" aria-label="Select Difficulty Level">
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
        </div>
    </div>


    <footer class="footer">
        <div>
            <h1>Charades Word Generator</h1>
            <small>&copy; <?php echo date("Y") ?> Ricky Wu</small>
        </div>
    </footer>

    <script>
        const WORDS_API_URL = "charades_";
        async function loadWords(difficulty) {
            try {
                const response = await fetch(`${WORDS_API_URL}${difficulty}_words.json`);
                if (!response.ok) {
                    throw new Error('Failed to fetch words');
                }
                const data = await response.json();
                return data[difficulty];
            } catch (error) {
                console.error('Error loading words:', error);
                document.getElementById('wordDisplay').textContent = 'Error loading words. Please try again later.';
                return [];
            }
        }

        async function getRandomWord(difficulty) {
            const wordsList = await loadWords(difficulty);
            if (!wordsList || wordsList.length === 0) {
                return 'No words found for this difficulty';
            }

            const randomIndex = Math.floor(Math.random() * wordsList.length);
            return wordsList[randomIndex];
        }

        async function displayWord() {
            const selectedDifficulty = document.getElementById('difficulty').value;
            const word = await getRandomWord(selectedDifficulty);
            document.getElementById('wordDisplay').textContent = word;
        }

        document.addEventListener('DOMContentLoaded', () => {
            displayWord();
            document.getElementById('generateButton').addEventListener('click', displayWord);
            document.getElementById('difficulty').addEventListener('change', displayWord);
        });
    </script>
</body>

</html>