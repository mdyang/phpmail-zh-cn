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
require_once("classes/class.SmtpConfig.php");
require_once("classes/class.SmtpConfigPersistence.php");
require_once("classes/class.AddressBook.php");
require_once("classes/class.AddressBookPersistence.php");

$tid = $_GET["tid"];
$redirect = $_GET["redirect"];

$persistence = new SmtpConfigPersistence();
$smtps = $persistence->findAll();
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link type="text/css" rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<title>发送邮件</title>
</head>
<body>
<div id="mainContent">
<?php 
require("header.php");
?>
	<form id="form1" method="post" action="<?php echo $redirect;?>?tid=<?php echo $tid;?>">
		<input type="button" onclick="send()" value="发送" /><br />
		<b>SMTP配制式</b>
			<select id="smtp" name="smtp">
			<?php foreach($smtps as $smtp){?>
				<option value="<?php echo $smtp->getTid();?>"><?php echo $smtp->getDisplayName()."&lt;".$smtp->getEmail()."&gt;, ".$smtp->getUsername()."@".$smtp->getHost().":".$smtp->getPort()?></option>
			<?php }?>
			</select><br />
		<b>一次性收件人: 只对以下每个地址只发送一次</b><br />
			To 
			<input type="button" class="addrInputClass" pseudo="onceto" value="手动添加地址" />
			<input type="button" class="addrLinkClass" pseudo="onceto" value="地址簿" /><br />
			<input type="hidden" id="onceto" class="once" name="onceto" />
			<div style="background:#ccc" id="oncetoList">&nbsp;</div>
<!--			<textarea id="onceto" class="once" name="onceto"></textarea><br />	-->
			Cc 			
			<input type="button" class="addrInputClass" pseudo="oncecc" value="手动添加地址" />
			<input type="button" class="addrLinkClass" pseudo="oncecc" value="地址簿" /><br />
			<input type="hidden" id="oncecc" class="once" name="oncecc" />
			<div style="background:#ccc" id="onceccList">&nbsp;</div>	
<!--			<textarea id="oncecc" class="once" name="oncecc"></textarea><br />	-->
			Bcc 
			<input type="button" class="addrInputClass" pseudo="oncebcc" value="手动添加地址" />
			<input type="button" class="addrLinkClass" pseudo="oncebcc" value="地址簿" /><br />
			<input type="hidden" id="oncebcc" class="once" name="oncebcc" />
			<div style="background:#ccc" id="oncebccList">&nbsp;</div>		
<!--			<textarea id="oncebcc" class="once" name="oncebcc"></textarea><br />	-->
		<b>重复性收件人：每次发信，收件人中都将包括以下收件人</b><br />	
			To 
			<input type="button" class="addrInputClass" pseudo="manyto" value="手动添加地址" />
			<input type="button" class="addrLinkClass" pseudo="manyto" value="地址簿" /><br />
			<input type="hidden" id="manyto" class="many" name="manyto" />
			<div style="background:#ccc" id="manytoList">&nbsp;</div>	
<!--			<textarea id="manyto" class="many" name="manyto"></textarea><br />-->
			Cc 
			<input type="button" class="addrInputClass" pseudo="manycc" value="手动添加地址" />
			<input type="button" class="addrLinkClass" pseudo="manycc" value="地址簿" /><br />
			<input type="hidden" id="manycc" class="many" name="manycc" />
			<div style="background:#ccc" id="manyccList">&nbsp;</div>	
<!--			<textarea id="manycc" class="many" name="manycc"></textarea><br />-->
			Bcc 
			<input type="button" class="addrInputClass" pseudo="manybcc" value="手动添加地址" />
			<input type="button" class="addrLinkClass" pseudo="manybcc" value="地址簿" /><br />
			<input type="hidden" id="manybcc" class="many" name="manybcc" />
			<div style="background:#ccc" id="manybccList">&nbsp;</div>	
<!--			<textarea id="manybcc" class="many" name="manybcc"></textarea><br />-->
			SMTP收件人数限制(拆组发送)<br />
			<input type="text" id="oncesize" name="oncesize" value="100" />人/组
		</div>
	</form>
	<div id="panelContainer">
	</div>
</div>
<script>
<?php
$addrPersistence = new AddressBookPersistence();
$addrBooks = $addrPersistence->findAll();
$strs = array();
foreach($addrBooks as $addr){
	$strs[] = Utility::strMapToStrJSDeclaration(array(
		"name"	=>  $addr->getName(),
		"content"	=>	$addr->getContent()
	));
}
echo "var addrs = ";
echo Utility::arrayToJSDeclaration($strs);
echo ";";
?>
var tid = "<?php echo $tid;?>";
var curtextarea;
var addrbook;
var addrinput;

function get_form(){
	return document.getElementById("form1");
}

function createElem(tag){
	return document.createElement(tag);
}

function find(id){
	return document.getElementById(id);
}

