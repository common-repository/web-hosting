<?php

// Version: 1.5.4

function edit_domains()

{

 global $woocommerce,$post,$wpdb,$order,$product,$fulldomainname,$product_id,$ns1,$ns2,$ns3,$ns4,
 $errormessage,$product_name,$lock,$pageposition,$order_id,$x;

  $lang='';$x=0;
  $edit_domains = new lang($lang);
	$data=false;
   $order_id = false; $path = '';$httpResponse= false;

	if ( is_user_logged_in() )

	{

		//	if (current_user_can('customer') )

		if (current_user_can('customer') || (current_user_can('administrator') ))
		{
			$customer_id = get_current_user_id();
			$customer_orders = wc_get_orders(array(
											'limit'    => -1,
											'customer' => get_current_user_id(),
											) );

			foreach ( $customer_orders as $value)
			{
				$order_id = $value->get_id();
				$order = wc_get_order( $order_id );

				foreach ( $order->get_items() as $item_id => $item )
				{
					$product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
					$product_name = $product->get_name();
					$product_id = $product->get_id();
					wh_get_domain_order_details($product_name, $data);
					$result = json_decode($data, TRUE);
					$endtime = $result["endtime"];
					$domainreg = $result['currentstatus'];
						if(isset($endtime) && ($endtime >1))
						{
							if (ctype_digit($endtime))
							{
								date("F j, Y", $endtime);
								$expirydate = $date;
							}

							else 
								{
									$expirydate = get_post_meta($order_id,'_' . $product_name . '_domainexpiry',$expirydate);
									$domainreg = get_post_meta($order_id,'_' . $product_name . '_domain-registered',true);
									if(!$domainreg){$domainreg = get_post_meta($product_id,'domain-registered',true);} //backward compatibility
									if($domainreg == 'yes'){$domainreg = 'Active';}
									if(!$expirydate){$expirydate = get_post_meta($product_id,'domainexpiry',true);} //backward compatibility
								}
						}
/*
						echo '<A NAME="' . esc_html ($pageposition) .'"></a>';
				if(isset($_POST['checkns']))
				{
						if ($_POST['checkns'])
						{
							$wh_run_checkns = sanitize_text_field ($_POST['wh_run_checkns']);
							if ($wh_run_checkns == "yes")
							{
								$wh_run_checkns = false;
							$retrieved_nonce = $_REQUEST['_wpnonce'];
							if (!wp_verify_nonce($retrieved_nonce, 'wh_checkns' ) ) die( htmlentities($edit_domains->security_token, ENT_COMPAT,'ISO-8859-1', true) );
							$ns1 = false; $ns2 = false;$ns3 = false; $ns4 = false;
							
							$domainname = sanitize_text_field ($_POST['product_name']);
							$product_id = sanitize_text_field ($_POST['product_id']);
							$order_id = sanitize_text_field ($_POST['order_id']);
							echo "product_name " . $domainname . "<br>";
							echo "product_id " . $product_id . "<br>";
							echo "order_id " . $order_id . "<br>";
							$ns1 = sanitize_text_field ($_POST['ns1']);

							if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns1))
							{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_1, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}

							$ns2 = sanitize_text_field ($_POST['ns2']);
							if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns2))
							{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_2, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}

							$ns3 = sanitize_text_field ($_POST['ns3']);
							if(isset($ns3) && ($ns3 <> ''))
							{
								if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns3))
								{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_3, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}
							}

							$ns4 = sanitize_text_field ($_POST['ns4']);
							if(isset($ns4) && ($ns4 <> ''))
							{
								if (!preg_match("/\b(?:(?:ns?)[0-9]\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $ns4))
								{echo '<div class ="whmessageboxred">' . htmlentities($edit_domains->resellerclub_nameserver_error_4, ENT_COMPAT,'ISO-8859-1', true) . '</div>';$error=true;}
							}

							//$page = get_page_by_title( $domainname,'','product' );
							//$product_id = $page->ID;

							if ($ns1 == false)
							{
								$errormessage = htmlentities($edit_domains->resellerclub_nameserver_1_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								if ($ns2 == false)
								{
									$errormessage = htmlentities($edit_domains->resellerclub_nameserver_1_2_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								}
							}

							if ($ns2 == false)	
							{
								$errormessage = htmlentities($edit_domains->resellerclub_nameserver_2_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								if ($ns1 == false)	
								{
									$errormessage = htmlentities($edit_domains->resellerclub_nameserver_1_2_error_requires_valid_name, ENT_COMPAT,'ISO-8859-1', true);
								}
							}

							update_nameservers_api($product_id);
							$x++;
							$_POST['checkns'] = '';
							}
						}
				}
*/
					
				}

			}
		//	echo '<A NAME="' . esc_html ($pageposition) .'"></a>';	
			edit_domains_test();

	if (isset($_POST['select']))
	{
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wh_domain_options_form' ) ) die( htmlentities($edit_domains->$this->security_token, ENT_COMPAT,'ISO-8859-1', true ));
		$domainaction = sanitize_text_field ($_POST['select']);
		//	if ($domainaction == 'Change Nameservers')
		if ($domainaction == '1')
		{
			echo "here";
			$domainname = sanitize_text_field ($_POST['product_name']);
			$customer_id = get_current_user_id();
			//echo '<A NAME="' . esc_html ($pageposition) .'"></a>';
			echo '<h4>' . htmlentities($edit_domains->form_nameserver, ENT_COMPAT,'ISO-8859-1', true) . '</h4><br />' . esc_html($domainname) . '<br /><br />';
/*
			$customer_orders = wc_get_orders(array(
											'limit'    => -1,
											'customer' => get_current_user_id(),
											) );

			foreach ( $customer_orders as $value)
			{
				$order_id = $value->get_id();
				$order = wc_get_order( $order_id );
				$s='1';

				foreach ( $order->get_items() as $item_id => $item )
				{
					$product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
					$product_name = $product->get_name();
					$product_id = $product->get_id();

					while($s <= 4 && $product_name == $domainname)
					{
						echo htmlentities($edit_domains->form_nameserver, ENT_COMPAT,'ISO-8859-1', true) . ' ' . esc_html ($s) .': &nbsp; ' . get_post_meta( $product_id, 'nameserver0'.esc_html($s), true );
						echo '<br />';$s++;$tempdomainname = $product_id;
					}
				}
			}
*/
			?><br /><br />
			<?php
			echo '<form method="post" action="' .esc_attr ($path) . '#' . esc_html($pageposition) . '">' ; ?>
			<?php wp_nonce_field('wh_checkns'); ?>
			<input type="hidden" name="product_name" value=<?php echo esc_html($domainname);?> >
			<input type="hidden" name="product_id" value="<?php echo $product_id;?>" >
			<input type="hidden" name="order_id" value="<?php echo $order_id;?>" >
			<input type="hidden" name="wh_run_checkns" value="yes" >
			<table>
			<tr>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_01, ENT_COMPAT,'ISO-8859-1', true);?> * </p><p><input type="text" name="ns1" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_02, ENT_COMPAT,'ISO-8859-1', true);?> *</p><input type="text" name="ns2" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			</tr>
			<tr>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_03, ENT_COMPAT,'ISO-8859-1', true);?> </p><input type="text" name="ns3" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			<th style="border:0px;">
			<p><?php echo htmlentities($edit_domains->form_nameserver_04, ENT_COMPAT,'ISO-8859-1', true);?> </p><input type="text" name="ns4" pattern="[a-z0-9.-]+\.[a-z]{2,3}$"></p>
			</th>
			</tr>
			<tr>
			<th style="border:0px;padding-top:10px;">
			<input type="submit" name="checkns" value="<?php echo htmlentities($edit_domains->change, ENT_COMPAT,'ISO-8859-1', true);?>"/>
			</th>
			</tr>
			</table>
			</form>
			<?php

		}

	} // end of isset($_POST['select']))





















			if (isset($domainaction) && ($domainaction == '2'))
			{
				$domainname = sanitize_text_field ($_POST['product_name']);
				echo '<A NAME="' . esc_html ($pageposition) .'"></a>';
				echo '<h3>' . htmlentities($edit_domains->my_account_domain, ENT_COMPAT,'ISO-8859-1', true) . '</h3>';
				echo htmlentities($edit_domains->my_account_domain, ENT_COMPAT,'ISO-8859-1', true) . ': ' . esc_html($domainname);
				$product_name = $domainname;
				domain_secret_api($product_name);
			}

			if (isset($domainaction) && ($domainaction == '3'))
			{
				$domainname = sanitize_text_field ($_POST['product_name']);
				echo '<h3>Domain</h3>';
				echo 'Domain: ' . esc_html($domainname);
				$product_name = $domainname;
				$lock='disable';
				unlock_domain_api($lock);
			}

			if (isset($domainaction) && ($domainaction == '4'))
			{
				$domainname = sanitize_text_field ($_POST['product_name']);
				echo '<h3>Domain</h3>';
				echo 'Domain: ' . esc_html($domainname);
				$product_name = $domainname;
				$lock='enable';
				unlock_domain_api($lock);
			}

		} // end of if (current_user_can('customer')){

} // end of user logged in

		else 
		{
			echo htmlentities($edit_domains->my_account_login_to_view_this_page, ENT_COMPAT,'ISO-8859-1', true);

			if (! is_user_logged_in() )	
			{
				?>
				<a href="<?php echo wp_login_url( home_url() ); ?>" title="Log In"> Log In</a>
				<?php
			}
		}

}

add_shortcode('edit_domains','edit_domains');
