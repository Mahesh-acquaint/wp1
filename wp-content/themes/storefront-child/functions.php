<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION


/*******************************************************Custom code 22-6-23**********************************************************/

function custom_js_css_files() {
    wp_enqueue_style( 'jquery_min_cc',get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css' );
    wp_enqueue_style( 'custom_css',get_stylesheet_directory_uri() . '/assets/css/custom.css' );
    wp_enqueue_script('jquery_min_js',get_stylesheet_directory_uri() . '/assets/js/jquery.min.js',array('jquery'));
    wp_enqueue_script('bootstrap_min_js',get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js',array('jquery'));
    wp_enqueue_script('custom_js',get_stylesheet_directory_uri() . '/assets/js/custom.js',array('jquery'));
}

add_action( 'wp_enqueue_scripts', 'custom_js_css_files' );


function current_template_name() {
    global $template;
    print_r( $template );
  }
 add_action( 'wp_footer', 'current_template_name' );

 /***** Change Sale Text on Shop Page Product *****/ 

function ds_change_sale_text() {
    return '<span class="onsale"> Recent Sale! </span>';
}

add_filter('woocommerce_sale_flash', 'ds_change_sale_text');

/***** Change Add To cart Text on Shop Products Page  *****/ 

add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' ); 

function woocommerce_custom_product_add_to_cart_text() {

    return __( 'Purchase Now', 'woocommerce' );

}

/***** Change Add To cart Text on Single Product Page *****/ 

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );

function woocommerce_custom_single_add_to_cart_text() {

    return __( 'Buy Now', 'woocommerce' );
}

/***** Add custom Text After All Product Title   ******/

add_filter( 'the_title', 'add_custom_text_after_all_product_title', 10, 2 );
function add_custom_text_after_all_product_title( $title, $id ) {
   global $product;
   if('product' == get_post_type($id)){
        //$exclusive = get_field('exclusive', $id);   // pass the id into get_field
        $title = $title .', ' .'Custom Text added';
    }
    return $title;
}

/*************************************** Add custom Text Input Field in General Section ***************************************/
/*Input Text Field*/
/*Add*/
function woocommerce_add_custom_field_general_section_single_product(){
   
    global $woocommerce, $post, $product;
    
    //Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_general_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
    echo "<br>";
    woocommerce_wp_select( array(
        'id'      => 'costom_add_general_select_field',
        'label'   => __( 'Additional Fields<br> (Select) : ', 'woocommerce'),
        'options' => array(
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
            'Sat' => 'Saturday',
            'Sun' => 'Sunday'
        ),
    ) );

    echo "<br>";
    woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_general_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
    echo "<br>"; 
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_general_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
    echo "<br>";
    woocommerce_wp_radio(array(
        'id'=>'costom_add_general_radio_button_field',
        //'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                '10 days'    => '10 days',
                '15 days'    => '15 days',
                '30 days'    => '30 days',
             ),
    ));
    echo "<br>";
     woocommerce_wp_text_input(array(
        'id'=>'costom_add_inventory_input_text_field',
        'label'=>__('Additional Fields:<br>(Input Field):','woocommerce'),
        'class'=>'inventory_input_field',
    ));
    echo "<br>";
    woocommerce_wp_select( array(
        'id'      => 'costom_add_inventory_select_field',
        'label'   => __( 'Additional Fields<br> (Select) : ', 'woocommerce'),
        'options' => array(
            'January' => 'January ',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December',
        ),
    ) );

    echo "<br>";
    woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_inventory_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
    echo "<br>";
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_inventoy_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
    echo "<br>";
    woocommerce_wp_radio(array(
        'id'=>'costom_add_inventory_radio_button_field',
        //'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'Male'    => 'Male',
                'Female' => 'Female',
                'other' => 'Other',
             ),
    ));
    echo "<br>";
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_link_product_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
    echo "<br>";
    woocommerce_wp_select( array(
        'id'      => 'costom_add_linked_product_select_field',
        'label'   => __( 'Additional Fields<br> (Select) : ', 'woocommerce'),
        'options' => array(
            'January' => 'January ',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December',
        ),
    ) );

    echo "<br>";
    woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_linked_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
    echo "<br>";
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_linked_product_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));
    echo "<br>";
    woocommerce_wp_select( array(
        'id'      => 'costom_add_attribute_select_field',
        'label'   => __( 'Additional Fields<br> (Select) &nbsp; : ', 'woocommerce'),
        'options' => array(
            'Summer' => 'Summer ',
            'Moonsoon' => 'Moonsoon',
            'Winter' => 'Winter',
        ),
    ) );
    echo "<br>";
    woocommerce_wp_radio(array(
        'id'=>'costom_add_linked_radio_button_field',
        //'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'India'    => 'India',
                'Mp' => 'Mp',
                'Mh' => 'Mh',
                'Dhl'=>'Dhl'
             ),
    ));

    echo "<br>";
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_attributes_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
    echo "<br>";
    woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_attributes_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );   
    echo "<br>";
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_attributes_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));  
    echo "<br>";
    woocommerce_wp_radio(array(
        'id'=>'costom_add_attributes_radio_button_field',
        'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'India'    => 'India',
                'Mp' => 'Mp',
                'Mh' => 'Mh',
                'Dhl'=>'Dhl'
             ),
    ));
    echo "<br>";
    woocommerce_wp_text_input(
        array(
            'id'          => 'costom_add_advanced_input_field',
            'label'       => __('Additional Fields<br> (input Field) : ', 'woocommerce'),
            'placeholder' => 'Add Custom custom text',
            'desc_tip'    => 'true'
        )
    );
    echo "<br>";
    woocommerce_wp_select( array(
        'id'      => 'costom_add_advanced_select_field',
        'label'   => __( 'Additional Fields<br> (Select) &nbsp; : ', 'woocommerce'),
        'options' => array(
            'HP' => 'HP ',
            'Lenovo' => 'Lenovo',
            'MAC' => 'MAC',
            'Dell' => 'Dell',
        ),
    ) );
    echo "<br>";
    woocommerce_wp_checkbox(array(
        'id'=>'costom_add_advanced_checkbox_field',
        'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
        'class'=>'checkbox_class',
    ));

    echo "<br>";
    woocommerce_wp_radio(array(
        'id'=>'costom_add_advanced_radio_button_field',
       // 'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
        'class'=>'radio_class',
        'options' => array(
                'Kasol'    => 'Kasol',
                'Simla' => 'Simla',
                'Manali' => 'Manali',
                'Leh'=>'Leh'
             ),
    ));
    echo "<br>";
    woocommerce_wp_textarea_input(array(
             'id'=>'costom_add_addvanced_text_area_field',
             'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
             'placeholder' => 'Add Custom Text Contents',
             'class'=>'text_area_class',
         ),
     );
}
add_action('woocommerce_product_options_general_product_data', 'woocommerce_add_custom_field_general_section_single_product');

