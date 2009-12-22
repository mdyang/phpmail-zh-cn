<?php 
require("authenticate_begin.php");
// add custom check options here
require("authenticate_end.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
require_once("classes/class.Utility.php");
$action = $_GET["action"];
$tid;
if ($action == "create"){
	$tid = Utility::getTimeMills();	
}
else{
	$tid = $_GET["tid"];
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<title>编辑邮件</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
	<form id="form1" method="post" action="docompose.php?tid=<?php echo $tid;?>">
		<input type="button" onclick="javascript:send_mail()" value="发送" />
		<input type="button" onclick="javascript:save_mail()" value="保存" /><br />
		
		主题<br />
		<input id="subject" type="text" name="subject" style="width:600px" /><br />
		附件
		<input type="button" onclick="javascript:append_upfile_iframe()" value="上传附件" />
		<div id="uploadFileContainer"></div>
		<ul id="fileview"></ul>
		
		正文插图
		<input type="button" onclick="javascript:append_upimage_iframe()" value="上传图片" />
		<div id="uploadImageContainer"></div>
		<div style="background:#fff;height:150px;width:900px;overflow-x:auto;margin:0px;padding:0px;white-space:nowrap;border:solid 1px #ccc">
			<ul id="imgview"></ul>
		</div>
		
		正文<br />
		<table width="1000" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="850">
					<textarea id="maincontent" name="content"></textarea>
				</td>
				<td width="150">
					信纸 <a href="uploadziptmpl.php" target="_blank">添加信纸</a>
					<div style="text-align:center;background:#fff;height:550px;width:150px;overflow-y:auto;margin:0px;padding:0px;white-space:nowrap;border:solid 1px #ccc">
						<div id="templateview"></div>
					</div>
				</td>
			</tr>
		</table>		

	</form><br />
</div>
<script>
var tid = "<?php echo $tid;?>";
var upfileiframe;
var upimageframe;
var new_mail = <?php echo ($action=="create")?"true":"false";?>;

function get_upload_file_container(){
	return document.getElementById("uploadFileContainer");
}

function get_upload_image_container(){
	return document.getElementById("uploadImageContainer");
}

function get_fileview(){
	return document.getElementById("fileview");	
}

function get_imageview(){
	return document.getElementById("imgview");	
}

function get_templateview(){
	return document.getElementById("templateview");	
}

function get_form(){
	return document.getElementById("form1");
}

function set_subject(subject){
	$("#subject").attr("value", subject);
}

function set_content(content){
	tinyMCE.activeEditor.setContent(content);
}

function send_mail(){
	$(get_form())
		.attr("action", $(get_form()).attr("action")+"&action=send")
		.submit();
}

function save_mail(){
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

function append_upimage_iframe(){
	upimageiframe = document.createElement("iframe");
	$(upimageiframe)
		.attr("frameborder", 0)
		.attr("src", "upload-img.php?tid="+tid)
		.css({
			width:		"400px",
			height:		"48px",
			border:		"none"
		});
	get_upload_image_container().appendChild(upimageiframe);
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
	$(li).html(filename + " <a href=# onclick='delete_file(\""+ filename +"\", this.parentNode)'>删除</a>");
	get_fileview().appendChild(li);
}

function delete_file(filename, elem){
	$.ajax( {
		type: "POST",
		url: "xmldeletefile.php",
		data: {file:"upload/"+tid+"/attachments/"+filename},
		dataType: "text",
		cache:	false,
		success: function(text) {
				if (text == "succeed"){
					get_fileview().removeChild(elem);
				}
				else{
					alert("删除失败，请重试");
				}
			}
		}); 
}

function complete_image_upload(result, filename){

	$("#uploadImageContainer").html("");
	
	if (result == "failed"){
		alert("上传失败，请重试");
	}
	else{
		append_image(filename);
	}
}

function append_image(filename){
	var li = document.createElement("li");
	var img = document.createElement("img");
	var url = "upload/"+tid+"/images/"+filename;
	$(img)
		.attr("src", url)
		.css({
			"width":	"100px",
			"height":	"100px",
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

function append_template(data){
	var div = document.createElement("div");
	var img = document.createElement("img");
	var name = data.name;
	var url = data.image;
	$(img)
		.attr("src", url)
		.css({
			"width":	"100px",
			"height":	"100px",
			border:		"solid 1px #000"
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
			apply_template(data.tid);
		});
	$(div).css({margin:"10px"});
	div.appendChild(img);

	var span = document.createElement('span');
	$(span).text(data.name);

	div.appendChild(document.createElement('br'));
	div.appendChild(span);
	get_templateview().appendChild(div);
}

function apply_template(_tid){
	$.ajax( {
		type: "GET",
		url: "xmltemplates.php?action=content&tid="+_tid,
		dataType: "xml",
		cache: false,
		success: function(xml) {
				$(xml).find("content").each(function(){
					set_content($(this).text());
				});
			}
		});
}

function insert_image(url){
	tinyMCE.activeEditor.focus();
	tinyMCE.activeEditor.selection.setContent("<img src=\"" + url + "\" />");
}

function append_content(){
	$.ajax( {
		type: "GET",
		url: "xmlmail.php?tid="+tid,
		dataType: "xml",
		cache :false,
		success: function(xml) {
				$(xml).find("file").each(function(){
					append_file($(this).text());
				});
				$(xml).find("image").each(function(){
					append_image($(this).text());
				});
				$(xml).find("subject").each(function(){
					set_subject($(this).text());
				});
				$(xml).find("content").each(function(){
					set_content($(this).text());
				});
			}
		}); 
}

function load_templates(){
	$.ajax( {
		type: "GET",
		url: "xmltemplates.php?action=list",
		dataType: "xml",
		cache :false,
		success: function(xml) {
				$(xml).find("template").each(function(){
					append_template({
						tid:	$(this).attr("tid"),
						name:	$(this).attr("name"),
						image:	$(this).attr("image")
					});
				});
			}
		});	
}

tinyMCE.init({
	mode :								"exact",
	elements :							"maincontent",
	theme :								"advanced",
	theme_advanced_toolbar_align :		"left",
	theme_advanced_toolbar_location :	"top",
	language :							"zh",
	width :								850,
	height :							550,

	plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",

	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : "css/content.css"
});

$(document).ready(function(){
	if (!new_mail){
		append_content();
	}
	load_templates();
});

</script>
</body>
</html>