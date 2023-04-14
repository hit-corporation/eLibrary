<!doctype html>
<html lang="en">
<head>
    <base href="<?=base_url()?>"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <title>Read Book</title>
    <link rel="stylesheet" src="<?=html_escape('assets/node_modules/pdfjs-dist/web/pdf_viewer.css')?>"/>
    <script src="<?=html_escape('assets/node_modules/pdfjs-dist/build/pdf.min.js')?>" defer></script>
    <script src="<?=html_escape('assets/node_modules/pdfjs-dist/web/pdf_viewer.js')?>" defer></script>
    <style>
        html {
            min-height: 100vh;
        }
        body {
            height: 100vh;
            width: 100vw;
        }

        #main-canvas {
            height: inherit;
            width: inherit;
        }
    </style>
</head>
<body>
    
    <canvas id="main-canvas"></canvas>
    <!-- async -->
    <script async>
        const file = pdfJsLib.getDocument('');
    </script>
</body>
</html>