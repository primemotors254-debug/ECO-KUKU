<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<header class="site-header"><div class="container header-inner">
<a class="site-branding" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Eco Kuku home">
<?php if(has_custom_logo()){the_custom_logo();}else{ ?><span class="brand-mark">EK</span><span>ECO KUKU</span><?php } ?>
</a>
<button class="mobile-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">Menu</button>
<nav class="main-navigation" id="primary-menu" aria-label="Primary navigation"><?php wp_nav_menu(array('theme_location'=>'primary','container'=>false,'fallback_cb'=>'ecokuku_fallback_menu')); ?></nav>
<?php echo ecokuku_whatsapp_link('Hello Eco Kuku, I would like to make an enquiry.','Talk to us','header-cta'); ?>
</div></header>
