<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,900" rel="stylesheet">
    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        ::-webkit-scrollbar {width: 8px;}
        ::-webkit-scrollbar-track {border-radius: 10px;}
        ::-webkit-scrollbar-thumb {background: #8400ff; border-radius: 10px;}
        /* ::-webkit-scrollbar-thumb:hover{background: yellowgreen;} */
        body {
            padding: 0;
            margin: 0;
            color: white;
            overflow-y: hidden;
        }
        #page {
            position: relative;
            height: 100vh;
            padding: 10px 5%;
            background: #030005;
            overflow-y: scroll;
        }
        .d-none {display: none;}
        .ts2 {
            text-shadow: 0px 2px 0px #8400ff;
        }
        .traceback {width: 100%; height: 150px; margin: 50px 0; padding: 10px; background-color: #0A192F; overflow-y: auto;}
        .error a {
            font-family: 'Montserrat', sans-serif;
            display: inline-block;
            text-transform: uppercase;
            color: #8400ff;
            text-decoration: none;
            border: 2px solid;
            background: transparent;
            padding: 10px 40px;
            font-size: 14px;
            font-weight: 700;
            -webkit-transition: 0.2s all;
            transition: 0.2s all;
        }
        @media only screen and (max-width: 767px) {
            
        }
        @media only screen and (max-width: 480px) {
            
        }
        .errs {width: 100%; min-height: 200px; margin: 50px 0; padding: 20px; background-color: #0A192F; scrollbar-width: 10px; scrollbar-color: white blue;}
        .ts {text-shadow: -1px -1px 0px #8400ff, 1px 1px 0px #ff005a;}
        summary {margin: 25px 0; font-size: 1.2rem;}

    </style>

</head>

<body>
<div id="page">
    <div class="header" style="display: flex; justify-content: space-between; padding: 8px">
        <h1 class="brands ts2">Comfortable</h1>
        <h4 class="error"><a href="#" class="help">Docs</a></h4>
    </div>
    <div class="errs">
        <h2 class="ts2" title="Exception Name"><?= get_class($e) ?></h2>
        <h2 title="Exception file"><?= $e -> getFile() ?> - Line : <?= $e -> getLine() ?></h2>
        <h3 title="Exception Code">Code : #<?= $e -> getCode() ?></h3>
        <h4 style="color: silver;" title="Exception Message">Message : <?= $e -> getMessage() ?></h4>
    </div>
    <div style="text-align:right; margin: 10px 0;"><i class="randomQuote" title='Random Quote'>Passion is above all. Life if as you were die tomorrow ! - "R. Descartes"</i></div>
    <hr>
    <h3 class="tracebackTitle error"><a href="javascript:void(0)">Traceback</a></h3>
    <div class="tracebackContainer" style="margin: 30px 0;">
        <?php foreach($e->getTrace() as $trace): ?>
            <?php $file = $trace['file'] ?? $trace['class']; ?>
            <details>
                <summary class="trace-c"><?=$file?></summary>
                    <div class="traceback">
                        <h4 title="Exception Code"><?= dump($trace) ?></h4>
                    </div>
            </details>
        <?php endforeach;?>
    </div>
    
<script>
    let _y = document.querySelectorAll('.trace-c'); _y[0] ? _y[0].click() : null;
</script>
</div>
</body>
</html>
