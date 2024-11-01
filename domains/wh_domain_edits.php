<?php

// Version: 1.5.4


function domain_edits($product_name,$domainreg,$output_string2)
{
	ob_start();
	global $product_name, $product_id, $domainreg, $output_string2,$order_id,$order_count, $product_count;
	$lang='';
	$domain_edits = new lang($lang);
	$path = '';
	
	if (current_user_can('customer') || (current_user_can('administrator') ))
	{
		
		
		
		
		if ($domainreg == 'Active')
		{
			


			
			?>
			<table style="border: 0px">
			<?php
			echo '<form method="post" action="' . esc_attr ($path) . '">' ; ?>
			<tr style="border: 0px">
			<td style="border: 0px">
			<?php echo htmlentities($domain_edits->my_account_manage_domain, ENT_COMPAT,'ISO-8859-1', true);?> &nbsp;
			<input type="hidden" name="product_name" value=<?php echo esc_attr ($product_name);?> >
			<input type="hidden" name="product_id" value=<?php echo esc_attr ($product_id);?> >
			<input type="hidden" name="order_id" value=<?php echo esc_attr ($order_id);?> >
			<?php wp_nonce_field('wh_domain_options_form'); ?>

			<select name="select">
			<option value="0"><?php echo htmlentities($domain_edits->my_account_select, ENT_COMPAT,'ISO-8859-1', true);?></option>
			<option value="1"><?php echo htmlentities($domain_edits->my_account_change_nameservers, ENT_COMPAT,'ISO-8859-1', true);?></option>
			<option value="2"><?php echo htmlentities($domain_edits->my_account_domain_secret, ENT_COMPAT,'ISO-8859-1', true);?></option>
			<option value="3"><?php echo htmlentities($domain_edits->my_account_unlock_domain, ENT_COMPAT,'ISO-8859-1', true);?></option>
			<option value="4"><?php echo htmlentities($domain_edits->my_account_lock_domain, ENT_COMPAT,'ISO-8859-1', true);?></option>
			</select>
			</td>

			<td style="border: 0px; padding-top:30px;">
			<input type="submit" name="check" value="<?php echo htmlentities($domain_edits->go, ENT_COMPAT,'ISO-8859-1', true); ?>"/>
			</td>
			</tr>
			</form>
			</table>
			<?php

		} // end of if ($domainreg == 'yes'){

	} // end of if (current_user_can('customer')){

$output_string2=ob_get_contents();

ob_end_clean();

return $output_string2; ob_start();

}

add_action('domain_edits','domain_edits');
