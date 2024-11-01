<?php
// Version: 1.5.4

function wh_woo_updated_cart()
{
	global $woocommerce, $cart_domain_array, $domain_array, $wpdb;
	$x=0;$custom_value=false;$custom_option = false;$temp_array_temp = array();$temp_array_values = array();





	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values )
	{
		$_product = $values['data'];
		$product_id = $_product->get_id();
		
		if(!empty($values['custom_option']))
		{
		
			
			$temp_array_temp[] = $values['custom_option'];
			
			$temp_array_values[] = $values;
			update_option("temp_wh_cart_values",$temp_array_values);
			
		}
	
	
		$producttype = get_post_meta($product_id , 'package', true);
		if ($producttype=="domain") 
							{
			
								update_post_meta($product_id , 'in_cart', 'yes');
							}
	
	
	
	}
		
		update_option("temp_wh_cart_items",$temp_array_temp);

}
add_action( 'woocommerce_cart_updated', 'wh_woo_updated_cart', 10, 0 ); 


function wh_check_deleted_cart_items()

{
	global $woocommerce;
	$var=array();$deleted_products = array();$key="";
foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values )
	{
		$_product = $values['data'];
		$product_id = $_product->get_id();
		
		
	
	
		
	
	
		
		$var = WC()->cart->get_removed_cart_contents();
	
		foreach ($var as $key => $value)
		{
			$id = $value['product_id'];
			$deleted_products[]=$id;
			
			if ( FALSE === get_post_status($id) ) 
			{}
		else
			{
			$producttype = get_post_meta($id , 'package', true);
			if ($producttype=="domain") 
				{	
				update_post_meta($id,'in_cart',"");	
				}
			}

		}
	
	
	}	
	update_option("removed_cart_ids",$deleted_products);
}
add_action( 'woocommerce_after_cart', 'wh_check_deleted_cart_items', 10, 0 ); 

function wh_cart_is_empty()
{
$args = array(
			'post_type' => 'product',
			'page_id' => '',
			'posts_per_page' => -1
			);
			
			$loop = new WP_Query( $args );
			$xx=0;
			if ( $loop->have_posts() ) 
			{
				while ( $loop->have_posts() ) : $loop->the_post();
				
				$posts = $loop->posts;
				$product_id = $posts[$xx]->ID;
				
				
				
							$producttype = get_post_meta( $product_id, 'package',true);
							if (isset($producttype) && ($producttype == "domain"))
							{
								$domain_registered = get_post_meta( $product_id, 'domain-registered',true);
								if ($domain_registered == "no")
								{
									$domain_in_cart = get_post_meta( $product_id, 'in_cart',true);
									if($domain_in_cart =="yes")
									{
									update_post_meta( $product_id, 'in_cart','');
									}
								}
							}
			$xx++;
			endwhile;
			}
	
}



add_action( 'woocommerce_cart_is_empty', 'wh_cart_is_empty', 10, 0 ); 


/**
 * Display input on single product page
 */
function wh_domain_name()
{
	global $woocommerce, $wh_cart_items, $wh_domain_value;
	
	 $count=false; $wh_cart_items = array();$show_domain_box = false;$is_domain_in_array = false;$domain_array = array();
	$wh_cart_items = get_option('temp_wh_cart_items',true);	
	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values )
		{
		$_product = $values['data'];
		$terms = get_the_terms( $_product->get_id(), 'product_cat' ); // changed 02-05-2017
		$product_name = $_product->get_name();
		$product_id = $_product->get_id();
		$parent_id = $_product->get_parent_id();
		if (isset($parent_id) && ($parent_id >0))
		{
		$price = get_post_meta($parent_id , '_price', true);
		$producttype = get_post_meta($parent_id , 'package', true);
		$id = $parent_id;
		}
		else
		{
		$price = get_post_meta($product_id , '_price', true);
		$producttype = get_post_meta($product_id , 'package', true);
		$id = $product_id;
		}
		
		if ($producttype=="domain") {
			
			//update_post_meta($product_id , 'in_cart', 'yes');
			
		if (in_array($product_name, $wh_cart_items,true))
		{
			$show_domain_box == true;
			
		}
		else
		{
		$domain_array[] = $product_name;
		//update_post_meta($product_id , 'in_cart', 'yes');
		}
		
		
		}
		
		}
	
	update_option("domain_array",$domain_array);
	
	
	
   $value = isset( $_POST['_domain_name' ] ) ? sanitize_text_field( $_POST['_domain_name'] ) : '';
	$value2 = isset( $_POST['_domain_name_text' ] ) ? sanitize_text_field( $_POST['_domain_name_text'] ) : '';
	
		if((empty($domain_array)))
		{
			printf( '<p><label>%s<input name="_domain_name_text" value="%s" /></label></p>', __( 'Enter your domain name: ', 'wh-plugin-textdomain' ), esc_attr( $value ) );
		}
		else
		{
		
		
		
		
			
		$output = '	 Select your domain name
		 <select name = "_domain_name" value="%s">
		 <option> Select </option>
		 ';	
		 
		foreach($domain_array as $wh_domain_value)
		{
			
					$output .=	'<option>' . $wh_domain_value . '</option>';
		
		}	
		$output .=	'</select>';
		
		if($show_domain_box == true)
		{
				
			printf( '<p><label>%s<input name="_domain_name_text" value="%s" /></label></p>', __( 'Enter your domain name: ', 'wh-plugin-textdomain' ), esc_attr( $value ) );
		
		}
				else
				{			
				printf($output, __( 'Enter your domain name: ', 'wh-plugin-textdomain' ), esc_attr( $wh_domain_value ) );
				}
		
					// *******************************************************************************************************************
 
 
 
		}

}
add_action( 'woocommerce_before_add_to_cart_button', 'wh_domain_name', 9 );


