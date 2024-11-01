<?php
/*
Version: 1.5.4
*/
class lang {
var $lang;
function __construct($lang){
$lang = get_option('wh_language',true);
$dir    = WH_PATH . 'language/';
$files1 =	array_diff(scandir($dir), array('..', '.','class'));
foreach ($files1 as $key => $value)
{
$string_len = strlen($value);
$new_string_len = $string_len - 4;
$letter_code = $string_len - 6;
$value = substr($value,0,$new_string_len);
$letters = substr($value,$letter_code,$letter_code + 2);
if ($lang == $letters)
{
if (file_exists(WH_PATH . 'language/' . $value . '.php'))
{
include WH_PATH . 'language/' . $value . '.php'; $language = true;
}
}
}
if ($language == false){
if (file_exists(WH_PATH . 'language/language-UK.php'))
{
include WH_PATH . 'language/language-UK.php';
}
else{
wp_die('error cannot find language file in /web-hosting/language/');
}
}
return $lang;
}
}