<?php
   if ( ! isset( $content_width ) )
   	$content_width = 525; 
   if ( ! function_exists( 'vdtheme_setup' ) ):
   function vdtheme_setup() {
   if ( ! function_exists( 'vdtheme_content_nav' ) ) :
   function vdtheme_content_nav( $nav_id ) {
   	global $wp_query, $post;
   	   	if ( is_single() ) {
   		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
   		$next = get_adjacent_post( false, '', false );
   		if ( ! $next && ! $previous )
   			return;
   	}
   	   	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
   		return;
   	$nav_class = 'site-navigation paging-navigation';
   	if ( is_single() )
   		$nav_class = 'site-navigation post-navigation';
   	?> 
<nav class=<?php echo $nav_class; ?> id="<?php echo $nav_id; ?>"role=navigation>
   <h1 class=assistive-text><?php _e( 'Post navigation', 'vdtheme' ); ?></h1>
   <?php if ( is_single() ) : ?> <?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'vdtheme' ) . '</span> %title' ); ?> <?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'vdtheme' ) . '</span>' ); ?> <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?> <?php if ( get_next_posts_link() ) : ?> 
   <div class=nav-previous><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'vdtheme' ) ); ?></div>
   <?php endif; ?> <?php if ( get_previous_posts_link() ) : ?> 
   <div class=nav-next><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'vdtheme' ) ); ?></div>
   <?php endif; ?> <?php endif; ?> 
</nav>
<?php
   }
   endif;    if ( ! function_exists( 'vdtheme_comment' ) ) :
   function vdtheme_comment( $comment, $args, $depth ) {
   	$GLOBALS['comment'] = $comment;
   	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?> 
<li class="pingback post">
   <p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'vdtheme' ), ' ' ); ?></p>
   <?php else : ?> 
