<?php get_header(); ?>
<main>
<section class="hero"><div class="container hero-grid"><div>
<p class="eyebrow">Poultry farming · Done better</p><h1>Everything your poultry farm needs.</h1>
<p class="hero-copy">Explore poultry products, practical farming information and equipment selected to support your next step in poultry farming.</p>
<div class="hero-actions"><a class="button" href="<?php echo esc_url(home_url('/shop/')); ?>">Explore the shop ↗</a><a class="button button-outline" href="<?php echo esc_url(home_url('/about/')); ?>">Our story</a></div>
</div><div class="hero-image"><?php $hero=get_theme_mod('ecokuku_hero_image'); if($hero): ?><img src="<?php echo esc_url($hero); ?>" alt="Poultry farming at Eco Kuku"><?php else: ?><div class="image-placeholder"><div><strong>ADD A REAL ECO KUKU FARM PHOTO</strong><br><span>Appearance → Customize → Eco Kuku Contact Details</span></div></div><?php endif; ?></div></div></section>
<section class="trust-band"><div class="container trust-inner"><div class="trust-item">✓ Clear product information</div><div class="trust-item">✓ Direct WhatsApp enquiries</div><div class="trust-item">✓ Practical farming knowledge</div></div></section>
<section class="section"><div class="container"><div class="section-heading"><div><p class="eyebrow" style="color:#9b6a2c">Find what you need</p><h2>Shop by category</h2><p>Explore products and tools that fit your poultry operation.</p></div><a href="<?php echo esc_url(home_url('/shop/')); ?>">View all products ↗</a></div>
<div class="category-grid">
<a class="category-card" href="<?php echo esc_url(home_url('/shop/')); ?>"><img loading="lazy" src="https://images.unsplash.com/photo-1585355611267-1f2a7c1d0b30?auto=format&fit=crop&w=800&q=80" alt="Egg incubators"><div class="category-copy"><h3>Egg incubators</h3><p>Equipment for hatching operations</p></div></a>
<a class="category-card" href="<?php echo esc_url(home_url('/shop/')); ?>"><img loading="lazy" src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&w=800&q=80" alt="Day-old chicks"><div class="category-copy"><h3>Day-old chicks</h3><p>Plan your next poultry batch</p></div></a>
<a class="category-card" href="<?php echo esc_url(home_url('/shop/')); ?>"><img loading="lazy" src="https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=800&q=80" alt="Poultry equipment"><div class="category-copy"><h3>Poultry equipment</h3><p>Tools for everyday farm work</p></div></a>
<a class="category-card" href="<?php echo esc_url(home_url('/poultry-farming/')); ?>"><img loading="lazy" src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80" alt="Poultry farming guides"><div class="category-copy"><h3>Farming guides</h3><p>Learn and plan with confidence</p></div></a>
</div></div></section>
<?php if(class_exists('WooCommerce')): ?><section class="section section-cream"><div class="container"><div class="section-heading"><div><p class="eyebrow" style="color:#9b6a2c">From the catalogue</p><h2>Featured products</h2><p>Add your products in WooCommerce and mark selected items as featured.</p></div><a href="<?php echo esc_url(home_url('/shop/')); ?>">Browse shop ↗</a></div><?php echo do_shortcode('[products limit="4" columns="4" visibility="featured"]'); ?></div></section><?php endif; ?>
<section class="section"><div class="container"><div class="section-heading"><div><p class="eyebrow" style="color:#9b6a2c">Built around real farm needs</p><h2>More than a product catalogue</h2></div></div><div class="feature-grid">
<article class="feature"><div class="feature-icon">↗</div><h3>Choose with confidence</h3><p>Read clear product details and specifications before enquiring.</p></article>
<article class="feature"><div class="feature-icon">✳</div><h3>Learn as you grow</h3><p>Find practical information for poultry farmers and keepers.</p></article>
<article class="feature"><div class="feature-icon">✆</div><h3>Talk to our team</h3><p>Ask questions and place product enquiries directly through WhatsApp.</p></article>
</div></div></section>
<section class="section section-cream"><div class="container"><div class="cta-panel"><div><h2>Need help choosing a product?</h2><p>Ask us about specifications, availability and delivery.</p></div><?php echo ecokuku_whatsapp_link('Hello Eco Kuku, I would like to enquire about your poultry products.','Enquire on WhatsApp ↗','button'); ?></div></div></section>
</main><?php get_footer(); ?>
