window.addEventListener("load", function(){
	document.getElementById("nav-hamburger").addEventListener("click", function(){
			document.getElementById("sidebar").style.width="70%";
			document.getElementById("mobile-sidebar-mask").style.display="block";
			document.getElementById("mobile-sidebar-mask").style.backgroundColor="rgba(0,0,0,0.5)";
	}, false);
	document.getElementById("mobile-sidebar-mask").addEventListener("click", function(){
		document.getElementById("sidebar").style.width="0%";
		document.getElementById("mobile-sidebar-mask").style.backgroundColor="rgba(0,0,0,0.0)";		
		document.getElementById("mobile-sidebar-mask").style.display="none";
}, false);
});

window.addEventListener('resize', function(e) {
	if(window.innerWidth>768){
		document.getElementById("sidebar").style.width="25%";
		document.getElementById("mobile-sidebar-mask").style.backgroundColor="rgba(0,0,0,0.0)";		
		document.getElementById("mobile-sidebar-mask").style.display="none";
	}else{
		document.getElementById("sidebar").style.width="0%";
	}
}, false);
