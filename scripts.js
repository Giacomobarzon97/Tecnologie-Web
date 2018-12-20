function openMobileSidebar(){
	var wrapper=document.getElementById("sidebar-wrapper");
	var mask=document.getElementById("mobile-sidebar-mask");
	if(wrapper!=null && mask!=null){
		wrapper.style.width="70%";
		mask.style.display="block";
		mask.style.backgroundColor="rgba(0,0,0,0.5)";
	}
}

function closeMobileSidebar(){
	var wrapper=document.getElementById("sidebar-wrapper");
	var mask=document.getElementById("mobile-sidebar-mask");
	if(wrapper!=null && mask!=null){
		wrapper.style.width="0%";
		mask.style.backgroundColor="rgba(0,0,0,0.0)";		
		mask.style.display="none";
	}
}

function toggleMobileNavMenu(){
	var menu=document.getElementById("menu");
	if(menu!=null){
		if(menu.style.display=="block"){
			menu.style.display="none";		
		}else{
			menu.style.display="block"	;	
		}
	}
}

function sidebarExpandButtons(){
	var buttons = document.getElementsByClassName("expand-button");
	for(var i=0; i<buttons.length;i++){
		buttons[i].addEventListener("click",function(e){
			e = e || window.event;
			var target = e.target || e.srcElement;
			var sublist= target.parentNode.parentNode.getElementsByTagName("UL")[0];
			if(sublist.style.display=="block"){
				target.src="img/expand-button.svg";
				sublist.style.display="none";
			}else{
				sublist.style.display="block";
				target.src="img/collapse-button.svg";				
			}
		},false);
	}
}

window.addEventListener("load", function(){
	var hamburger=document.getElementById("nav-hamburger");
	var mask=document.getElementById("mobile-sidebar-mask");
	var menuIcon=document.getElementById("nav-menu-icon");
	if(hamburger!=null && mask!=null){
		hamburger.addEventListener("click",openMobileSidebar, true);
		mask.addEventListener("click",closeMobileSidebar, true);
	}
	if(menuIcon!=null){
		menuIcon.addEventListener("click",toggleMobileNavMenu , true);
	}
	sidebarExpandButtons();
});

window.addEventListener('resize', function(e) {
	var wrapper=document.getElementById("sidebar-wrapper");
	var mask=document.getElementById("mobile-sidebar-mask");
	var menu=document.getElementById("menu");
	if(window.innerWidth>768){
		if(wrapper!=null && mask!=null){
			wrapper.style.width="25%";
			mask.style.backgroundColor="rgba(0,0,0,0.0)";		
			mask.style.display="none";
		}
		if(menu!=null){
			menu.style.display="block";
		}
	}else{
		if(wrapper!=null){
			wrapper.style.width="0%";
		}
		if(menu!=null){
			menu.style.display="none";
		}

	}
}, false);

/* nav-bar menu collapse */
document.addEventListener("DOMContentLoaded", function() {
	//The first argument are the elements to which the plugin shall be initialized
	//The second argument has to be at least a empty object or a object with your desired options
	var sidebar=document.getElementById("sidebar-wrapper");
	if(sidebar!=null){
		OverlayScrollbars(sidebar, { });
	}
});
