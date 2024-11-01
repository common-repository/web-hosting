<?php
/*
Version: 1.5.4
Author: D.J.Gennoe
Author URI: http://www.web-uk.co.uk
*/
//*********************************************************************************
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
function adminaddcss() 	{
if (file_exists(THEME_PATH."/web-hosting/css/whadmin.css")){$url = (THEME_PATH."/web-hosting/css/whadmin.css"); wp_enqueue_style( 'whadminstyle', $url);
wp_register_style( 'adminaddcss', get_template_directory_uri() . '/whadminstyle.css', false, '1.0.0' );}
else {
wp_enqueue_style( 'whadminstyle', plugins_url( '/web-hosting/css') . '/whadminstyle.css' );
}
}
add_action('admin_enqueue_scripts', 'adminaddcss');


function wh_plugin_menu() {
add_menu_page(__('Web Hosting','web-hosting'), __('Web Hosting','web-hosting'), 'manage_options' ,'wh_settings_page','wh_plugin_options_hosting');
add_submenu_page('wh_settings_page', __('Hosting Settings','web-hosting'), __('Hosting','web-hosting'),'manage_options', 'wh_settings_page','wh_plugin_options_hosting');
add_submenu_page('wh_settings_page', __('Domains','web-hosting'), __('Domains','web-hosting'), 'manage_options', 'wh_domains_settings', 'wh_plugin_options_domains');
add_submenu_page('wh_settings_page', __('Accounts','web-hosting'), __('Accounts','web-hosting'), 'manage_options', 'wh_account_settings', 'wh_plugin_options_accounts');
}
add_action( 'admin_menu', 'wh_plugin_menu' );


	function admin_get_whm_data($query,$whm_result)
	{
		global $whm_result,$query;
		$user =  get_option( 'wh_whm_username',true );
		$token = get_option( 'wh_whm_token',true );
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		$header[0] = "Authorization: whm $user:$token";
		curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
		curl_setopt($curl, CURLOPT_URL, $query);
		$whm_result = curl_exec($curl);
		curl_close($curl);
		return $whm_result;
	}
	add_action('admin_get_whm_data','admin_get_whm_data');
	
	
	function wh_plugin_options_accounts()
{
		if ( !current_user_can( 'manage_options' ) ){
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
		global $query,$whm_result;
		$count=0;
		echo '<div class="wrap">';?>
		<h2><?php echo __("Order Settings",'web-hosting'); ?></h2><?php
		echo '</div>';
		// Now display the settings editing screen
		echo '<div class="wrap">';
		// header
		echo "<h2>" . __( 'Customer Account Details', 'menu-test' ) . "</h2>";
		// settings form
		// ************** Delete Hosting Account ***************************
	if( isset($_POST[ 'wh_account_delete' ]) && $_POST[ 'wh_account_delete' ] == 'Y' )
	{
			$retrieved_nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_account_confirm_delete' ) ) die ( 'Sorry security token has expired');
			$val_username = sanitize_text_field ($_POST[ 'wh_delete_account_username']);
			$val_choice = sanitize_text_field ($_POST[ 'Submit1']);
			if($val_choice =="Yes")
			{
				$whm_ip = get_option('wh_whm_ip',true);
				$whm_port = get_option( 'wh_whm_port',true);
				$username = $val_username;
				$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/removeacct?user=' . $username . '&keepdns=0';
				admin_get_whm_data($query,$whm_result);
				$exit = 0;
				echo '<div class="whmessageboxgreen">' . __("Account ") . esc_html($val_username) . __("has been deleted") . '</div>';
			} else {echo __("Account",'web-hosting') .  esc_html($val_username) . __(" has not been deleted",'web-hosting');}
	}
	
		if( isset($_POST[ 'wh_delete_account_hidden' ]) && $_POST[ 'wh_delete_account_hidden' ] == 'Y' )
		{
			$retrieved_nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_account_delete_form' ) ) die ( 'Sorry security token has expired' );
			$val_username = sanitize_text_field ($_POST[ 'wh_delete_account_username']);
			?>
			<div id="admin_account_suspend_table"><?php echo __("Confirm Deletion this cannot be undone",'web-hosting') . '<table><tr><td>';?>
			<form name="formconfirm" method="post" action="">
			<?php wp_nonce_field('wh_admin_account_confirm_delete'); ?>
			<input type="hidden" name="wh_delete_account_username" value="<?php echo esc_html($val_username); ?>">
			<input type="hidden" name="wh_account_delete" value="Y">
			<?php echo '<input type="submit" name="Submit1" class="wh_button-primary" value=' . __("Yes",'web-hosting') . ' /></td>';
			echo '<td><input type="submit" name="Submit2" class="wh_button-primary" value=' . __("No",'web-hosting') . ' /></td>';
			?></form></tr></table></div>
			<?php
		}
				// ************** Suspend Hosting Account ***************************
				
		if( isset($_POST[ 'wh_suspend_account_hidden' ]) && $_POST[ 'wh_suspend_account_hidden' ] == 'Y' )
		{
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_account_suspend_form' ) ) die ( 'Sorry security token has expired' );
		$val_username = sanitize_text_field ($_POST[ 'wh_suspend_account_username']);
		$val_reason = sanitize_text_field ($_POST[ 'wh_suspend_reason']);
		update_option('wh_suspended_' . $val_username, $val_reason);
		$whm_ip = get_option('wh_whm_ip',true);
		$whm_port = get_option( 'wh_whm_port',true);
		$username = $val_username;
		$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/suspendacct?user=' . $username . '&reason=0';
		admin_get_whm_data($query,$whm_result);
		$exit = 0;
		echo '<div class="whmessageboxgreen">' . __("Account",'web-hosting') . ' ' . esc_html($val_username) . __(" has been suspended",'web-hosting') . '</div>';
		}
// ************** Unsuspend Hosting Account ***************************

		if( isset($_POST[ 'wh_unsuspend_account_hidden' ]) && $_POST[ 'wh_unsuspend_account_hidden' ] == 'Y' )
		{
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_account_unsuspend_form' ) ) die ( 'Sorry security token has expired' );
		$val_username = sanitize_text_field ($_POST[ 'wh_unsuspend_account_username']);
		$whm_ip = get_option('wh_whm_ip',true);
		$whm_port = get_option( 'wh_whm_port',true);
		$username = $val_username;
		$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/unsuspendacct?user=' . $username ;
		admin_get_whm_data($query,$whm_result);
		$exit = 0;
		echo '<div class="whmessageboxgreen">' . __("Account",'web-hosting') . ' ' . esc_html($val_username) . __(" has been un-suspended",'web-hosting') . '</div>';
		delete_option('wh_suspended_' . $val_username);
		}
			if( isset($_POST[ 'wh_submit_account_hidden' ]) && $_POST[ 'wh_submit_account_hidden' ] == 'Y' )
			{
				$retrieved_nonce = $_REQUEST['_wpnonce'];
				if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_account_edit_form' ) ) die ( 'Sorry security token has expired' );
				$val_username = sanitize_text_field ($_POST[ 'wh_submit_account_username']);
				?>
				<div id="admin_account_suspend_table"><table><tr><th>
				<?php echo $val_username;?></th></tr><tr><td>
				<form name="form4" method="post" action="">
				<?php wp_nonce_field('wh_admin_account_suspend_form'); ?>
				<input type="hidden" name="wh_suspend_account_hidden" value="Y">
				<input type="hidden" name="wh_suspend_account_username" value="<?php echo esc_html($val_username); ?>">
				<input type="text" name="wh_suspend_reason"  value="" size="10"><?php echo __("Reason for suspension",'web-hosting'); ?>
				<?php echo '<input type="submit" name="Submit" class="wh_button-primary" value=' . __("Suspend Account",'web-hosting') . ' /></td>';
				?></form>
				<td>
				<form name="form5" method="post" action="">
				<?php wp_nonce_field('wh_admin_account_unsuspend_form'); ?>
				<input type="hidden" name="wh_unsuspend_account_hidden" value="Y">
				<input type="hidden" name="wh_unsuspend_account_username" value="<?php echo esc_html($val_username); ?>">
				<?php echo '<input type="submit" name="Submit" class="wh_button-primary" value=' . __("Unsuspend Account",'web-hosting') . ' /></td>';
				?></form>
				<td>
				<form name="form6" method="post" action="">
				<?php wp_nonce_field('wh_admin_account_delete_form'); ?>
				<input type="hidden" name="wh_delete_account_hidden" value="Y">
				<input type="hidden" name="wh_delete_account_username" value="<?php echo esc_html($val_username); ?>">
				<?php echo '<input type="submit" name="Submit" class="wh_button-primary" value=' . __("Delete Account",'web-hosting') . ' /></td>';
				?></form>
				</tr>
				</table></div>
				<?php
			}
			
			
		$opt_val_whm_username =  get_option( 'wh_whm_username' );
		$whm_username = $opt_val_whm_username;
		$whm_ip = get_option('wh_whm_ip',true);
		$whm_port = get_option( 'wh_whm_port',true);
		$query = 'https://' . $whm_ip . ':' . $whm_port . '/json-api/listaccts?api.version=1&api.sort.a.field=user&api.sort.enable=1';
		admin_get_whm_data($query,$whm_result);
		$json = json_decode($whm_result);
		?>
		<h2><?php echo __("Current Accounts",'web-hosting'); ?></h2>
		<div id="admin_account_table"><table>
		<tr>
		<th><?php echo __("Username",'web-hosting'); ?></th>
		<th><?php echo __("Domain",'web-hosting');?></th>
		<th><?php echo __("Email",'web-hosting');?></th>
		<th><?php echo __("Disk Space",'web-hosting');?></th>
		<th><?php echo __("Disk Usage",'web-hosting');?></th>
		<th><?php echo __("Package",'web-hosting');?></th>
		<th><?php echo __("Status",'web-hosting');?></th>
		</tr><tr><?php
			if($json)
			{
				foreach ($json->{'data'}->{'acct'} as $value)
				{
					$a = $value->{'user'};
					$b = $value->{'domain'};
					$c = $value->{'email'};
					$d = $value->{'disklimit'};
					$e = $value->{'diskused'};
					$f = $value->{'plan'};
					$g = $value->{'suspended'};
					if($g == 0){$g = "Active";}else {$g = "suspended";}
					if ($a){
					?>
					<td><form name="form3" method="post" action="">
					<?php wp_nonce_field('wh_admin_account_edit_form'); ?>
					<input type="hidden" name="wh_submit_account_hidden" value="Y">
					<input type="hidden" name="wh_submit_account_username" value="<?php echo esc_html($a); ?>">
					<?php echo '<input type="submit" name="Submit" class="wh_button-primary" value="' . esc_html($a) . '" /></form></td><td>' . esc_html($b) . '</td><td>' . esc_html($c) . '</td><td>' . esc_html($d) . '</td><td>' . esc_html($e) . '</td><td>' . esc_html($f) . '</td><td>' . esc_html($g) . '</td></form>';
					}
					echo '</tr><tr>';$th_count = 0;
					$count++;
				}
					?> </table></div><?php
			}
				else 
				
				{
				echo '<div class ="whmessageboxred"><b>' . __("Accounts:",'web-hosting') . '</b>' . __(" error: cannot access server please check your WHM token",'web-hosting') . '</div>';
				}
}




function wh_plugin_options_domains()
{
	if ( !current_user_can( 'manage_options' ) ){ wp_die( __( 'You do not have sufficient permissions to access this page.' ) );}
	echo '<div class="wrap">';
	echo '<h2>' . __("Web Domain Settings",'web-hosting') . '</h2>';
	echo '</div>';
$number_of_tld=false;
$number_of_tld = get_option( 'tlds',true);
			if( isset($_POST[ 'wh_submit_tld_hidden' ]) && $_POST[ 'wh_submit_tld_hidden' ] == 'Y' )
		{
			// Read their posted value
			$retrieved_nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_domains_form' ) ) die( 'Sorry security token has expired' );
			$val_tld0 = sanitize_text_field ($_POST[ 'tlds']);
			if (ctype_digit($val_tld0))
			{
				update_option( 'tlds', $val_tld0 );
			} else{ die( 'Please only submit numbers' );}
			
				$number_of_tld = get_option( 'tlds',true);
				$count = 0;
				do
				{
				$count++;
				if(isset($_POST[ 'tld' . $count]))
				{
				$tld = sanitize_text_field ($_POST[ 'tld' . $count]);
				}
				if(isset($_POST[ 'tld' . $count . 'price']))
				{
				$tld_price = sanitize_text_field ($_POST[ 'tld' . $count . 'price']);
				}
				$array[$tld] = $tld_price;
				} 

				while ($count < $number_of_tld);
				ksort ($array);
				$count = 0;
					if($array)
					{
					foreach ($array as $key => $val)
					{
					$count++;
					update_option( 'wh_tld' . $count, $key );
					update_option( 'wh_tld' . $count . 'price', $val );
					}
					$array='';
					}
		}
		
				// Now display the settings editing screen
				echo '<div class="wrap">';
				// header
				echo "<h2>" . __( 'Top Level Domains', 'menu-test' ) . "</h2>";
				// settings form
				echo __("Top Level Domains you want to sell e.g. .biz .com",'web-hosting'); ?><br />
				<table>
				<form name="form1" method="post" action="">
				<?php wp_nonce_field('wh_admin_domains_form'); ?>
				<input type="hidden" name="wh_submit_tld_hidden" value="Y">
				<tr>
				<td>
				<p><?php _e("Number of TLD to sell:", 'menu-test' ); ?>
				<input type="text" name="tlds" pattern="[0-9]{1,2}" value="<?php echo  esc_attr( $number_of_tld); ?>" size="5"></p>
				</td>
				</tr>
				<tr>
				<td>TLD eg .biz
				</td>
				<td> <?php echo __("Selling Price",'web-hosting');?>
				</td>
				</tr>
				<?php
				$number_of_tld = get_option( 'tlds');
					if ($number_of_tld > 0)
					{
					$count = 0;
					do
					{
					$count++;
					$s = get_option( 'wh_tld' . $count);
					$val_tld = get_option( 'wh_tld' . $count . 'price');
					?>
					<tr>
					<td>
					<p><?php _e("TLD" . $count . ":", 'menu-test' ); ?>
					<input type="text" name="tld<?php echo $count; ?>" pattern="[.]+[a-z\.]{1,32}" value="<?php echo esc_attr(  $s ); ?>" size="10"></p>
					</td>
					<td>
					<p><?php _e("Price &nbsp;&pound;", 'menu-test' ); ?>
					<input type="text" name="tld<?php echo $count . 'price' ?>" pattern="[0-9]+\.[0-9]{2,2}$" value="<?php echo esc_attr( $val_tld ); ?>" size="5"></p>
					</td>
					</tr>
					<?php
					} while ($count < $number_of_tld );
					}
						?>
						<hr />
						<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes','web-hosting') ?>" />
						</p>
						</form>
						</table>
						</div>
						<?php
}


function wh_plugin_options_hosting() 
{
	if ( !current_user_can( 'manage_options' ) )  
	{
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
		echo '<div class="wrap">';
		echo '<h2>' . __("Web Hosting Settings",'web-hosting') . '</h2>';
		echo '</div>';
		
	global $wh_global;
		
					// Read in existing option value from database
					$opt_val_id = get_option('wh_reseller_id');
					$opt_val_api = get_option( 'wh_reseller_api' );
					$opt_val_whm_hash = get_option( 'wh_whm_hash' );
					$opt_val_whm_token = get_option( 'wh_whm_token' );
					$opt_val_whm_servername = get_option( 'wh_whm_servername' );
					$opt_val_whm_username = get_option( 'wh_whm_username' );
					$opt_val_whm_ip = get_option( 'wh_whm_ip' );
					$opt_val_whm_ip_address = get_option( 'wh_whm_ip_address' );
					$opt_val_whm_port = get_option( 'wh_whm_port' );
					$opt_val_whm_cp_port = get_option( 'wh_whm_cp_port' );
					$opt_val_hostingpage = get_option( 'wh_hostingpage' );
					$opt_val_addonspage = get_option( 'wh_addonspage' );
					$opt_val_domainsformpage = get_option( 'wh_domainsformpage' );
					$opt_val_domainspage = get_option( 'wh_domainspage' );
					$opt_val_shoppingpage = get_option( 'wh_shoppingpage' );
					$opt_val_nameserver01 = get_option( 'wh_nameserver01' );
					$opt_val_nameserver02 = get_option( 'wh_nameserver02' );
					$opt_val_nameserver03 = get_option( 'wh_nameserver03' );
					$opt_val_nameserver04 = get_option( 'wh_nameserver04' );
					$opt_val_checkbox = get_option( 'wh_checkbox' );
					$opt_val_companyname = get_option( 'wh_companyname' );
					$opt_val_companyaddress01 = get_option( 'wh_companyaddress01' );
					$opt_val_companyaddress02 = get_option( 'wh_companyaddress02' );
					$opt_val_companycity = get_option( 'wh_companycity' );
					$opt_val_companystate = get_option( 'wh_companystate' );
					$opt_val_companypostcode = get_option( 'wh_companypostcode' );
					$opt_val_companyphone = get_option( 'wh_companyphone' );
						// See if the user has posted us some information
						// If they did, this hidden field will be set to 'Y'
						
	if( isset($_POST[ 'mt_submit_hidden' ]) && $_POST[ 'mt_submit_hidden' ] == 'Y' ) 
	{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wh_admin_hosting_form' ) ) die( 'Sorry security token has expired' );
		$error=false;
		
				// Read their posted value
			$opt_val_id = sanitize_text_field ($_POST[ 'wh_reseller_id' ]);
			if (ctype_digit($opt_val_id)) 
			{
			update_option( 'wh_reseller_id', $opt_val_id );
			$wh_global["admin"]["resellerclub"]["api_user_id"] = $opt_val_id;
			
			}else{ echo '<div class ="whmessageboxred"><b>' . __("Error Reseller id:",'web-hosting') . '</b> ' . __("Please only use numbers, please try again",'web-hosting') . '</div>' ;$error=true;}
			
			$opt_val_api = sanitize_text_field ($_POST[ 'wh_api_key' ]);
			if (ctype_alnum($opt_val_api)) 
			{
			update_option( 'wh_reseller_api', $opt_val_api );
			$wh_global["admin"]["resellerclub"]["wh_reseller_api_key"] = $opt_val_api;
			}else{ echo '<div class ="whmessageboxred"><b>' . __("Error Api Key:",'web-hosting') . '</b> ' . __("Please only use alphanumeric characters (Letters and numbers) please try again",'web-hosting') . '</div>' ;$error=true;}

			$opt_val_whm_hash = sanitize_text_field($_POST['wh_whm_hash'  ]);
			$trimmed = trim($opt_val_whm_hash," \r\n");$opt_val_whm_hash = $trimmed;
			$trimmed = str_replace(' ', '', $opt_val_whm_hash);$opt_val_whm_hash = $trimmed;
			if ((ctype_alnum($opt_val_whm_hash) || ($opt_val_whm_hash == "")) )
			{
			update_option( 'wh_whm_hash', $opt_val_whm_hash );
			$wh_global["admin"]["whm"]["wh_whm_hash"] = $opt_val_whm_hash;
			}else{ echo '<div class ="whmessageboxred"><b>' . __("Error WHM Hash Key:",'web-hosting') . '</b> ' . __("Please only use alphanumeric characters (Letters and numbers) please try again",'web-hosting') . '</div>' ;$error=true;}

			$opt_val_whm_token = sanitize_text_field($_POST[ 'wh_whm_token' ]);
			$trimmed = trim($opt_val_whm_token," \r\n");$opt_val_whm_token = $trimmed;
			$trimmed = str_replace(' ', '', $opt_val_whm_token);$opt_val_whm_token = $trimmed;
			
			if (ctype_alnum($opt_val_whm_token)) 
			{
			update_option( 'wh_whm_token', $opt_val_whm_token );
			$wh_global["admin"]["whm"]["wh_whm_token"] = $opt_val_whm_token;
			}else{ echo '<div class ="whmessageboxred"><b>' . __("Error WHM Token:",'web-hosting') . '</b> ' . __("Please only use alphanumeric characters (Letters and numbers) please try again",'web-hosting') . '</div>' ;$error=true;}

			$opt_val_whm_servername = sanitize_text_field ($_POST[ 'wh_whm_servername' ]);

			update_option( 'wh_whm_servername', $opt_val_whm_servername );
			$wh_global["admin"]["whm"]["wh_whm_servername"] = $opt_val_whm_servername;

			$opt_val_whm_username = sanitize_text_field ($_POST[ 'wh_whm_username' ]);

			update_option( 'wh_whm_username', $opt_val_whm_username );
			$wh_global["admin"]["whm"]["wh_whm_username"] = $opt_val_whm_username;

			$opt_val_whm_ip = sanitize_text_field ($_POST[ 'wh_whm_ip' ]);

			if (!filter_var($opt_val_whm_ip, FILTER_VALIDATE_IP) === false) 
			{
			update_option( 'wh_whm_ip', $opt_val_whm_ip );
			$wh_global["admin"]["whm"]["wh_whm_ip"] = $opt_val_whm_ip;
			} else { echo '<div class ="whmessageboxred"><b>' . __("Error WHM ip address:",'web-hosting') . '</b> ' . __("Please only use format 127.0.4.1 please try again",'web-hosting') . '</div>' ;$error=true;}

			$opt_val_whm_ip_address = sanitize_text_field ($_POST[ 'wh_whm_ip_address' ]);

			update_option( 'wh_whm_ip_address', $opt_val_whm_ip_address );
			$wh_global["admin"]["whm"]["wh_whm_ip_address"] = $opt_val_whm_ip_address;

			$opt_val_whm_port = sanitize_text_field ($_POST[ 'wh_whm_port' ]);

			if (ctype_digit($opt_val_whm_port)) 
			{
				update_option( 'wh_whm_port', $opt_val_whm_port );
				$wh_global["admin"]["whm"]["wh_whm_port"] = $opt_val_whm_port;
			}
			else{ echo '<div class ="whmessageboxred"><b>' . __("Error WHM Server Port:",'web-hosting') . '</b> ' .  __("Please only use numbers please try again",'web-hosting') . '</div>' ;$error=true;}

			$opt_val_whm_cp_port = sanitize_text_field ($_POST[ 'wh_whm_cp_port' ]);

			if (ctype_digit($opt_val_whm_cp_port)) 
			{
			update_option( 'wh_whm_cp_port', $opt_val_whm_cp_port );
			$wh_global["admin"]["whm"]["wh_whm_cp_port"] = $opt_val_whm_cp_port;
			}
			else{ echo '<div class ="whmessageboxred"><b>' . __("Error Cpanel Port:",'web-hosting') . '</b> ' . __("Please only use numbers please try again",'web-hosting') . '</div>' ;$error=true;}

			
		
			
			
			$opt_val_hostingpage = sanitize_text_field ($_POST[ 'wh_hostingpage' ]);

			update_option( 'wh_hostingpage', $opt_val_hostingpage );
			$wh_global["admin"]["wh_hostingpage"] = $opt_val_hostingpage;

			$opt_val_addonspage = sanitize_text_field ($_POST[ 'wh_addonspage' ]);

			update_option( 'wh_addonspage', $opt_val_addonspage );
			$wh_global["admin"]["wh_addonspage"] = $opt_val_addonspage;

			$opt_val_domainspage = sanitize_text_field ($_POST[ 'wh_domainspage' ]);

			update_option( 'wh_domainspage', $opt_val_domainspage );
			$wh_global["admin"]["wh_domainspage"] = $opt_val_domainspage;
			
			$opt_val_domainsformpage = sanitize_text_field ($_POST[ 'wh_domainsformpage' ]);

			update_option( 'wh_domainsformpage', $opt_val_domainsformpage );
			$wh_global["admin"]["wh_domainsformpage"] = $opt_val_domainsformpage;

			$opt_val_shoppingpage = sanitize_text_field ($_POST[ 'wh_shoppingpage' ]);

			update_option( 'wh_shoppingpage', $opt_val_shoppingpage );
			$wh_global["admin"]["wh_shoppingpage"] = $opt_val_shoppingpage;
			$opt_val_nameserver01 = sanitize_text_field ($_POST[ 'wh_nameserver01' ]);

if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $opt_val_nameserver01))
{ echo '<div class ="whmessageboxred">' . __("Error nameserver 01 has not been updated incorrect format used",'web-hosting') . '</div>';$error=true;}
else {update_option( 'wh_nameserver01', $opt_val_nameserver01 );$wh_global["admin"]["wh_nameserver01"] = $opt_val_nameserver01;}
$opt_val_nameserver02 = sanitize_text_field ($_POST[ 'wh_nameserver02' ]);
// Save the posted value in the database
if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $opt_val_nameserver02))
{ echo '<div class ="whmessageboxred">' . __("Error nameserver 02 has not been updated incorrect format used",'web-hosting') . '</div>';$error=true;}
else {update_option( 'wh_nameserver02', $opt_val_nameserver02 );$wh_global["admin"]["wh_nameserver02"] = $opt_val_nameserver02;}
$opt_val_nameserver03 = sanitize_text_field ($_POST[ 'wh_nameserver03' ]);
// Save the posted value in the database
if ($opt_val_nameserver03){
if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $opt_val_nameserver03))
{ echo '<div class ="whmessageboxred">' . __("Error nameserver 03 has not been updated incorrect format used",'web-hosting') . '</div>';$error=true;}
else {update_option( 'wh_nameserver03', $opt_val_nameserver03 );$wh_global["admin"]["wh_nameserver03"] = $opt_val_nameserver03;}
}
$opt_val_nameserver04 = sanitize_text_field ($_POST[ 'wh_nameserver04' ]);
// Save the posted value in the database
if ($opt_val_nameserver03){
if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $opt_val_nameserver04))
{ echo '<div class ="whmessageboxred">' . __("Error nameserver 04 has not been updated incorrect format used",'web-hosting') . '</div>';$error=true;}
else {update_option( 'wh_nameserver04', $opt_val_nameserver04 );$wh_global["admin"]["wh_nameserver04"] = $opt_val_nameserver04;}
}
$opt_val_checkbox = sanitize_text_field ($_POST[ 'wh_checkbox' ]);
// Save the posted value in the database
update_option( 'wh_checkbox', $opt_val_checkbox );$wh_global["admin"]['resellerclub']["wh_checkbox"] = $opt_val_checkbox;

