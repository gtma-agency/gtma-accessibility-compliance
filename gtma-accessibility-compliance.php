<?php
/*
Plugin Name: GTMA Accessibility & Compliance
Plugin URI: https://gtma.agency/accessibility-compliance
Description: Adds accessibilty and complaince support to websites powered by GTMA
Version: 0.1.0
Author: GTMA Devs
Author URI: https://gtma.agency
Text Domain: gtma-a-c
Domain Path: /languages
*/

add_action( 'wp_head', function() {

    $gtma_a_c_settings_options = get_option( 'gtma_a_c_settings_option_name' ); // Array of All Options
    $compliance_termly_uuid_1 = $gtma_a_c_settings_options['compliance_termly_uuid_1']; // Termly UUID
    $enable_auto_blocker = $gtma_a_c_settings_options['enable_auto_blocker'] ? 'yes' : 'no'; // Termly Auto Block
	
    if ($compliance_termly_uuid_1) {
        echo '
        <script
            type="text/javascript"
            src="https://app.termly.io/embed.min.js"
            data-auto-block="'. $enable_auto_blocker .'"
            data-website-uuid="' . $compliance_termly_uuid_1 . '"
            ></script>
        ';
    } else {
        echo '
        <script>
        console.log("Please add the Termly UUID in the settings page");
        </script>';
    }
}, 1);

add_action( 'wp_footer', function() {

    $gtma_a_c_settings_options = get_option( 'gtma_a_c_settings_option_name' ); // Array of All Options
    $accessibility_panel_color_0 = $gtma_a_c_settings_options['accessibility_panel_color_0']; // Accessibility Panel Color

    echo "
    <script>
    (function(){
        var s = document.createElement('script'),
        e = ! document.body ? document.querySelector('head') : document.body;
        s.src = 'https://acsbapp.com/apps/app/dist/js/app.js';
        s.async = true;
        s.onload = function(){
        acsbJS.init({
            statementLink : '',
            footerHtml : 'Powered by GTMA',
            hideMobile : false,
            hideTrigger : false,
            language : 'en',
            position : 'right',
            leadColor : '$accessibility_panel_color_0', // customize to the site colors
            triggerColor : '$accessibility_panel_color_0', // customize to the site colors
            triggerRadius : '50%',
            triggerPositionX : 'right',
            triggerPositionY : 'bottom',
            triggerIcon : 'wheels2',
            triggerSize : 'medium',
            triggerOffsetX : 70,
            triggerOffsetY : 20,
            mobile : {
                triggerSize : 'small',
                triggerPositionX : 'right',
                triggerPositionY : 'center',
                triggerOffsetX : 10,
                triggerOffsetY : 0,
                triggerRadius : '50%'
            }
        });
        };
        e.appendChild(s);
    }());
    </script>
    ";
}, 100 );

