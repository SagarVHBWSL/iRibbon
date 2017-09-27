<?php
/**
 * Theme Functions
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category CyberChimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v3.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Load text domain.
function cyberchimps_text_domain() {
	load_theme_textdomain( 'iribbon', get_template_directory() . '/inc/languages' );
}
add_action( 'after_setup_theme', 'cyberchimps_text_domain' );

// Load Core
require_once( get_template_directory() . '/cyberchimps/init.php' );
require_once( get_template_directory() . '/inc/widget.php' );
require_once( get_template_directory() . '/inc/testimonial_template.php' );
require( get_template_directory() . '/inc/admin-about.php' );

function iribbon_enqueue()
{
    $directory_uri  = get_template_directory_uri();
    wp_enqueue_script( 'jquery-flexslider', $directory_uri . '/inc/js/jquery.flexslider.js', 'jquery', '', true );
}
add_action( 'wp_enqueue_scripts', 'iribbon_enqueue' );

// Set the content width based on the theme's design and stylesheet.
if( !isset( $content_width ) ) {
	$content_width = 640;
} /* pixels */

function cyberchimps_add_site_info() {
	?>
	<p>&copy; Company Name</p>
<?php
}

add_action( 'cyberchimps_site_info', 'cyberchimps_add_site_info' );

if( !function_exists( 'cyberchimps_comment' ) ) :
// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
	function cyberchimps_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
				<p><?php _e( 'Pingback:', 'iribbon' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'iribbon' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
					<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
						<footer>
							<div class="comment-author reviewer vcard">
								<?php echo get_avatar( $comment, 40 ); ?>
								<?php printf( '%1$s <span class="says">%2$s</span>', sprintf( '<cite class="fn">%1$s</cite>',
								                                                              get_comment_author_link() ),
								              __( 'says', 'iribbon' ) ); ?>
							</div>
							<!-- .comment-author .vcard -->
							<?php if( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'iribbon' ); ?></em>
								<br/>
							<?php endif; ?>

							<div class="comment-meta commentmetadata">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed">
									<time pubdate datetime="<?php comment_time( 'c' ); ?>">
										<?php
										/* translators: 1: date, 2: time */
										printf( __( '%1$s at %2$s', 'iribbon' ), get_comment_date(), get_comment_time() ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'iribbon' ), ' ' );
								?>
							</div>
							<!-- .comment-meta .commentmetadata -->
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
						<!-- .reply -->
					</article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif; // ends check for cyberchimps_comment()

// set up next and previous post links for lite themes only
function cyberchimps_next_previous_posts() {
	if( get_next_posts_link() || get_previous_posts_link() ): ?>
		<div class="more-content">
			<div class="row-fluid">
				<div class="span6 previous-post">
					<?php previous_posts_link(); ?>
				</div>
				<div class="span6 next-post">
					<?php next_posts_link(); ?>
				</div>
			</div>
		</div>
	<?php
	endif;
}

add_action( 'cyberchimps_after_content', 'cyberchimps_next_previous_posts' );

if( !function_exists( 'cyberchimps_theme_check' ) ) :
// core options customization Names and URL's
//Pro or Free has to stay prepended with cyberchimps_
	function cyberchimps_theme_check() {
		$level = 'free';

		return $level;
	}
endif;
//Theme Name
function cyberchimps_options_theme_name() {
	$text = 'iRibbon';

	return $text;
}

//Doc's URL
function cyberchimps_options_documentation_url() {
	$url = 'http://cyberchimps.com/guides/c-free/';

	return $url;
}

// Support Forum URL
function cyberchimps_options_support_forum() {
	$url = 'http://cyberchimps.com/forum/free/iribbon/';

	return $url;
}

add_filter( 'cyberchimps_current_theme_name', 'cyberchimps_options_theme_name', 1 );
add_filter( 'cyberchimps_documentation', 'cyberchimps_options_documentation_url' );
add_filter( 'cyberchimps_support_forum', 'cyberchimps_options_support_forum' );

