<?php

/**
 * Mythos Customizer
 */


if (!class_exists('THMC_Framework')):

	class THMC_Framework
	{
		/**
		 * Instance of WP_Customize_Manager class
		 */
		public $wp_customize;


		private $fields_class = array();

		private $google_fonts = array();

		/**
		 * Constructor of 'THMC_Framework' class
		 *
		 * @wp_customize (WP_Customize_Manager) Instance of 'WP_Customize_Manager' class
		 */
		function __construct( $wp_customize )
		{
			$this->wp_customize = $wp_customize;

			$this->fields_class = array(
				'text'            => 'WP_Customize_Control',
				'checkbox'        => 'WP_Customize_Control',
				'textarea'        => 'WP_Customize_Control',
				'radio'           => 'WP_Customize_Control',
				'select'          => 'WP_Customize_Control',
				'email'           => 'WP_Customize_Control',
				'url'             => 'WP_Customize_Control',
				'number'          => 'WP_Customize_Control',
				'range'           => 'WP_Customize_Control',
				'hidden'          => 'WP_Customize_Control',
				'date'            => 'Mythos_Date_Control',
				'color'           => 'WP_Customize_Color_Control',
				'upload'          => 'WP_Customize_Upload_Control',
				'image'           => 'WP_Customize_Image_Control',
				'radio_button'    => 'Mythos_Radio_Button_Control',
				'checkbox_button' => 'Mythos_Checkbox_Button_Control',
				'switch'          => 'Mythos_Switch_Button_Control',
				'multi_select'    => 'Mythos_Multi_Select_Control',
				'radio_image'     => 'Mythos_Radio_Image_Control',
				'checkbox_image'  => 'Mythos_Checkbox_Image_Control',
				'color_palette'   => 'Mythos_Color_Palette_Control',
				'rgba'            => 'Mythos_Rgba_Color_Picker_Control',
				'title'           => 'Mythos_Switch_Title_Control',
			);

			$this->load_custom_controls();

			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ), 100 );
		}

		public function customizer_scripts()
		{
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'thmc-select2', MYTHOS_URI.'lib/customizer/assets/select2/css/select2.min.css' );
			wp_enqueue_style( 'thmc-customizer', MYTHOS_URI.'lib/customizer/assets/css/customizer.css' );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'thmc-select2', MYTHOS_URI.'lib/customizer/assets/select2/js/select2.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'thmc-rgba-colorpicker', MYTHOS_URI.'lib/customizer/assets/js/thmc-rgba-colorpicker.js', array('jquery', 'wp-color-picker'), '1.0', true );
			wp_enqueue_script( 'thmc-customizer', MYTHOS_URI.'lib/customizer/assets/js/customizer.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );

			wp_localize_script( 'thmc-customizer', 'thm_customizer', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'import_success' => esc_html__('Success! Your theme data successfully imported. Page will be reloaded within 2 sec.', 'mythos'),
				'import_error' => esc_html__('Error! Your theme data importing failed.', 'mythos'),
				'file_error' => esc_html__('Error! Please upload a file.', 'mythos')
			) );
		}

		private function load_custom_controls(){
			get_template_part('lib/customizer/controls/radio-button');
            get_template_part('lib/customizer/controls/radio-image');
            get_template_part('lib/customizer/controls/checkbox-button');
            get_template_part('lib/customizer/controls/checkbox-image');
            get_template_part('lib/customizer/controls/switch');
            get_template_part('lib/customizer/controls/date');
            get_template_part('lib/customizer/controls/multi-select');
            get_template_part('lib/customizer/controls/color-palette');
            get_template_part('lib/customizer/controls/rgba-colorpicker');
            get_template_part('lib/customizer/controls/title');

            // Load Sanitize class
            get_template_part('lib/customizer/libs/sanitize');
		}

		public function add_option( $options ){
			if (isset($options['sections'])) {
				$this->panel_to_section($options);
			}
		}
		private function panel_to_section( $options )
		{
			$panel = $options;
			$panel_id = $options['id'];

			unset($panel['sections']);
			unset($panel['id']);

			// Register this panel
			$this->add_panel($panel, $panel_id);

			$sections = $options['sections'];

			if (!empty($sections)) {
				foreach ($sections as $section) {
					$fields = $section['fields'];
					$section_id = $section['id'];

					unset($section['fields']);
					unset($section['id']);

					$section['panel'] = $panel_id;

					$this->add_section($section, $section_id);

					if (!empty($fields)) {
						foreach ($fields as $field) {
							if (!isset($field['settings'])) {
								var_dump($field);
							}
							$field_id = $field['settings'];

							$this->add_field($field, $field_id, $section_id);
						}
					}
				}
			}
		}

		private function add_panel($panel, $panel_id){
			$this->wp_customize->add_panel( $panel_id, $panel );
		}

		private function add_section($section, $section_id)
		{
			$this->wp_customize->add_section( $section_id, $section );
		}

		private function add_field($field, $field_id, $section_id){
			$setting_args = array(
				'default'        => isset($field['default']) ? $field['default'] : '',
				'type'           => isset($field['setting_type']) ? $field['setting_type'] : 'theme_mod',
				'transport'     => isset($field['transport']) ? $field['transport'] : 'refresh',
				'capability'     => isset($field['capability']) ? $field['capability'] : 'edit_theme_options',
			);

			if (isset($field['type']) && $field['type'] == 'switch') {
				$setting_args['sanitize_callback'] = array('Mythos_Sanitize', 'switch_sntz');
			} elseif (isset($field['type']) && ($field['type'] == 'checkbox_button' || $field['type'] == 'checkbox_image')) {
				$setting_args['sanitize_callback'] = array('Mythos_Sanitize', 'multi_checkbox');
			} elseif (isset($field['type']) && $field['type'] == 'multi_select') {
				$setting_args['sanitize_callback'] = array('Mythos_Sanitize', 'multi_select');
				$setting_args['sanitize_js_callback'] = array('Mythos_Sanitize', 'multi_select_js');
			}

			$control_args = array(
				'label'       => isset($field['label']) ? $field['label'] : '',
				'section'     => $section_id,
				'settings'    => $field_id,
				'type'        => isset($field['type']) ? $field['type'] : 'text',
				'priority'    => isset($field['priority']) ? $field['priority'] : 10,
			);

			if (isset($field['choices'])) {
				$control_args['choices'] = $field['choices'];
			}

			// Register the settings
			$this->wp_customize->add_setting( $field_id, $setting_args );
			$control_class = isset($this->fields_class[$field['type']]) ? $this->fields_class[$field['type']] : 'WP_Customize_Control';
			// Add the controls
			$this->wp_customize->add_control( new $control_class( $this->wp_customize, $field_id, $control_args ) );
		}
	}

