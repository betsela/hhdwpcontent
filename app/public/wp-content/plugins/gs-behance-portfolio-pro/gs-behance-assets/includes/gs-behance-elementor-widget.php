<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_GsBehance_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'gs-behance';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'GS Behance Portfolio', 'gs-behance' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-behance';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Shortcode Settings', 'gs-behance' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gs_beh_cols',
			[
				'label' => __( 'Columns', 'gs-behance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
                    '4'      => '3 Columns',
                    '3'      => '4 Columns'
				],
				'default' => '3',
			]
        );
        

		$this->add_control(
			'gs_beh_theme',
			[
				'label' => __( 'Select Theme', 'gs-behance' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [

                    'gs_beh_theme1'   => 'Theme 1 (Projects)',
                    'gs_beh_theme2'   => 'Theme 2 (Projects Stat)',
                    'gs_beh_theme3'   => 'Theme 3 (Hover)',
                    'gs_beh_theme4'   => 'Theme 4 (Popup)',
                    'gs_beh_theme5'   => 'Theme 5 (Slider)',
                    'gs_beh_theme6'   => 'Theme 6 (Profile)',
                    'gs_beh_theme7'   => 'Theme 7 (Filter)'

				],
				'default' => 'gs_beh_theme1',
			]
        );

        $this->add_control(
			'gs_beh_tot_projects',
			[
				'label' => __( 'Total projects to display', 'gs-behance' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 5,
				
			]
        );
        

		$this->add_control(
			'ge_be_field',
			[
				'label' => __( 'Field', 'gs-behance' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
        );
        
        
    
        
		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		

		echo do_shortcode('[gs_behance theme="'.$settings['gs_beh_theme'].'" column="'.$settings['gs_beh_cols'].'" count="'.$settings['gs_beh_tot_projects'].'" field="'.$settings['ge_be_field'].'"]');

	}

	// protected function _content_template() {
	// 	echo do_shortcode('[gs_logo theme="{{{settings.theme}}}"]');
	// }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_GsBehance_Widget() );