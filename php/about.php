<?php include_once ('sessionManager.php'); ?>
<!DOCTYPE html>
<html xml:lang="it-IT" lang="it-IT">
    <head>
        <title>About &#124; DevSpace</title>
        <meta charset="UTF-8">
        <meta name="description" content="Informazioni sulla piattaforma DevSpace e i suoi sviluppatori" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
        <meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
        <?php include_once ('favicon.php'); ?>
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="./scripts.js"></script>
        
    </head>
    
    <body>
        <button onclick="topFunction()" id="retTop" title="Torna su"></button>
        <?php
            include_once('navbar.php');
        ?>
        
        <div id="header">
            <h1>NOME SITO</h1>
        </div>
        <div class="about-section1">
            <h1>Chi siamo??</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut odio. Nam sed est. Nam a risus et est iaculis adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ut justo. In tincidunt viverra nisl. Donec dictum malesuada magna. Curabitur id nibh auctor tellus adipiscing pharetra. Fusce vel justo non orci semper feugiat. Cras eu leo at purus ultrices tristique.
            </p>
        </div>
        <div class="about-section2">
            <h1>Il Nostro Team</h1>
            <div class="grid">
                <div class="row">
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="http://placekitten.com/810/810" alt="meow"/>
                        </div>
                        <h1>Barzon Giacomo</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a><img alt="github logo" src="img/github-logo.svg"/></a></li>
                            <li><a><img alt="facebook logo" src="img/facebook-logo.svg"/></a></li>
                            <li><a><img alt="mail logo" src="img/mail-logo.svg"/></a></li>
                        </ul>
                    </div>
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="http://placekitten.com/810/810" alt="meow"/>
                        </div>
                        <h1>Barzon Giacomo</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a><img alt="github logo" src="img/github-logo.svg"/></a></li>
                            <li><a><img alt="facebook logo" src="img/facebook-logo.svg"/></a></li>
                            <li><a><img alt="mail logo" src="img/mail-logo.svg"/></a></li>
                        </ul>
                    </div>
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="http://placekitten.com/810/810" alt="meow"/>
                        </div>
                        <h1>Barzon Giacomo</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a><img alt="github logo" src="img/github-logo.svg"/></a></li>
                            <li><a><img alt="facebook logo" src="img/facebook-logo.svg"/></a></li>
                            <li><a><img alt="mail logo" src="img/mail-logo.svg"/></a></li>
                        </ul>
                    </div>
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="http://placekitten.com/810/810" alt="meow"/>
                        </div>
                        <h1>Barzon Giacomo</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a><img alt="github logo" src="img/github-logo.svg"/></a></li>
                            <li><a><img alt="facebook logo" src="img/facebook-logo.svg"/></a></li>
                            <li><a><img alt="mail logo" src="img/mail-logo.svg"/></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-section3">
            <h1>Perchè questo sito?</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut odio. Nam sed est. Nam a risus et est iaculis adipiscing. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ut justo. In tincidunt viverra nisl. Donec dictum malesuada magna. Curabitur id nibh auctor tellus adipiscing pharetra. Fusce vel justo non orci semper feugiat. Cras eu leo at purus ultrices tristique.
            </p>
        </div>
        <div id="footer">
            <div id="upper-footer">
                <p>powered by</p>
                <h1>Universita' di Padova</h1>
            </div>
            <div id="lower-footer">
                <div id="developers">
                    <h2>Developed By</h2>
                    <ul>
                        <li>Barzon Giacomo</li>
                        <li>De Filippis Francesco</li>
                        <li>Greggio Giacomo</li>
                        <li>Roverato Michele</li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
