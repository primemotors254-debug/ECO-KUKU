<?php get_header(); ?><main class="page-content"><div class="container">
<?php if(have_posts()): if(is_home()&&!is_front_page()): ?><h1 class="content-heading"><?php single_post_title(); ?></h1><?php endif; while(have_posts()): the_post(); ?>
<article <?php post_class(); ?>><h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php if(has_post_thumbnail()): ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a><?php endif; ?><div class="entry-content"><?php the_excerpt(); ?></div></article><hr>
<?php endwhile; the_posts_pagination(); else: ?><h1>Welcome to Eco Kuku</h1><p>Published content will appear here.</p><?php endif; ?></div></main><?php get_footer(); ?>