//*****************************************************************************************************************************************
/**
 * Validate when adding to cart make sure a domain name is given for hosting
 * 
 * @param bool $passed
 * @param int $product_id
 * @param int $quantity
 * @return bool
 */
function domain_name_add_to_cart_validation( $passed, $product_id, $qty ){
	$result = false;

    if( isset( $_POST['_domain_name'] ) && sanitize_text_field( $_POST['_domain_name'] ) == '' )
	{
        $product = wc_get_product( $product_id );
        wc_add_notice( sprintf( __( '%s cannot be added to the cart until you enter the domain name you wish to use.', 'domain_name-plugin-textdomain' ), $product->get_title() ), 'error' );
			return false;
    }
	
	
	
	

    return $passed;

}
add_filter( 'woocommerce_add_to_cart_validation', 'domain_name_add_to_cart_validation', 10, 3 );




function wh_add_to_cart_validation( $passed, $product_id, $qty ){
	$result = false;

    
	if( isset( $_POST['_domain_name_text'] ) && sanitize_text_field( $_POST['_domain_name_text'] ) == '' )
	{
        $product = wc_get_product( $product_id );
        wc_add_notice( sprintf( __( '%s cannot be added to the cart until you enter the domain name you wish to use.', 'wh-plugin-textdomain' ), $product->get_title() ), 'error' );
        return false;
    }
	

    return $passed;

}
add_filter( 'woocommerce_add_to_cart_validation', 'wh_add_to_cart_validation', 10, 3 );


//***********************************************************************************************************************************************

/**
 * Add custom data to the cart item
 * 
 * @param array $cart_item
 * @param int $product_id
 * @return array
*/
function domain_name_add_cart_item_data( $cart_item, $product_id ){

    if( isset( $_POST['_domain_name'] ) ) {
        $cart_item['custom_option'] = sanitize_text_field( $_POST[ '_domain_name' ] );
    }

	
    return $cart_item;

}
add_filter( 'woocommerce_add_cart_item_data', 'domain_name_add_cart_item_data', 10, 2 );





function wh_add_cart_item_data( $cart_item, $product_id ){

  
	
 if( isset( $_POST['_domain_name_text'] ) ) {
        $cart_item['custom_option_text'] = sanitize_text_field( $_POST[ '_domain_name_text' ] );
    }
	
		$producttype = get_post_meta($product_id , 'package', true);
		
		if ($producttype=="domain") {
			$domaintype = get_post_meta($product_id , 'new-or-transfer', true);			
			if ($domaintype == "transfer")
			{
			 $cart_item['domain'] = "Transfer";	
			}
		}
	
    return $cart_item;

}
add_filter( 'woocommerce_add_cart_item_data', 'wh_add_cart_item_data', 10, 2 );


//*****************************************************************************************************************************
/**
 * Load cart data from session
 * 
 * @param array $cart_item
 * @param array $other_data
 * @return array
 */
function domain_name_get_cart_item_from_session( $cart_item, $values ) {

    if ( isset( $values['custom_option'] ) ){
        $cart_item['custom_option'] = $values['custom_option'];
		if(isset($values['domain']))
		{
		$cart_item['domain'] = $values['domain'];
		}
    }
	
	
    return $cart_item;

}
add_filter( 'woocommerce_get_cart_item_from_session', 'domain_name_get_cart_item_from_session', 20, 2 );





function wh_get_cart_item_from_session( $cart_item, $values ) {

   
	if ( isset( $values['custom_option_text'] ) ){
        $cart_item['custom_option_text'] = $values['custom_option_text'];
    }
	
	if ( isset( $values['domain'] ) ){
		$cart_item['domain'] = $values['domain'];
	}
	
    return $cart_item;

}
add_filter( 'woocommerce_get_cart_item_from_session', 'wh_get_cart_item_from_session', 20, 2 );


//*********************************************************************************************************************************
/**
 * Add meta to order item
 * 
 * @param int $item_id
 * @param array $values
 * @return void
 */