//upgrade bar
function cyberchimps_upgrade_bar_pro_title() {
	$title = 'iRibbon Pro 2';

	return $title;
}

function cyberchimps_upgrade_link() {
	$link = 'http://cyberchimps.com/store/iribbon-pro/';

	return $link;
}

add_filter( 'cyberchimps_upgrade_pro_title', 'cyberchimps_upgrade_bar_pro_title' );
add_filter( 'cyberchimps_upgrade_link', 'cyberchimps_upgrade_link' );

// Help Section
function cyberchimps_options_help_header() {
	$text = 'iRibbon';

	return $text;
}

function cyberchimps_options_help_sub_header() {
	$text = __( 'iRibbon an elegant and responsive WordPress Theme', 'iribbon' );

	return $text;
}

add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );

// Branding images and defaults

// Banner default
function cyberchimps_banner_default() {
	$url = '/images/branding/banner.jpg';

	return $url;
}

add_filter( 'cyberchimps_banner_img', 'cyberchimps_banner_default' );

//theme specific skin options in array. Must always include option default
function cyberchimps_skin_color_options( $options ) {
	// Get path of image
	$imagepath = get_template_directory_uri() . '/inc/css/skins/images/';

	$options = array(
		'default' => $imagepath . 'default.png'
	);

	return $options;
}

add_filter( 'cyberchimps_skin_color', 'cyberchimps_skin_color_options', 1 );

// theme specific background images
function cyberchimps_background_image( $options ) {
	$imagepath = get_template_directory_uri() . '/cyberchimps/lib/images/';
	$options   = array(
		'none'  => $imagepath . 'backgrounds/thumbs/none.png',
		'noise' => $imagepath . 'backgrounds/thumbs/noise.png',
		'blue'  => $imagepath . 'backgrounds/thumbs/blue.png',
		'dark'  => $imagepath . 'backgrounds/thumbs/dark.png',
		'space' => $imagepath . 'backgrounds/thumbs/space.png'
	);

	return $options;
}

add_filter( 'cyberchimps_background_image', 'cyberchimps_background_image' );

// theme specific typography options
function cyberchimps_typography_sizes( $sizes ) {
	$sizes = array( '8', '9', '10', '12', '14', '16', '20' );

	return $sizes;
}

function cyberchimps_typography_faces( $faces ) {
	$faces = array(
		'Arial, Helvetica, sans-serif'                     => 'Arial',
		'Arial Black, Gadget, sans-serif'                  => 'Arial Black',
		'Comic Sans MS, cursive'                           => 'Comic Sans MS',
		'Courier New, monospace'                           => 'Courier New',
		'Georgia, serif'                                   => 'Georgia',
		'Impact, Charcoal, sans-serif'                     => 'Impact',
		'Lucida Console, Monaco, monospace'                => 'Lucida Console',
		'Lucida Sans Unicode, Lucida Grande, sans-serif'   => 'Lucida Sans Unicode',
		'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
		'Tahoma, Geneva, sans-serif'                       => 'Tahoma',
		'Times New Roman, Times, serif'                    => 'Times New Roman',
		'Trebuchet MS, sans-serif'                         => 'Trebuchet MS',
		'Verdana, Geneva, sans-serif'                      => 'Verdana',
		'Symbol'                                           => 'Symbol',
		'Webdings'                                         => 'Webdings',
		'Wingdings, Zapf Dingbats'                         => 'Wingdings',
		'MS Sans Serif, Geneva, sans-serif'                => 'MS Sans Serif',
		'MS Serif, New York, serif'                        => 'MS Serif',
	);

	return $faces;
}

function cyberchimps_typography_styles( $styles ) {
	$styles = array( 'normal' => 'Normal', 'bold' => 'Bold' );

	return $styles;
}

