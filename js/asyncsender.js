var curIndex = 0;
var listLength;
var curHeader;
var progressBarWidth = 200;

function findId(id){
	return document.getElementById(id);
}

function createElem(tag){
	return document.createElement(tag);
}

function initVariables(){
	listLength = addressList.length;
	curHeader = findId("eventMessageHeader");
}

function appendContent(content){
	var div = createElem("div");
	$(div)
		.css({
			margin:		"10px",
			background:	"#ccc"
		})
		.html(content);
	getEventMessageContainer().insertBefore(div, curHeader);
	curHeader = div;
}

function getEventMessageContainer(){
	return findId("eventMessageContainer");
}

function getProgressBar(){
	return findId("progressBar");
}

function setProgress(percentage){
	$(getProgressBar()).css({
		width:	""+percentage*progressBarWidth+"px"
	});
}

$(document).ready(function(){
	initVariables();
	
	curIndex = 0;
	
	var requestFunction = function(){
		
		$.ajax( {
			timeout: 300000,
			type: "POST",
			url: "xmlmailer.php",
			data: {
				mailtid	:	mailtid,
				smtpid	:	smtpid,
				to		:	addressList[curIndex]["to"],
				cc		:	addressList[curIndex]["cc"],
				bcc		:	addressList[curIndex]["bcc"]
			},
			cache:false,
			dataType: "text",
			success: function(text) {
					var message = "<b>" + text + "</b>";
					appendContent(message);
					setProgress(++curIndex / listLength);
					if (curIndex < listLength){
						requestFunction();
					}
					else{
						alert("·¢ËÍÍê±Ï£¡");
					}
				}
		}); 
	};
	
	requestFunction();
	
});