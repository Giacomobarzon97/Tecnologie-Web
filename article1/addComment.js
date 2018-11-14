window.addEventListener("load", function ( ){
    //Comment Reply
	var commentReply= document.getElementsByClassName("comment-reply");
	var previousReplyClick=null;
	var commentFormDiv= document.createElement("div");
	commentFormDiv.className="reply-form";
	var commentForm=document.createElement("form");
	commentForm.method="POST";
	commentForm.action="";
	commentFormDiv.appendChild(commentForm);
	var commentFormTextArea=document.createElement("textarea");
	commentFormTextArea.rows="7";
	commentFormTextArea.cols="40";
	commentForm.appendChild(commentFormTextArea);
	var commentFormSubmit=document.createElement("input");
	commentFormSubmit.type="submit";
	commentForm.appendChild(commentFormSubmit)
	for(var i=0; i<commentReply.length; i++){
		commentReply[i].addEventListener("click",function(e){
			e = e || window.event;
			var target = e.target || e.srcElement;
			target.parentNode.appendChild(commentFormDiv);
			target.style.display="none";
			if(previousReplyClick!=null){
				previousReplyClick.style.display="block"
			}
			previousReplyClick=target;
		},false);
	}
});