add_filter( 'cyberchimps_typography_sizes', 'cyberchimps_typography_sizes' );
add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces' );
add_filter( 'cyberchimps_typography_styles', 'cyberchimps_typography_styles' );

/**
 * Adds extra div container to sidebar widget title
 *
 * @param $title
 *
 * @return string
 */
function cyberchimps_sidebar_before_widget_title( $title ) {
	$title = '<div class="cc-widget-title-container">' . $title;

	return $title;
}

add_action( 'cyberchimps_sidebar_before_widget_title', 'cyberchimps_sidebar_before_widget_title', 10, 1 );

/**
 * Finished extra div container to sidebar widget title
 *
 * @param $title
 *
 * @return string
 */
function cyberchimps_sidebar_after_widget_title( $title ) {
	$title = $title . '</div>';

	return $title;
}

add_action( 'cyberchimps_sidebar_after_widget_title', 'cyberchimps_sidebar_after_widget_title', 10, 1 );

// Set separator for post entry meta.
function cyberchimps_entry_meta_sep() {
	return '.';
}

add_filter( 'cyberchimps_entry_meta_sep', 'cyberchimps_entry_meta_sep' );

// Customize widget element before_title markup.
function cyberchimps_before_widget_title( $title ) {

	$before_title = '<div class="cc-widget-title-container">';

	$title = $before_title . $title;

	return $title;
}

add_filter( 'cyberchimps_before_widget_title', 'cyberchimps_before_widget_title', 10, 1 );

// Customize widget element after_title markup.
function cyberchimps_after_widget_title( $title ) {

	$after_title = '</div>';

	$title = $title . $after_title;

	return $title;
}

add_filter( 'cyberchimps_after_widget_title', 'cyberchimps_after_widget_title', 10, 1 );

function cyberchimps_after_widget( $after ) {
	$after_widget = '<div class="ribbon-bottom-container"><div class="ribbon-bottom"></div></div>';

	$after = $after_widget . $after;

	return $after;
}

add_action( 'cyberchimps_after_widget', 'cyberchimps_after_widget', 10, 1 );

// Add goggle font Lobster.
function cyberchimps_add_google_font() {

	// Check if SSL is present, if so then use https othereise use http
	$protocol = is_ssl() ? 'https' : 'http';
	?>
	<link rel='stylesheet' href='<?php echo $protocol; ?>://fonts.googleapis.com/css?family=Lobster' type='text/css'>
<?php
}

add_action( 'wp_head', 'cyberchimps_add_google_font' );

// enabling theme support for title tag
function iribbon_title_setup() 
{
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'iribbon_title_setup' );


//add header drag and drop options
function cyberchimps_add_header_drag_and_drop_options() {
	$options = array(
		'cyberchimps_logo_description'  => __( 'Logo + Description', 'iribbon' ),
		'cyberchimps_header_content'    => __( 'Logo + Icons', 'iribbon' ),
		'cyberchimps_logo_search'       => __( 'Logo + Search', 'iribbon' ),
		'cyberchimps_logo'              => __( 'Logo', 'iribbon' ),
                'cyberchimps_sitename_contact'  => __( 'Logo + Contact', 'iribbon' ),
	);

	return $options;
}

add_filter( 'header_drag_and_drop_options', 'cyberchimps_add_header_drag_and_drop_options', 10 );


