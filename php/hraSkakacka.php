<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skákačka</title>
    <script src="https://pixijs.download/release/pixi.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styleSkakacka.css">
</head>
<body>
    <h1>Hello PixiJS</h1>
    
    <div id="container"></div>
    <script>
        // Vytvoření obrazovky
        const app = new PIXI.Application({ width: 750, height: 750 });
        document.getElementById('container').appendChild(app.view);

        // Vytvoření hráče/objektu
        const obj = new PIXI.Graphics();
        obj.beginFill(0x00F2FF);
        obj.drawRect(0, 0, 50, 50);
        obj.endFill();
        obj.x = 375 - 25;
        obj.y = 375 - 25;
        app.stage.addChild(obj);

        // Platformy
        const platforms = [
            { x: 0, y: 730, width: 750, height: 20 }, // Podlaha
            { x: 100, y: 600, width: 200, height: 20 }, // První platforma
            { x: 450, y: 500, width: 200, height: 20 }, // Druhá platforma
            // Zde můžete přidat další platformy podle potřeby
        ];

        platforms.forEach(platform => {
            const platformGraphics = new PIXI.Graphics();
            platformGraphics.beginFill(0xCCCCCC);
            platformGraphics.drawRect(platform.x, platform.y, platform.width, platform.height);
            platformGraphics.endFill();
            app.stage.addChild(platformGraphics);
        });

        // Pohyb objektem pomocí šipek
        const speed = 5;
        const keys = {};
        let isJumping = false;
        let jumpHeight = 100; // Výška skoku

        window.addEventListener("keydown", onKeyDown);
        window.addEventListener("keyup", onKeyUp);

        function onKeyDown(e) {
            keys[e.keyCode] = true;
            if (e.keyCode === 38 && !isJumping) { // Šipka nahoru a není v provozu žádný skok
                isJumping = true;
                jump();
            }
        }

        function onKeyUp(e) {
            keys[e.keyCode] = false;
        }

        function jump() {
            let startY = obj.y;
            let targetY = obj.y - jumpHeight;
            let duration = 500; // Doba trvání skoku v milisekundách

            let startTime = null;
            function jumpAnimation(timestamp) {
                if (!startTime) startTime = timestamp;
                let progress = timestamp - startTime;
                let newY = startY - ((progress / duration) * jumpHeight);
                if (newY <= targetY) {
                    obj.y = targetY;
                    fall();
                    return;
                }
                obj.y = newY;
                requestAnimationFrame(jumpAnimation);
            }

            requestAnimationFrame(jumpAnimation);
        }

        function fall() {
            let isTouchingPlatform = false;
            platforms.forEach(platform => {
                if (
                    obj.x + obj.width >= platform.x &&
                    obj.x <= platform.x + platform.width &&
                    obj.y + obj.height >= platform.y &&
                    obj.y <= platform.y + platform.height
                ) {
                    isTouchingPlatform = true;
                }
            });

            if (!isTouchingPlatform) {
                let startY = obj.y;
                let targetY = 750 - 25 - 50; // Výchozí pozice objektu
                let duration = 500; // Doba trvání pádu v milisekundách

                let startTime = null;
                function fallAnimation(timestamp) {
                    if (!startTime) startTime = timestamp;
                    let progress = timestamp - startTime;
                    let newY = startY + ((progress / duration) * (750 - 25 - 50 - startY)); // 750 je výška obrazovky, 25 je výška platformy, 50 je výška objektu
                    if (newY >= targetY) {
                        obj.y = targetY;
                        isJumping = false;
                        return;
                    }
                    obj.y = newY;
                    requestAnimationFrame(fallAnimation);
                }

                requestAnimationFrame(fallAnimation);
            } else {
                isJumping = false;
            }
        }

        app.ticker.add(() => {
            if (keys[37]) { // Šipka v levo
                obj.x -= speed;
            }
            if (keys[39]) { // Šipka vpravo
                obj.x += speed;
            }
        });
    </script>
    


</body>
</html>
