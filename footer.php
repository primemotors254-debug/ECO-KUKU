<footer class="site-footer"><div class="container"><div class="footer-grid">
<div><a class="site-branding" href="<?php echo esc_url(home_url('/')); ?>" style="color:#fff"><span class="brand-mark">EK</span><span>ECO KUKU</span></a><p>Practical poultry products and farming information to help farmers make informed decisions.</p></div>
<div><h3>Explore</h3><ul><li><a href="<?php echo esc_url(home_url('/shop/')); ?>">Shop products</a></li><li><a href="<?php echo esc_url(home_url('/poultry-farming/')); ?>">Poultry farming guides</a></li><li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Eco Kuku</a></li></ul></div>
<div><h3>Contact</h3><ul><?php $phone=get_theme_mod('ecokuku_phone'); $email=get_theme_mod('ecokuku_email'); $location=get_theme_mod('ecokuku_location'); ?>
<?php if($phone): ?><li><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','',$phone)); ?>"><?php echo esc_html($phone); ?></a></li><?php endif; ?>
<?php if($email): ?><li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li><?php endif; ?>
<?php if($location): ?><li><?php echo esc_html($location); ?></li><?php endif; ?>
<?php if(!$phone&&!$email&&!$location): ?><li>Add business details in Appearance → Customize → Eco Kuku Contact Details.</li><?php endif; ?></ul></div>
</div><div class="footer-bottom">© <?php echo esc_html(date('Y')); ?> Eco Kuku. All rights reserved.</div></div></footer>
<?php $wa=ecokuku_whatsapp_url('Hello Eco Kuku, I have an enquiry.'); if($wa): ?><a class="whatsapp-float" href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener noreferrer">WhatsApp Eco Kuku ↗</a><?php endif; ?>
<?php wp_footer(); ?></body></html>