endif;

/**
*
*/
class THM_Customize
{
	public $google_fonts = array();

	function __construct( $options )
	{
		$this->options = $options;

		add_action('customize_register', array($this, 'customize_register'));
		add_action('wp_enqueue_scripts', array($this, 'mythos_get_google_fonts_data'));

		add_action('wp_ajax_thm_export_data', array($this, 'export_data_cb'));
		add_action('wp_ajax_thm_import_data', array($this, 'import_data_cb'));
	}

	public function customize_register( $wp_customize )
	{
		$mythos_framework = new THMC_Framework( $wp_customize );

		$mythos_framework->add_option( $this->options );

		$this->import_export_ui( $wp_customize );
	}

	public function import_export_ui( $wp_customize )
	{

		get_template_part( 'lib/customizer/controls/export' );
        get_template_part( 'lib/customizer/controls/import' );

		$wp_customize->add_setting( 'thm_export', array(
			'default'        => '',
			'transport'      => 'postMessage',
            'capability'     => 'edit_theme_options',
            'sanitize_callback'  => 'esc_attr',
		) );

		$wp_customize->add_control( new Mythos_Export_Control( $wp_customize, 'thm_export_ctrl', array(
			'label'       => 'Export Theme Data',
			'section'     => 'thm_import_export',
			'settings'    => 'thm_export',
			'type'        => 'export',
			'priority'    => 10,
		) ) );

		$wp_customize->add_setting( 'thm_import', array(
			'default'        => '',
			'transport'      => 'postMessage',
            'capability'     => 'edit_theme_options',
            'sanitize_callback'  => 'esc_attr',
		) );

		$wp_customize->add_control( new Mythos_Import_Control( $wp_customize, 'thm_import_ctrl', array(
			'label'       => 'Import Theme Data',
			'section'     => 'thm_import_export',
			'settings'    => 'thm_import',
			'type'        => 'export',
			'priority'    => 10,
		) ) );
	}