/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class GTMAACSettings {
	private $gtma_a_c_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'gtma_a_c_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'gtma_a_c_settings_page_init' ) );
	}

	public function gtma_a_c_settings_add_plugin_page() {
		add_options_page(
			'Accessibility &amp; Compliance', // page_title
			'Accessibility &amp; Compliance', // menu_title
			'activate_plugins', // capability
			'gtma-a-c-settings', // menu_slug
			array( $this, 'gtma_a_c_settings_create_admin_page' ) // function
		);
	}

	public function gtma_a_c_settings_create_admin_page() {
		$this->gtma_a_c_settings_options = get_option( 'gtma_a_c_settings_option_name' ); ?>

		<div class="wrap">
			<h2>GTMA Accessibility + Compliance Settings</h2>
			<p>Customize the settings for your Accessibility and Compliance package through GTMA</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'gtma_a_c_settings_option_group' );
					do_settings_sections( 'gtma-a-c-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function gtma_a_c_settings_page_init() {
		register_setting(
			'gtma_a_c_settings_option_group', // option_group
			'gtma_a_c_settings_option_name', // option_name
			array( $this, 'gtma_a_c_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'gtma_a_c_settings_setting_section', // id
			'Settings', // title
			array( $this, 'gtma_a_c_settings_section_info' ), // callback
			'gtma-a-c-settings-admin' // page
		);

		add_settings_field(
			'accessibility_panel_color_0', // id
			'Accessibility Panel Color(hex)', // title
			array( $this, 'accessibility_panel_color_0_callback' ), // callback
			'gtma-a-c-settings-admin', // page
			'gtma_a_c_settings_setting_section' // section
		);

		add_settings_field(
			'accessibility_trigger_offset', // id
			'Accessibility Icon Offset(px)', // title
			array( $this, 'accessibility_trigger_offset_callback' ), // callback
			'gtma-a-c-settings-admin', // page
			'gtma_a_c_settings_setting_section', // section
		);

		add_settings_field(
			'compliance_termly_uuid_1', // id
			'Termly UUID', // title
			array( $this, 'compliance_termly_uuid_1_callback' ), // callback
			'gtma-a-c-settings-admin', // page
			'gtma_a_c_settings_setting_section' // section
		);

		add_settings_field(
			'enable_auto_blocker', // id
			'Enable Auto Blocker', // title
			array( $this, 'enable_auto_blocker_callback' ), // callback
			'gtma-a-c-settings-admin', // page
			'gtma_a_c_settings_setting_section' // section
		);
	}

	public function gtma_a_c_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['accessibility_panel_color_0'] ) ) {
			$sanitary_values['accessibility_panel_color_0'] = sanitize_text_field( $input['accessibility_panel_color_0'] );
		}

		if ( isset( $input['accessibility_trigger_offset'] ) ) {
			$sanitary_values['accessibility_trigger_offset'] = sanitize_text_field( $input['accessibility_trigger_offset'] );
		}

        if ( isset( $input['compliance_termly_uuid_1'] ) ) {
			$sanitary_values['compliance_termly_uuid_1'] = sanitize_text_field( $input['compliance_termly_uuid_1'] );
		}

		if ( isset( $input['enable_auto_blocker'] ) ) {
			$sanitary_values['enable_auto_blocker'] = sanitize_text_field( $input['enable_auto_blocker'] );
		}

        return $sanitary_values;
	}

	public function gtma_a_c_settings_section_info() {
		
	}

	public function accessibility_panel_color_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="gtma_a_c_settings_option_name[accessibility_panel_color_0]" id="accessibility_panel_color_0" value="%s">',
			isset( $this->gtma_a_c_settings_options['accessibility_panel_color_0'] ) ? esc_attr( $this->gtma_a_c_settings_options['accessibility_panel_color_0']) : ''
		);
	}

	public function accessibility_trigger_offset_callback() {
		printf(
			'<input class="regular-text" type="number" name="gtma_a_c_settings_option_name[accessibility_trigger_offset]" id="accessibility_trigger_offset" value="%s">',
			isset( $this->gtma_a_c_settings_options['accessibility_trigger_offset'] ) ? esc_attr( $this->gtma_a_c_settings_options['accessibility_trigger_offset']) : '20'
		);
	}

    public function compliance_termly_uuid_1_callback() {
        printf(
            '<input class="regular-text" type="text" name="gtma_a_c_settings_option_name[compliance_termly_uuid_1]" id="compliance_termly_uuid_1" value="%s">',
            isset( $this->gtma_a_c_settings_options['compliance_termly_uuid_1'] ) ? esc_attr( $this->gtma_a_c_settings_options['compliance_termly_uuid_1']) : ''
        );
	}

	public function enable_auto_blocker_callback() {
		$options = $this->gtma_a_c_settings_options['enable_auto_blocker'];

		$html = '<input type="checkbox" id="enable_auto_blocker" name="gtma_a_c_settings_option_name[enable_auto_blocker]" value="1"' . checked( 1, $options, false ) . '/>';
		$html .= '<br><span class="description">If there are issues with page elements loading, try disabling this.</span>';
		echo $html;
	}
}
if ( is_admin() )
	$gtma_a_c_settings = new GTMAACSettings();

/* 
 * Retrieve this value with:
 * $gtma_a_c_settings_options = get_option( 'gtma_a_c_settings_option_name' ); // Array of All Options
 * $accessibility_panel_color_0 = $gtma_a_c_settings_options['accessibility_panel_color_0']; // Accessibility Panel Color
 * $accessibility_trigger_color_1 = $gtma_a_c_settings_options['accessibility_trigger_color_1']; // Accessibility Trigger Color
 */
