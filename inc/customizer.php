<?php
/**
 * Enterprise Theme Customizer
 *
 * @package Enterprise
 */
function enterprise_customize_register( $wp_customize ) {

	/** ===============
	 * Extends controls class to add textarea with description
	 */
	class Enterprise_WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public $description = '';
		public function render_content() { ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
			<textarea rows="5" style="width:98%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>

		<?php }
	}

	/** ===============
	 * Extends controls class to add descriptions to text input controls
	 */
	class Enterprise_WP_Customize_Text_Control extends WP_Customize_Control {
		public $type = 'customtext';
		public $description = '';
		public function render_content() { ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		</label>

		<?php }
	}

	/** ===============
	 * Extends controls class to add descriptions to color picker controls
	 */
	class Enterprise_WP_Customize_Color_Control extends WP_Customize_Control {
		public $type = 'color';
		public $description = '';
		public $statuses;
		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __( 'Default', 'enterprise' ) );
			parent::__construct( $manager, $id, $args );
		}
		public function enqueue() {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}
		public function to_json() {
			parent::to_json();
			$this->json['statuses'] = $this->statuses;
		}
		public function render_content() {
			$this_default = $this->setting->default;
			$default_attr = '';
			if ( $this_default ) {
				if ( false === strpos( $this_default, '#' ) )
					$this_default = '#' . $this_default;
				$default_attr = ' data-default-color="' . esc_attr( $this_default ) . '"';
			}
			// The input's value gets set by JS. Don't fill it.
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
				<div class="customize-control-content">
					<input class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'enterprise' ); ?>"<?php echo $default_attr; ?> />
				</div>
			</label>
			<?php
		}
	}

	/** ===============
	 * Site Title (Logo) & Tagline
	 */
	// section adjustments
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Title (Logo) & Tagline', 'enterprise' );
	$wp_customize->get_section( 'title_tagline' )->priority = 10;

	// site title
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_control( 'blogname' )->priority = 10;

	// logo uploader
	$wp_customize->add_setting( 'enterprise_logo', array(
		'default' => null,
		'sanitize_callback'	=> 'esc_url_raw'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'enterprise_logo', array(
		'label'		=> __( 'Custom Site Logo (replaces title)', 'enterprise' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'enterprise_logo',
		'priority'	=> 20
	) ) );

	// site tagline
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_control( 'blogdescription' )->priority = 30;

	// hide the tagline?
	$wp_customize->add_setting( 'enterprise_hide_tagline', array(
		'default'			=> 0,
		'sanitize_callback'	=> 'enterprise_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'enterprise_hide_tagline', array(
		'label'		=> __( 'Hide Tagline', 'enterprise' ),
		'section'	=> 'title_tagline',
		'priority'	=> 40,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Design Options
	 */
	$wp_customize->add_section( 'enterprise_layout_design', array(
    	'title'       	=> __( 'Design Options', 'enterprise' ),
		'description' 	=> __( 'Control the primary design color and other elements of your site.', 'enterprise' ),
		'priority'   	=> 20,
	) );

	// design color
	$wp_customize->add_setting( 'enterprise_design_color', array(
		'default'		=> '#2E9FEB',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );
	$wp_customize->add_control( new Enterprise_WP_Customize_Color_Control( $wp_customize, 'enterprise_design_color', array(
		'label'		=> __( 'Primary Design Color', 'enterprise' ),
		'section'	=> 'enterprise_layout_design',
		'priority'	=> 20,
		'description' 	=> __( 'The primary design color is used for links, borders, buttons, and other design elements.', 'enterprise' ),
	) ) );

	// design color	text
	$wp_customize->add_setting( 'enterprise_design_color_text', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );
	$wp_customize->add_control( new Enterprise_WP_Customize_Color_Control( $wp_customize, 'enterprise_design_color_text', array(
		'label'		=> __( 'Text Color for Designed Elements', 'enterprise' ),
		'section'	=> 'enterprise_layout_design',
		'priority'	=> 30,
		'description' 	=> __( 'When the above Primary Design Color is used as a background color, this color option is applied to the text within that element.', 'enterprise' ),
	) ) );

	/**
	 * restructure the default Colors section/control
	 */
	// get rid of the default Colors section
	$wp_customize->remove_section( 'colors' );
		// move Colors option to Enterprise custom section
		$wp_customize->get_control( 'background_color' )->section = 'enterprise_layout_design';
		// change the Colors label
		$wp_customize->get_control( 'background_color' )->label = __( 'Full Site Background Color', 'enterprise' );
		// put Colors option in a logical spot
		$wp_customize->get_control( 'background_color' )->priority = 40;

	/**
	 * restructure the default Background Image section
	 */
	// get rid of the default Background Image section
	$wp_customize->remove_section( 'background_image' );
		// move Background Image uploader to Enterprise custom section
		$wp_customize->get_control( 'background_image' )->section = 'enterprise_layout_design';
		// change the Background Image label
		$wp_customize->get_control( 'background_image' )->label = __( 'Full Site Background Image', 'enterprise' );
		// put Background Image uploader in a logical spot
		$wp_customize->get_control( 'background_image' )->priority = 50;

	// main site box shadow
	$wp_customize->add_setting( 'enterprise_page_box_shadow', array(
		'default'			=> 0,
		'sanitize_callback'	=> 'enterprise_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'enterprise_page_box_shadow', array(
		'label'		=> __( 'Remove Page Box Shadow', 'enterprise' ),
		'section'	=> 'enterprise_layout_design',
		'priority'	=> 70,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Content Options
	 */
	$wp_customize->add_section( 'enterprise_content_section', array(
    	'title'       	=> __( 'Content Options', 'enterprise' ),
		'description' 	=> __( 'Adjust the display of content on your website. All options have a default value that can be left as-is but you are free to customize.', 'enterprise' ),
		'priority'   	=> 40,
	) );

	// post content
	$wp_customize->add_setting( 'enterprise_post_content', array(
		'default'			=> 0,
		'sanitize_callback'	=> 'enterprise_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'enterprise_post_content', array(
		'label'		=> __( 'Display Post Excerpts', 'enterprise' ),
		'section'	=> 'enterprise_content_section',
		'priority'	=> 10,
		'type'      => 'checkbox',
	) );

	// read more link
	$wp_customize->add_setting( 'enterprise_read_more', array(
		'default'			=> __( 'Continue reading', 'enterprise' ),
		'sanitize_callback'	=> 'enterprise_sanitize_text'
	) );
	$wp_customize->add_control( 'enterprise_read_more', array(
	    'label' 	=> __( 'Excerpt & More Link Text', 'enterprise' ),
	    'section' 	=> 'enterprise_content_section',
		'priority'	=> 20,
	) );

	// credits & copyright
	$wp_customize->add_setting( 'enterprise_credits_copyright', array(
		'default'			=> null,
		'sanitize_callback'	=> 'enterprise_sanitize_textarea',
	) );
	$wp_customize->add_control( new Enterprise_WP_Customize_Textarea_Control( $wp_customize, 'enterprise_credits_copyright', array(
		'label'			=> __( 'Footer Credits & Copyright', 'enterprise' ),
		'section'		=> 'enterprise_content_section',
		'priority'		=> 60,
		'description'	=> __( 'Displays tagline, site title, copyright, and year by default. Allowed tags: <img>, <a>, <div>, <span>, <blockquote>, <p>, <em>, <strong>, <form>, <input>, <br>, <s>, <i>, <b>', 'enterprise' ),
	) ) );
}
add_action( 'customize_register', 'enterprise_customize_register' );


/**
 * Sanitize checkbox options
 */
function enterprise_sanitize_checkbox( $input ) {
    if ( $input == 1 ) :
        return 1;
    else :
        return 0;
    endif;
}


/**
 * Sanitize text input
 */
function enterprise_sanitize_text( $input ) {
    return strip_tags( stripslashes( $input ) );
}


/**
 * Sanitize text input to allow anchors
 */
function enterprise_sanitize_link_text( $input ) {
    return strip_tags( stripslashes( $input ), '<a>' );
}


/**
 * Sanitize textarea
 */
function enterprise_sanitize_textarea( $input ) {
	$allowed = array(
		's'			=> array(),
		'br'		=> array(),
		'em'		=> array(),
		'i'			=> array(),
		'strong'	=> array(),
		'b'			=> array(),
		'a'			=> array(
			'href'			=> array(),
			'title'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'form'		=> array(
			'id'			=> array(),
			'class'			=> array(),
			'action'		=> array(),
			'method'		=> array(),
			'autocomplete'	=> array(),
			'style'			=> array(),
		),
		'input'		=> array(
			'type'			=> array(),
			'name'			=> array(),
			'class' 		=> array(),
			'id'			=> array(),
			'value'			=> array(),
			'placeholder'	=> array(),
			'tabindex'		=> array(),
			'style'			=> array(),
		),
		'img'		=> array(
			'src'			=> array(),
			'alt'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'height'		=> array(),
			'width'			=> array(),
		),
		'span'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'p'			=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'div'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'blockquote' => array(
			'cite'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
	);
    return wp_kses( $input, $allowed );
}


/**
 * sanitize hex colors
 */
function enterprise_sanitize_hex_color( $color ) {
	if ( '' === $color ) :
		return '';
    endif;

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) :
		return $color;
    endif;

	return null;
}


/**
 * Add Customizer theme styles to <head>
 */
function enterprise_customizer_head_styles() {
	$bg_color = get_option( 'enterprise_background_color' );
	$design_color = get_option( 'enterprise_design_color' );
	$design_color_text = get_option( 'enterprise_design_color_text' ); ?>

	<style type="text/css">
		<?php if ( 1 == get_theme_mod( 'enterprise_hide_tagline' ) ) : // if no tagline, reposition the header menu ?>
			.main-navigation {
				top: 33px;
			}
		<?php endif; ?>
		<?php if ( 1 == get_theme_mod( 'enterprise_page_box_shadow' ) ) : // remove main site box shadow ?>
			#page {
				box-shadow: none;
			}
		<?php endif; ?>
		<?php if ( '#323232' != $bg_color && '' != $bg_color ) : // Is the background color no longer the default? ?>
			body {
				background: <?php echo enterprise_sanitize_hex_color( $bg_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( '#2e9feb' != $design_color && '' != $design_color ) : // Is the design color no longer the default? ?>
			#page,
			.bypostauthor .comment-footer {
				border-color: <?php echo enterprise_sanitize_hex_color( $design_color ); ?>;
			}
			a,
			.main-navigation .menu > .highlight > a,
			.main-navigation .menu > .highlight.current-menu-item > a,
			.main-navigation .menu > .highlight > a:before,
			.main-navigation ul ul li.highlight a,
			.main-navigation ul ul .highlight a:before,
			.comment-full:hover > .reply > .comment-reply-link,
			.site-main .comment-navigation a:hover,
			.site-main .paging-navigation a:hover {
				color: <?php echo enterprise_sanitize_hex_color( $design_color ); ?>;
			}
			button,
			input[type="submit"],
			input[type="submit"]:hover,
			input[type="button"],
			input[type="button"]:hover,
			.more-link,
			.menu-toggle,
			.main-navigation ul ul .highlight a,
			.main-navigation ul ul .highlight.current-menu-item a,
			.main-navigation ul ul .highlight.current-menu-parent > a,
			.widget_calendar table caption {
				background: <?php echo enterprise_sanitize_hex_color( $design_color ); ?>;
			}
		<?php endif; ?>
		<?php
			/**
			 * Is the design color text no longer the default? Even if it is,
			 * reinforce the design color text if the the primary design color
			 * has been changed.
			 */
			if ( ( '#ffffff' != $design_color_text && '' != $design_color_text ) || ( '#2e9feb' != $design_color && '' != $design_color ) ) :
			?>
			button,
			input[type="submit"],
			input[type="submit"]:hover,
			input[type="button"],
			input[type="button"]:hover,
			.more-link,
			.menu-toggle,
			.site-header .main-navigation ul ul .highlight a,
			.site-header .main-navigation ul ul .highlight.current-menu-item a,
			.site-header .main-navigation ul ul .highlight.current-menu-parent > a,
			.widget_calendar table caption {
				color: <?php echo enterprise_sanitize_hex_color( $design_color_text ); ?>;
			}
			@media screen and (max-width: 780px) {
				.site-header .main-navigation ul ul .highlight a,
				.site-header .main-navigation .menu > .highlight > a {
					color: <?php echo enterprise_sanitize_hex_color( $design_color ); ?>;
				}
			}
		<?php endif; ?>
	</style>
<?php }
add_action( 'wp_head', 'enterprise_customizer_head_styles' );


/**
 * Add Customizer UI styles to the <head> only on Customizer page
 */
function enterprise_customizer_styles() { ?>
	<style type="text/css">
		body { background: #fff; }
		#customize-controls #customize-theme-controls .description { display: block; color: #999; margin: 2px 0 15px; font-style: italic; }
		textarea, input, select, .customize-description { font-size: 12px !important; }
		.customize-control-title { font-size: 13px !important; margin: 5px 0 3px !important; }
		.customize-control label { font-size: 12px !important; }
		.customize-control-text,
		#customize-control-background_image { margin-bottom: 15px; }
		.control-description { color: #999; font-style: italic; margin-bottom: 6px; }
	</style>
<?php }
add_action( 'customize_controls_print_styles', 'enterprise_customizer_styles' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function enterprise_customize_preview_js() {
	wp_enqueue_script( 'enterprise_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), ENTERPRISE_VERSION, true );
}
add_action( 'customize_preview_init', 'enterprise_customize_preview_js' );