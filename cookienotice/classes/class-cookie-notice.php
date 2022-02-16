<?php
class Cookie_Notice {

	/**
	 * Option name where all options got saved.
	 *
	 * @var string
	 */
	public static $options_group_name = 'COOKIENOTICE';

	/**
	 * Schema of plugin's options.
	 *
	 * @var array[]
	 */
	private static $options_schema = array(
		array(
			'name'   => 'COOKIENOTICE_main',
			'title'  => 'Cookie Notice Settings',
			'fields' => array(
				array(
					'name'    => 'enableCookieNotice',
					'title'   => 'Enable Cookie Notice',
					'type'    => 'checkbox',
					'default' => 1,
				),
				array(
					'name'    => 'cookieNoticeText',
					'title'   => 'Message Text',
					'type'    => 'textarea',
					'default' => 'We use cookies to ensure that we give you the best experience on our website.',
				),
				array(
					'name'    => 'cookieNoticeBtnText',
					'title'   => 'Button Text',
					'type'    => 'text',
					'default' => 'Got It!',
				),
			),
		),
		array(
			'name'   => 'COOKIENOTICE_styles',
			'title'  => 'Cookie Notice Styles',
			'fields' => array(
				array(
					'name'    => 'cookieNoticeBg',
					'title'   => 'Background',
					'type'    => 'color',
					'default' => 'rgba(31,52,74,0.75)',
				),
				array(
					'name'    => 'cookieNoticeFontSize',
					'title'   => 'Text Font Size, px',
					'type'    => 'number',
					'default' => '16',
				),
				array(
					'name'    => 'cookieNoticeAlign',
					'title'   => 'Text Alignment',
					'type'    => 'select',
					'default' => 'left',
					'options' => array(
						'left'   => 'Left',
						'right'  => 'Right',
						'center' => 'Center',
					),
				),
				array(
					'name'    => 'cookieNoticeTextColor',
					'title'   => 'Text Color',
					'type'    => 'color',
					'default' => '#fff',
				),
				array(
					'name'    => 'cookieNoticeBtnFontSize',
					'title'   => 'Button Font Size, px',
					'type'    => 'number',
					'default' => '14',
				),
				array(
					'name'    => 'cookieNoticeBtnBgColor',
					'title'   => 'Button Background Color',
					'type'    => 'color',
					'default' => '#1a78b6',
				),
				array(
					'name'    => 'cookieNoticeBtnTextColor',
					'title'   => 'Button Cancel Text Color',
					'type'    => 'color',
					'default' => '#fff',
				),
				array(
					'name'    => 'cookieNoticeBtnBorderColor',
					'title'   => 'Button Border Color',
					'type'    => 'color',
					'default' => '#1a78b6',
				),
			),
		),
	);

	/**
	 * Admin page slug for options page.
	 *
	 * @var string
	 */
	public static $options_page_name = 'cookie-notice';

	public static function init() {

		register_activation_hook( COOKIENOTICE_PLUGIN_FILE, array( __CLASS__, 'install' ) );
		register_deactivation_hook( COOKIENOTICE_PLUGIN_FILE, array( __CLASS__, 'deactivate' ) );
		register_uninstall_hook( COOKIENOTICE_PLUGIN_FILE, array( __CLASS__, 'uninstall' ) );

		add_action( 'admin_menu', array( __CLASS__, 'init_menu' ), 82 );

		add_action( 'init', array( __CLASS__, 'init_assets' ) );

		add_action( 'admin_init', array( __CLASS__, 'setting_fields' ), 20 );

		add_action( 'wp_footer', array( __CLASS__, 'render_popup' ) );

		add_action( 'wp_footer', array( __CLASS__, 'render_styles' ) );

	}

	public static function init_menu() {
		add_menu_page( 'Cookie Notice', 'Cookie Notice', 'manage_options', self::$options_page_name, array( __CLASS__, 'admin_page' ), 'dashicons-format-aside', 82 );
	}