function send(){
	// presend operations	
	var _once_to = "";
	var _once_cc = "";
	var _once_bcc = "";
	var _many_to = "";
	var _many_cc = "";
	var _many_bcc = "";

	$(find("oncetoList")).children().each(function(){
		_once_to += ($(this).data("addr")+";");
	});
	$(find("onceccList")).children().each(function(){
		_once_cc += ($(this).data("addr")+";");
	});
	$(find("oncebccList")).children().each(function(){
		_once_bcc += ($(this).data("addr")+";");
	});
	$(find("manytoList")).children().each(function(){
		_many_to += ($(this).data("addr")+";");
	});
	$(find("manyccList")).children().each(function(){
		_many_cc += ($(this).data("addr")+";");
	});
	$(find("manybccList")).children().each(function(){
		_many_bcc += ($(this).data("addr")+";");
	});
	
	$(find("onceto")).attr("value", _once_to);
	$(find("oncecc")).attr("value", _once_cc);
	$(find("oncebcc")).attr("value", _once_bcc);
	$(find("manyto")).attr("value", _many_to);
	$(find("manycc")).attr("value", _many_cc);
	$(find("manybcc")).attr("value", _many_bcc);
	
	$(get_form()).submit();
}

function close_addrbook(){
	$(addrbook).css({
		display:	"none"
	});
}

function init_addr_book(){

	addrbook = createElem("div");
	$(addrbook)
		.css({
			"text-align":	"left",
			position:	"absolute",
			background :	"#ccc",
			display	:	"none",
			padding :	"5px",
			border :	"solid 1px #000"
		});

	var input = createElem("input");
	$(input)
		.attr({
			type	: "button",
			value	: "关闭"
		})
		.click(function(){
			close_addrbook();
		});
	addrbook.appendChild(input);

	for (var i = 0; i < addrs.length; i ++){
		var curAddr = addrs[i];
		addrbook.appendChild(createElem("br"));
		var _a = createElem("a");
		$(_a)
			.text(curAddr["name"])
			.data("_name", curAddr["name"])
			.data("_addr", curAddr["content"])
			.mouseover(function(){
				$(this).css({
					color:	"#f00"
				});
			})
			.mouseout(function(){
				$(this).css({
					color:	"#000"
				});
			})
			.click(function(){

				add_addr_item("[地址簿:"+$(this).data("_name")+"]", $(this).data("_addr"));
				
				close_addrbook();
			});
		addrbook.appendChild(_a);
	}	

	find("panelContainer").appendChild(addrbook);
}

function add_addr_item(_name, _content){
	var parentSpan = createElem("span");
	$(parentSpan)
		.data("addr", _content)
		.css({
			"margin-right"	:	"10px"
		});

	var spanName = createElem("span");
	$(spanName).text(_name);
	parentSpan.appendChild(spanName);
	
	var spanClose = createElem("a");
	$(spanClose)
		.text("删除")
		.css({
			color	:	"#f00"
		})
		.click(function(){
			var _item = this.parentNode;
			var _parent = _item.parentNode;
			_parent.removeChild(_item);
		});
	
	parentSpan.appendChild(spanClose);
	
	find(curtextarea+"List").appendChild(parentSpan);
}

function init_addr_input(){
	addrinput = createElem("div");
	$(addrinput)
		.css({
			width:	"640px",
			height:	"400px",
			border:	"solid 1px #000",
			background:	"#ccc",
			padding:	"5px",
			display:	"none",
			position:	"absolute"
		});

	var _confirm = createElem("input");
	$(_confirm)
		.attr({
			type:	"button",
			value:	"确定"
		})
		.click(function(){
			var _text = $(find("_manual_addr_input")).text();
			add_addr_item(_text, _text);
			$(find("_manual_addr_input")).text("");
			$(addrinput).css({
				display	:	"none"
			});
		});
	addrinput.appendChild(_confirm);

	var _cancel = createElem("input");
	$(_cancel)
		.attr({
			type:	"button",
			value:	"取消"
		})
		.click(function(){
			$(find("_manual_addr_input")).text("");
			$(addrinput).css({
				display	:	"none"
			});
		});
	addrinput.appendChild(_cancel);
	addrinput.appendChild(createElem("br"));

	var _textarea = createElem("textarea");
	$(_textarea)
		.css({
			width:	"630px",
			height:	"365px",
			border:	"solid 1px #808080"
		})
		.attr("id", "_manual_addr_input");

	addrinput.appendChild(_textarea);
	
	find("panelContainer").appendChild(addrinput);
}

$(document).ready(function(){

	init_addr_book();

	init_addr_input();

	$(".addrLinkClass").click(function(e){
		curtextarea = $(this).attr("pseudo");
		$(addrbook).css({
			display:	"",
			left:	""+e.pageX+"px",
			top:	""+e.pageY+"px"
		});
	});

	$(".addrInputClass").click(function(e){
		curtextarea = $(this).attr("pseudo");
		$(addrinput).css({
			display:	"",
			left:	""+e.pageX+"px",
			top:	""+e.pageY+"px"
		});
	});
});

</script>
</body>
</html>
