<?php

class Mythos_Dashboard {
    /**
	 * Mythos constructor
	 */
    public function __construct() {
        if ( is_admin() ) {
		    add_action('admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		    add_action('admin_menu', array( $this, 'theme_info' ));
        }
    }

	/**
	 * Enqueue scripts for admin page only: Theme info page
	 */
	function admin_scripts( $hook ) {
		if ( $hook === 'widgets.php' || $hook === 'appearance_page_ft_mythos'  ) {
			wp_enqueue_style( 'mythos-dashboard-css', get_template_directory_uri() . '/css/dashboard.css' );
		}
	}

	function theme_info() {
		$menu_title = "<span class='mythos-menu-item'>".esc_html__('Mythos Theme', 'mythos')."</span>";
		add_theme_page( esc_html__( 'Mythos Dashboard', 'mythos' ), $menu_title, 'edit_theme_options', 'ft_mythos', array( $this, 'theme_info_page' ));
	}

	function theme_info_page() {
		$theme_data = wp_get_theme('mythos');
		?>
        <div class="wrap about-wrap theme_info_wrapper thm-theme-dashboard-wrap">
            <div class="thm-getting-start">
                <div class="thm-theme-dashboard-container">
                    <h1 class="thm-theme-welcome-title">
                        <?php printf(wp_kses('Welcome to <strong>Mythos</strong> v%1s', 'mythos'), $theme_data->Version ); ?>
                    </h1>
                    <div class="thm-theme-dashboard-row">
                        <div class="thm-theme-dashboard-col thm-theme-dashboard-col-75">
                            <div class="thm-theme-dashboard-card">
                                <div class="thm-theme-about-text">
                                    <h3 class="thm-theme-title"><?php esc_html_e( 'Theme Overview', 'mythos' ); ?></h3>
                                    <?php printf(wp_kses( 'Mythos is the perfect WordPress multipurpose theme catered for business, eCommerce, and corporate sites. It’s beautifully <strong>built with Qubely</strong>, a revolutionary Gutenberg block toolkit, to create amazing websites in a snap. The theme improves conversion rate by grabbing an incredible amount of user attention. Mythos works great for professional showcasing of corporate firms, creative agencies, shops, and businesses of all scales.', 'mythos' )); ?>
                                    <div><a href="<?php echo admin_url('customize.php'); ?>#accordion-section-sub_header_banner" class="button button-primary"><?php esc_html_e('Start Customizing', 'mythos'); ?></a></div>
                                </div><!--/.thm-theme-about-text-->
                                <div class="thm-theme-customizer">
                                    <h3 class="thm-theme-title"><?php esc_html_e( 'Core Features', 'mythos' ); ?></h3>
                                    <ul class="thm-theme-dashboard-list">
                                        <li><?php esc_html_e( 'Completely Gutenberg Based', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Integrated Qubely Block Plugin', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Modern & Aesthetic Design', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Fully Responsive', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Highly Customizable', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Logo Settings', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Layout and Styling', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Advanced Blog Setting', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Bottom Settings', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Footer Settings', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Exclusive Blog Design', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'SEO Friendly', 'mythos' ); ?></li>
                                        <li><?php esc_html_e( 'Rich Documentation', 'mythos' ); ?></li>
                                    </ul>
                                </div><!--/.thm-theme-customizer-->
                            </div><!--/.thm-theme-dashboard-card-->
                            <div class="thm-theme-dashboard-row">
                                <div class="thm-theme-dashboard-col thm-theme-dashboard-col-30">
                                    <div class="thm-theme-dashboard-card">
                                        <h3 class="thm-theme-title"><?php esc_html_e( 'Documentation', 'mythos' ); ?></h3>
                                        <div class="thm-theme-about-text"><?php esc_html_e('Need any help to set up and configure? Please have a look at our detailed documentation.', 'mythos') ?></div>
                                        <a href="<?php echo esc_url( 'https://www.themeum.com/docs/mythos-introduction/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e('Documentation', 'mythos'); ?></a>
                                    </div>
                                </div>
                                <div class="thm-theme-dashboard-col thm-theme-dashboard-col-30">
                                    <div class="thm-theme-dashboard-card">
                                        <h3 class="thm-theme-title"><?php esc_html_e( 'Support', 'mythos' ); ?></h3>
                                        <div class="thm-theme-about-text"><?php esc_html_e('We have an expert support team to assist you in every situation related to our product.', 'mythos'); ?></div>
                                        <a href="<?php echo esc_url( 'https://www.themeum.com/support-forums/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e('Get Support', 'mythos'); ?></a>
                                    </div>
                                </div>
                                <div class="thm-theme-dashboard-col thm-theme-dashboard-col-30">
                                    <div class="thm-theme-dashboard-card">
                                        <h3 class="thm-theme-title"><?php esc_html_e( 'Upgrade to Pro', 'mythos' ); ?></h3>
                                        <div class="thm-theme-about-text"><?php esc_html_e('Get 5 home variations, one-click demo installer, and more by upgrading to Mythos Pro. ', 'mythos'); ?></div>
                                        <a href="<?php echo esc_url( 'https://www.themeum.com/product/mythos-pro/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e('Upgrade Pro', 'mythos'); ?></a>
                                    </div>
                                </div>
                            </div><!--/.thm-theme-dashboard-row-->
                        </div><!--/.thm-theme-dashboard-col-75-->
                        <div class="thm-theme-dashboard-col thm-theme-dashboard-col-25">
                            <div class="thm-plugin thm-theme-dashboard-card">
                                <div class="thm-plugin-info">
                                    <h2 class="thm-theme-title"><?php esc_html_e( 'Qubely', 'mythos' ); ?></h2>
                                    <a href="<?php echo esc_url( 'https://wordpress.org/plugins/qubely' ); ?>" target="_blank" class="button button-white"><?php esc_html_e('Free Download', 'mythos'); ?></a>
                                </div>
                                <!-- <h3 class="thm-theme-title"><?php //esc_html_e( 'Advanced Gutenberg Blocks', 'mythos' ); ?></h3> -->
                                <h3 class="thm-theme-title"><?php esc_html_e( 'Advanced Gutenberg Blocks', 'mythos' ); ?></h3>
                                <div class="thm-theme-about-text"><?php esc_html_e('Qubely offers a rich collection of highly customizable dedicated Gutenberg blocks.', 'mythos'); ?></div>
                                <ul class="thm-theme-dashboard-basic-list">
                                    <li><a href="https://qubely.io/blocks/"><?php esc_html_e( '25+ blocks', 'mythos' ); ?></a></li>    
                                    <li><?php esc_html_e( 'Predefined sections', 'mythos' ); ?></li>
                                    <li><?php esc_html_e( 'Modern layout bundles', 'mythos' ); ?></li>
                                    <li><?php esc_html_e( 'Highly customizable rows & columns', 'mythos' ); ?></li>
                                    <li><?php esc_html_e( 'Device-specific responsive controls', 'mythos' ); ?></li>
                                    <li><?php esc_html_e( 'Custom CSS', 'mythos' ); ?></li>
                                </ul>
                                <a href="<?php echo esc_url( 'https://wordpress.org/plugins/qubely' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e('View Details', 'mythos'); ?></a>
                                <img class="qubely-dashboard-image" src="https://qubely.io/wp-content/uploads/2019/10/qubely-options-logo.png" alt="qubely Logo" />
                            </div>
                            <div class="theme-rating thm-theme-dashboard-card">
                                <h3 class="thm-theme-title"><?php esc_html_e( 'Happy with Our Work?', 'mythos' ); ?></h3>
                                <div class="thm-theme-about-text"><?php esc_html_e('We are really thankful to you that you have chosen our theme.', 'mythos'); ?></div>
                                <a href="https://wordpress.org/support/theme/mythos/reviews/#new-post" target="_blank"><?php esc_html_e( 'Rate Mythos', 'mythos' ); ?> ★★★★★</a>
                            </div>
                        </div><!--/.thm-theme-dashboard-col-25-->
                    </div><!--/.thm-theme-dashboard-row-->    
                </div><!--/.thm-theme-dashboard-row-->    
            </div><!--/.thm-getting-start-->
        </div> <!--/.thm-theme-dashboard-wrap-->
		<?php
	}
}

new Mythos_Dashboard();