/*Save*/
function woocommerce_add_custom_field_general_section_single_product_save_field($post_id){

     $product = wc_get_product( $post_id );
     $title = isset( $_POST['costom_add_general_input_field'] ) ? $_POST['costom_add_general_input_field'] : '';
     $product->update_meta_data( 'costom_add_general_input_field', sanitize_text_field( $title ) );
     $product->save();

     $product1 = wc_get_product( $post_id );
     $title1 = isset( $_POST['costom_add_general_select_field'] ) ? $_POST['costom_add_general_select_field'] : '';
     $product1->update_meta_data( 'costom_add_general_select_field', sanitize_text_field( $title1 ));
     $product1->save();

     $product2 = wc_get_product( $post_id );
     $title2 = isset( $_POST['costom_add_general_text_area_field'] ) ? $_POST['costom_add_general_text_area_field'] : '';
     $product2->update_meta_data( 'costom_add_general_text_area_field', sanitize_text_field( $title2 ));
     $product2->save();

     $super = isset( $_POST[ 'costom_add_general_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_general_checkbox_field' ] ? 'yes' : 'no';
     update_post_meta( $post_id, 'costom_add_general_checkbox_field', $super );  

     $product3 = wc_get_product( $post_id );
     $title3 = isset( $_POST['costom_add_general_radio_button_field'] ) ? $_POST['costom_add_general_radio_button_field'] : '';
     $product3->update_meta_data( 'costom_add_general_radio_button_field', sanitize_text_field( $title3 ));
     $product3->save();

     $product4 = wc_get_product( $post_id );
     $title4 = isset( $_POST['costom_add_inventory_input_text_field'] ) ? $_POST['costom_add_inventory_input_text_field'] : '';
     $product4->update_meta_data( 'costom_add_inventory_input_text_field', sanitize_text_field( $title4 ));
     $product4->save();

     $product5 = wc_get_product( $post_id );
     $title5 = isset( $_POST['costom_add_inventory_select_field'] ) ? $_POST['costom_add_inventory_select_field'] : '';
     $product5->update_meta_data( 'costom_add_inventory_select_field', sanitize_text_field( $title5 ));
     $product5->save();

     $product6 = wc_get_product( $post_id );
     $title6 = isset( $_POST['costom_add_inventory_text_area_field'] ) ? $_POST['costom_add_inventory_text_area_field'] : '';
     $product6->update_meta_data( 'costom_add_inventory_text_area_field', sanitize_text_field( $title6 ));
     $product6->save();

     $super1 = isset( $_POST[ 'costom_add_inventoy_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_inventoy_checkbox_field' ] ? 'yes' : 'no';
     update_post_meta( $post_id, 'costom_add_inventoy_checkbox_field', $super1 );   

     $product7 = wc_get_product( $post_id );
     $title7 = isset( $_POST['costom_add_link_product_input_field'] ) ? $_POST['costom_add_link_product_input_field'] : '';
     $product7->update_meta_data( 'costom_add_link_product_input_field', sanitize_text_field( $title7 ));
     $product7->save();

     // $product8 = wc_get_product( $post_id );
     // $title8 = isset( $_POST['costom_add_inventory_radio_button_field'] ) ? $_POST['costom_add_inventory_radio_button_field'] : '';
     // $product8->update_meta_data( 'costom_add_inventory_radio_button_field', sanitize_text_field( $title8 ));
     // $product8->save();

     $product9 = wc_get_product( $post_id );
     $title9 = isset( $_POST['costom_add_linked_product_select_field'] ) ? $_POST['costom_add_linked_product_select_field'] : '';
     $product9->update_meta_data( 'costom_add_linked_product_select_field', sanitize_text_field( $title9 ));
     $product9->save();

     $product10 = wc_get_product( $post_id );
     $title10 = isset( $_POST['costom_add_linked_text_area_field'] ) ? $_POST['costom_add_linked_text_area_field'] : '';
     $product10->update_meta_data( 'costom_add_linked_text_area_field', sanitize_text_field( $title10 ));
     $product10->save();

     $super3 = isset( $_POST[ 'costom_add_linked_product_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_linked_product_checkbox_field' ] ? 'yes' : 'no';
     update_post_meta( $post_id, 'costom_add_linked_product_checkbox_field', $super3 );   

     // $product11 = wc_get_product( $post_id );
     // $title11 = isset( $_POST['costom_add_attribute_select_field'] ) ? $_POST['costom_add_attribute_select_field'] : '';
     // $product11->update_meta_data( 'costom_add_attribute_select_field', sanitize_text_field( $title11 ));
     // $product11->save(); 

     // // $title12 = isset( $_POST['costom_add_linked_radio_button_field'] ) ? $_POST['costom_add_linked_radio_button_field'] : '';
     // // $product12->update_meta_data( 'costom_add_linked_radio_button_field', sanitize_text_field( $title12 ));
     // // $product12->save();

     // // $title13 = isset( $_POST['costom_add_attributes_input_field'] ) ? $_POST['costom_add_attributes_input_field'] : '';
     // // $product13->update_meta_data( 'costom_add_attributes_input_field', sanitize_text_field( $title13 ));
     // // $product13->save();

     // $title14 = isset( $_POST['costom_add_attributes_text_area_field'] ) ? $_POST['costom_add_attributes_text_area_field'] : '';
     // $product14->update_meta_data( 'costom_add_attributes_text_area_field', sanitize_text_field( $title14 ));
     // $product14->save();

     // $super5 = isset( $_POST[ 'costom_add_attributes_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_attributes_checkbox_field' ] ? 'yes' : 'no';
     // update_post_meta( $post_id, 'costom_add_attributes_checkbox_field', $super5 );

     // $title15 = isset( $_POST['costom_add_attributes_radio_button_field'] ) ? $_POST['costom_add_attributes_radio_button_field'] : '';
     // $product15->update_meta_data( 'costom_add_attributes_radio_button_field', sanitize_text_field( $title15 ));
     // $product15->save();

     // $title160 = isset( $_POST['costom_add_advanced_input_field'] ) ? $_POST['costom_add_advanced_input_field'] : '';
     // $product160->update_meta_data( 'costom_add_advanced_input_field', sanitize_text_field( $title16 ));
     // $product160->save();

     // $title17 = isset( $_POST['costom_add_advanced_select_field'] ) ? $_POST['costom_add_advanced_select_field'] : '';
     // $product17->update_meta_data( 'costom_add_advanced_select_field', sanitize_text_field( $title170 ));
     // $product17->save();

     // $title18 = isset( $_POST['costom_add_addvanced_text_area_field'] ) ? $_POST['costom_add_addvanced_text_area_field'] : '';
     // $product18->update_meta_data( 'costom_add_addvanced_text_area_field', sanitize_text_field( $title18 ));
     // $product18->save();

     // $super6 = isset( $_POST[ 'costom_add_advanced_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_advanced_checkbox_field' ] ? 'yes' : 'no';
     // update_post_meta( $post_id, 'costom_add_advanced_checkbox_field', $super6 );  

     // $title19 = isset( $_POST['costom_add_advanced_radio_button_field'] ) ? $_POST['costom_add_advanced_radio_button_field'] : '';
     // $product19->update_meta_data( 'costom_add_advanced_radio_button_field', sanitize_text_field( $title19 ));
     // $product19->save();   


}
add_action('woocommerce_process_product_meta', 'woocommerce_add_custom_field_general_section_single_product_save_field');

/*Display*/

function woocommerce_add_custom_input_text_field_general_section_display_field(){
    $Product_id=get_the_ID();
   
    $text_feld=get_post_meta($Product_id,'costom_add_general_input_field',true);
    if ($text_feld){
        echo "<br>";
        echo "<b>General Input:</b> ";
        echo $text_feld;
    }

    $select_field=get_post_meta($product_id,'costom_add_general_select_field',true);
    if($select_field) {
      echo "<br>";  
      echo "<b>General Select:</b> ";
      print_r($select_field);  
    }


    $text_area_field=get_post_meta($product_id,'costom_add_general_text_area_field',true);
    if ($text_area_field) {
       echo "<br>"; 
       echo "<b>General Textarea:</b> ";
       print_r($text_area_field);
    }

    $checkbox_field99=get_post_meta($product_id,'costom_add_general_checkbox_field',true);
    if ($checkbox_field99) {
      echo "<br>";  
      echo "<b>General Checkbox:</b> ";
      print_r($checkbox_field99);
    }

    $radio_btn_value=get_post_meta($product_id,'costom_add_general_radio_button_field',true);
    if($radio_btn_value) {
       echo "<br>"; 
       echo "<b>General Redio:</b> ";
       print_r($radio_btn_value);
    }


    $display_inventory_val=get_post_meta($product_id,'costom_add_inventory_input_text_field',true);
    if($display_inventory_val) {
       echo "<br>"; 
       echo "<b>Inventory Input Field :</b> ";
       print_r($display_inventory_val);
    }

    $display_inventory_val=get_post_meta($product_id,'costom_add_inventory_select_field',true);
    if ($display_inventory_val) {
    echo "<br>";    
    echo "<b>Month:</b> ";
    print_r($display_inventory_val);
    }

    $text_area_field=get_post_meta($product_id,'costom_add_inventory_text_area_field',true);
    if ($text_area_field) {
      echo "<br>";  
      echo "<b>Inventory Text Area:</b> ";
      print_r($text_area_field);
    }

    $checkbox_field100=get_post_meta($product_id,'costom_add_inventoy_checkbox_field',true);
    if ($checkbox_field100) {
       echo "<br>"; 
       echo "<b>Inventory Checkbox :</b>";
       print_r($checkbox_field100);
    }

    // $radio_btn_value1=get_post_meta($product_id,'costom_add_inventory_radio_button_field',true);
    // if ($radio_btn_value1) {
    //    echo "<br>"; 
    //    echo "<b>Inventory Redio : </b>";
    //    print_r($radio_btn_value1);
    // }

    $radio_btn_value2=get_post_meta($product_id,'costom_add_link_product_input_field',true);
    if ($radio_btn_value2) {
     echo "<br>";
     echo "<b>Link Product Input  : </b>";
     print_r($radio_btn_value2);
    }

    $display_inventory_val=get_post_meta($product_id,'costom_add_linked_product_select_field',true);
    if($display_inventory_val){
        echo "<br>";
       echo "<b>Linked Product Select:</b> ";
       print_r($display_inventory_val);
    }


    $text_area_field=get_post_meta($product_id,'costom_add_linked_text_area_field',true);
    if ($text_area_field) {
       echo "<br>"; 
       echo "<b>Linked Product Text Area:</b> ";
       print_r($text_area_field);    
    }

    $checkbox_field11=get_post_meta($product_id,'costom_add_linked_product_checkbox_field',true);
    if($checkbox_field11){
      echo "<br>";  
      echo "<b>Linked Product Checkbox :</b>";
      print_r($checkbox_field11);
    }

    // $display_advanced_val=get_post_meta($product_id,'costom_add_advanced_input_field',true);
    // if ($display_advanced_val) {
    //   echo "<br>";  
    //   echo "<b>Addvanced Input:</b> ";
    //   print_r($display_advanced_val);
    // }

    // $display_inventory_val=get_post_meta($product_id,'costom_add_advanced_select_field',true);
    // if($display_inventory_val) {
    //     echo "<br>";
    //     echo "<b>Advanced Select:</b> ";
    //     print_r($display_inventory_val);
    // }


    // $text_area_field=get_post_meta($product_id,'costom_add_addvanced_text_area_field',true);
    // if ($text_area_field) {
    //   echo "<br>";
    //   echo "<b>Advanced Text Area:</b> ";
    //   print_r($text_area_field); 
    // }    
   

    // $checkbox_field12=get_post_meta($product_id,'costom_add_advanced_checkbox_field12',true);
    // if ($checkbox_field12){
    //     echo "<br>";
    //     echo "<b>Attributes Checkbox :</b>";
    //     print_r($checkbox_field12);
    // }


    // $radio_btn_value3=get_post_meta($product_id,'costom_add_advanced_radio_button_field',true);
    // if($radio_btn_value3){
    //     echo "<br>";
    //    echo "<b>Attributes Redio : </b>";
    //    print_r($radio_btn_value3);
    // }

    // $radio_btn_value4=get_post_meta($product_id,'costom_add_attributes_input_field',true);
    // if ($radio_btn_value4) {
    //     echo "<br>";
    //   echo "<b>Attributes Input : </b>";
    //   print_r($radio_btn_value4);
    // }
    

    // $display_inventory_val=get_post_meta($product_id,'costom_add_attribute_select_field',true);
    // if ($display_inventory_val) {
    //     echo "<br>";
    //     echo "<b>Attributes Select:</b> ";
    // print_r($display_inventory_val);
    // }
  

    // $text_area_field=get_post_meta($product_id,'costom_add_attributes_text_area_field',true);
    // if ($text_area_field) {
    //     echo "<br>";
    //   echo "<b>Attributes Text Area:</b> ";
    //   print_r($text_area_field); 
    // }

    // $checkbox_field01=get_post_meta($product_id,'costom_add_attributes_checkbox_field',true);
    // if ($checkbox_field01) {
    //     echo "<br>";
    //     echo "<b>Attributes Checkbox :</b>";
    //     print_r($checkbox_field01);
    // }

    // $radio_btn_value5=get_post_meta($product_id,'costom_add_attributes_radio_button_field',true);
    // if($radio_btn_value5){
    //     echo "<br>";
    //    echo "<b>Attributes Redio : </b>";
    //    print_r($radio_btn_value5);
    // }

    // $radio_btn_value6=get_post_meta($product_id,'costom_add_linked_radio_button_field',true);
    // if ($radio_btn_value6){
    //     echo "<br>";
    //    echo "<b>Linked Product Redio : </b>";
    //    print_r($radio_btn_value6);
    // }
}
add_action('woocommerce_single_product_summary','woocommerce_add_custom_input_text_field_general_section_display_field');



/*************************************** Add New Custom Tab Section (Custom Panel) ***************************************/

function my_custom_tab_action() {
  ?>
  <li class="custom_tab">
    <a href="#the_custom_panel">
      <span><?php _e( 'My Additional Custom Tab', 'wp1' ); ?></span>
    </a>
  </li>
  <?php
}
add_action( 'woocommerce_product_write_panel_tabs', 'my_custom_tab_action' );

/*************************************** Add New Custom Tab Section Fileds ***************************************/
function custom_tab_panel() {
    global $woocommerce, $post, $product;
  ?>
  <div id="the_custom_panel" class="panel woocommerce_options_panel">
    <div class="options_group">
      <?php
         woocommerce_wp_text_input(array(
                'id'          => 'my_custom_tab_input_text_field',
                'label'       => __('Additional Fields<br> (input Field New Tab) : ', 'woocommerce'),
                'placeholder' => 'Add Custom custom text',
                'desc_tip'    => 'true'
            )
        );

        woocommerce_wp_select( array(
            'id'      => 'costom_add_new_custom_tab_select_field',
            'label'   => __( 'Additional Fields New Tab<br> (Select) &nbsp; : ', 'woocommerce'),
            'options' => array(
                'HR' => 'HR ',
                'Manager' => 'Manager',
                'TL' => 'TL',
                'Senior' => 'Senior',
            ),
        ) );
        echo "<br>";
        woocommerce_wp_textarea_input(array(
            'id'=>'costom_add_new_tab_text_area_field1',
            'label'   => __( 'Additional Fields:<br>(Text Area) : ', 'woocommerce'),
            'placeholder' => 'Add Custom Text Contents',
            'class'=>'text_area_class',
             ),
            );
        echo "<br>";
        woocommerce_wp_checkbox(array(
            'id'=>'costom_add_new_tab_checkbox_field',
            'label'=>__('Additional Fields:<br>(checkbox) :','woocommerce'),
            'class'=>'checkbox_class',
            ),
        );

        echo "<br>";
        woocommerce_wp_radio(array(
            'id'=>'costom_add_new_tab_radio_button_field',
            'label'=>__('Additional Fields:<br>(Radio Botton) :','woocommerce'),
            'class'=>'radio_class',
            'options' => array(
                'Pakistan'    => 'Pakistan',
                'Inida' => 'Inida',
                'USA' => 'USA',
                'UA'=>'UA'
             ),
        ));

      ?>
    </div>
  </div>
<?php
}
add_action( 'woocommerce_product_data_panels', 'custom_tab_panel' );

function woocommerce_save_custom_input_text_new_custom_tab_section_single_product($post_id){

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['my_custom_tab_input_text_field'] ) ? $_POST['my_custom_tab_input_text_field'] : '';
    $product->update_meta_data( 'my_custom_tab_input_text_field', sanitize_text_field( $title ));
    $product->save();
   
    $title = isset( $_POST['costom_add_new_custom_tab_select_field'] ) ? $_POST['costom_add_new_custom_tab_select_field'] : '';
    $product->update_meta_data( 'costom_add_new_custom_tab_select_field', sanitize_text_field( $title ));
    $product->save();

   
    $title = isset( $_POST['costom_add_new_tab_text_area_field1'] ) ? $_POST['costom_add_new_tab_text_area_field1'] : '';
    $product->update_meta_data( 'costom_add_new_tab_text_area_field1', sanitize_text_field( $title ));
    $product->save();

    $super = isset( $_POST[ 'costom_add_new_tab_checkbox_field' ] ) && 'yes' === $_POST[ 'costom_add_new_tab_checkbox_field' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'costom_add_new_tab_checkbox_field', $super );

    
    $title = isset( $_POST['costom_add_new_tab_radio_button_field'] ) ? $_POST['costom_add_new_tab_radio_button_field'] : '';
    $product->update_meta_data( 'costom_add_new_tab_radio_button_field', sanitize_text_field( $title ));
    $product->save();

}
add_action('woocommerce_process_product_meta','woocommerce_save_custom_input_text_new_custom_tab_section_single_product');

/*Display*/
function woocommerce_display_custom_input_field_custom_tab_section(){
    global $post,$woocommerce,$product;
    echo "<br>";
    $product_id=get_the_ID();
    $input_value=get_post_meta($product_id,'my_custom_tab_input_text_field',true);
    if($input_value){
       echo "<b>Custom Tab Input : </b>";
       print_r($input_value);
    }
    echo "<br>";
    $select_value=get_post_meta($product_id,'costom_add_new_custom_tab_select_field',true);
    if($select_value){
       echo "<b>Custom Tab Input : </b>";
       print_r($select_value);
    }
    echo "<br>";
    $text_area_value=get_post_meta($product_id,'costom_add_new_tab_text_area_field1',true);
    if($text_area_value){
       echo "<b>Custom Tab Input : </b>";
       print_r($text_area_value);
    }
    echo "<br>";
    $checkbox_field=get_post_meta($product_id,'costom_add_new_tab_checkbox_field',true);
    if ($checkbox_field){
        echo "<b>Custom Tab Checkbox :</b>";
        print_r($checkbox_field);
    }
    echo "<br>";
    $radio_field=get_post_meta($product_id,'costom_add_new_tab_radio_button_field',true);
    if ($radio_field){
        echo "<b>Custom Tab Radio :</b>";
        print_r($radio_field);
    }
}
add_action('woocommerce_single_product_summary','woocommerce_display_custom_input_field_custom_tab_section');

/*Add Load More In Shop Page*/

// add_filter( 'loop_shop_per_page', 'my_remove_pagination', 20 );
 
// function my_remove_pagination( $cols ) {
 
// $cols = 90;
 
// return $cols;
 
// }

function mb_remove_sidebar() {
    return false;
}

add_filter( 'is_active_sidebar', 'mb_remove_sidebar', 10, 2 );

// ******************************Load More Shop Page*****************************************************************
/*This Shortcode is Added in loop/pagination.php*/
add_shortcode('load_more_product','load_more_product_function');

function load_more_product_function(){
   //global $wp_query;

   ?>

    <div class="btn-group text-center">
        <button class="btn btn-primary load_more">Load More</button>
    </div>
    <?php
}
add_action('wp_footer','js_add_for_loadmore_ooter');

function js_add_for_loadmore_ooter(){
    ?>
   <script type="text/javascript"> 
    jQuery(document).ready(function($) {
        pod_page=4;    

        //pod_page="<?php echo ( get_query_var('paged') ) ? get_query_var('paged') : 1; ?>";
        var total_product_post_count="<?php echo ceil(wp_count_posts( 'product' )->publish/4);  ?>";
        var ajx_url='<?php echo admin_url('admin-ajax.php'); ?>';

        jQuery('.load_more').on('click',function(){
          //alert(total_product_post_count);
            jQuery.ajax({
              url: ajx_url,
              type: 'POST',
              data: {
                'action': 'load_more_action',
                pod_page:pod_page

              },
              success: function(load_more_res) {
                jQuery('.products').append(load_more_res);
                if(total_product_post_count == pod_page){
                    jQuery('.load_more').hide();
                   }
                   pod_page++;
              },
            });
        })
    });    
  </script>

    <?php
}


add_action( 'wp_ajax_load_more_action','wp_ajax_load_more_action_function' );
add_action( 'wp_ajax_nopriv_load_more_action','wp_ajax_load_more_action_function');

function wp_ajax_load_more_action_function(){
    $pod_page_aj=$_POST['pod_page'];
    
    $post_id[] = $post->ID;
    $pod_load_arg = array(
         'post_type'=>'product',
         'posts_per_page' => 4,
         'paged'=>$pod_page_aj,
         'orderby' => 'post_date',
         'order' => 'DESC',
    );
    $podcast_load_posts=new WP_Query($pod_load_arg);
    echo '<div class="main-blog-box row">';     
    if($podcast_load_posts->have_posts()){
        while($podcast_load_posts->have_posts()){
            $podcast_load_posts->the_post();
            wc_get_template_part( 'content', 'product' );  
        }
        wp_reset_postdata();
    }
    echo '</div> ';
    die();
}

/*** Custom Hook******/

add_action('woocommerce_custom_filter_shop_loop','woocommerce_custom_filter_shop_loop_function');

function woocommerce_custom_filter_shop_loop_function(){
  ?>
  <select class="form-select" id="custom_filter">
      <option value="all_products">All Products</option>
      <option value="letest">Sort By Latest</option>
      <option value="low_to_high">Price(Low to High)</option>
      <option value="high_to_low">Price(High to High)</option>  
      <option value="featured">Featured Products</option>      
  </select>
    <?php 
}

add_action('wp_footer','custom_filter_function');

function custom_filter_function(){
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#custom_filter').on('change',function(){
                var filterval= jQuery('#custom_filter').val();
                var ajax_url="<?php echo admin_url('admin-ajax.php'); ?>";

                if (filterval=='all_products') {
                    jQuery(".load_more").css("display", "block");
                }else{
                    jQuery(".load_more").css("display", "none");
                }
                
                jQuery.ajax({
                  url: ajax_url,
                  type: 'POST',
                  data: {
                    'action': 'custom_product_filter',
                    filterval : filterval,
                  },
                  success: function(filter_response) {
                   jQuery('.products').html(filter_response);
                    //jQuery('.products').append(filter_response);
                  },
                });
            })
        })
    </script>
    <?php
}


