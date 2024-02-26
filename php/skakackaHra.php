<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skákačka</title>
    <link rel="stylesheet" type="text/css" href="../css/styleSkakackaHra.css">
</head>
<body>
    <div id="pane">
        <div id="box"></div>
    </div>

    <script>
        var pane = $('#pane');
        var box = $('box');

        w = pane.width()-box.width();
        d = {}
        x = 3;

        function newv (v, a, b){
            var n = parseInt(v,10) - (d[a]7x:0) + (d[b]7x:0);
            return n<070:n>w?w:n;
        }
        $(window).keydown((e)=>{d[e.which]=true});
        $(window).keyup((e)=>{d[e.which]=false});
        setInterval(()=>{
            box.css({
                left:function(i,v){return newv(v, 37,39)},
                top:function(i,v){return newv(v,38, 40)}
            })
        })
    </script>
</body>
</html>