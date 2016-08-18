<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
  $order = new WC_Order( $order->id );
  $items = $order->get_items();

   foreach ($items as $key => $product ) {
    if(preg_match("/brigade beach/i", $product['name'], $match)){
      echo '<strong>Please Print this email to use as your ticket to get in to the BC Brigade Beach Bash.</strong>';
    }
  }
?>

<p><?php printf( __( "Hi there. Your recent order on %s has been completed. Your order details are shown below for your reference:", 'woocommerce' ), get_option( 'blogname' ) ); ?></p>

<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Emails::order_schema_markup() Adds Schema.org markup.
 * @since 2.5.0
 */?>

<?php

do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

$order = new WC_Order( $order->id );
$items = $order->get_items();

foreach ($items as $key => $product ) {
  if(preg_match("/brigade beach/i", $product['name'], $match)){
  	echo '<h2>Brigade Bash Details</h2>';
    for($i = 1; $i <= $product['qty']; $i++){
      $fields[] = 'email_address_'. $i;
      $fields[] = 'shirt_size_'. $i;


      echo '<table>';
      echo '<tr>';
      echo '<td><p><strong>'.__('Email '.$i).':</strong> ' . get_post_meta( $order->id, 'email_address_'. $i, true ) . '</p></td>';
      echo '<td><p><strong>'.__('Shirt Size '.$i).':</strong> ' . get_post_meta( $order->id, 'shirt_size_'. $i, true ) . '</p></td>';
      echo '</tr>';
      echo '</table>';
    }
  }
}

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
