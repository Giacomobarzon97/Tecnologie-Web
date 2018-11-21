window.addEventListener("load", function(){
	document.getElementById("nav-hamburger").addEventListener("click", function(){
			document.getElementById("sidebar-wrapper").style.width="70%";
			document.getElementById("mobile-sidebar-mask").style.display="block";
			document.getElementById("mobile-sidebar-mask").style.backgroundColor="rgba(0,0,0,0.5)";
	}, false);
	document.getElementById("mobile-sidebar-mask").addEventListener("click", function(){
		document.getElementById("sidebar-wrapper").style.width="0%";
		document.getElementById("mobile-sidebar-mask").style.backgroundColor="rgba(0,0,0,0.0)";		
		document.getElementById("mobile-sidebar-mask").style.display="none";
	}, false);
	
	
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
				previousReplyClick.style.display="block"
			}
			previousReplyClick=target;
		},false);
	}
});

window.addEventListener('resize', function(e) {
	if(window.innerWidth>768){
		document.getElementById("sidebar-wrapper").style.width="25%";
		document.getElementById("mobile-sidebar-mask").style.backgroundColor="rgba(0,0,0,0.0)";		
		document.getElementById("mobile-sidebar-mask").style.display="none";
	}else{
		document.getElementById("sidebar-wrapper").style.width="0%";
	}
}, false);

function menuCollapse() {
    var y = document.getElementById('nav-bar-menu');
    if (y.className === "menu") {
      y.className += " responsive";
    } else {
      y.className = "menu";
    }
}