function iRibbon_add_icon_theme_options( $fields_list ) {

	$imagepath = get_template_directory_uri() . '/images/ribbons/';

// Snapchat
	$fields_list[] = array(
		'name'    => __( 'Snapchat', 'cyberchimps_core' ),
		'id'      => 'social_snapchat',
		'type'    => 'toggle',
		'section' => 'cyberchimps_header_social_section',
		'heading' => 'cyberchimps_header_heading'
	);

	$fields_list[] = array(
		'name'    => __( 'Snapchat URL', 'cyberchimps_core' ),
		'id'      => 'snapchat_url',
		'class'   => 'social_snapchat_toggle',
		'std'     => 'https://snapchat.com/add/',
		'type'    => 'text',
		'section' => 'cyberchimps_header_social_section',
		'heading' => 'cyberchimps_header_heading'
	);

	// ribbon style option.
	$fields_list[] = array(
		'name'    => __( 'Choose your ribbon style for menu', 'cyberchimps_core' ),
		'id'      => 'ribbon_style',
		'std'     => 'default',
		'type'    => 'images',
		'options' => apply_filters( 'cyberchimps_ribbon_style_options', array(
			'default' => $imagepath . 'ribbon-default.png',
			'dashed'  => $imagepath . 'ribbon-dashed.png'
		) ),
		'section' => 'cyberchimps_header_options_section',
		'heading' => 'cyberchimps_header_heading'
	);

	return apply_filters( 'cyberchimps_field_filter', $fields_list );
}

add_filter( 'cyberchimps_field_list', 'iRibbon_add_icon_theme_options', 20 );

add_action( 'customize_register', 'iRibbon_add_icon_customizer', 20 );
function iRibbon_add_icon_customizer( $wp_customize )
{

	$imagepath = get_template_directory_uri() . '/images/ribbons/';

// Add Snapchat Setting
    $wp_customize->add_setting( 'cyberchimps_options[social_snapchat]', array(
        'sanitize_callback' => 'cyberchimps_sanitize_checkbox',
        'type' => 'option'
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'social_snapchat', array(
        'label' => __( 'Display Snapchat?', 'cyberchimps_core' ),
        'section' => 'cyberchimps_social_media',
        'settings' => 'cyberchimps_options[social_snapchat]',
        'type' => 'checkbox'
    ) ) );
    $wp_customize->add_setting( 'cyberchimps_options[snapchat_url]', array(
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option'
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'snapchat_url', array(
        'label' => __( 'Snapchat URL', 'cyberchimps_core' ),
        'section' => 'cyberchimps_social_media',
        'settings' => 'cyberchimps_options[snapchat_url]'
    ) ) );

	// ribbon style option.
	$ribbon_styles = apply_filters( 'cyberchimps_ribbon_style_options', array(
        'default' => $imagepath . 'ribbon-default.png',
        'dashed' => $imagepath . 'ribbon-dashed.png'
            ) );
	$wp_customize->add_setting( 'cyberchimps_options[ribbon_style]', array(
            'default' => 'default',
            'type' => 'option',
            'sanitize_callback' => 'cyberchimps_text_sanitization'
        ) );

        $wp_customize->add_control( new Cyberchimps_skin_selector( $wp_customize, 'ribbon_style', array(
            'label' => __( 'Choose your ribbon style for menu', 'cyberchimps_core' ),
            'section' => 'cyberchimps_header_section',
            'settings' => 'cyberchimps_options[ribbon_style]',
            'choices' => $ribbon_styles,
        ) ) );
}

function iRibbon_customize_register( $wp_customize ) {
   $wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
   $wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';

   $wp_customize->selective_refresh->add_partial( 'blogname', array(
'selector' => '.site-title a',
) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.blog-description p',
	) );

	$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[primary]', array(
		'selector' => '.navbar-inner',
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[footer_copyright_text]', array(
		'selector' => '#copyright',
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[theme_backgrounds]', array(
		'selector' => '#social',
	) );

	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[sidebar_images]', array(
		'selector' => '#content',
	) );
	
	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[custom_logo]', array(
		'selector' => '#logo',
	) );
		
	$wp_customize->selective_refresh->add_partial( 'cyberchimps_options[searchbar]', array(
		'selector' => '#navigation #searchform',
	) );

}
function iRibbon_customize_partial_blogname() {
bloginfo( 'name' );
}

function iRibbon_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

