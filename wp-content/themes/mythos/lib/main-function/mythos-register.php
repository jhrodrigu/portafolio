<?php
/* -------------------------------------------- *
 * Mythos Widget
 * -------------------------------------------- */
if(!function_exists('mythos_widdget_init')):

    function mythos_widdget_init()
    {
        register_sidebar(array(
                'name'          => esc_html__( 'Sidebar', 'mythos' ),
                'id'            => 'sidebar',
                'description'   => esc_html__( 'Widgets in this area will be shown on Sidebar.', 'mythos' ),
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>',
                'before_widget' => '<div id="%1$s" class="widget %2$s" >',
                'after_widget'  => '</div>'
            )
        );

        register_sidebar(array(
                'name'          => esc_html__( 'Bottom 1', 'mythos' ),
                'id'            => 'bottom1',
                'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 1.' , 'mythos'),
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
                'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
                'after_widget'  => '</div></div>'
            )
        );

        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 2', 'mythos' ),
            'id'            => 'bottom2',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 2.' , 'mythos'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );

        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 3', 'mythos' ),
            'id'            => 'bottom3',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 3.' , 'mythos'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );
        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 4', 'mythos' ),
            'id'            => 'bottom4',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 4.' , 'mythos'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );
    }

    add_action('widgets_init','mythos_widdget_init');

endif;


# Google Font
if ( ! function_exists( 'mythos_fonts_url' ) ) :
    function mythos_fonts_url() {
    $fonts_url = '';

    $open_sans = _x( 'on', 'Open Sans font: on or off', 'mythos' );
     
    if ( 'off' !== $open_sans ) {
    $font_families = array();
     
    if ( 'off' !== $open_sans ) {
    $font_families[] = 'Open Sans:300,400,600,700,800';
    }
     
    $query_args = array(
    'family'  => urlencode( implode( '|', $font_families ) ),
    'subset'  => urlencode( 'latin' ),
    );
     
    $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
     
    return esc_url_raw( $fonts_url );
    }
endif;


/* -------------------------------------------- *
 * Mythos Style
 * -------------------------------------------- */
if(!function_exists('mythos_style')):

    function mythos_style(){
        wp_enqueue_style( 'default-google-font', '//fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700' );

        wp_enqueue_style( 'mythos-font', mythos_fonts_url(), array(), null );
        wp_enqueue_media(); 
        # CSS
        wp_enqueue_style( 'bootstrap.min', MYTHOS_CSS . 'bootstrap.min.css',false,'all');
        wp_enqueue_style( 'fontawesome.min', MYTHOS_CSS . 'fontawesome.min.css',false,'all');
        wp_enqueue_style( 'mythos-main', MYTHOS_CSS . 'main.css',false,'all');
        wp_enqueue_style( 'mythos-responsive', MYTHOS_CSS . 'responsive.css',false,'all');
        wp_enqueue_style( 'mythos-style',get_stylesheet_uri());
        wp_add_inline_style( 'mythos-style', mythos_css_generator() );
        # JS
        wp_enqueue_script('tether','https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js',array(),false,true);
        wp_enqueue_script('bootstrap',MYTHOS_JS.'bootstrap.min.js',array(),false,true);
        wp_enqueue_script('loopcounter',MYTHOS_JS.'loopcounter.js',array(),false,true);

        # Single Comments
        if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }
        wp_enqueue_script('mythos-main',MYTHOS_JS.'main.js',array(),false,true);
    }
    add_action('wp_enqueue_scripts','mythos_style');

endif;


function mythos_customize_control_js() {
    wp_enqueue_script( 'thmc-customizer', MYTHOS_URI.'lib/customizer/assets/js/customizer.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'mythos_customize_control_js' );


add_action('enqueue_block_editor_assets', 'mythos_action_enqueue_block_editor_assets');
function mythos_action_enqueue_block_editor_assets() {
    wp_enqueue_style( 'bootstrap-grid.min', MYTHOS_CSS . 'bootstrap-grid.min.css',false,'all');
    wp_enqueue_style( 'mythos-style', get_stylesheet_uri() );
    wp_enqueue_style( 'mythos-gutenberg-editor-styles', get_template_directory_uri() . '/css/style-editor.css', null, 'all' );
    wp_add_inline_style( 'mythos-style', mythos_css_generator() );
}

/* -------------------------------------------- *
 * TGM for Plugin activation
 * -------------------------------------------- */
add_action( 'tgmpa_register', 'mythos_plugins_include');

if(!function_exists('mythos_plugins_include')):

    function mythos_plugins_include()
    {
        $plugins = array(
                array(
                    'name'                  => esc_html__( 'Qubely', 'mythos' ),
                    'slug'                  => 'qubely',
                    'required'              => false,
                    'version'               => '',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => esc_url('https://downloads.wordpress.org/plugin/qubely.zip'),
                ),
                array(
                    'name'                  => esc_html__( 'WP Mega Menu', 'mythos' ),
                    'slug'                  => 'wp-megamenu',
                    'required'              => false,
                    'version'               => '',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => esc_url('https://downloads.wordpress.org/plugin/wp-megamenu.zip'),
                ),
                array(
                    'name'                  => esc_html__( 'MailChimp for WordPress', 'mythos' ),
                    'slug'                  => 'mailchimp-for-wp',
                    'required'              => false,
                ),     
            );
            $config = array(
                    'domain'            => 'mythos',
                    'default_path'      => '',
                    'menu'              => 'install-required-plugins',
                    'has_notices'       => true,
                    'dismissable'       => true, 
                    'dismiss_msg'       => '', 
                    'is_automatic'      => false,
                    'message'           => ''
            );
    tgmpa( $plugins, $config );
    }

endif;
