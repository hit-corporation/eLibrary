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
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 75px;
        }

        nav {
            position: fixed;
            width: 100%;
            padding: .5rem 1rem;
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, .4);
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.12), 0px 1px 2px 0px rgba(0,0,0,0.24);
            display: flex;
            flex-wrap: nowrap;
            flex-grow: 0;
            justify-content: end;
            align-items: center;
        }

        button#previous,
        button#next {
            padding: .25rem .5rem;
            display: inline-block;
            vertical-align: baseline;
            border-radius: 4px;
            border: none;
            outline: 1px;
        }

        #current-page {
            margin-left: .25rem;
            margin-right: .25rem;
            padding: .25rem;
            border-radius: .7rem;
            background-color: white;
            width: 2.5rem;
        }
    </style>
</head>
<body>
<nav>
    <div></div>
    <button id="previous">&lt;</button>
    <input type="text" id="current-page" disabled>
    <button id="next">&gt;</button>
</nav>
<div id="main-content">
</div>
    <!-- async -->

    <script src="<?=html_escape('assets/node_modules/pdfjs-dist/build/pdf.min.js')?>"></script>
    <script src="<?=html_escape('assets/node_modules/pdfjs-dist/web/pdf_viewer.js')?>"></script>
    <script defer>
        const main = document.getElementById('main-content'),
              BASE_URL = document.querySelector('base').href;

        // if browser is chrome
        // if(window.navigator.userAgent.indexOf('Chrome') != -1) {
           
        //     const embed = document.createElement('embed');

        //     embed.src = "<?=html_escape(base_url('assets/files/books/'.$book['file_1']))?>#toolbar=0&navpanes=1";
        //     embed.style.height = '100vh';
        //     embed.style.width = '100vw';

        //     main.appendChild(embed);
        // }
        // if browser is firefox
        //if(window.navigator.userAgent.indexOf('Firefox') != -1) {

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
        //}

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
                document.activeElement.focus();
                clearTimeout(time);
                time = setTimeout(() => {
                    let newObj = {};
                    Array.from(document.cookie.split(';'), item => {
                        var entry = item.trim().split('=');
                        Object.assign(newObj, {[entry[0]]:decodeURIComponent(entry[1])});
                        // fetch(window.location.href, {
                        //     method: 'DELETE',
                        //     headers: {
                        //         'Content-Type': 'application/json'
                        //     }
                        // }) 
                        // .then(res => res.json())
                        // .then(res => {
                        //     window.location.reload();
                        // })
                        // .catch(err => {
                        //     window.location.reload();
                        // });
                    });
                    
                    console.log(newObj);

                }, 2 * 1000);
            }
        }

        window.addEventListener('load', e => { 
            document.activeElement.focus();
            idleLogout() 
        });
    </script>
</body>
</html>