	public function mythos_get_google_fonts_data()
	{
		if (isset($this->options['sections']) && !empty($this->options['sections'])) {
			foreach ($this->options['sections'] as $section) {
				if (isset($section['fields']) && !empty($section['fields'])) {
					foreach ($section['fields'] as $field) {
						if (isset($field['google_font']) && $field['google_font'] == true) {
							$this->google_fonts[$field['settings']] = array();

							if (isset($field['default']) && !empty($field['default'])) {
								$this->google_fonts[$field['settings']]["default"] = $field['default'];
							}

							if (isset($field['google_font_weight']) && !empty($field['google_font_weight'])) {
								$this->google_fonts[$field['settings']]["weight"] = $field['google_font_weight'];
							}

							if (isset($field['google_font_weight_default']) && !empty($field['google_font_weight_default'])) {
								$this->google_fonts[$field['settings']]["weight_default"] = $field['google_font_weight_default'];
							}
						}
					}
				}
			}
		}

		$all_fonts = array();

		if (!empty($this->google_fonts)) {
			foreach ($this->google_fonts as $font_id => $font_data) {
				$font_family_default = isset($font_data['default']) ? $font_data['default'] : '';
				$font_family = get_theme_mod( $font_id, $font_family_default );

				if (!isset($all_fonts[$font_family])) {
					$all_fonts[$font_family] = array();
				}

				if (isset($font_data['weight']) && !empty($font_data['weight'])) {
					$font_weight_default = isset($font_data['weight_default']) ? $font_data['weight_default'] : '';

					$font_weight = get_theme_mod( $font_data['weight'], $font_weight_default );

					$all_fonts[$font_family][] = $font_weight;
				}

			}
		}

		$font_url = "//fonts.googleapis.com/css?family=";

		if (!empty($all_fonts)) {

			$i = 0;

			foreach ($all_fonts as $font => $weights) {

				if ($i) {
					$font_url .= "%7C";
				}

				$font_url .= str_replace(" ", "+", $font);

				if (!empty($weights)) {
					$font_url .= ":";
					$font_url .= implode(",", $weights);
				}

				$i++;
			}

			wp_enqueue_style( "tm-google-font", $font_url );
		}
	}
}



