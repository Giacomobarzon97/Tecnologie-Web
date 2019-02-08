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
        <?php
            include_once('navbar.php');
        ?>
        
        <div id="header">
            <h1>DevSpace</h1>
        </div>
        <div class="about-section1">
            <h1>Who are we?</h1>
            <p>
                Students from University of Padua, attending the course of Computer Science (Mathematics Department "Tullio Levi-Civita" - DM).
                Our group consists of four members: Francesco De Filippis, Michele Roverato, Giacomo Barzon and Giacomo Greggio.
            </p>
        </div>
        <div class="about-section2">
            <h1>Our Team</h1>
            <div class="grid">
                <div class="row">
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="https://avatars0.githubusercontent.com/u/43989185?s=400&v=4" alt="Github avatar of Barzon Giacomo"/>
                        </div>
                        <h1>Barzon Giacomo</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a href="https://github.com/Giacomobarzon97"><img alt="github logo" src="img/github-logo.svg" /></a></li>
                        </ul>
                    </div>
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="https://avatars2.githubusercontent.com/u/11294898?s=400&v=4" alt="Github avatar of Michele Roverato"/>
                        </div>
                        <h1>Roverato Michele</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a href="https://github.com/ScrappyCocco"><img alt="github logo" src="img/github-logo.svg" /></a></li>
                        </ul>
                    </div>
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="https://avatars3.githubusercontent.com/u/29098430?s=400&v=4" alt="Github avatar of De Filippis Francesco"/>
                        </div>
                        <h1>De Filippis Francesco</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a href="https://github.com/frncscdf"><img alt="github logo" src="img/github-logo.svg" /></a></li>
                        </ul>
                    </div>
                    <div class="bio-card">
                        <div class="bio-image">
                            <img src="https://avatars1.githubusercontent.com/u/43755172?s=460&v=4" alt="Github avatar of Greggio Giacomo"/>
                        </div>
                        <h1>Greggio Giacomo</h1>
                        <h2>Full stack developer</h2>
                        <ul>
                            <li><a href="https://github.com/giacomogreggio"><img alt="github logo" src="img/github-logo.svg" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-section3">
            <h1>Why did we make this site?</h1>
            <p>
                This site is a project for the course of Web Technologies. This course takes place in our University during the last year of our Bachelor Degree.
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
