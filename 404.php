<?php
   get_header(); ?> 
<div class=content-area id=primary>
   <div class=site-content id=content role=main>
      <article class="error404 not-found post"id=post-0>
         <header class=entry-header>
            <h1 class=entry-title><?php _e( 'This page isn\'t available. Sorry about that.', 'vdtheme' ); ?></h1>
         </header>
         <div class=entry-content>
            <p><?php _e( 'Try searching for something else.', 'vdtheme' ); ?></p>
            <?php get_search_form(); ?> <?php the_widget( 'WP_Widget_Recent_Posts' ); ?> 
            <div class=widget>
               <h2 class=widgettitle><?php _e( 'Most Used Categories', 'vdtheme' ); ?></h2>
               <ul> <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?> </ul>
            </div>
            
         </div>
      </article>
   </div>
</div>
<?php get_footer(); ?>
