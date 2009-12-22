<?php
require_once('class.phpmailer.php');
require_once("class.Utility.php");

class Mailer{
	
	public static function send($mailinfo){
		
		$mmail = $mailinfo["mail"];
		$smtp = $mailinfo["smtp"];
		$tolist = $mailinfo["to"];
		$cclist = $mailinfo["cc"];
		$bcclist = $mailinfo["bcc"];
		// an [real filepath]=>[cid] mapping
		$image = $mailinfo["image"];
		$files = $mailinfo["files"];

		$mail             = new PHPMailer();

		$body             = $mmail["content"];
		//$body             = eregi_replace("[\]",'',$body);

		$mail->CharSet = "GB2312";
		$mail->IsSMTP();
		$mail->Host       = $smtp["host"];
		$mail->IsHTML(true);
		
		foreach($image as $key => $val){
			echo $key."=>".$val;
			$mail->AddEmbeddedImage($key, $val);
		}
		$mail->SMTPDebug  = false;

		$mail->SMTPAuth   = true;
		$mail->Port       = $smtp["port"];
		$mail->Username   = $smtp["username"];
		$mail->Password   = $smtp["password"];

		$mail->SetFrom($smtp["email"], $smtp["displayName"]);

		$mail->AddReplyTo($smtp["email"], $smtp["displayName"]);

		$mail->Subject    = $mmail["subject"];

//		$mail->AltBody    = "请使用支持HTML的邮件阅读器查看本邮件"; 

		$mail->MsgHTML($body);
		
		foreach($tolist as $to){
			$mail->AddAddress($to, $to);
		}
		foreach($cclist as $cc){
			$mail->AddCC($cc, $cc);
		}
		foreach($bcclist as $bcc){
			$mail->AddBCC($bcc, $bcc);
		}

		foreach($files as $file){
			$mail->AddAttachment(Utility::getAbsolutePathRel("upload/".$mmail["tid"]."/attachments/".$file));
		}
		
		echo "<br />";
		if(!$mail->Send()) {
			echo $mail->ErrorInfo;
		} else {
			echo "操作完成";
		}
//		echo "<br />";
//		echo "本次操作的地址";
//		echo "<div style='margin:5px;background:#ccc'>";
//		echo "<b>To: </b>";
//		foreach($tolist as $to){
//			echo $to;
//			echo ", ";
//		}
//		echo "<br />";
//		echo "<b>CC: </b>";
//		foreach($cclist as $cc){
//			echo $cc;
//			echo ", ";
//		}
//		echo "<br />";
//		echo "<b>BCC: </b>";
//		foreach($bcclist as $bcc){
//			echo $bcc;
//			echo ", ";
//		}
//		echo "</div>";

	}
}


?>
