<?php
/**
 * Plugin Name: Brigade Bash Checkout Options
 * Description: Add email and tshirt size options to checkout page
 * Version: 1.0.0
 * Author: Patrick Hoydar
 * License: GPL2
 */

$fields = [
    "foo" => "bar",
    "bar" => "foo",
];

add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

$added_custom_fields = false;

function my_custom_checkout_field( $checkout ) {
    global $added_custom_fields, $fields;

    $added_custom_fields = true;

    $items = WC()->cart->get_cart();

    $line;
    // perform a case-Insensitive search for the word "Vi"

    // if (preg_match("/\bVi\b/i", $line, $match)) :
    //   print "Match found!";
    //   endif;

    foreach( $items as $cart_item_key => $values ) {

      $line = $values['data']->post->post_title;

      // if($values['product_id'] == 914){
      if(preg_match("/brigade beach/i", $line, $match)){
          echo '<div class="brigade_bash_checkout_options"><h2>' . __('Brigade Bash Options') .'</h2><small>required *</small></div>';
          echo '<p>' . __('Each Brigade Bash ticket comes with a t-shirt. Please enter an email and a shirt size for each ticket being ordered.') . '</p>';

          for ($i=1; $i <= $values['quantity'] ; $i++) {
            $fields[] = 'email_address_'. $i;
            $fields[] = 'shirt_size_'. $i;

            echo '<div id="brigade_bash_checkout_field">';

            woocommerce_form_field( 'email_address_'.$i, array(
                'type'          => 'text',
                'class'         => array('form-row-first'),
                'label'         => __('Email ' . $i),
                'placeholder'   => __('Email'),
                'required'      => true,
                ), $checkout->get_value( 'email_address_'.$i ));

            woocommerce_form_field( 'shirt_size_'.$i, array(
                'type'          => 'select',
                'class'         => array('form-row-last'),
                'label'         => __('Shirt Size ' . $i),
                'required'      => true,
                'options' => array(
                  'no_selection' => '',
                  'small' => 'S',
                  'medium' => 'M',
                  'large' => 'L',
                  'extra_large' => 'XL'
                  ),
                ), $checkout->get_value( 'shirt_size_'.$i ));

            echo '</div>';

          }
      }

    }
  }

/**
* Process the checkout
*/

add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
  global $added_custom_fields;

    foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {

      if(preg_match("/brigade beach/i", $values['data']->post->post_title, $match)){
        for ($i=1; $i <= $values['quantity'] ; $i++) {
             if ( ! $_POST['email_address_'.$i] || ! is_email( $_POST['email_address_'.$i] ) )
                wc_add_notice( __( 'Please enter a valid email address for email ' . $i ), 'error' );

             if ( $_POST['shirt_size_'.$i] == '' )
                wc_add_notice( __( 'Please Select a T-shirt size ' . $i ), 'error' );
        }
      }
    }

}

/**
* Update the order meta with field value
*/

add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {

    foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {

      if(preg_match("/brigade beach/i", $values['data']->post->post_title, $match)){
        for ($i=1; $i <= $values['quantity'] ; $i++) {
          if ( ! $_POST['email_address_'.$i] || is_email( $_POST['email_address_'.$i] ) )
            update_post_meta( $order_id, 'email_address_'.$i, $_POST['email_address_'.$i] );

          if ( ! $_POST['shirt_size_'.$i] == '' )
            update_post_meta( $order_id, 'shirt_size_'.$i, $_POST['shirt_size_'.$i] );
        }
      }
    }
}

add_action('woocommerce_order_details_after_order_table','add_custom_details_to_order_received', 10, 1 );

function add_custom_details_to_order_received($order){
  $order = new WC_Order( $order->id );
  $items = $order->get_items();

  global $fields;

  ?>

  <h2><?php _e( 'Brigage Bash Details', 'woocommerce' ); ?></h2>
  <table class="shop_table order_details">
    <thead>
      <tr>
        <th class="product-name"><?php _e( 'Email', 'woocommerce' ); ?></th>
        <th class="product-total"><?php _e( 'Shirt Size', 'woocommerce' ); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php

      foreach ($items as $key => $product ) {
        if(preg_match("/brigade beach/i", $product['name'], $match)){
          for($i = 1; $i <= $product['qty']; $i++){

            $fields[] = 'email_address_'. $i;
            $fields[] = 'shirt_size_'. $i;

            echo '<tr>';
            echo '<td><p><strong>'.__('Email '.$i).':</strong> ' . get_post_meta( $order->id, 'email_address_'. $i, true ) . '</p></td>';
            echo '<td><p><strong>'.__('Shirt Size '.$i).':</strong> ' . get_post_meta( $order->id, 'shirt_size_'. $i, true ) . '</p></td>';
            echo '</tr>';
          }
        }
      }

      var_dump($fields);

      /**
      * Display field value on the order email
      */

      add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');

      function my_custom_checkout_field_order_meta_keys( $keys ) {
        for ($i=0; $i < count($fields); $i++) {
          $keys[] = 'email_address_'. $i;
          $keys[] = 'shirt_size_'. $i;
        }

        return $keys;
      }

      ?>
    </tbody>
  </table>

  <?php
}

/**
* Display field value on the order edit page
*/

add_action('woocommerce_admin_order_data_after_columns', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
  $order = new WC_Order( $order->id );
  $items = $order->get_items();

  global $field;

  ?>
    <h2 class="brigade-details-header">Brigade Bash Details</h2>
    <div class="brigade-bash-admin-details">
    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Shirt Size</th>
        </tr>
      </thead>
      <?php

      foreach ($items as $key => $product ) {
        if(preg_match("/brigade beach/i", $product['name'], $match)){
          for($i = 1; $i <= $product['qty']; $i++){
            $fields[] = 'email_address_'. $i;
            $fields[] = 'shirt_size_'. $i;

            echo '<tr>';
            echo '<td><p><strong>'.__('Email '.$i).':</strong> ' . get_post_meta( $order->id, 'email_address_'. $i, true ) . '</p></td>';
            echo '<td><p><strong>'.__('Shirt Size '.$i).':</strong> ' . get_post_meta( $order->id, 'shirt_size_'. $i, true ) . '</p></td>';
            echo '</tr>';
          }
        }
      }

      ?>
    </table>
    </div>
  <?php
}

