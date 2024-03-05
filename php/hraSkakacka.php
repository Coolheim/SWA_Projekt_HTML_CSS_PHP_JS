<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skákačka</title>
    <script src="https://pixijs.download/release/pixi.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }
        #app-container {
            width: 800px; /* Šířka kontejneru */
            height: 800px; /* Výška kontejneru */
            border: 2px solid black; /* Okraj kontejneru */
            position: relative;
        }
        #score {
            position: absolute;
            top: 10px;
            left: 10px;
            font-family: Arial, sans-serif;
            font-size: 20px;
        }
        #lives {
            position: absolute;
            top: 10px;
            right: 10px;
            font-family: Arial, sans-serif;
            font-size: 20px;
        }
        #restart-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <div id="app-container">
        <div id="score">Skóre: <span id="score-value">0</span></div>
        <div id="lives">Životy: <span id="lives-value">3</span></div>
        <button id="restart-btn">Restartovat</button>
    </div>

    <script>
        const app = new PIXI.Application({ width: 800, height: 800 });
        document.getElementById('app-container').appendChild(app.view);

        // Nastavení pozadí
        const background = PIXI.Sprite.from('../images/backgroud.png'); // Relativní cesta k obrázku
        background.width = app.renderer.width;
        background.height = app.renderer.height;
        app.stage.addChild(background);

        const texture = PIXI.Texture.from('../images/postavickaRobot.png'); // Relativní cesta k obrázku
        const character = new PIXI.Sprite(texture);
        character.anchor.set(0.5);
        character.width = 50;
        character.height = 50;
        character.x = app.screen.width / 2;
        character.y = app.screen.height - character.height / 2 - 50; // Postavička je 50 pixelů od dolního okraje obrazovky
        app.stage.addChild(character);

        const speed = 8; // Zvýšení rychlosti pohybu postavičky
        const keys = {};

        window.addEventListener("keydown", onKeyDown);
        window.addEventListener("keyup", onKeyUp);

        function onKeyDown(e) {
            keys[e.key] = true;
        }

        function onKeyUp(e) {
            keys[e.key] = false;
        }

        function moveCharacter() {
            if (keys["ArrowLeft"] && character.x > character.width / 2) {
                character.x -= speed;
            }
            if (keys["ArrowRight"] && character.x < app.renderer.width - character.width / 2) {
                character.x += speed;
            }
        }

        app.ticker.add(moveCharacter);

        const scoreText = document.getElementById('score-value');
        const livesText = document.getElementById('lives-value');
        let score = 0;
        let lives = 3;
        let fallingSpeed = 2; // Počáteční rychlost padání

        function updateScore() {
            scoreText.textContent = score;
            livesText.textContent = lives;
        }

        const objectTexture = PIXI.Texture.from('../images/blesk.png'); // Relativní cesta k obrázku
        const object = new PIXI.Sprite(objectTexture);
        object.anchor.set(0.5);
        object.width = 50;
        object.height = 50;
        object.x = Math.random() * (app.renderer.width - object.width) + object.width / 2;
        object.y = 0;
        app.stage.addChild(object);

        function moveObject() {
            object.y += fallingSpeed; // Použijeme proměnnou fallingSpeed pro rychlost padání
            if (object.y > app.renderer.height + object.height / 2) {
                object.x = Math.random() * (app.renderer.width - object.width) + object.width / 2;
                object.y = 0;
            }
            if (object.y + object.height / 2 > character.y - character.height / 2 &&
                object.y - object.height / 2 < character.y + character.height / 2 &&
                object.x + object.width / 2 > character.x - character.width / 2 &&
                object.x - object.width / 2 < character.x + character.width / 2) {
                score++;
                updateScore();
                object.x = Math.random() * (app.renderer.width - object.width) + object.width / 2;
                object.y = 0;
                fallingSpeed += 0.2; // Zvýšíme rychlost padání po každém získaném bodu
            }
            if (object.y + object.height / 2 > app.renderer.height) {
                lives--;
                updateScore();
                object.x = Math.random() * (app.renderer.width - object.width) + object.width / 2;
                object.y = 0;
            }
            if (lives <= 0) {
                document.getElementById('restart-btn').style.display = 'block'; // Zobrazíme tlačítko pro restart
            }
        }

        app.ticker.add(moveObject);

        document.getElementById('restart-btn').addEventListener('click', () => {
            // Resetování hry
            score = 0;
            lives = 3;
            fallingSpeed = 2;
            updateScore();
            document.getElementById('restart-btn').style.display = 'none'; // Schováme tlačítko pro restart
        });
    </script>
</body>
</html>
