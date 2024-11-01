<?php

// Version: 1.5.4


if (file_exists(THEME_PATH."/web-hosting/wh_globals.php")){require_once (THEME_PATH."/web-hosting/wh_globals.php" );}

	else{

		if (file_exists(WH_PATH."wh_globals.php"))
			{require_once (WH_PATH."wh_globals.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "wh_globals.php" . " was not found<br>";}

		}



if (file_exists(THEME_PATH."/web-hosting/domains/wh_domain_forms.php")){require_once (THEME_PATH."/web-hosting/domains/wh_domain_forms.php" );}

	else{

		if (file_exists(WH_PATH."domains/wh_domain_forms.php"))
			{require_once (WH_PATH."domains/wh_domain_forms.php" );} 
				else {$file_error .= "file " . WH_PATH . "domains/wh_domain_forms.php" . " was not found<br>";}

		}

if (file_exists(ABSPATH . WPINC . "/class-phpmailer.php"))
			{require_once(ABSPATH . WPINC . '/class-phpmailer.php');} 
				else {$file_error .= "Error: file " . ABSPATH . WPINC . "/class-phpmailer.php" . "was not found<br>";}
				



if (file_exists(THEME_PATH."/web-hosting/functions/wh_functions.php")){require_once (THEME_PATH."/web-hosting/functions/wh_functions.php" );}

	else{

		if (file_exists(WH_PATH."functions/wh_functions.php"))
			{require_once (WH_PATH."functions/wh_functions.php" );}
				else {$file_error .= "Error: file " . WH_PATH . "functions/wh_functions.php" . " was not found<br>";}


		}
		
if (file_exists(THEME_PATH."/web-hosting/functions/wh_whm.php")){require_once (THEME_PATH."/web-hosting/functions/wh_whm.php" );}

	else{

		if (file_exists(WH_PATH."functions/wh_whm.php"))
			{require_once (WH_PATH."functions/wh_whm.php" );}
				else {$file_error .= "Error: file " . WH_PATH . "functions/wh_whm.php" . " was not found<br>";}


		}

if (file_exists(THEME_PATH."/web-hosting/functions/wh_account_page.php")){require_once (THEME_PATH."/web-hosting/functions/wh_account_page.php" );}

	else{

		if (file_exists(WH_PATH."functions/wh_account_page.php"))
			{require_once (WH_PATH."functions/wh_account_page.php" );}
				else {$file_error .= "Error: file " . WH_PATH . "functions/wh_account_page.php" . " was not found<br>";}


		}

if (file_exists(THEME_PATH."/web-hosting/resellerclub/wh_resellerclub.php")){require_once (THEME_PATH."/web-hosting/resellerclub/wh_resellerclub.php" );}

	else{

		if (file_exists(WH_PATH."resellerclub/wh_resellerclub.php"))
			{require_once (WH_PATH."resellerclub/wh_resellerclub.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "resellerclub/wh_resellerclub.php" . " was not found<br>";}

		}



if (file_exists(THEME_PATH."/web-hosting/includes/tcpdf/config/lang/eng.php")){require_once (THEME_PATH."/web-hosting/includes/tcpdf/config/lang/eng.php" );}

	else{

		if (file_exists(WH_PATH."includes/tcpdf/config/lang/eng.php"))
			{require_once (WH_PATH."includes/tcpdf/config/lang/eng.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "includes/tcpdf/config/lang/eng.php" . " was not found<br>";}

		}

if (file_exists(THEME_PATH."/web-hosting/includes/tcpdf/tcpdf.php")){require_once (THEME_PATH."/web-hosting/includes/tcpdf/tcpdf.php" );}

	else{

		if (file_exists(WH_PATH."includes/tcpdf/tcpdf.php"))
			{require_once (WH_PATH."includes/tcpdf/tcpdf.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "includes/tcpdf/tcpdf.php" . " was not found<br>";}

		}

if (file_exists(THEME_PATH."/web-hosting/includes/tcpdf/tcpdf_class.php")){require_once (THEME_PATH."/web-hosting/includes/tcpdf/tcpdf_class.php" );}

	else{

		if (file_exists(WH_PATH."includes/tcpdf/tcpdf_class.php"))
			{require_once (WH_PATH."includes/tcpdf/tcpdf_class.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "includes/tcpdf/tcpdf_class.php" . " was not found<br>";}
		}

if (file_exists(THEME_PATH."/web-hosting/includes/widget.php")){require_once (THEME_PATH."/web-hosting/includes/widget.php" );}

	else{

		if (file_exists(WH_PATH."includes/widget.php"))
			{require_once (WH_PATH."includes/widget.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "includes/widget.php" . " was not found<br>";}
		}

if (file_exists(THEME_PATH."/web-hosting/language/class/class.php")){require_once (THEME_PATH."/web-hosting/language/class/class.php" );}

	else{

		if (file_exists(WH_PATH."language/class/class.php"))
			{require_once (WH_PATH."language/class/class.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "language/class/class.php" . " was not found<br>";}
	}
	
if (file_exists(THEME_PATH."/web-hosting/domains/wh_domains.php")){require_once (THEME_PATH."/web-hosting/domains/wh_domains.php" );}

	else{

		if (file_exists(WH_PATH."domains/wh_domains.php"))
			{require_once (WH_PATH."domains/wh_domains.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "domains/wh_domains.php" . " was not found<br>";}
	}
	
	
if (file_exists(THEME_PATH."/web-hosting/resellerclub/wh_signup.php")){require_once (THEME_PATH."/web-hosting/resellerclub/wh_signup.php" );}

	else{	
	
	if (file_exists(WH_PATH."/resellerclub/wh_signup.php"))
			{require_once (WH_PATH."/resellerclub/wh_signup.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/resellerclub/wh_signup.php" . " was not found<br>"; echo $file_error;}

	}
	
	
	
if (file_exists(THEME_PATH."/web-hosting/resellerclub/wh_customer_info.php")){require_once (THEME_PATH."/web-hosting/resellerclub/wh_customer_info.php" );}

	else{	
	
	if (file_exists(WH_PATH."/resellerclub/wh_customer_info.php"))
			{require_once (WH_PATH."/resellerclub/wh_customer_info.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/resellerclub/wh_customer_info.php" . " was not found<br>"; echo $file_error;}

	}
	
		
if (file_exists(THEME_PATH."/web-hosting/resellerclub/wh_customer_id.php")){require_once (THEME_PATH."/web-hosting/resellerclub/wh_customer_id.php" );}

	else{	
	
	if (file_exists(WH_PATH."/resellerclub/wh_customer_id.php"))
			{require_once (WH_PATH."/resellerclub/wh_customer_id.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/resellerclub/wh_customer_id.php" . " was not found<br>"; echo $file_error;}

	}
		
if (file_exists(THEME_PATH."/web-hosting/resellerclub/wh_register.php")){require_once (THEME_PATH."/web-hosting/resellerclub/wh_register.php" );}

	else{	
	
	if (file_exists(WH_PATH."/resellerclub/wh_register.php"))
			{require_once (WH_PATH."/resellerclub/wh_register.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/resellerclub/wh_register.php" . " was not found<br>"; echo $file_error;}

	}
		
if (file_exists(THEME_PATH."/web-hosting/functions/wh_custom_fields.php")){require_once (THEME_PATH."/web-hosting/functions/wh_custom_fields.php" );}

	else{	
	
	if (file_exists(WH_PATH."/functions/wh_custom_fields.php"))
			{require_once (WH_PATH."/functions/wh_custom_fields.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/functions/wh_custom_fields.php" . " was not found<br>"; echo $file_error;}

	}
	
if (file_exists(THEME_PATH."/web-hosting/domains/wh_clear_domains.php")){require_once (THEME_PATH."/web-hosting/domains/wh_clear_domains.php" );}

	else{	
	
	if (file_exists(WH_PATH."/domains/wh_clear_domains.php"))
			{require_once (WH_PATH."/domains/wh_clear_domains.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/domains/wh_clear_domains.php" . " was not found<br>"; echo $file_error;}

	}
	
if (file_exists(THEME_PATH."/web-hosting/domains/wh_domain_edits.php")){require_once (THEME_PATH."/web-hosting/domains/wh_domain_edits.php" );}

	else{	
	
	if (file_exists(WH_PATH."/domains/wh_domain_edits.php"))
			{require_once (WH_PATH."/domains/wh_domain_edits.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/domains/wh_domain_edits.php" . " was not found<br>"; echo $file_error;}

	}
if (file_exists(THEME_PATH."/web-hosting/domains/wh_edit_domains.php")){require_once (THEME_PATH."/web-hosting/domains/wh_edit_domains.php" );}

	else{	
	
	if (file_exists(WH_PATH."/domains/wh_edit_domains.php"))
			{require_once (WH_PATH."/domains/wh_edit_domains.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/domains/wh_edit_domains.php" . " was not found<br>"; echo $file_error;}

	}
	
if (file_exists(THEME_PATH."/web-hosting/domains/wh_locking_domain.php")){require_once (THEME_PATH."/web-hosting/domains/wh_locking_domain.php" );}

	else{	
	
	if (file_exists(WH_PATH."/domains/wh_locking_domain.php"))
			{require_once (WH_PATH."/domains/wh_locking_domain.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/domains/wh_locking_domain.php" . " was not found<br>"; echo $file_error;}

	}
if (file_exists(THEME_PATH."/web-hosting/includes/wh_iso-codes.php")){require_once (THEME_PATH."/web-hosting/includes/wh_iso-codes.php" );}

	else{	
	
	if (file_exists(WH_PATH."/includes/wh_iso-codes.php"))
			{require_once (WH_PATH."/includes/wh_iso-codes.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "/includes/wh_iso-codes.php" . " was not found<br>"; echo $file_error;}

	}
if ( is_admin() ) {

// We are in admin mode

if (file_exists(THEME_PATH."/web-hosting/includes/admin.php")){require_once (THEME_PATH."/web-hosting/includes/admin.php" );}

	else{
		
		if (file_exists(WH_PATH."includes/admin.php"))
			{require_once (WH_PATH."includes/admin.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "includes/admin.php" . " was not found<br>";}

		}

}