$opt_val_companyname = sanitize_text_field ($_POST[ 'wh_companyname' ]);
// Save the posted value in the database
if(!preg_match('/^[a-z0-9 \-]+$/i', $opt_val_companyname)){
echo '<div class ="whmessageboxred">' . __("Error Company Name: has not been updated please only use letters, numbers and spaces",'web-hosting') . ' </div>';$error=true;
}
else{
update_option( 'wh_companyname', $opt_val_companyname );$wh_global["admin"]["wh_companyname"] = $opt_val_companyname;
}

$opt_val_companyaddress01 = sanitize_text_field ($_POST[ 'wh_companyaddress01' ]);
// Save the posted value in the database
if(!preg_match('/^[a-zA-Z0-9 \-]+$/i', $opt_val_companyaddress01)){
echo '<div class ="whmessageboxred">' . __("Error Company Address 1: has not been updated please only use letters, numbers,hyphens and spaces",'web-hosting') . ' </div>';$error=true;
}
else{
update_option( 'wh_companyaddress01', $opt_val_companyaddress01 );$wh_global["admin"]["wh_companyaddress01"] = $opt_val_companyaddress01;
}
$opt_val_companyaddress02 = sanitize_text_field ($_POST[ 'wh_companyaddress02' ]);
// Save the posted value in the database
if(!preg_match('/^[a-zA-Z0-9 \-]+$/i', $opt_val_companyaddress02)){
echo '<div class ="whmessageboxred">' . __("Error Company Address 2: has not been updated please only use letters, numbers,hyphens and spaces",'web-hosting') . ' </div>';$error=true;
}
else{
update_option( 'wh_companyaddress02', $opt_val_companyaddress02 );$wh_global["admin"]["wh_companyaddress02"] = $opt_val_companyaddress02;
}

