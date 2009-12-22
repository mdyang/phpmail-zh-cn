<?php
require_once("classes/class.Utility.php");

session_start();

$_no_access = array(
	"const"		=>	array(
			array(true, true, false)
		),
	"array"		=>	array(
			"session"	=>	array()
		),
	"action"	=>	array(
			"redirect"	=>	"index.php"
		)
);

$_no_auth = array(
	"const"		=>	array(),
	"array"		=>	array(
			"session"	=>	array()
		),
	"action"	=>	array()
);

$_user_auth = array(
	"const"		=>	array(),
	"array"		=>	array(
			"session"	=>	array(
					array("logged", true, true),
					array("username", null, false),
					array("type", "user", true)
				)
		),
	"action"	=>	array(
			"redirect"	=>	"login.php"
		)
);

$_admin_auth = array(
	"const"		=>	array(),
	"array"		=>	array(
			"session"	=>	array(
					array("logged", true, true),
					array("username", null, false),
					array("type", "admin", true)
				)
		),
	"action"	=>	array(
			"redirect"	=>	"adminlogin.php"
		)
);

$_auth_config = array(
	"logout.php"			=>	array($_no_auth),
	"login.php"				=>	array($_no_auth),
	"dologin.php"			=>	array($_no_auth),
	"adminlogin.php"		=>	array($_no_auth),
	"doadminlogin.php"		=>	array($_no_auth),
	"index.php"				=>	array($_user_auth, $_admin_auth),
	"compose.php"			=>	array($_user_auth, $_admin_auth),
	"composecard.php"		=>	array($_user_auth, $_admin_auth),
	"docompcard.php"		=>	array($_user_auth, $_admin_auth),
	"docompcardtmpl.php"	=>	array($_user_auth, $_admin_auth),
	"docompose.php"			=>	array($_user_auth, $_admin_auth),
	"dosend.php"			=>	array($_user_auth, $_admin_auth),
	"dozipmail.php"			=>	array($_user_auth, $_admin_auth),
	"presend.php"			=>	array($_user_auth, $_admin_auth),
	"upload-file.php"		=>	array($_user_auth, $_admin_auth),
	"upload-img.php"		=>	array($_user_auth, $_admin_auth),
	"uploadzipmail.php"		=>	array($_user_auth, $_admin_auth),
	"viewlocal.php"			=>	array($_user_auth, $_admin_auth),
	"xmladdrbook.php"		=>	array($_user_auth, $_admin_auth),
	"xmlcardtmpl.php"		=>	array($_user_auth, $_admin_auth),
	"xmlmail.php"			=>	array($_user_auth, $_admin_auth),
	"xmlmailer.php"			=>	array($_user_auth, $_admin_auth),
	"xmltemplates.php"		=>	array($_user_auth, $_admin_auth),
	"xmldeletefile.php"		=>	array($_user_auth, $_admin_auth),
	"uploadziptmpl.php"		=>	array($_admin_auth),
	"compcardtmpl.php"		=>	array($_admin_auth),
	"deletedir.php"			=>	array($_admin_auth),
	"doeditaddrbook.php"	=>	array($_admin_auth),
	"doeditsmtp.php"		=>	array($_admin_auth),
	"doziptmpl.php"			=>	array($_admin_auth),
	"editaddrbook.php"		=>	array($_admin_auth),
	"editsmtp.php"			=>	array($_admin_auth),
	"manageaddrbook.php"	=>	array($_admin_auth),
	"managecardtmpl.php"	=>	array($_admin_auth),
	"managesmtp.php"		=>	array($_admin_auth),
	"managetmpl.php"		=>	array($_admin_auth),
	"admin.php"				=>	array($_admin_auth),
	"manageuser.php"		=>	array($_admin_auth),
	"newuser.php"			=>	array($_admin_auth),
	"donewuser.php"			=>	array($_admin_auth),
	"manageadmin.php"		=>	array($_admin_auth),
	"newadmin.php"			=>	array($_admin_auth),
	"donewadmin.php"		=>	array($_admin_auth)
);
$_cur_page_file = Utility::curFile();
$_cur_auth_settings = $_auth_config[$_cur_page_file];
$_cur_auth_params = 
	array(
		"session"	=>	$_SESSION,
		"get"		=>	$_GET,
		"post"		=>	$_POST,
		"cookie"	=>	$_COOKIE,
	);

?>