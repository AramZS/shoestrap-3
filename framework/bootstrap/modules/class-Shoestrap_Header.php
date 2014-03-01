<?php


if ( ! class_exists( 'Shoestrap_Header' ) ) {

	/**
	* The Header module
	*/
	class Shoestrap_Header {

		function __construct() {
			add_filter( 'redux/options/' . SHOESTRAP_OPT_NAME . '/sections', array( $this, 'options' ), 80 );
			add_action( 'widgets_init',       array( $this, 'header_widgets_init'              ), 30  );
			add_action( 'shoestrap_pre_wrap', array( $this, 'branding'                         ), 3   );
		}
		/*
		 * The Header module options.
		 */
		function options( $sections ) {
			$settings = get_option( SHOESTRAP_OPT_NAME );

			// Jumbotron Options
			$section = array(
				'title' => __( 'Header', 'shoestrap'),
				'icon'  => 'el-icon-eye-open'
			);

			$fields[] = array( 
				'id'          => 'help9',
				'title'       => __( 'Extra Branding Area', 'shoestrap' ),
				'desc'        => __( 'You can enable an extra branding/header area. In this header you can add your logo, and any other widgets you wish.', 'shoestrap' ),
				'type'        => 'info',
			);

			$fields[] = array( 
				'title'       => __( 'Display the Header.', 'shoestrap' ),
				'desc'        => __( 'Turn this ON to display the header. Default: OFF', 'shoestrap' ),
				'id'          => 'header_toggle',
				'default'     => 0,
				'type'        => 'switch',
			);

			$fields[] = array( 
				'title'       => __( 'Display branding on your Header.', 'shoestrap' ),
				'desc'        => __( 'Turn this ON to display branding ( Sitename or Logo )on your Header. Default: ON', 'shoestrap' ),
				'id'          => 'header_branding',
				'default'     => 1,
				'type'        => 'switch',
				'required'    => array('header_toggle','=',array('1')),
			);

			$fields[] = array( 
				'title'       => __( 'Header Background', 'shoestrap' ),
				'desc'        => __( 'Specify the background for your header.', 'shoestrap' ),
				'id'          => 'header_bg',
				'default'     => array(
					'background-color' => '#ffffff'
				),
				'output'      => '.header-wrapper',
				'type'        => 'background',
				'required'    => array( 'header_toggle','=',array( '1' ) ),
			);

			$fields[] = array( 
				'title'       => __( 'Header Background Opacity', 'shoestrap' ),
				'desc'        => __( 'Select the background opacity for your header. Default: 100%.', 'shoestrap' ),
				'id'          => 'header_bg_opacity',
				'default'     => 100,
				'min'         => 0,
				'step'        => 1,
				'max'         => 100,
				'compiler'    => true,
				'type'        => 'slider',
				'required'    => array('header_toggle','=',array('1')),
			);

			$fields[] = array( 
				'title'       => __( 'Header Text Color', 'shoestrap' ),
				'desc'        => __( 'Select the text color for your header. Default: #333333.', 'shoestrap' ),
				'id'          => 'header_color',
				'default'     => '#333333',
				'transparent' => false,    
				'type'        => 'color',
				'required'    => array('header_toggle','=',array('1')),
			);

			$fields[] = array( 
				'title'       => __( 'Header Top Margin', 'shoestrap' ),
				'desc'        => __( 'Select the top margin of header in pixels. Default: 0px.', 'shoestrap' ),
				'id'          => 'header_margin_top',
				'default'     => 0,
				'min'         => 0,
				'max'         => 200,
				'type'        => 'slider',
				'required'    => array('header_toggle','=',array('1')),
			);

			$fields[] = array( 
				'title'       => __( 'Header Bottom Margin', 'shoestrap' ),
				'desc'        => __( 'Select the bottom margin of header in pixels. Default: 0px.', 'shoestrap' ),
				'id'          => 'header_margin_bottom',
				'default'     => 0,
				'min'         => 0,
				'max'         => 200,
				'type'        => 'slider',
				'required'    => array('header_toggle','=',array('1')),
			);

			$section['fields'] = $fields;

			$section = apply_filters( 'shoestrap_module_header_options_modifier', $section );
			
			$sections[] = $section;
			return $sections;

		}

		/**
		 * Register sidebars and widgets
		 */
		function header_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'Header Area', 'shoestrap' ),
				'id'            => 'header-area',
				'before_widget' => '<div class="container">',
				'after_widget'  => '</div>',
				'before_title'  => '<h1>',
				'after_title'   => '</h1>',
			));
		}

		/*
		 * The Header template
		 */
		function branding() {
			if ( shoestrap_getVariable( 'header_toggle' ) == 1 ) { ?>
				<div class="before-main-wrapper">

					<?php if ( shoestrap_getVariable( 'site_style' ) == 'boxed' ) : ?>
						<div class="container">
					<?php endif; ?>

						<div class="header-wrapper">

							<?php if ( shoestrap_getVariable( 'site_style' ) == 'wide' ) : ?>
								<div class="container">
							<?php endif; ?>

								<?php if ( shoestrap_getVariable( 'header_branding' ) == 1 ) : ?>
									<a class="brand-logo" href="<?php echo home_url(); ?>/">
										<h1><?php if ( class_exists( 'ShoestrapBranding' ) ) echo ShoestrapBranding::logo(); ?></h1>
									</a>
								<?php endif; ?>

								<?php $pullclass = ( shoestrap_getVariable( 'header_branding' ) == 1 ) ? ' class="pull-right"' : ''; ?>

								<div<?php echo $pullclass; ?>>
									<?php dynamic_sidebar( 'header-area' ); ?>
								</div >

							<?php if ( shoestrap_getVariable( 'site_style' ) == 'wide' ) : ?>
								</div>
							<?php endif; ?>
						</div>

					<?php if ( shoestrap_getVariable( 'site_style' ) == 'boxed' ) : ?>
						</div>
					<?php endif; ?>
				</div>
				<?php
			}
		}
	}
}