// Customizer Section
$mythos_panel_to_section = array(
	'id'           => 'languageschool_panel_options',
	'title'        => esc_html( 'Mythos Options', 'mythos' ),
	'description'  => esc_html__( 'Mythos Theme Options', 'mythos' ),
	'priority'     => 10,
	
	'sections'     => array(
		array(
			'id'              => 'topbar_setting',
			'title'           => esc_html__( 'Topbar Settings', 'mythos' ),
			'description'     => esc_html__( 'Topbar Settings', 'mythos' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(

				array(
					'settings' => 'topbar_enable',
					'label'    => esc_html__( 'Topbar Enable/Disable', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),				
				array(
					'settings' => 'topbar_email',
					'label'    => esc_html__( 'Topbar Email', 'mythos' ),
					'type'     => 'email',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'topbar_phone',
					'label'    => esc_html__( 'Topbar Phone Number', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				
				), 			
				array(
					'settings' => 'topbar_text_color',
					'label'    => esc_html__( 'Topbar Text/Link Color', 'mythos' ),
					'type'     => 'rgba',
					'priority' => 10,
					'default'  => 'rgba(255, 255, 255, 0.6)',
				),
				array(
					'settings' => 'topbar_link_hover_color',
					'label'    => esc_html__( 'Topbar Link Hover color', 'mythos' ),
					'type'     => 'rgba',
					'priority' => 10,
					'default'  => '#fff',
				),
			)//fields
		),//topbar_setting

		array(
			'id'              => 'logo_setting',
			'title'           => esc_html__( 'Logo Settings', 'mythos' ),
			'description'     => esc_html__( 'Logo Settings', 'mythos' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(			
				array(
					'settings' => 'logo_width',
					'label'    => esc_html__( 'Logo Width', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => 80,
				),
				array(
					'settings' => 'logo_height',
					'label'    => esc_html__( 'Logo Height', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
				),
			)//fields
		),//topbar_setting
		
		array(
			'id'              => 'sub_header_banner',
			'title'           => esc_html__( 'Sub Header Banner', 'mythos' ),
			'description'     => esc_html__( 'sub header banner', 'mythos' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(

				array(
					'settings' => 'sub_header_padding_top',
					'label'    => esc_html__( 'Sub-Header Padding Top', 'mythos' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 140,
				),
				array(
					'settings' => 'sub_header_padding_bottom',
					'label'    => esc_html__( 'Sub-Header Padding Bottom', 'mythos' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 0,
				),
				array(
					'settings' => 'sub_header_banner_color',
					'label'    => esc_html__( 'Sub-Header BG Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default' 	=> '#01c3ca',
				),
				array(
					'settings' => 'sub_header_title',
					'label'    => esc_html__( 'Title Settings', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'sub_header_title_color',
					'label'    => esc_html__( 'Header Title Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#01c3ca',
				),
			)//fields
		),//sub_header_banner


		array(
			'id'              => 'typo_setting',
			'title'           => esc_html__( 'Typography Setting', 'mythos' ),
			'description'     => esc_html__( 'Typography Setting', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(

				array(
					'settings' => 'font_title_body',
					'label'    => esc_html__( 'Body Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//body font
				array(
					'settings' => 'body_google_font',
					'label'    => esc_html__( 'Select Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' 					=> true,
					'google_font_weight' 			=> 'body_font_weight',
					'google_font_weight_default' 	=> '400'
				),
				array(
					'settings' => 'body_font_size',
					'label'    => esc_html__( 'Body Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'body_font_height',
					'label'    => esc_html__( 'Body Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'body_font_weight',
					'label'    => esc_html__( 'Body Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '400',
					'choices'  => array(
						'' => esc_html__( 'Select', 'mythos' ),
						'100' => esc_html__( '100', 'mythos' ),
						'200' => esc_html__( '200', 'mythos' ),
						'300' => esc_html__( '300', 'mythos' ),
						'400' => esc_html__( '400', 'mythos' ),
						'500' => esc_html__( '500', 'mythos' ),
						'600' => esc_html__( '600', 'mythos' ),
						'700' => esc_html__( '700', 'mythos' ),
						'800' => esc_html__( '800', 'mythos' ),
						'900' => esc_html__( '900', 'mythos' ),
					)
				),
				array(
					'settings' => 'body_font_color',
					'label'    => esc_html__( 'Body Font Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#7e879a',
				),
				array(
					'settings' => 'font_title_menu',
					'label'    => esc_html__( 'Menu Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Menu font
				array(
					'settings' => 'menu_google_font',
					'label'    => esc_html__( 'Select Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '700'
				),
				array(
					'settings' => 'menu_font_size',
					'label'    => esc_html__( 'Menu Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'menu_font_height',
					'label'    => esc_html__( 'Menu Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '20',
				),
				array(
					'settings' => 'menu_font_weight',
					'label'    => esc_html__( 'Menu Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '700',
					'choices'  => array(
						'' => esc_html( 'Select', 'mythos' ),
						'100' => esc_html( '100', 'mythos' ),
						'200' => esc_html( '200', 'mythos' ),
						'300' => esc_html( '300', 'mythos' ),
						'400' => esc_html( '400', 'mythos' ),
						'500' => esc_html( '500', 'mythos' ),
						'600' => esc_html( '600', 'mythos' ),
						'700' => esc_html( '700', 'mythos' ),
						'800' => esc_html( '800', 'mythos' ),
						'900' => esc_html( '900', 'mythos' ),
					)
				),
				array(
					'settings' => 'font_title_h1',
					'label'    => esc_html__( 'Heading 1 Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 1
				array(
					'settings' => 'h1_google_font',
					'label'    => esc_html__( 'Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '700'
				),
				array(
					'settings' => 'h1_font_size',
					'label'    => esc_html__( 'Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '44',
				),
				array(
					'settings' => 'h1_font_height',
					'label'    => esc_html__( 'Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '48',
				),
				array(
					'settings' => 'h1_font_weight',
					'label'    => esc_html__( 'Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '700',
					'choices'  => array(
						'' => esc_html__( 'Select', 'mythos' ),
						'100' => esc_html__( '100', 'mythos' ),
						'200' => esc_html__( '200', 'mythos' ),
						'300' => esc_html__( '300', 'mythos' ),
						'400' => esc_html__( '400', 'mythos' ),
						'500' => esc_html__( '500', 'mythos' ),
						'600' => esc_html__( '600', 'mythos' ),
						'700' => esc_html__( '700', 'mythos' ),
						'800' => esc_html__( '800', 'mythos' ),
						'900' => esc_html__( '900', 'mythos' ),
					)
				),

				array(
					'settings' => 'font_title_h2',
					'label'    => esc_html__( 'Heading 2 Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 2
				array(
					'settings' => 'h2_google_font',
					'label'    => esc_html__( 'Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h2_font_size',
					'label'    => esc_html__( 'Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '30',
				),
				array(
					'settings' => 'h2_font_height',
					'label'    => esc_html__( 'Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '36',
				),
				array(
					'settings' => 'h2_font_weight',
					'label'    => esc_html__( 'Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html__( 'Select', 'mythos' ),
						'100' => esc_html__( '100', 'mythos' ),
						'200' => esc_html__( '200', 'mythos' ),
						'300' => esc_html__( '300', 'mythos' ),
						'400' => esc_html__( '400', 'mythos' ),
						'500' => esc_html__( '500', 'mythos' ),
						'600' => esc_html__( '600', 'mythos' ),
						'700' => esc_html__( '700', 'mythos' ),
						'800' => esc_html__( '800', 'mythos' ),
						'900' => esc_html__( '900', 'mythos' ),
					)
				),

				array(
					'settings' => 'font_title_h3',
					'label'    => esc_html__( 'Heading 3 Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 3
				array(
					'settings' => 'h3_google_font',
					'label'    => esc_html__( 'Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h3_font_size',
					'label'    => esc_html__( 'Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '22',
				),
				array(
					'settings' => 'h3_font_height',
					'label'    => esc_html__( 'Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '28',
				),
				array(
					'settings' => 'h3_font_weight',
					'label'    => esc_html__( 'Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html__( 'Select', 'mythos' ),
						'100' => esc_html__( '100', 'mythos' ),
						'200' => esc_html__( '200', 'mythos' ),
						'300' => esc_html__( '300', 'mythos' ),
						'400' => esc_html__( '400', 'mythos' ),
						'500' => esc_html__( '500', 'mythos' ),
						'600' => esc_html__( '600', 'mythos' ),
						'700' => esc_html__( '700', 'mythos' ),
						'800' => esc_html__( '800', 'mythos' ),
						'900' => esc_html__( '900', 'mythos' ),
					)
				),

				array(
					'settings' => 'font_title_h4',
					'label'    => esc_html__( 'Heading 4 Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 4
				array(
					'settings' => 'h4_google_font',
					'label'    => esc_html__( 'Heading4 Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h4_font_size',
					'label'    => esc_html__( 'Heading4 Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '17',
				),
				array(
					'settings' => 'h4_font_height',
					'label'    => esc_html__( 'Heading4 Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '22',
				),
				array(
					'settings' => 'h4_font_weight',
					'label'    => esc_html__( 'Heading4 Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html__( 'Select', 'mythos' ),
						'100' => esc_html__( '100', 'mythos' ),
						'200' => esc_html__( '200', 'mythos' ),
						'300' => esc_html__( '300', 'mythos' ),
						'400' => esc_html__( '400', 'mythos' ),
						'500' => esc_html__( '500', 'mythos' ),
						'600' => esc_html__( '600', 'mythos' ),
						'700' => esc_html__( '700', 'mythos' ),
						'800' => esc_html__( '800', 'mythos' ),
						'900' => esc_html__( '900', 'mythos' ),
					)
				),

				array(
					'settings' => 'font_title_h5',
					'label'    => esc_html__( 'Heading 5 Font Options', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),

				//Heading 5
				array(
					'settings' => 'h5_google_font',
					'label'    => esc_html__( 'Heading5 Google Font', 'mythos' ),
					'type'     => 'select',
					'default'  => 'Open Sans',
					'choices'  => mythos_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h5_font_size',
					'label'    => esc_html__( 'Heading5 Font Size', 'mythos' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'h5_font_height',
					'label'    => esc_html__( 'Heading5 Font Line Height', 'mythos' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'h5_font_weight',
					'label'    => esc_html__( 'Heading5 Font Weight', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => esc_html__( 'Select', 'mythos' ),
						'100' => esc_html__( '100', 'mythos' ),
						'200' => esc_html__( '200', 'mythos' ),
						'300' => esc_html__( '300', 'mythos' ),
						'400' => esc_html__( '400', 'mythos' ),
						'500' => esc_html__( '500', 'mythos' ),
						'600' => esc_html__( '600', 'mythos' ),
						'700' => esc_html__( '700', 'mythos' ),
						'800' => esc_html__( '800', 'mythos' ),
						'900' => esc_html__( '900', 'mythos' ),
					)
				),

			)//fields
		),//typo_setting

		array(
			'id'              => 'layout_styling',
			'title'           => esc_html__( 'Layout & Styling', 'mythos' ),
			'description'     => esc_html__( 'Layout & Styling', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				
				array(
					'settings' => 'custom_preset_en',
					'label'    => esc_html__( 'Set Custom Color', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'major_color',
					'label'    => esc_html__( 'Major Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#01c3ca',
				),
				array(
					'settings' => 'major_color2',
					'label'    => esc_html__( 'For Gradient Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#00d3a7',
				),
				array(
					'settings' => 'hover_color',
					'label'    => esc_html__( 'Hover Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#333',
				),
			
				# navbar color section start.
				array(
					'settings' => 'menu_color_title',
					'label'    => esc_html__( 'Menu Color Settings', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'menu_font_color',
					'label'    => esc_html__( 'Text Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),

				array(
					'settings' => 'navbar_hover_text_color',
					'label'    => esc_html__( 'Hover Text Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),

				array(
					'settings' => 'navbar_active_text_color',
					'label'    => esc_html__( 'Active Text Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),

				# Submenu
				array(
					'settings' => 'sub_menu_color_title',
					'label'    => esc_html__( 'Sub-Menu Color Settings', 'mythos' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'sub_menu_bg',
					'label'    => esc_html__( 'Background Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#ffffff',
				),
				array(
					'settings' => 'sub_menu_text_color',
					'label'    => esc_html__( 'Text Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#7e879a',
				),
				array(
					'settings' => 'sub_menu_text_color_hover',
					'label'    => esc_html__( 'Hover Text Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#02c0d0',
				),
				#End of the navbar color section
			)//fields
		),//Layout & Styling


		array(
			'id'              => 'social_media_settings',
			'title'           => esc_html__( 'Social Media', 'mythos' ),
			'description'     => esc_html__( 'Social Media', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'wp_facebook',
					'label'    => esc_html__( 'Add Facebook URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_twitter',
					'label'    => esc_html__( 'Add Twitter URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_linkedin',
					'label'    => esc_html__( 'Add Linkedin URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_instagram',
					'label'    => esc_html__( 'Add Instagram URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_skype',
					'label'    => esc_html__( 'Add Skype URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_google_plus',
					'label'    => esc_html__( 'Add Goole Plus URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_pinterest',
					'label'    => esc_html__( 'Add Pinterest URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_youtube',
					'label'    => esc_html__( 'Add Youtube URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_linkedin_user',
					'label'    => esc_html__( 'Linkedin Username( For Share )', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_dribbble',
					'label'    => esc_html__( 'Add Dribbble URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_behance',
					'label'    => esc_html__( 'Add Behance URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_flickr',
					'label'    => esc_html__( 'Add Flickr URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => 'wp_vk',
					'label'    => esc_html__( 'Add Vk URL', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '',
				),
				
			)//fields
		),//social_media


		# 404 Page.
		array(
			'id'              => '404_settings',
			'title'           => esc_html__( '404 Page', 'mythos' ),
			'description'     => esc_html__( '404 page background and text settings', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'logo_404',
					'label'    => esc_html__( 'Upload Image', 'mythos' ),
					'type'     => 'upload',
					'priority' => 10,
					'default'  => '',
				),
				array(
					'settings' => '404_title',
					'label'    => esc_html__( '404 Page Title', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => esc_html__('The page doesn\'t exist.', 'mythos')
				),
				array(
					'settings' => '404_description',
					'label'    => esc_html__( '404 Page Description', 'mythos' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => ''
				),
				array(
					'settings' => '404_btn_text',
					'label'    => esc_html__( 'Button Text', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => 'Go to Homepage',
				),
			)
		),

		# Blog Settings.
		array(
			'id'              => 'blog_setting',
			'title'           => esc_html__( 'Archive Setting', 'mythos' ),
			'description'     => esc_html__( 'Set up Archive page', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'blog_column',
					'label'    => esc_html__( 'Select Archive Column', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '6',
					'choices'  => array(
						'12' 	=> esc_html( 'Column 1', 'mythos' ),
						'6' 	=> esc_html( 'Column 2', 'mythos' ),
						'4' 	=> esc_html( 'Column 3', 'mythos' ),
					)
				),
				array(
					'settings' => 'blog_date',
					'label'    => esc_html__( 'Show Archive Date', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_author',
					'label'    => esc_html__( 'Show Archive Author', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_category',
					'label'    => esc_html__( 'Show Archive Category', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_comment',
					'label'    => esc_html__( 'Show Comment', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_intro_en',
					'label'    => esc_html__( 'Show Archive Content', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),

				array(
					'settings' => 'blog_post_text_limit',
					'label'    => esc_html__( 'Excerpt Charlength Limit', 'mythos' ),
					'type'     => 'text',
					'priority' => 10,
					'default'  => '220',
				),
			)//fields
		),//blog_setting

		array(
			'id'              => 'blog_single_setting',
			'title'           => esc_html__( 'Blog Single Page Setting', 'mythos' ),
			'description'     => esc_html__( 'Setup blog single post', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				
				array(
					'settings' => 'blog_date_single',
					'label'    => esc_html__( 'Show blog single date', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_author_single',
					'label'    => esc_html__( 'Show blog single author', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_category_single',
					'label'    => esc_html__( 'Show blog single category', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_comment_single',
					'label'    => esc_html__( 'Show blog single comment', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
							
			) #fields
		), 
		#blog_single_page_setting

		array(
			'id'              => 'bottom_setting',
			'title'           => esc_html__( 'Bottom Setting', 'mythos' ),
			'description'     => esc_html__( 'Bottom Setting', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'bottom_column',
					'label'    => esc_html__( 'Select Bottom Column', 'mythos' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '4',
					'choices'  => array(
						'12' 	=> esc_html__( 'Column 1', 'mythos' ),
						'6' 	=> esc_html__( 'Column 2', 'mythos' ),
						'4' 	=> esc_html__( 'Column 3', 'mythos' ),
						'3' 	=> esc_html__( 'Column 4', 'mythos' ),
					)
				),
				array(
					'settings' => 'bottom_color',
					'label'    => esc_html__( 'Bottom background Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#21223f',
				),
				array(
					'settings' => 'bottom_title_color',
					'label'    => esc_html__( 'Bottom Title Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),	
				array(
					'settings' => 'bottom_link_color',
					'label'    => esc_html__( 'Bottom Link Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#a8a9c4',
				),				
				array(
					'settings' => 'bottom_hover_color',
					'label'    => esc_html__( 'Bottom link hover color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'bottom_text_color',
					'label'    => esc_html__( 'Bottom Text color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#a8a9c4',
				),
				array(
					'settings' => 'bottom_padding_top',
					'label'    => esc_html__( 'Bottom Top Padding', 'mythos' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),	
				array(
					'settings' => 'bottom_padding_bottom',
					'label'    => esc_html__( 'Bottom Padding Bottom', 'mythos' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 45,
				),					
			)//fields
		),//bottom_setting		
		array(
			'id'              => 'footer_setting',
			'title'           => esc_html__( 'Footer Setting', 'mythos' ),
			'description'     => esc_html__( 'Footer Setting', 'mythos' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'footer_en',
					'label'    => esc_html__( 'Disable Copyright Area', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'footer_logo',
					'label'    => esc_html__( 'Upload Logo', 'mythos' ),
					'type'     => 'upload',
					'priority' => 10,
					'default' 	=> '',
				),
				array(
					'settings' => 'copyright_en',
					'label'    => esc_html__( 'Disable copyright text', 'mythos' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'copyright_text',
					'label'    => esc_html__( 'Copyright Text', 'mythos' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => esc_html__( '2019 Mythos. All Rights Reserved.', 'mythos' ),
				),
				array(
					'settings' => 'theme_design',
					'label'    => esc_html__( 'Intro Text', 'mythos' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => esc_html__( 'Design & Development by Themeum.', 'mythos' ),
				),
				array(
					'settings' => 'copyright_text_color',
					'label'    => esc_html__( 'Footer Text Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#6c6d8b',
				),				
				array(
					'settings' => 'copyright_link_color',
					'label'    => esc_html__( 'Footer Link Color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#6c6d8b',
				),				
				array(
					'settings' => 'copyright_hover_color',
					'label'    => esc_html__( 'Footer link hover color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'copyright_bg_color',
					'label'    => esc_html__( 'Footer background color', 'mythos' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#21223f',
				),
				array(
					'settings' => 'copyright_padding_top',
					'label'    => esc_html__( 'Footer Top Padding', 'mythos' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 25,
				),	
				array(
					'settings' => 'copyright_padding_bottom',
					'label'    => esc_html__( 'Footer Bottom Padding', 'mythos' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 25,
				),					
			)//fields
		),//footer_setting
		
	),
);//wpestate-core_panel_options

$mythos_framework = new THM_Customize( $mythos_panel_to_section );

