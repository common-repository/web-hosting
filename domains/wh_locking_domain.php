<?php

// Version: 1.5.4



function unlock_domain_api($lock)
{
	global $datajson,$lock,$url,$str,$data,$product_name,$rc_url,$api_user_id,$api_key;
	$lang='';
	$unlock_domain = new lang($lang);
	
	$api_user_id = get_option( "wh_reseller_id",true);
	$api_key = get_option( "wh_reseller_api",true);
	$rc_url = get_option( "wh_checkbox",true);
	if ($rc_url == "yes"){$rc_url = "test.";}
	
	wh_get_domain_order_details($product_name,$data);
	$result = json_decode($data, TRUE);



	$domain_order_id=$result["orderid"];
		if ($domain_order_id)
		{
			$url1 = 'https://' . $rc_url . 'httpapi.com/api/domains/' . $lock . '-theft-protection.json?';
			$str ='auth-userid=' . $api_user_id . '&api-key=' . $api_key . '&order-id=' . $domain_order_id;
			$url = $url1 . $str;
			$data = '';
			$data = CallDomainAPI('POST', $url, $data);
			$datajson = json_decode($data, TRUE);
			$status = ($datajson["status"]);

				if ($status == 'Success')
				{

					if ($lock == 'enable'){echo '<a name=""></a><br /> ' . htmlentities($unlock_domain->domain_edits_form_option_lock_domain_message, ENT_COMPAT,'ISO-8859-1', true) . '<br /><br />';}

					if ($lock == 'disable'){echo '<a name=""></a><br /> ' . htmlentities($unlock_domain->domain_edits_form_option_unlock_domain_message, ENT_COMPAT,'ISO-8859-1', true) . ' <br /><br /><br />';}

				}

		}

}

add_action('unlock_domain_api','unlock_domain_api');
