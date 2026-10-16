<?php
if (!defined('ABSPATH')) { exit; }

function ecokuku_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array('height'=>80,'width'=>240,'flex-height'=>true,'flex-width'=>true));
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    add_theme_support('woocommerce');
    register_nav_menus(array('primary'=>__('Primary Menu','eco-kuku'),'footer'=>__('Footer Menu','eco-kuku')));
}
add_action('after_setup_theme','ecokuku_setup');

function ecokuku_assets() {
    wp_enqueue_style('eco-kuku-style',get_stylesheet_uri(),array(),'1.0.0');
    wp_enqueue_script('eco-kuku-navigation',get_template_directory_uri().'/assets/js/navigation.js',array(),'1.0.0',true);
}
add_action('wp_enqueue_scripts','ecokuku_assets');

function ecokuku_customize_register($wp_customize) {
    $wp_customize->add_section('ecokuku_contact',array('title'=>__('Eco Kuku Contact Details','eco-kuku'),'priority'=>30));
    $fields=array(
        'ecokuku_whatsapp'=>array('WhatsApp number (international digits only)','2547XXXXXXXX'),
        'ecokuku_phone'=>array('Business phone number','+254 7XX XXX XXX'),
        'ecokuku_email'=>array('Business email','hello@example.co.ke'),
        'ecokuku_location'=>array('Business location','Kenya'),
        'ecokuku_hero_image'=>array('Homepage hero image URL','URL of your uploaded real farm photo')
    );
    foreach($fields as $id=>$details){
        $wp_customize->add_setting($id,array('default'=>'','sanitize_callback'=>$id==='ecokuku_hero_image'?'esc_url_raw':'sanitize_text_field'));
        $wp_customize->add_control($id,array('label'=>$details[0],'section'=>'ecokuku_contact','type'=>$id==='ecokuku_hero_image'?'url':'text','description'=>'Example: '.$details[1]));
    }
}
add_action('customize_register','ecokuku_customize_register');

function ecokuku_whatsapp_number() { return preg_replace('/[^0-9]/','',get_theme_mod('ecokuku_whatsapp','')); }
function ecokuku_whatsapp_url($message='') {
    $number=ecokuku_whatsapp_number();
    if(!$number) return '';
    return 'https://wa.me/'.$number.($message?'?text='.rawurlencode($message):'');
}
function ecokuku_whatsapp_link($message='',$label='Order on WhatsApp',$class='button') {
    $url=ecokuku_whatsapp_url($message);
    if(!$url) return '';
    return '<a class="'.esc_attr($class).'" target="_blank" rel="noopener noreferrer" href="'.esc_url($url).'">'.esc_html($label).'</a>';
}
function ecokuku_product_whatsapp_button() {
    if(!function_exists('is_product')||!is_product()) return;
    global $product;
    if(!$product) return;
    $message=sprintf('Hello Eco Kuku, I would like to enquire about %s. Product link: %s',$product->get_name(),get_permalink($product->get_id()));
    echo '<div style="margin:14px 0">'.ecokuku_whatsapp_link($message,'Enquire / Order on WhatsApp','button').'</div>';
}
add_action('woocommerce_after_add_to_cart_form','ecokuku_product_whatsapp_button',20);
function ecokuku_fallback_menu() {
    echo '<ul><li><a href="'.esc_url(home_url('/')).'">Home</a></li><li><a href="'.esc_url(home_url('/shop/')).'">Shop</a></li><li><a href="'.esc_url(home_url('/poultry-farming/')).'">Poultry Farming</a></li><li><a href="'.esc_url(home_url('/about/')).'">About Us</a></li><li><a href="'.esc_url(home_url('/contact/')).'">Contact</a></li></ul>';
}