add_action( 'wp_ajax_custom_product_filter', 'custom_product_filter_function' );
add_action( 'wp_ajax_nopriv_custom_product_filter', 'custom_product_filter_function' );

function custom_product_filter_function(){
    $filter=$_POST['filterval'];

    if ($filter=='all_products') {
        
        $pod_load_arg = array(
             'post_type'=>'product',
             'posts_per_page' => 13,
             'orderby' => 'post_date',
             'order' => 'DESC',
        );
        $podcast_load_posts=new WP_Query($pod_load_arg);
        echo '<div class="main-blog-box row">';     
        if($podcast_load_posts->have_posts()){
            while($podcast_load_posts->have_posts()){
                $podcast_load_posts->the_post();
                wc_get_template_part( 'content', 'product' );  
            }
            wp_reset_postdata();
        }
        echo '</div> ';
        die();
    }
    if ($filter=='letest') {
       
       $pod_load_arg = array(
             'post_type'=>'product',
             'posts_per_page' => -1,             
             'orderby' => 'post_date',
             'order' => 'DESC',
        );
        $podcast_load_posts=new WP_Query($pod_load_arg);
        echo '<div class="main-blog-box row">';     
        if($podcast_load_posts->have_posts()){
            while($podcast_load_posts->have_posts()){
                $podcast_load_posts->the_post();
                wc_get_template_part( 'content', 'product' );  
            }
            wp_reset_postdata();
        }
        echo '</div> '; 
        die();
    }
    if ($filter=='low_to_high'){
        $pod_load_arg = array(
             'post_type'=>'product',
             'posts_per_page' => -1,
             'meta_key' => '_price',
             'orderby' => 'meta_value_num',   //price metakey is '_price' !
             'order' => 'asc'
             // 'orderby' => 'post_date',
             // 'order' => 'DESC',
             // 'meta_query' => array(
             //    // 'relation' => 'OR',
             //        array(
             //            array(
             //                'meta_key' => '_price',
             //                'value' => 13,
             //                'orderby'=>'_price',
             //                'order'=>'asc'
                            
             //            ),
             //        ),
             // ),
        );
        $podcast_load_posts=new WP_Query($pod_load_arg);
         echo '<div class="main-blog-box row">';     
        if($podcast_load_posts->have_posts()){
            while($podcast_load_posts->have_posts()){
                $podcast_load_posts->the_post();
                wc_get_template_part( 'content', 'product' );  
            }
            wp_reset_postdata();
        }
        echo '</div> '; 
        die();
    }
    if ($filter=='high_to_low'){
        $pod_load_arg = array(
             'post_type'=>'product',
             'posts_per_page' => -1,
             'meta_key' => '_price',
             'orderby' => 'meta_value_num',   //price metakey is '_price' !
             'order' => 'DESC'
        );
        $podcast_load_posts=new WP_Query($pod_load_arg);
         echo '<div class="main-blog-box row">';     
        if($podcast_load_posts->have_posts()){
            while($podcast_load_posts->have_posts()){
                $podcast_load_posts->the_post();
                wc_get_template_part( 'content', 'product' );  
            }
            wp_reset_postdata();
        }
        echo '</div> '; 
        die();
    }
    if ($filter=='featured'){
        //echo do_shortcode('[featured_products]');
        $pod_load_arg = array(
            'post_type' => 'product',
            'posts_per_page'      => -1,
            'tax_query' => array(
          //'relation' => 'AND',
                array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
                'operator' => 'IN',
                ),
          ),
        );
        $podcast_load_posts=new WP_Query($pod_load_arg);
         echo '<div class="main-blog-box row">';     
        if($podcast_load_posts->have_posts()){
            while($podcast_load_posts->have_posts()){
                $podcast_load_posts->the_post();
                wc_get_template_part( 'content', 'product' );  
            }
            wp_reset_postdata();
        }
        echo '</div> '; 
        die();
    }
    die();
}

/*Redirect on Cart Page from Shop Page*/
add_filter('woocommerce_add_to_cart_redirect', 'change_woocommerce_add_to_cart_redirect_url');
function change_woocommerce_add_to_cart_redirect_url($url){
    echo $url = wc_get_cart_url();
    return $url;
}