$opt_val_companycity = sanitize_text_field ($_POST[ 'wh_companycity' ]);
// Save the posted value in the database
if(!preg_match('/^[a-zA-Z \.-]+$/i', $opt_val_companycity)){
echo '<div class ="whmessageboxred">' . __("Error Company City: has not been updated please only use letters,periods,hyphens and spaces",'web-hosting') . ' </div>';$error=true;
}
else{
update_option( 'wh_companycity', $opt_val_companycity );$wh_global["admin"]["wh_companycity"] = $opt_val_companycity;
}

$opt_val_companystate = sanitize_text_field ($_POST[ 'wh_companystate' ]);
// Save the posted value in the database
if(!preg_match('/^[a-zA-Z\ ]+$/i', $opt_val_companystate)){
echo '<div class ="whmessageboxred">' . __("Error Company State: has not been updated please only use letters and spaces",'web-hosting') . ' </div>';$error=true;
}
else{
update_option( 'wh_companystate', $opt_val_companystate );$wh_global["admin"]["wh_companystate"] = $opt_val_companystate;
}
$opt_val_companypostcode = sanitize_text_field ($_POST[ 'wh_companypostcode' ]);
// Save the posted value in the database
$postcode = strtoupper(str_replace(' ','',$opt_val_companypostcode));