<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?> >
   <article class=comment id="comment-<?php comment_ID(); ?>">
      <footer>
         <div class="comment-author vcard"> <?php echo get_avatar( $comment, 40 ); ?> <?php printf( __( '%s <span class="says">says:</span>', 'vdtheme' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?> </div>
         <?php if ( $comment->comment_approved == '0' ) : ?> <em><?php _e( 'Your comment is awaiting moderation.', 'vdtheme' ); ?></em><br> <?php endif; ?> 
         <div class="comment-meta commentmetadata"><a href=<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>><time datetime="<?php comment_time( 'c' ); ?>"pubdate> <?php
            printf( __( '%1$s at %2$s', 'vdtheme' ), get_comment_date(), get_comment_time() ); ?> </time></a> <?php edit_comment_link( __( '(Edit)', 'vdtheme' ), ' ' );
            ?> </div>
      </footer>
      <div class=comment-content><?php comment_text(); ?></div>
      <div class=reply> <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?> </div>
   </article>
   <?php
      endif;
      }
      endif;       if ( ! function_exists( 'vdtheme_posted_on' ) ) :
      function vdtheme_posted_on() {
      printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'vdtheme' ) . '.',
      	esc_url( get_permalink() ),
      	esc_attr( get_the_time() ),
      	esc_attr( get_the_date( 'c' ) ),
      	esc_html( get_the_date() ),
      	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      	esc_attr( sprintf( __( 'View all posts by %s', 'vdtheme' ), get_the_author() ) ),
      	esc_html( get_the_author() )
      );
      }
      endif;
      function vdtheme_categorized_blog() {
      if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
      	      	$all_the_cool_cats = get_categories( array(
      		'hide_empty' => 1,
      	) );
      	      	$all_the_cool_cats = count( $all_the_cool_cats );
      	set_transient( 'all_the_cool_cats', $all_the_cool_cats );
      }
      if ( '1' != $all_the_cool_cats ) {
      	      	return true;
      } else {
      	      	return false;
      }
      }
      function vdtheme_category_transient_flusher() {
            delete_transient( 'all_the_cool_cats' );
      }
      add_action( 'edit_category', 'vdtheme_category_transient_flusher' );
      add_action( 'save_post', 'vdtheme_category_transient_flusher' );
      function vdtheme_wp_title( $title, $sep ) {
      global $page, $paged;
      if ( is_feed() )
      	return $title;
            $title .= get_bloginfo( 'name' );
            $site_description = get_bloginfo( 'description', 'display' );
      if ( $site_description && ( is_home() || is_front_page() ) )
      	$title .= " $sep $site_description";
            if ( $paged >= 2 || $page >= 2 )
      	$title .= " $sep " . sprintf( __( 'Page %s', 'vdtheme' ), max( $paged, $page ) );
      return $title;
      }
      add_filter( 'wp_title', 'vdtheme_wp_title', 10, 2 );
      load_theme_textdomain( 'vdtheme', get_template_directory() . '/languages' );
      add_theme_support( 'automatic-feed-links' );
      add_theme_support( 'custom-background' );
      add_editor_style();
      register_nav_menus( array(
      	'primary' => __( 'Primary Menu', 'vdtheme' ),
      ) );
      add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'chat', 'image', 'video' ) );
      add_theme_support( 'infinite-scroll', array(
      	'footer' => 'page',
      ) );
      }
      endif;       add_action( 'after_setup_theme', 'vdtheme_setup' );
      function vdtheme_widgets_init() {
      register_sidebar( array(
      	'name'          => __( 'Sidebar', 'vdtheme' ),
      	'id'            => 'sidebar-1',
      	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      	'after_widget'  => '</aside>',
      	'before_title'  => '<h1 class="widget-title">',
      	'after_title'   => '</h1>',
      ) );
      }
      add_action( 'widgets_init', 'vdtheme_widgets_init' );
      function vdtheme_scripts() {
      global $post;
      wp_enqueue_style( 'vdtheme-style', get_stylesheet_uri() );
      wp_enqueue_style( 'vdtheme-min-css', get_template_directory_uri() . '/css/vdt.css' );
      wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );
      if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      	wp_enqueue_script( 'comment-reply' );
      }
      if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
      	wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
      }
      }
      add_action( 'wp_enqueue_scripts', 'vdtheme_scripts' );
      function vdtheme_footer_credits() {
      echo vdtheme_get_footer_credits();
      }
      add_action( 'vdtheme_credits', 'vdtheme_footer_credits' );
      function vdtheme_get_footer_credits( $credits = '' ) {
      return sprintf(
      	'%1$s %2$s',
      	'<a href="' . esc_url( __( 'http://wordpress.org/', 'vdtheme' ) ) . '" rel="generator">' . __( 'Proudly powered by WordPress', 'vdtheme' ) . '</a>',
      	sprintf( __( 'Theme: %1$s by %2$s.', 'vdtheme' ), 'vdtheme', '<a href="http://saran.ga/" rel="designer">Saran</a>' )
      );
      }
      add_filter( 'infinite_scroll_credit', 'vdtheme_get_footer_credits' );
      function vdtheme_post_format_title( $title, $post_id = false ) {
      if ( ! $post_id )
      	return $title;
      $post = get_post( $post_id );
            if ( ! $post || $post->post_type != 'post' )
      	return $title;
      if ( is_single() && (bool) get_post_format( $post ) )
      	$title = sprintf( '<span class="entry-format">%1$s: </span>%2$s', get_post_format_string( get_post_format( $post ) ), $title );
      return $title;
      }
      add_filter( 'the_title', 'vdtheme_post_format_title', 10, 2 );
      function vdtheme_custom_header_setup() {
      $args = array(
      	'default-image'          => vdtheme_get_default_header_image(),
      	'width'                  => 100,
      	'height'                 => 100,
      	'flex-width'             => true,
      	'flex-height'            => true,
      	'header-text'            => false,
      	'default-text-color'     => '',
      	'wp-head-callback'       => '',
      	'admin-head-callback'    => '',
      	'admin-preview-callback' => '',
      );
      $args = apply_filters( 'vdtheme_custom_header_args', $args );
      if ( function_exists( 'wp_get_theme' ) ) {
      	add_theme_support( 'custom-header', $args );
      } else {
      	      	define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
      	define( 'HEADER_IMAGE',        $args['default-image'] );
      	define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
      	define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
      	add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
      }
      }
      add_action( 'after_setup_theme', 'vdtheme_custom_header_setup' );
      function vdtheme_get_default_header_image() {
            $default = get_option( 'avatar_default', 'mystery' );       if ( 'mystery' == $default )
      	$default = 'mm';
      elseif ( 'gravatar_default' == $default )
      	$default = '';
      $url = ( is_ssl() ) ? 'https://secure.gravatar.com' : 'http://gravatar.com';
      $url .= sprintf( '/avatar/%s/', md5( get_option( 'admin_email' ) ) );
      $url = add_query_arg( array(
      	's' => 100,
      	'd' => urlencode( $default ),
      ), $url );
      return esc_url_raw( $url );
      }       ?>