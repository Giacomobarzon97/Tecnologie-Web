<?php
	session_start();
?>
<div id="nav-full">
			<h1>Nome Sito</h1> 
			<ul id="menu">
				<?php
					if(isset($_SESSION['nickname'])) {
						echo "<li><a href='index.php'>Home</a></li>
						"; 
						echo "<li><a href='profile.php'>Il tuo profilo</a></li>
						";
						echo "<li><a href='logout.php'>Logout</a></li>
						";
					} else {
						echo "<li><a href='index.php'>Home</a></li>
						";
						echo "<li><a href='registrazione.php'>Registrati</a></li>
						";
						echo "<li><a href='login.php'>Accedi</a></li>
						";
					}
				?>
				<li><a href="">About</a></li>
			</ul>
			<img src="img/hamburger.svg" alt="menu-icon" id="nav-menu-icon"/>
        </div>