update_option( 'wh_companypostcode', $opt_val_companypostcode );$wh_global["admin"]["wh_companypostcode"] = $opt_val_companypostcode;

$opt_val_companyphone = sanitize_text_field ($_POST[ 'wh_companyphone' ]);
// Save the posted value in the database
if(!preg_match('/^[\d +]+$/i', $opt_val_companyphone))
{
echo '<div class ="whmessageboxred">' . __("Error Telephone: has not been updated please use just numbers and spaces",'web-hosting') . '</div>';$error=true;
}
else
{
update_option( 'wh_companyphone', $opt_val_companyphone );$wh_global["admin"]["wh_companyphone"] = $opt_val_companyphone;
}
// Put a "settings saved" message on the screen
if ($error==false){
	update_option( 'wh_global', $wh_global );
?>
<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php
}
}
// Now display the settings editing screen
echo '<div class="wrap">';
// header
echo "<h2>" . __( 'ResellerClub', 'menu-test' ) . "</h2>";
// settings form
?>
<form name="form1" method="post" action="">
<?php wp_nonce_field('wh_admin_hosting_form'); ?>
<input type="hidden" name="<?php echo  esc_attr( 'mt_submit_hidden' ); ?>" value="Y">
<p><?php _e("Reseller id:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_reseller_id' ); ?>" pattern="[0-9]{6}|[0-9]{8}" value="<?php echo esc_attr( $opt_val_id ); ?>" size="20"> 6 or 8 digit Number
<br />
<?php
if ($opt_val_id == ''){
$resellercluburl = 'http://uk.resellerclub.com/signup-now';
?>
<a href="<?php echo esc_url( $resellercluburl ) ?>" target="_blank"><?php echo __("Get a Resellerclub account",'web-hosting'); ?></a>
<?php }?></p><hr />
<p><?php _e("Api Key:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_api_key' ); ?>" value="<?php echo esc_attr( $opt_val_api); ?>" size="34"> Letters and Numbers only</p>
<p><?php _e("Nameserver01:", 'menu-test' ); ?>
<input type="text" name="<?php echo  esc_attr( 'wh_nameserver01' ); ?>" value="<?php echo  esc_attr( $opt_val_nameserver01) ; ?>" size="20"> Format ns1.example.com</p>
<p><?php _e("Nameserver02:", 'menu-test' ); ?>
<input type="text" name="<?php echo  esc_attr( 'wh_nameserver02' ); ?>" value="<?php echo esc_attr( $opt_val_nameserver02 ); ?>" size="20"> Format ns2.example.com</p>
<p><?php _e("Nameserver03:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_nameserver03' ); ?>" value="<?php echo esc_attr( $opt_val_nameserver03 ); ?>" size="20"> Format ns3.example.com</p>
<p><?php _e("Nameserver04:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_nameserver04' ); ?>" value="<?php echo esc_attr( $opt_val_nameserver04 ); ?>" size="20"> Format ns4.example.com</p>
<hr><?php
if ($opt_val_checkbox == 'yes'){ $checked = 'checked';}?>
<p><?php _e("Resellerclub Demo:", 'menu-test' ); ?>
<input type="checkbox" name="<?php echo esc_attr( 'wh_checkbox' ); ?>" value="yes" <?php echo esc_attr( $checked ); ?> >Check this if you are using Resellerclub Demo Site</p>
<hr>
<h2> WHM </h2>
<hr />
<p><?php _e("WHM username:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_username' ); ?>" value="<?php echo esc_attr( $opt_val_whm_username ); ?>"size="20"></p>
<p><?php _e('WHM Hash Key: please note this method is now deprecated use WHM Token instead <a href="https://www.web-uk.co.uk/wordpress/plugins/web-hosting/support/" target="_blank"> visit our support page for information</a>', 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_hash' ); ?>" value="<?php echo esc_attr( $opt_val_whm_hash ); ?>" size="100"></p>
<p><?php _e("WHM Token:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_token' ); ?>" value="<?php echo esc_attr( $opt_val_whm_token ); ?>" size="100"></p>
<p><?php _e("WHM ip address:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_ip' ); ?>" value="<?php echo esc_attr( $opt_val_whm_ip ); ?>" size="16">e.g. 100.50.5.10</p>
<p><?php _e("WHM server address:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_ip_address' ); ?>" value="<?php echo esc_attr( $opt_val_whm_ip_address ); ?>" size="16">e.g. cloud500.web-uk.co.uk or can be WHM ip address as above</p>
<p><?php _e("WHM Server Name:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_servername' ); ?>" value="<?php echo esc_attr( $opt_val_whm_servername ); ?>" size="20">e.g. cloud500</p>
<p><?php _e("WHM Server Port:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_port' ); ?>" value="<?php echo esc_attr( $opt_val_whm_port ); ?>" size="20"> Port used by your server to access WHM e.g. 2087</p>
<p><?php _e("Cpanel Port:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_whm_cp_port' ); ?>" value="<?php echo esc_attr( $opt_val_whm_cp_port ); ?>" size="20"> Port used by your server to access Cpanel e.g. 2083</p>


<h2> <?php echo __("Call To Action Buttons",'web-hosting'); ?> </h2>
<h3> <?php echo __("My-Account page",'web-hosting'); ?></h3>
<p><b> <?php echo __("Domains",'web-hosting'); ?></b></p>
<p><?php _e("Domains Page:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_domainsformpage' ); ?>" value="<?php echo esc_attr( $opt_val_domainsformpage ); ?>" size="20"> page where your Domain Checker Form is displayed e.g. /domains/</p>
<input type="text" name="<?php echo esc_attr( 'wh_domainspage' ); ?>" value="<?php echo esc_attr( $opt_val_domainspage ); ?>" size="20"> page where your Domain Checker shortcode [domain-checker] is placed e.g. /domain-checker/</p>

<b> <?php echo __("Hosting Packages",'web-hosting'); ?></b>
<p><?php _e("Hosting Packages Page:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_hostingpage' ); ?>" value="<?php echo esc_attr( $opt_val_hostingpage ); ?>" size="20"> page URL where your hosting packages are displayed e.g. /web-hosting/</p>
<p><b> <?php echo __("Addons",'web-hosting'); ?></b></p>
<p><?php _e("Addons Page:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_addonspage' ); ?>" value="<?php echo esc_attr( $opt_val_addonspage ); ?>" size="20"> page URL where your Addons are displayed e.g. /addons/</p>
<p><b><?php echo __("Continue Shopping Button In Cart",'web-hosting'); ?></b></p>
<p><?php _e("Continue Shopping Page:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_shoppingpage' ); ?>" value="<?php echo esc_attr( $opt_val_shoppingpage ); ?>" size="20"> page URL where your products are displayed e.g. /shop/</p>
<hr />
<h2> <?php echo __("Company Details",'web-hosting'); ?></h2>
<p><?php _e("Company Name:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companyname' ); ?>" value="<?php echo esc_attr( $opt_val_companyname ); ?>" size="20"> Company name to be displayed on invoices</p>
<p><?php _e("Company Address 1:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companyaddress01' ); ?>" value="<?php echo esc_attr( $opt_val_companyaddress01 ); ?>" size="20"> First line of address</p>
<p><?php _e("Company Address 2:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companyaddress02' ); ?>" value="<?php echo esc_attr( $opt_val_companyaddress02 ); ?>" size="20"> Second line of address</p>
<p><?php _e("City:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companycity' ); ?>" value="<?php echo esc_attr( $opt_val_companycity ); ?>" size="20"> City</p>
<p><?php _e("State:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companystate' ); ?>" value="<?php echo esc_attr( $opt_val_companystate ); ?>" size="20"> State</p>
<p><?php _e("Postcode:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companypostcode' ); ?>" value="<?php echo esc_attr( $opt_val_companypostcode ); ?>" size="20"> Postcode</p>
<p><?php _e("Telephone:", 'menu-test' ); ?>
<input type="text" name="<?php echo esc_attr( 'wh_companyphone' ); ?>" value="<?php echo esc_attr( $opt_val_companyphone ); ?>" size="20"> Telephone Number</p>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
</form>
</div>
<?php


}
