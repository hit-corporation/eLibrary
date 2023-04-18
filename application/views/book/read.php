<!doctype html>
<html lang="en">
<head>
    <base href="<?=base_url()?>"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <title>Read Book</title>
    <!--<link rel="stylesheet" src="<?=html_escape('assets/node_modules/pdfjs-dist/web/pdf_viewer.css')?>"/>-->
   
    <style>

        *, *::before, *::after {
           box-sizing: border-box;
        }

        html {
            min-height: 100vh;
            width: 100vw;
        }
        body {
            height: 100vh;
            width: 100%;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            display: block;
        }

        #main-content {
            max-width: 80vw !important;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div id="main-content">
</div>
    <!-- async -->

    <!--<script src="<?=html_escape('assets/node_modules/pdfjs-dist/build/pdf.min.js')?>"></script>-->
    <!-- <script src="<?=html_escape('assets/node_modules/pdfjs-dist/web/pdf_viewer.js')?>"></script> -->
    <script defer>

        const main = document.getElementById('main-content');

        // if browser is chrome
        if(window.navigator.userAgent.indexOf('Chrome') != -1) {
           
            const embed = document.createElement('embed');

            embed.src = "<?=html_escape(base_url('assets/files/books/'.$book['file_1']))?>#toolbar=1&navpanes=1";
            embed.style.height = '100vh';
            embed.style.width = '100vw';

            main.appendChild(embed);
        }
        // if browser is firefox
        if(window.navigator.userAgent.indexOf('Firefox') != -1) {

            var canvas = document.createElement('canvas');
            main.appendChild(canvas);

            pdfjsLib.GlobalWorkerOptions.workerSrc = 'assets/node_modules/pdfjs-dist/build/pdf.worker.min.js';

            const pdfLoad = pdfjsLib.getDocument("<?=html_escape(base_url('assets/files/books/'.$book['file_1']))?>");

            pdfLoad.promise.then(pdf => {
                var pageNum = 1;

                pdf.getPage(pageNum).then(page => {

                    var scale = 1;
                    var viewport = page.getViewport({scale: scale});

                   
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);

                    renderTask.promise.then(function () {
                        
                    });
                });
            });
        }

        // timer
        const idleLogout = () => {
            let time;
            let timeUnit = "<?=$setting['limit_idle_unit']?>";
            let timeValue = <?=$setting['limit_idle_value']?>;
            let seconds = 0;
            // convert to secnds
            switch(timeUnit)
            {
                case 'minutes':
                    seconds = timeValue * 60;
                    break;
                case 'hours':
                    seconds = timeValue * 60 * 60;
                case 'week':
                    seconds = timeValue * 7 * 24 * 60 * 60;
                    break;
            }
            // reset time 
            window.addEventListener('load', resetTimer, true);
            var events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
            events.forEach(function(name) {
                document.addEventListener(name, resetTimer, true);
            });

            function resetTimer() {
                clearTimeout(time);
                time = setTimeout(() => {
                    let newObj = {};
                    Array.from(document.cookie.split(';'), item => {
                        var entry = item.trim().split('=');
                        Object.assign(newObj, {[entry[0]]:decodeURIComponent(entry[1])});
                    });
                    
                    console.log(newObj);

                }, 2 * 1000);
            }
        }

        window.addEventListener('load', e => idleLogout());
    </script>
</body>
</html>