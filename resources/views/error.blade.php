<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stayhere - Coding challenge</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">

        <!-- Styles -->
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font: 14px/1 'Open Sans', sans-serif;
                color: #555;
                background: #e5e5e5;
            }

            .gallery {
                width: 90%;
                margin: 0 auto;
                padding: 5px;
                background: #fff;
                box-shadow: 0 1px 2px rgba(0,0,0,.3);
            }

            .gallery > div {
                position: relative;
                float: left;
                padding: 5px;
                width: 33%;
            }

            .gallery > div > img {
                display: block;
                width: 100%;
                transition: .1s transform;
                transform: translateZ(0); /* hack */
                background-color: #f0f0f5;
            }

            .gallery > div:hover {
                z-index: 1;
            }

            .gallery > div:hover > img {
                transform: scale(1.7,1.7);
                transition: .3s transform;
            }

            .cf:before, .cf:after {
                display: table;
                content: "";
                line-height: 0;
            }

            .cf:after {
                clear: both;
            }

            h1 {
                margin: 40px 0;
                font-size: 30px;
                text-align: center;
            }
        </style>

        <style>
            body {
                font-family: 'Open Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <h1>can't open the link at the momment</h1>
    </body>
</html>