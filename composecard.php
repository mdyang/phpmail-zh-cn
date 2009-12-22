<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
require_once("classes/class.Utility.php");
$tid = Utility::getTimeMills();
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/flash-head.js"></script>
<title>编辑明信片</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
	<form id="form1" method="post" action="docompcard.php?tid=<?php echo $tid;?>">
		<input type="button" onclick="javascript:send_mail()" value="发送" />
		<input type="button" onclick="javascript:save_mail()" value="保存" /><br />
		
		主题<br />
		<input id="subject" type="text" name="subject" style="width:600px" /><br />
		
		明信片模板
		<a href="compcardtmpl.php" target="_blank">上传模板</a>
		<div style="background:#fff;height:150px;width:780px;overflow-x:auto;margin:0px;padding:0px;white-space:nowrap;border:solid 1px #ccc">
			<ul id="imgview"></ul>
		</div><br />
		<script language="JavaScript" type="text/javascript">
			AC_FL_RunContent(
				'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0',
				'width', '680',
				'height', '360',
				'src', 'cardeditor',
				'quality', 'high',
				'pluginspage', 'http://www.adobe.com/go/getflashplayer',
				'align', 'middle',
				'play', 'true',
				'loop', 'true',
				'scale', 'showall',
				'wmode', 'window',
				'devicefont', 'false',
				'id', 'cardeditor',
				'bgcolor', '#ffffff',
				'name', 'cardeditor',
				'menu', 'true',
				'allowFullScreen', 'false',
				'allowScriptAccess','sameDomain',
				'movie', 'cardeditor',
				'salign', ''
				); //end AC code
		</script>
		<noscript>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="680" height="360" id="cardeditor" align="middle">
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="false" />
				<param name="movie" value="cardeditor.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="cardeditor.swf" quality="high" bgcolor="#ffffff" width="680" height="360" name="cardeditor" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
			</object>
		</noscript>
		<input id="image" type="hidden" name="image" />
	</form><br />
</div>
<script>
var tid = "<?php echo $tid;?>";
var upfileiframe;
var upimageframe;
var theFlash;

function get_upload_file_container(){
	return document.getElementById("uploadFileContainer");
}

function get_fileview(){
	return document.getElementById("fileview");	
}

function get_imageview(){
	return document.getElementById("imgview");	
}

function get_form(){
	return document.getElementById("form1");
}

function set_subject(subject){
	$("#subject").attr("value", subject);
}

function pre_submit_op(){
	$("#image").attr("value", theFlash.getPicture());
}

function send_mail(){
	pre_submit_op();
	$(get_form())
		.attr("action", $(get_form()).attr("action")+"&action=send")
		.submit();
}

function save_mail(){
	pre_submit_op();
	$(get_form())
		.attr("action", $(get_form()).attr("action")+"&action=save")
		.submit();
}

function append_upfile_iframe(){
	upfileiframe = document.createElement("iframe");
	$(upfileiframe)
		.attr("frameborder", 0)
		.attr("src", "upload-file.php?tid="+tid)
		.css({
			width:		"400px",
			height:		"48px",
			border:		"none"
		});
	get_upload_file_container().appendChild(upfileiframe);
}

function complete_file_upload(result, filename){

	$("#uploadFileContainer").html("");
	
	if (result == "failed"){
		alert("上传失败，请重试");
	}
	else{
		append_file(filename);
	}
}

function append_file(filename){
	var li = document.createElement("li");
	$(li).text(filename);
	get_fileview().appendChild(li);
}

function append_image(data){

	var url = data.url;
	var name = data.name;
	
	var li = document.createElement("li");
	var img = document.createElement("img");
	$(img)
		.attr({
			"src":	url,
			"alt":	name
		})
		.css({
			"width":		"132px",
			"height":		"99px",
			border:			"solid 1px #000"
		})
		.mouseover(function(){
			$(this).css({
				border:		"solid 1px #f00"
			});
		})
		.mouseout(function(){
			$(this).css({
				border:		"solid 1px #000"
			});
		})
		.click(function(){
			insert_image(url);
		});
	li.appendChild(img);
	get_imageview().appendChild(li);
}

function insert_image(url){
	theFlash.loadImage(url);
}

function showBase64(){
	var from = +new Date();
	document.write(cardeditor.getPicture());
	var to = +new Date();
	alert("Processing Complete, Time Elapsed: " + to-from + " ms.");
}

function append_content(){
	$.ajax( {
		type: "GET",
		url: "xmlcardtmpl.php",
		dataType: "xml",
		cache :false,
		success: function(xml) {
				$(xml).find("template").each(function(){
					append_image({
						url:	$(this).attr("image"),
						name:	$(this).attr("name")
					});
				});
			}
		}); 
}

$(document).ready(function(){

	if (typeof cardeditor == "undefined"){
		theFlash = document.getElementById("cardeditor");
	}
	else{
		theFlash = cardeditor;
	}
	
	append_content();
});

</script>
</body>
</html>
