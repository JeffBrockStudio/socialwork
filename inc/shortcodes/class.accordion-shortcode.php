<?php
/**
 * Shortcode for embedding accordion style module
 *
 * Template:
 * [accordion name='web name']
 * [section title='section title'] content [/section]
 * [section title='section title'] content [/section]
 * [section title='section title'] content [/section]
 * [/accordion]
 */
class SocialWork_Accordion {
	const PRIORITY = 12;

	/**
	 * Accordion constructor.
	 */
	public function __construct() {
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop', self::PRIORITY );

		remove_filter( 'the_excerpt', 'wpautop' );
		add_filter( 'the_excerpt', 'wpautop', self::PRIORITY );

		add_shortcode( 'socialwork_accordion', array( $this, 'accordion_handler' ) );
		add_shortcode( 'section', array( $this, 'section_handler' ) );
		add_shortcode( 'subsection', array( $this, 'subsection_handler' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'socialwork_enqueue_accordion_script' ) );
	}

	/**
	 * Load accordion JS.
	 *
	 * @return void
	 */
	public function socialwork_enqueue_accordion_script() {
		$template_directory = get_bloginfo( 'stylesheet_directory' );
		$theme_version = wp_get_theme( get_template( ) )->get( 'Version' );

		wp_register_script( 'socialwork-accordion-script', $template_directory  . '/js/shortcodes/accordion.js', array( 'jquery', 'socialwork' ), $theme_version, true );
	}

	/**
	 * Accordion handler.
	 *
	 * @param string $atts attributes from shortcode: name, style.
	 * @param string $content content from shortcode.
	 * @return string
	 */
	public function accordion_handler( $atts, $content ) {

		// only enqueue script when shortcode is present!
		wp_enqueue_script( 'socialwork-accordion-script' );

		// TODO: style attribute.
		$accordion_atts = shortcode_atts(
			array(
				'name'  => '',
				'style' => '',
			),
			$atts
		);

		// if no name set, use default 'accordion'.
		if ( empty( $accordion_atts['name'] ) ) {
			$accordion_name = 'accordion';
		} else {
			// otherwise, get the name from the atts.
			$accordion_name = strtolower( $accordion_atts['name'] );
			// Make name alphanumeric (removes all other characters).
			$accordion_name = preg_replace( '/[^a-z0-9_\s-]/', '', $accordion_name );
			// Clean up multiple dashes or whitespaces in name.
			$accordion_name = preg_replace( '/[\s-]+/', ' ', $accordion_name );
			// Convert whitespaces and underscore to dash.
			$accordion_name = preg_replace( '/[\s_]/', '-', $accordion_name );
		}

		if ( 'uppercase-title' === $accordion_atts['style'] ) {
			$class = 'uppercase-title';
		} else {
			$class = '';
		}

		// if there's no content, display a message with instructions on how to add the required structure.
		if ( empty( $content ) ) {
			return 'No content inside the accordion element. Make sure your close your accordion element. Required stucture: [accordion][section]content[/section][/accordion]';
		}

		// build the shortcode.
		$output = do_shortcode( $content );

 		return sprintf(
			'<div class="accordion %s" id="uw-accordion"><div class="screen-reader-text">%s</div>%s</div>',
			$class,
			$accordion_atts['name'],
			$output
		);
	}

	/**
	 * Section handler.
	 *
	 * @param array  $atts attributes for the accordion section: title, active.
	 * @param string $content content of the section.
	 * @return string
	 */
	public function section_handler( $atts, $content ) {
		$section_atts = shortcode_atts(
			array(
				'title'  => '',
				'subheading'  => '',
				'active' => false,
			),
			$atts
		);

		$class = '';

		if ( empty( $content ) ) {
			$content = 'No content for this section.  Make sure you wrap your content like this: [section]Content here[/section]';
		}
		if ( $section_atts['active'] ) {
			$class      = 'show';
			$active_tab = 'true';
		} else {
			$active_tab = 'false';
			$class      = '';
		}
		$output = do_shortcode( $content );

		return sprintf(
			'<div class="accordion"><div class="card-header" id="accordion-header"><h3 class="mb-0"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="%s" aria-controls="collapse"><span class="btn-text">TEST%s</span><span class="subheading">%s</span><span class="arrow-box"><span class="arrow"></span></span></button></h3></div><div id="collapse" class="collapse %s" aria-labelledby="collapse" data-parent="#accessible-accordion">%s</div></div>',
			$active_tab,
			$section_atts['title'],
			$section_atts['subheading'],
			$class,
			apply_filters( 'the_content', $output )
		);
	}

	/**
	 * Accordion section content handler
	 *
	 * @param string $content content from the panel section.
	 * @return string
	 */
	public function subsection_handler( $content ) {

		if ( empty( $content ) ) {
			$content = 'No content for this section.  Make sure you wrap your content like this: [section]Content here[/section]';
		}

		$output = do_shortcode( $content );
		return sprintf(
			'<div class="card-body">%s</div>',
			apply_filters( 'the_content', $output )
		);
	}
}