	public static function init_assets() {
		$options = self::$options_schema;
		$fields  = $options[0]['fields'];
		$enable  = get_option( 'enableCookieNotice' ) ? get_option( 'enableCookieNotice' ) : $fields[0]['default'];

		function cookie_notice_plugin_styles() {
			wp_register_style( 'cookie-notice-style', COOKIENOTICE_PLUGIN_URL . 'assets/css/styles.css', array(), COOKIENOTICE_VERSION );
			wp_enqueue_style( 'cookie-notice-style', COOKIENOTICE_PLUGIN_URL . 'assets/css/styles.css', null, COOKIENOTICE_VERSION );

			wp_register_script( 'cookie-notice-lib', COOKIENOTICE_PLUGIN_URL . '/assets/js/js.cookie.js', array( 'jquery' ), COOKIENOTICE_VERSION, true );
			wp_enqueue_script( 'cookie-notice-lib', COOKIENOTICE_PLUGIN_URL . '/assets/js/js.cookie.js', array( 'jquery' ), COOKIENOTICE_VERSION, true );

			wp_register_script( 'cookie-notice-scripts', COOKIENOTICE_PLUGIN_URL . '/assets/js/scripts.js', array( 'jquery' ), COOKIENOTICE_VERSION, true );
			wp_enqueue_script( 'cookie-notice-scripts', COOKIENOTICE_PLUGIN_URL . '/assets/js/scripts.js', array( 'jquery' ), COOKIENOTICE_VERSION, true );
		}
		function cookie_notice_admin_scripts() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker-alpha', COOKIENOTICE_PLUGIN_URL . '/assets/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '3.0.2', true );
			wp_enqueue_script( 'wp-color-picker-init', COOKIENOTICE_PLUGIN_URL . '/assets/js/wp-color-picker-init.js', array( 'wp-color-picker-alpha' ), '1.0.0', true );
		}
		add_action( 'admin_enqueue_scripts', 'cookie_notice_admin_scripts' );

		if ( $enable ) {
			add_action( 'wp_enqueue_scripts', 'cookie_notice_plugin_styles' );
		}
	}

	public static function admin_page() {
		?>
		<div class="wrap">
			<h2><?php echo get_admin_page_title(); ?></h2>

			<form action="options.php" method="post">
				<?php
				settings_fields( self::$options_group_name );
				do_settings_sections( self::$options_page_name );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public static function setting_fields() {
		// we create one section and add fields to this section
		$options_sections = self::$options_schema;
		foreach ( $options_sections as $section ) {
			$section_name  = $section['name'];
			$section_title = $section['title'];
			add_settings_section( $section_name, $section_title, false, self::$options_page_name );

			$fields = $section['fields'];
			foreach ( $fields as $field ) {

				register_setting( self::$options_group_name, $field['name'] );

				add_settings_field(
					$field['name'],
					$field['title'],
					function () use ( $field ) {
						self::field_callback( $field );
					},
					self::$options_page_name,
					$section_name
				);
			}
		}
	}

	public static function field_callback( $field ) {
		$option_name = $field['name'];
		$option_type = $field['type'];
		switch ( $option_type ) {
			case 'text':
				$value = get_option( $option_name ) ? get_option( $option_name ) : $field['default'];
				echo '<input name="' . $option_name . '" type="text" value="' . $value . '"  size="50" />';
				break;
			case 'color':
				$value = get_option( $option_name ) ? get_option( $option_name ) : $field['default'];
				echo '<input name="' . $option_name . '" type="text" value="' . $value . '"  size="50" class="color-picker" data-alpha-enabled="true" data-default-color="' . $value . '" />';
				break;
			case 'number':
				$value = get_option( $option_name ) ? get_option( $option_name ) : $field['default'];
				echo '<input name="' . $option_name . '" type="number" step="1" value="' . $value . '"  size="50" />';
				break;
			case 'textarea':
				$value = get_option( $option_name ) ? get_option( $option_name ) : $field['default'];
				echo '<textarea name="' . $option_name . '"  rows="3" cols="53">' . $value . '</textarea>';
				if ( ! empty( $field['description'] ) ) {
					echo '<p class="description">' . $field['description'] . '</p>';
				}
				break;
			case 'checkbox':
				$value   = get_option( $option_name ) ? get_option( $option_name ) : $field['default'];
				$checked = ( $value ) ? ' checked' : '';
				echo '<input name="' . $option_name . '" type="checkbox" value="1"' . $checked . ' />';
				break;
			case 'select':
				$value = get_option( $option_name ) ? get_option( $option_name ) : $field['default'];
				if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
					echo '<select name="' . $option_name . '">';
					foreach ( $field['options'] as $key => $label ) {
						$selected = ( $value === $key ) ? ' selected' : '';
						echo '<option value="' . $key . '"' . $selected . '>' . $label . '</option>';
					}
					echo '</select>';
				}
				break;
		}
	}

	/**
	 * Complete Analog of locate_template() but for plugins.
	 * Supports overriding plugin's templates by theme or stylesheet (child theme)
	 *
	 * @param string[]   $template_names   Array of template names to find.
	 * @param bool|false $load             If we should load template or just find it.
	 * @param bool|true  $require_once     Whether to require_once or require.
	 * @param array      $args             Optional. Additional arguments passed to the template.
	 *                                     Default empty array.
	 *
	 * @return string
	 */
	public static function locate_template( $template_name, $load = false, $require_once = true, $args = array() ) {

		$located = '';
		if ( file_exists( STYLESHEETPATH . '/cookie-notice/' . $template_name . '.php' ) ) {
			$located = STYLESHEETPATH . '/cookie-notice/' . $template_name . '.php';
		} elseif ( file_exists( TEMPLATEPATH . '/cookie-notice/' . $template_name . '.php' ) ) {
			$located = TEMPLATEPATH . '/cookie-notice/' . $template_name . '.php';
		} elseif ( file_exists( COOKIENOTICE_PLUGIN_DIR . 'templates/' . $template_name . '.php' ) ) {
			$located = COOKIENOTICE_PLUGIN_DIR . 'templates/' . $template_name . '.php';
		}

		if ( $load && '' !== $located ) {
			load_template( $located, $require_once, $args );
		}

		return $located;
	}

	public static function render_popup() {
		require_once self::locate_template( 'cookie-notice' );
	}

	public static function render_styles() {
		require_once COOKIENOTICE_PLUGIN_DIR . 'templates/custom-styles.php';
	}

	public static function delete_plugin_options() {
		$options_sections = self::$options_schema;
		foreach ( $options_sections as $section ) {
			$fields = $section['fields'];
			foreach ( $fields as $field ) {
				delete_option( $field['name'] );
				unregister_setting( self::$options_group_name, $field['name'] );
			}
		}
	}

	/**
	 * Update permalinks settings upon install.
	 */
	public static function install() {
		self::init_assets();
		flush_rewrite_rules();
	}

	/**
	 * Cleanup permalinks rules after deactivation.
	 */
	public static function deactivate() {
		remove_menu_page( self::$options_page_name );
		flush_rewrite_rules();
	}

	/**
	 * Delete options upon uninstall of plugin.
	 */
	public static function uninstall() {
		self::delete_plugin_options();
	}

}