add_action( 'customize_register', 'iRibbon_customize_register', 30 );
add_theme_support( 'customize-selective-refresh-widgets' );
add_action( 'admin_notices', 'my_admin_notice' );
function my_admin_notice(){

	$admin_check_screen = get_admin_page_title();

	if( !class_exists('SlideDeckPlugin') )
	{
	$plugin='slidedeck/slidedeck.php';
	$slug = 'slidedeck';
	$installed_plugins = get_plugins();

	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
			<?php if( isset( $installed_plugins[$plugin] ) )
			{
			?>
				 <a href="<?php echo admin_url( 'plugins.php' ); ?>">Activate the SlideDeck Lite plugin</a>
			 <?php
			}
			else
			{
			 ?>
			 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the SlideDeck Lite plugin</a>
			 <?php } ?>

		</p>
		</div>
		<?php
	}
	}

	if( !class_exists('WPForms') )
	{
	$plugin = 'wpforms-lite/wpforms.php';
	$slug = 'wpforms-lite';
	$installed_plugins = get_plugins();
	 if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
		?>
		<div class="notice notice-info is-dismissible" style="margin-top:15px;">
		<p>
			<?php if( isset( $installed_plugins[$plugin] ) )
			{
			?>
				 <a href="<?php echo admin_url( 'plugins.php' ); ?>">Activate the WPForms Lite plugin</a>
			 <?php
			}
			else
			{
			 ?>
	 		 <a href="<?php echo wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ), 'install-plugin_' . $slug ); ?>">Install the WP Forms Lite plugin</a>
			 <?php } ?>
		</p>
		</div>
		<?php
	}
	}

	if ( $admin_check_screen == 'Manage Themes' || $admin_check_screen == 'Theme Options Page' )
	{
	?>
		<div class="notice notice-success is-dismissible">
				<b><p>Liked this theme? <a href="https://wordpress.org/support/theme/iribbon/reviews/#new-post" target="_blank">Leave us</a> a ***** rating. Thank you! </p></b>
		</div>
		<?php
	}
	
}
function iribbon_set_defaults()
{

remove_action('testimonial', array( CyberChimpsTestimonial::instance(), 'render_display' ));
add_action('testimonial', 'iribbon_testimonial_render_display');  
}
add_action( 'init', 'iribbon_set_defaults' );

add_action( 'wp_enqueue_scripts', 'iribbon_ribbon_styles', 30 );
/** 
 * Add styles for ribbon selection
 */
function iribbon_ribbon_styles() {
	$ribbon_style = cyberchimps_get_option( 'ribbon_style' );
	if( $ribbon_style != 'default' ) {
		wp_enqueue_style( 'ribbon-style', get_template_directory_uri() . '/inc/css/ribbons/' . $ribbon_style . '.css', array( 'style' ), '1.0' );
	}
}

add_filter( 'body_class', 'iribbon_ribbon_style_body_classes' );
/**
 * Add ribbon style selector classes to the body classes.
 *
 * @param array $classes Current body classes.
 */
function iribbon_ribbon_style_body_classes( array $classes ) {

	$ribbon_style_type = cyberchimps_get_option( 'ribbon_style' );

	if ( $ribbon_style_type )
		$classes[] = 'ribbon-'.$ribbon_style_type;

	return $classes;

}

add_action('wp_head', 'iribbon_check_searchbar');
/**
 * Function to check if searchbar is displayed in menu
 */
function iribbon_check_searchbar()
{
	$check_searchbar = cyberchimps_get_option('searchbar');
	if( $check_searchbar )
	{
		?>
		<style>
			@media all and (min-width:980px) {
				.ribbon-dashed .navbar .nav
				{
					float:left;
				}
			}
		</style>

		<?php
	}
}

/* To reduce the thumbnail size of the ribbon images */
add_action( 'admin_menu', 'ifeaturepro_modern_skin_css');
function ifeaturepro_modern_skin_css()
{
?>
<style>
#customize-control-ribbon_style img
{
    height: 50px;
}
</style>
<?php
}
