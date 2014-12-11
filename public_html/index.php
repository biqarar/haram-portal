<?php

/**
@ In the name Of Allah
@ author: Baravak @hsbaravak fb.com/hasan.salehi itb.baravak@gmail.com +989356032043
@ version: 0.0.6
@ date: 
**/
header("Content-Type:text/html; charset=UTF-8");
/** Define DOMAIn as the server name */
define("DOMAIN", $_SERVER["SERVER_NAME"]);
define("host", 'http://'.DOMAIN);
/** Define PATH as the site location */
define("PATH", preg_replace("/index\.php$/", "", $_SERVER["SCRIPT_NAME"]));

$dir = preg_replace("[\\\\]", "/", __DIR__);
define("DIR", $dir);

if ( file_exists( DIR . '/config.php') )
{
	/** The config file resides in DIR */
	require_once( DIR . '/config.php' );
}
else
{   // A config file doesn't exist

    // Die with an error message
$die  = _( "There doesn't seem to be a <code>config.php</code> file. I need this before we can get started." ) . '</p>';
echo( $die. _( 'Contact with administrator!' ) );
exit();
}

//define config
error_reporting(E_ALL);
ini_set('display_errors','On');
ini_set('display_startup_errors','On');
ini_set('error_reporting','E_ALL | E_STRICT');
ini_set('track_errors','On');
ini_set('display_errors',1);
error_reporting(E_ALL);
/**
 * local lang
 */
$locale = 'fa_IR';
putenv( "LC_ALL={$locale}" );
setlocale( LC_ALL, $locale );
$domain = $locale;
bindtextdomain($domain, root_dir.'languages/');
textdomain("*");
session_start();
//load auto load
require_once(core."autoload.php");
//hendel
$main = new main_lib();

?>
