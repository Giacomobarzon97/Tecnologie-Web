window.addEventListener("load", function(){
	document.getElementById("nav-hamburger").addEventListener("click", function(){
		if(document.getElementById("sidebar").style.width=="0px"){
			document.getElementById("sidebar").style.width="250px";
		}else{
			document.getElementById("sidebar").style.width="0px";
		}
	}, false);
});

window.addEventListener('resize', function(e) {
	if(window.innerWidth>768){
		document.getElementById("sidebar").style.width="250px";
	}else{
		document.getElementById("sidebar").style.width="0px";
	}
}, false);
