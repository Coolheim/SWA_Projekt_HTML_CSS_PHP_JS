<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Textová hra</title>
<link rel="stylesheet" type="text/css" href="../css/styleHra1.css">
</head>
<body>

<div id="game-container">
    <h1>Textová hra</h1>
    <p>Vítej v textové hře.</p>
    <p>Tvoje příkazy: "Jdi rovne" "Jdi doprava" "Jdi doleva"</p>
    <p>Objevil jsi se v lese. Co uděláš?</p>
    <div id="output"></div>
    <input type="text" id="directionInput" placeholder="Zadejte ...">
    <button onclick="submitDirection()">Odeslat</button>
</div>

<script>
    function submitDirection(){
    var direction = document.getElementById("directionInput").value.toLowerCase();
    var output = document.getElementById("output");

    if (direction === "jdi rovne" || direction === "jdi doprava" || direction === "jdi doleva"){
        //output.innerHTML = "<p>Vše proběhlo správně :)</p>"
        if (direction === "jdi rovne") {
            output.innerHTML = "<p>Šel jsi rovně. Našel jsi medvěda porazil jsi ho a vyhrál jsi. </p>";
        } else if (direction === "jdi doprava") {
            output.innerHTML = "<p>Šel jsi doprava. Našel jsi medvěda a umřel jsi.</p>";
            boj();
        } else if (direction === "jdi doleva") {
            output.innerHTML = "<p>Šel jsi doleva. Našel jsi medvěda a umřel jsi.</p>";
        } else {
        output.innerHTML = "<p>Error :(</p>";
    }
    } else {
        output.innerHTML = "<p>Error :(</p>";
    }
}
</script>

</body>
</html>





