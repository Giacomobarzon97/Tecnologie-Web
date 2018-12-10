
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
		if(menu.style.display=="none"){
			menu.style.display="block";		
		}else{
			menu.style.display="none"	;	
		}
	}
}
function replyMessageBox(){
	//Comment Reply, create comment div and form
	var commentReply = document.getElementsByClassName("comment-reply-start-button");
	var previousReplyClick = null;
	var commentFormDiv = document.createElement("div");
	commentFormDiv.className = "input-comment";

	var commentForm = document.createElement("form");
	commentForm.method="POST";
	commentForm.action=""; //To add later, as input names

	var inputCommentArea = document.createElement("div");
	inputCommentArea.className="input-comment-area";

	var commentFormTextArea=document.createElement("textarea");
	commentFormTextArea.rows = "7";
	commentFormTextArea.cols = "100";
	commentFormTextArea.value = "";
	inputCommentArea.appendChild(commentFormTextArea);

	var commentFormSubmit = document.createElement("input");
	commentFormSubmit.type = "submit";
	commentFormSubmit.value = "Invia risposta";
	var inputCommentFooter = document.createElement("div");
	inputCommentFooter.className="input-reply-footer";
	inputCommentFooter.appendChild(commentFormSubmit)

	commentForm.appendChild(inputCommentArea);
	commentForm.appendChild(inputCommentFooter);
	commentFormDiv.appendChild(commentForm);

	//Onclick() status, executed when clicking "Reply" button
	for(var i=0; i<commentReply.length; i++){
		commentReply[i].addEventListener("click",function(e){
			e = e || window.event;
			var target = e.target || e.srcElement;
			target.parentNode.appendChild(commentFormDiv);
			//Azzero la text-area dall'input precedente
			commentFormDiv.childNodes[0].childNodes[0].childNodes[0].value = "";
			target.style.display="none";
			if(previousReplyClick!=null){
				previousReplyClick.style.display="block";
			}
			previousReplyClick=target;
		},false);
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
	replyMessageBox();
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