function domain_name_add_order_item_meta( $item_id, $values ) {

    if ( ! empty( $values['custom_option'] ) ) {
        wc_add_order_item_meta( $item_id, 'custom_option', $values['custom_option'] );           
    }
	

	
}
add_action( 'woocommerce_add_order_item_meta', 'domain_name_add_order_item_meta', 10, 2 );




function wh_add_order_item_meta( $item_id, $values ) {

   
	
if ( ! empty( $values['custom_option_text'] ) ) {
        wc_add_order_item_meta( $item_id, 'custom_option_text', $values['custom_option_text'] );           
    }
	
	if ( ! empty( $values['domain'] ) ) {
        wc_add_order_item_meta( $item_id, 'domain', $values['domain'] );           
    }
	
}
add_action( 'woocommerce_add_order_item_meta', 'wh_add_order_item_meta', 10, 2 );

//*****************************************************************************************************************************

/**
 * Display entered value in cart
 * 
 * @param array $other_data
 * @param array $cart_item
 * @return array
 */
function domain_name_get_item_data( $other_data, $cart_item ) 
{

		if ( isset( $cart_item['custom_option'] ) )
		{
			$other_data[] = array(
            'key' => __( 'Domain', 'domain_name-plugin-textdomain' ),
            'display' => sanitize_text_field( $cart_item['custom_option'] )
			);
		}
		
		
		
		
		
		
		$wh_cart_items = get_option('temp_wh_cart_items',true);
		if(isset($cart_item['custom_option']))
		{
		if (!in_array($cart_item['custom_option'], $wh_cart_items))
		{
		$wh_cart_items[] = $cart_item['custom_option'];
		
		update_option('temp_wh_cart_items',$wh_cart_items);
		}
		}

    return $other_data;

}
add_filter( 'woocommerce_get_item_data', 'domain_name_get_item_data', 10, 2 );




function wh_get_item_data( $other_data, $cart_item ) 
{

		
		
		
		if ( isset( $cart_item['custom_option_text'] ) )
			{

			$other_data[] = array(
				'key' => __( 'Domain', 'wh-plugin-textdomain' ),
				'display' => sanitize_text_field( $cart_item['custom_option_text'] )
				);
		
			}
		
		
		if ( isset( $cart_item['domain'] ) )
		{
			$other_data[] = array(
            'key' => __( 'Domain', 'wh-plugin-textdomain' ),
            'display' => ( $cart_item['domain'] )
			);
		}
		
		

    return $other_data;

}
add_filter( 'woocommerce_get_item_data', 'wh_get_item_data', 10, 2 );

//**********************************************************************************************************************
/**
 * Restore custom field to product meta when product retrieved for order item.
 * Meta fields will be automatically displayed if not prefixed with _
 * 
 * @param WC_Product $product 
 * @param WC_Order_Item_Product $order_item
 * @return array
 */
function domain_name_order_item_product( $product, $order_item ){

    if( $order_item->get_meta( 'custom_option' ) ){
        $product->add_meta_data( 'custom_option', $order_item->get_meta( 'custom_option' ), true );
    }
	


    return $product;

}
add_filter( 'woocommerce_order_item_product', 'domain_name_order_item_product', 10, 2 );





function wh_order_item_product( $product, $order_item ){

   
	
if( $order_item->get_meta( 'custom_option_text' ) ){
        $product->add_meta_data( 'custom_option_text', $order_item->get_meta( 'custom_option_text' ), true );
    }

  
if( $order_item->get_meta( 'domain_text' ) ){
        $product->add_meta_data( 'domain_text', $order_item->get_meta( 'domain_text' ), true );
    }
	
    return $product;
}
add_filter( 'woocommerce_order_item_product', 'wh_order_item_product', 10, 2 );

//*********************************************************************************************************************
/**
 * Customize the display of the meta key in order tables.
 * 
 * @param string $display_key
 * @param obj[] $meta
 * @param WC_Order_Item_Product $order_item
 * @return string
 */
function domain_name_order_item_display_meta_key( $display_key, $meta, $order_item ){
global $wh_domain_value, $wh_cart_items;
    if( $meta->key == 'custom_option' ){
        $display_key =  __( 'Your Domain', 'domain_name-plugin-textdomain' );
	    }
		

		
    return $display_key;

}
add_filter( 'woocommerce_order_item_display_meta_key', 'domain_name_order_item_display_meta_key', 10, 3 );








function wh_order_item_display_meta_key( $display_key, $meta, $order_item ){
global $wh_domain_value, $wh_cart_items;
   
		
if( $meta->key == 'custom_option_text' ){
        $display_key =  __( 'Your Domain', 'wh-plugin-textdomain' );
	    }
		
		if( $meta->key == 'domain_text' ){
        $display_key =  __( 'Domain', 'wh-plugin-textdomain' );
	    }
		
    return $display_key;

}
add_filter( 'woocommerce_order_item_display_meta_key', 'wh_order_item_display_meta_key', 10, 3 );

