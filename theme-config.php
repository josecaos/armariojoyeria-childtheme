<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('chamo_Theme_Config')) {

    class chamo_Theme_Config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'chamo'),
                'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'chamo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'chamo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'chamo'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'chamo'); ?>" />
                <?php endif; ?>

                <h4><?php echo ''.$this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'chamo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'chamo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' .__('Tags', 'chamo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo ''.$this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' .__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'chamo') . '</p>',__('http://codex.wordpress.org/Child_Themes', 'chamo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
	
            // General
            $this->sections[] = array(
                'title'     => esc_html__('General', 'chamo'),
                'desc'      => esc_html__('General theme options', 'chamo'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(

                    array(
                        'id'        => 'logo_main',
                        'type'      => 'media',
                        'title'     => esc_html__('Logo', 'chamo'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'chamo'),
                    ),
                    array(
                        'id'        => 'logo_homepage',
                        'type'      => 'media',
                        'title'     => esc_html__('Logo in homepage 1, 2', 'chamo'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'chamo'),
                    ),
					array(
                        'id'        => 'opt-favicon',
                        'type'      => 'media',
                        'title'     => esc_html__('Favicon', 'chamo'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload favicon here.', 'chamo'),
                    ),
                    array(
                        'id'        => 'background_opt',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => esc_html__('Body background', 'chamo'),
                        'subtitle'  => esc_html__('Upload image or select color. Only work with box layout', 'chamo'),
                        'default'   => array(
                                            'background-color'=>'#ffffff',
                                        ),
                    ),
                    array(
                        'id'        => 'page_content_background',
                        'type'      => 'background',
                        'output'    => array('.main-container'),
                        'title'     => esc_html__('Page content background', 'chamo'),
                        'subtitle'  => esc_html__('Select background for page content (default: #ffffff).', 'chamo'),
                        'default'   => array(
                                            'background-color'=>'#ffffff',
                                        ),
                    ),
                    array(
                        'id'        => 'back_to_top',
                        'type'      => 'switch',
                        'title'     => esc_html__('Back To Top', 'chamo'),
                        'desc'      => esc_html__('Show back to top button on all pages', 'chamo'),
                        'default'   => true,
                    ),
                ),
            );
			// Colors
            $this->sections[] = array(
                'title'     => esc_html__('Colors', 'chamo'),
                'desc'      => esc_html__('Color options', 'chamo'),
                'icon'      => 'el-icon-tint',
                'fields'    => array(
					array(
                        'id'        => 'primary_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Primary Color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for primary color (default: #f26522).', 'chamo'),
						'transparent' => false,
                        'default'   => '#f26522',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'sale_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Sale Label BG Color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for bg sale label (default: #f26522).', 'chamo'),
						'transparent' => true,
                        'default'   => '#f26522',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'saletext_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Sale Label Text Color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for sale label text (default: #ffffff).', 'chamo'),
						'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'rate_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Rating Star Color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for star of rating (default: #f7c71d).', 'chamo'),
						'transparent' => false,
                        'default'   => '#f7c71d',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'       => 'link_color',
                        'type'     => 'link_color',
                        //'output'    => array('a'),
                        'title'     => esc_html__('Link Color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for link (default: #7d7d7d).', 'chamo'),
                        'default'  => array(
                            'regular'  => '#7d7d7d',
                            'hover'    => '#f26522',
                            'active'   => '#f26522',
                            'visited'  => '#f26522',
                        )
                    ),
                    array(
                        'id'        => 'text_selected_bg',
                        'type'      => 'color',
                        'title'     => esc_html__('Text selected background', 'chamo'),
                        'subtitle'  => esc_html__('Select background for selected text (default: #91b2c3).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#91b2c3',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'text_selected_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Text selected color', 'chamo'),
                        'subtitle'  => esc_html__('Select color for selected text (default: #ffffff).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
                ),
            );
			
			//Header
			$this->sections[] = array(
                'title'     => esc_html__('Header', 'chamo'),
                'desc'      => esc_html__('Header options', 'chamo'),
                'icon'      => 'el-icon-tasks',
                'fields'    => array(

					array(
                        'id'        => 'header_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Header Layout', 'chamo'),
                       'customizer_only'   => false,
                        //Must provide key => value pairs for select options
                        'options'   => array(
                            'default' => 'Default',
                            'second' => 'Second',
                            'third' => 'Third',
                            'fourth' => 'Fourth',
                            'fifth' => 'Fifth',
                            'sixth' => 'Sixth',
                        ),
                        'default'   => 'default'
                    ),
                    array(
                        'id'        => 'header_bg',
                        'type'      => 'background',
                        'output'    => array('.header'),
                        'title'     => esc_html__('Header background', 'chamo'),
                        'subtitle'  => esc_html__('Upload image or select color.', 'chamo'),
                        'default'   => array(
                                            'background-color'=>'#ffffff',
                                        ),

                    ),
                    array(
                        'id'        => 'header_color',
                        'type'      => 'color',
                        'output'    => array('.header'),
                        'title'     => esc_html__('Header text color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for top bar text color (default: #363636).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#363636',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'       => 'header_link_color',
                        'type'     => 'link_color',
                        'title'     => esc_html__('Header link color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for header link color (default: #363636).', 'chamo'),
                        'default'  => array(
                            'regular'  => '#363636',
                            'hover'    => '#f26522',
                            'active'   => '#f26522',
                            'visited'  => '#f26522',
                        )
                    ),
                    array(
                        'id'        => 'slider_alias',
                        'type'      => 'text',
                        'title'     => esc_html__('Slider Alias', 'chamo'),
                        'subtitle'     => esc_html__('Enter the slider alias, only for homepage 4', 'chamo'),
                                        'default'   => 'home4-slider'
                                        ),
                ),
            );

            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Top Bar', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'topbar_bg',
                        'type'      => 'background',
                        'output'    => array('.top-bar'),
                        'title'     => esc_html__('Top bar background', 'chamo'),
                        'subtitle'  => esc_html__('Upload image or select color(default: #ffffff).', 'chamo'),
                        'default'   => array('background-color'=>'#ffffff'),
                    ),
                    array(
                        'id'        => 'topbar_color',
                        'type'      => 'color',
                        'output'    => array('.top-bar'),
                        'title'     => esc_html__('Top bar text color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for top bar text color (default: #363636).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#363636',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'       => 'topbar_link_color',
                        'type'     => 'link_color',
                        'output'    => array('.top-bar a'),
                        'title'     => esc_html__('Top bar link color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for top bar link color (default: #363636).', 'chamo'),
                        'default'  => array(
                            'regular'  => '#363636',
                            'hover'    => '#f26522',
                            'active'   => '#f26522',
                            'visited'  => '#476D83',
                        )
                    ),
                )
            );

            
			$this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Sticky header', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'sticky_header',
                        'type'      => 'switch',
                        'title'     => esc_html__('Use sticky header', 'chamo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'header_sticky_bg',
                        'type'      => 'color_rgba',
                        'title'     => esc_html__('Header sticky background', 'chamo'),
                        'subtitle'  => 'Set color and alpha channel',
                        'output'    => array('background-color' => '.header-sticky.ontop'),
                        'default'   => array(
                            'color'     => '#ffffff',
                            'alpha'     => 1
                        ),
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => 'Choose',
                            'cancel_text'               => 'Cancel',
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,
                            'input_text'                => 'Select Color'
                        ),                        
                    ),
                )
            );
            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Menu', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                
                    array(
                        'id'        => 'mobile_menu_label',
                        'type'      => 'text',
                        'title'     => esc_html__('Mobile menu label', 'chamo'),
                        'subtitle'     => esc_html__('The label for mobile menu (example: Menu, Go to...', 'chamo'),
                        'default'   => 'Menu'
                    ), 
                    array(
                        'id'        => 'sub_menu_bg',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Submenu background', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for sub menu bg (default: #252525).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#252525',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'sub_menu_color',
                        'type'      => 'color',
                        //'output'    => array(),
                        'title'     => esc_html__('Submenu color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for sub menu color (default: #959595).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#959595',
                        'validate'  => 'color',
                    ),
                )
            );   
            
            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Header Static Block', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                
                    array(
                        'id'=>'header_block',
                        'type' => 'textarea',
                        'title' => esc_html__('Content header static block (default: in header layout6)', 'chamo'), 
                        'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, strong, p, ul, li, div, h4', 'chamo'),
                        'default' => '',
                        'args'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 10
                        )
                    ),
                )
            );

			//Footer
			$this->sections[] = array(
                'title'     => esc_html__('Footer', 'chamo'),
                'desc'      => esc_html__('Footer options', 'chamo'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(

                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Footer Layout', 'chamo'),
                       'customizer_only'   => false,

                        //Must provide key => value pairs for select options
                        'options'   => array(
                            'default' => 'Default',
                            'second' => 'Second',
                            'third' => 'Third',
                            'fourth' => 'Fourth',
                        ),
                        'default'   => 'default'
                    ),
                    array(
                        'id'        => 'footer_bg',
                        'type'      => 'background',
                        'output'    => array('.footer'),
                        'title'     => esc_html__('Footer background', 'chamo'),
                        'subtitle'  => esc_html__('Upload image or select color ( default: #252525).', 'chamo'),
                        'default'   => array(
                                            'background-color'=>'#252525',
                                        ),
                    ),
                    array(
                        'id'        => 'footer_color',
                        'type'      => 'color',
                        'output'    => array('.footer'),
                        'title'     => esc_html__('Footer text color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for top bar text color (default: #959595).', 'chamo'),
                        'transparent' => false,
                        'default'   => '#959595',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'       => 'footer_link_color',
                        'type'     => 'link_color',
                        'output'    => array('.footer a'),
                        'title'     => esc_html__('Footer link color', 'chamo'),
                        'subtitle'  => esc_html__('Pick a color for footer link color (default: #f26522).', 'chamo'),
                        'default'  => array(
                            'regular'  => '#f26522',
                            'hover'    => '#f26522',
                            'active'   => '#f26522',
                            'visited'  => '#f26522',
                        )
                    ),
					array(
                        'id'        => 'logo_footer',
                        'type'      => 'media',
                        'title'     => esc_html__('Footer Logo', 'chamo'),
                        'compiler'  => 'true',
                        'mode'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'chamo'),
                    ),
					array(
						'id'               => 'copyright',
						'type'             => 'editor',
						'title'    => esc_html__('Copyright information', 'chamo'),
						'subtitle'         => esc_html__('HTML tags allowed: a, br, em, strong', 'chamo'),
						'default'          => 'Copyright RoadThemes 2016. All Rights Reserved',
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 5,
							'media_buttons'	=> false,
						)
					),
                ),
            );

            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'About Us', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'=>'about_us',
                        'type' => 'textarea',
                        'title' => esc_html__('About Us', 'chamo'), 
                        'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, strong, p, ul, li', 'chamo'),
                        'default' => '',
                    ),
                )
            );

            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Social Icons', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                
                    array(
                        'id'       => 'social_icons',
                        'type'     => 'sortable',
                        'title'    => esc_html__('Social Icons', 'chamo'),
                        'subtitle' => esc_html__('Enter social links', 'chamo'),
                        'desc'     => esc_html__('Drag/drop to re-arrange', 'chamo'),
                        'mode'     => 'text',
                        'options'  => array(
                            'facebook-square'     => '',
                            'twitter-square'     => '',
                            'instagram' => '',
                            'linkedin-square'     => '',
                            'youtube-square'     => '',
                            'pinterest-square'     => '',
                            'google-plus-square'     => '',
                            'tumblr-square'     => '',
                            'behance-square'     => '',
                            'vimeo-square'     => '',
                        ),
                        'default' => array(
                            'facebook-square'     => 'https://www.facebook.com/',
                            'twitter-square'     => 'https://twitter.com/',
                            'instagram' => 'https://www.instagram.com',
                            'linkedin-square'     => 'https://www.linkedin.com',
                            'youtube-square'     => 'https://www.youtube.com',
                            'pinterest-square'     => 'https://www.pinterest.com/',
                            'google-plus-square'     => 'https://plus.google.com/',
                            'tumblr-square'     => 'https://www.tumblr.com',
                            'behance-square'     => 'https://www.behance.net',
                            'vimeo-square'     => 'https://vimeo.com',
                        ),
                    ),
                )
            );

            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Recent Posts', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'footer_recent_post_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Recent post title', 'chamo'),
                        'subtitle' => esc_html__('Footer recent post title.', 'chamo'),
                        'default'   => 'Recent Posts'
                    ),
                )
            );
            
            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Product Tags', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'footer_product_tag_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Product tag title', 'chamo'),
                        'subtitle' => esc_html__('Footer product tag title.', 'chamo'),
                        'default'   => 'Related Tags'
                    ),
                )
            );

			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Newsletter', 'chamo' ),
				'subsection' => true,
				'fields'     => array(
					array(
                        'id'        => 'newsletter_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Newsletter title', 'chamo'),
                        'default'   => 'Please write your email and get our amazing updates, news and support...'
                    ),
					array(
						'id'       => 'newsletter_form',
						'type'     => 'text',
						'title'    => esc_html__('Newsletter form ID', 'chamo'),
						'subtitle' => esc_html__('The form ID of MailPoet plugin.', 'chamo'),
						'validate' => 'numeric',
						'msg'      => 'Please enter a form ID',
						'default'  => '1'
					),
				)
			);
		
            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Contact Information', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'contact_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Contact title', 'chamo'),
                        'default'   => 'Contact Info'
                    ),
                    array(
                        'id'=>'contact_info',
                        'type' => 'editor',
                        'title' => esc_html__('Contact Information', 'chamo'), 
                        'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, strong, p, ul, li', 'chamo'),
                        'default' => '',
                        'args'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 10
                        )
                    ),
                )
            );
            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Menus', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'footer_bottom',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Footer bottom Menu', 'chamo' ),
                        'subtitle' => esc_html__( 'Select a menu', 'chamo' ),
                    ),
                )
            );
			
			//Fonts
			$this->sections[] = array(
                'title'     => esc_html__('Fonts', 'chamo'),
                'desc'      => esc_html__('Fonts options', 'chamo'),
                'icon'      => 'el-icon-font',
                'fields'    => array(

                    array(
                        'id'            => 'bodyfont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Body font', 'chamo'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
						'text-align'   => false,
                        //'font-size'     => false,
                        //'line-height'   => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'output'        => array('body'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Main body font.', 'chamo'),
                        'default'       => array(
                            'color'         => '#959595',
                            'font-weight'    => '400',
                            'font-family'   => 'Montserrat',
                            'google'        => true,
                            'font-size'     => '14px',
                            'line-height'   => '24px'
						),
                    ),
					array(
                        'id'            => 'headingfont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Heading font', 'chamo'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size'     => false,
                        'line-height'   => false,
						'text-align'   => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        //'output'        => array('h1, h2, h3, h4, h5, h6'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Heading font.', 'chamo'),
                        'default'       => array(
							'color'         => '#363636',
                            'font-weight'    => '700',
                            'font-family'   => 'Montserrat',
                            'google'        => true,
						),
                    ),
					array(
                        'id'            => 'menufont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Menu font', 'chamo'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
						'text-align'   => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        //'output'        => array('h1, h2, h3, h4, h5, h6'), // An array of CSS selectors to apply this font style to dynamically
                        //'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Menu font.', 'chamo'),
                        'default'       => array(
                            'color'         => '#363636',
                            'font-weight'    => '400',
                            'font-family'   => 'Montserrat',
							'font-size'     => '14px',
                            'google'        => true,
						),
                    ),
                ),
            );
			
			// Layout
            $this->sections[] = array(
                'title'     => esc_html__('Layout', 'chamo'),
                'desc'      => esc_html__('Select page layout: Box or Full Width', 'chamo'),
                'icon'      => 'el-icon-align-justify',
                'fields'    => array(
					array(
						'id'       => 'page_layout',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__('Page Layout', 'chamo'),
						'options'  => array(
							'full' => 'Full Width',
							'box' => 'Box'
						),
						'default'  => 'full'
					),
                    array(
                        'id'        => 'box_layout_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Box layout width', 'chamo'),
                        'desc'      => esc_html__('Box layout width in pixels, default value: 1200', 'chamo'),
                        "default"   => 1200,
                        "min"       => 960,
                        "step"      => 1,
                        "max"       => 1920,
                        'display_value' => 'text'
                    ),
					array(
                        'id'        => 'preset_option',
                        'type'      => 'select',
                        'title'     => esc_html__('Preset', 'chamo'),
						'subtitle'      => esc_html__('Select a preset to quickly apply pre-defined colors and fonts', 'chamo'),
                       'customizer_only'   => false,
                        'options'   => array(
							'1' => 'Use options',
                            '2' => 'Preset 2',
                            '3' => 'Preset 3',
                            '4' => 'Preset 4',
                            '5' => 'Preset 5',
                            '6' => 'Preset 6',
                        ),
                        'default'   => '1'
                    ),
					array(
                        'id'        => 'enable_sswitcher',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show Style Switcher', 'chamo'),
						'subtitle'     => esc_html__('The style switcher is only for preview on front-end', 'chamo'),
						'default'   => true,
                    ),
                ),
            );
			
			//Brand logos
			$this->sections[] = array(
                'title'     => esc_html__('Brand Logos', 'chamo'),
                'desc'      => esc_html__('Upload brand logos and links', 'chamo'),
                'icon'      => 'el-icon-briefcase',
                'fields'    => array(
					array(
                        'id'       => 'brandscroll',
                        'type'     => 'switch',
                        'title'    => esc_html__('Auto scroll', 'chamo'),
                        'default'  => false,
                    ),
                    array(
                        'id'        => 'brandscrollnumber',
                        'type'      => 'slider',
                        'title'     => esc_html__('Scroll amount', 'chamo'),
                        'desc'      => esc_html__('Number of logos to scroll one time, default value: 1', 'chamo'),
                        "default"   => 1,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 12,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'brandpause',
                        'type'      => 'slider',
                        'title'     => esc_html__('Pause in (seconds)', 'chamo'),
                        'desc'      => esc_html__('Pause time, default value: 3000', 'chamo'),
                        "default"   => 3000,
                        "min"       => 1000,
                        "step"      => 500,
                        "max"       => 10000,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'brandanimate',
                        'type'      => 'slider',
                        'title'     => esc_html__('Animate in (seconds)', 'chamo'),
                        'desc'      => esc_html__('Animate time, default value: 2000', 'chamo'),
                        "default"   => 2000,
                        "min"       => 300,
                        "step"      => 100,
                        "max"       => 5000,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'          => 'brand_logos',
                        'type'        => 'slides',
                        'title'       => esc_html__('Logos', 'chamo'),
                        'desc'        => esc_html__('Upload logo image and enter logo link.', 'chamo'),
                        'placeholder' => array(
                            'title'           => esc_html__('Title', 'chamo'),
                            'description'     => esc_html__('Description', 'chamo'),
                            'url'             => esc_html__('Link', 'chamo'),
                        ),
                    ),
                ),
            );
           

			// Sidebar
			$this->sections[] = array(
                'title'     => esc_html__('Sidebar', 'chamo'),
                'desc'      => esc_html__('Sidebar options', 'chamo'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
					
					array(
                        'id'       => 'sidebarshop_pos',
                        'type'     => 'radio',
                        'title'    => esc_html__('Shop Sidebar Position', 'chamo'),
                        'subtitle'      => esc_html__('Sidebar on shop page', 'chamo'),
                        'options'  => array(
                            'left' => 'Left',
                            'right' => 'Right'),
                        'default'  => 'left'
                    ),
                    array(
                        'id'       => 'sidebarse_pos',
                        'type'     => 'radio',
                        'title'    => esc_html__('Pages Sidebar Position', 'chamo'),
                        'subtitle'      => esc_html__('Sidebar on pages', 'chamo'),
                        'options'  => array(
                            'left' => 'Left',
                            'right' => 'Right'),
                        'default'  => 'left'
                    ),
                    array(
                        'id'       => 'sidebarblog_pos',
                        'type'     => 'radio',
                        'title'    => esc_html__('Blog Sidebar Position', 'chamo'),
                        'subtitle'      => esc_html__('Sidebar on Blog pages', 'chamo'),
                        'options'  => array(
                            'left' => 'Left',
                            'right' => 'Right'),
                        'default'  => 'right'
                    )
                ),
            );
			
			// Portfolio
            $this->sections[] = array(
                'title'     => esc_html__('Portfolio', 'chamo'),
                'desc'      => esc_html__('Use this section to select options for portfolio', 'chamo'),
                'icon'      => 'el-icon-bookmark',
                'fields'    => array(
					array(
						'id'        => 'portfolio_columns',
						'type'      => 'slider',
						'title'     => esc_html__('Portfolio Columns', 'chamo'),
						"default"   => 3,
						"min"       => 2,
						"step"      => 1,
						"max"       => 4,
						'display_value' => 'text'
					),
					array(
						'id'        => 'portfolio_per_page',
						'type'      => 'slider',
						'title'     => esc_html__('Projects per page', 'chamo'),
						'desc'      => esc_html__('Amount of projects per page on portfolio page', 'chamo'),
						"default"   => 12,
						"min"       => 4,
						"step"      => 1,
						"max"       => 48,
						'display_value' => 'text'
					),
					array(
                        'id'        => 'related_project_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Related projects title', 'chamo'),
                        'default'   => 'Related Projects'
                    ),
                ),
            );
			
			// Product
            $this->sections[] = array(
                'title'     => esc_html__('Product', 'chamo'),
                'desc'      => esc_html__('Use this section to select options for product', 'chamo'),
                'icon'      => 'el-icon-tags',
                'fields'    => array(
					array(
                        'id'        => 'shop_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Shop Layout', 'chamo'),
                        'options'   => array(
                            'sidebar' => 'Sidebar',
                            'fullwidth' => 'Full Width',
                        ),
                        'default'   => 'sidebar'
                    ),
                    array(
                        'id'        => 'default_view',
                        'type'      => 'select',
                        'title'     => esc_html__('Shop default view', 'chamo'),
                        'options'   => array(
                            'grid-view' => 'Grid View',
                            'list-view' => 'List View',
                        ),
                        'default'   => 'grid-view'
                    ),
                    array(
                        'id'        => 'product_per_page',
                        'type'      => 'slider',
                        'title'     => esc_html__('Products per page', 'chamo'),
                        'subtitle'      => esc_html__('Amount of products per page on category page', 'chamo'),
                        "default"   => 12,
                        "min"       => 4,
                        "step"      => 1,
                        "max"       => 48,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'product_per_row',
                        'type'      => 'slider',
                        'title'     => esc_html__('Product columns', 'chamo'),
                        'subtitle'      => esc_html__('Amount of product columns on category page', 'chamo'),
                        'desc'      => esc_html__('Only works with: 1, 2, 3, 4, 6', 'chamo'),
                        "default"   => 3,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 6,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'product_per_row_fw',
                        'type'      => 'slider',
                        'title'     => esc_html__('Product columns on full width shop', 'chamo'),
                        'subtitle'      => esc_html__('Amount of product columns on full width category page', 'chamo'),
                        'desc'      => esc_html__('Only works with: 1, 2, 3, 4, 6', 'chamo'),
                        "default"   => 4,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 6,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'       => 'second_image',
                        'type'     => 'switch',
                        'title'    => esc_html__('Use secondary product image', 'chamo'),
                        'desc'      => esc_html__('Show the secondary image when hover on product on list', 'chamo'),
                        'default'  => true,
                    ),
                    array(
                        'id'        => 'upsells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Up-Sells title', 'chamo'),
                        'default'   => 'Upsell Products'
                    ),
                    array(
                        'id'        => 'crosssells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Cross-Sells title', 'chamo'),
                        'default'   => 'Cross-sells Products'
                    ),
                ),
            );
			// Background category
            $this->sections[] = array(
                'title'     => esc_html__('Background category', 'chamo'),
                'desc'      => esc_html__('Use this section to upload background image for product category page, select background color', 'chamo'),
                'icon'      => 'el-icon-picture',
                'subsection' => true,
                'fields'    => array(
                    
                    array(
                        'id'        => 'background_category',
                        'type'      => 'background',
                        'output'    => array('.shop-desc-inner'),
                        'title'     => esc_html__('Background category', 'chamo'),
                        'subtitle'  => esc_html__('Body background with image, color.', 'chamo'),
                        'default'   => '#ffffff',
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Product page', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'related_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Related products title', 'chamo'),
                        'default'   => 'Related Products'
                    ),
                    array(
                        'id'        => 'related_amount',
                        'type'      => 'slider',
                        'title'     => esc_html__('Number of related products', 'chamo'),
                        "default"   => 4,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 16,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'upsells_title',
                        'type'      => 'text',
                        'title'     => esc_html__('Up-Sells title', 'chamo'),
                        'default'   => 'Upsell Products'
                    ),
                    array(
                        'id'=>'share_head_code',
                        'type' => 'textarea',
                        'title' => esc_html__('ShareThis/AddThis head tag', 'chamo'), 
                        'desc' => esc_html__('Paste your ShareThis or AddThis head tag here', 'chamo'),
                        'default' => '',
                    ),
                    array(
                        'id'=>'share_code',
                        'type' => 'textarea',
                        'title' => esc_html__('ShareThis/AddThis code', 'chamo'), 
                        'desc' => esc_html__('Paste your ShareThis or AddThis code here', 'chamo'),
                        'default' => ''
                    ),
                )
            );
            $this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Quick View', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'        => 'detail_link_text',
                        'type'      => 'text',
                        'title'     => esc_html__('View details text', 'chamo'),
                        'default'   => 'View details'
                    ),
                    array(
                        'id'        => 'quickview_link_text',
                        'type'      => 'text',
                        'title'     => esc_html__('View all features text', 'chamo'),
                        'desc'      => esc_html__('This is the text on quick view box', 'chamo'),
                        'default'   => 'See all features'
                    ),
                )
            );
			// Blog options
            $this->sections[] = array(
                'title'     => esc_html__('Blog', 'chamo'),
                'desc'      => esc_html__('Use this section to select options for blog', 'chamo'),
                'icon'      => 'el-icon-file',
                'fields'    => array(
					array(
                        'id'        => 'blog_header_text',
                        'type'      => 'text',
                        'title'     => esc_html__('Blog header text', 'chamo'),
                        'default'   => 'Blog'
                    ),
                    array(
                        'id'        => 'blog_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Blog Layout', 'chamo'),
                        'options'   => array(
							'largeimage' => 'Large Image',
                            'nosidebar' => 'No Sidebar',
                            'sidebar' => 'Sidebar',
                        ),
                        'default'   => 'sidebar'
                    ),
                    array(
                        'id'        => 'readmore_text',
                        'type'      => 'text',
                        'title'     => esc_html__('Read more text', 'chamo'),
                        'default'   => 'Keep Reading',
                    ),
                    array(
                        'id'        => 'excerpt_length',
                        'type'      => 'slider',
                        'title'     => esc_html__('Excerpt length on blog page', 'chamo'),
                        "default"   => 32,
                        "min"       => 10,
                        "step"      => 2,
                        "max"       => 120,
                        'display_value' => 'text'
                    ),
                ),
            );
			$this->sections[] = array(
                'icon'       => 'el-icon-website',
                'title'      => esc_html__( 'Latest posts carousel', 'chamo' ),
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'blogscroll',
                        'type'     => 'switch',
                        'title'    => esc_html__('Latest posts auto scroll', 'chamo'),
                        'default'  => false,
                    ),
                    array(
                        'id'        => 'blogpause',
                        'type'      => 'slider',
                        'title'     => esc_html__('Pause in (seconds)', 'chamo'),
                        'desc'      => esc_html__('Pause time, default value: 3000', 'chamo'),
                        "default"   => 3000,
                        "min"       => 1000,
                        "step"      => 500,
                        "max"       => 10000,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'        => 'bloganimate',
                        'type'      => 'slider',
                        'title'     => esc_html__('Animate in (seconds)', 'chamo'),
                        'desc'      => esc_html__('Animate time, default value: 2000', 'chamo'),
                        "default"   => 2000,
                        "min"       => 300,
                        "step"      => 100,
                        "max"       => 5000,
                        'display_value' => 'text'
                    ),
                )
            );
			// Testimonials options
            $this->sections[] = array(
                'title'     => esc_html__('Testimonials', 'chamo'),
                'desc'      => esc_html__('Use this section to select options for Testimonials', 'chamo'),
                'icon'      => 'el-icon-comment',
                'fields'    => array(
					array(
						'id'       => 'testiscroll',
						'type'     => 'switch',
						'title'    => esc_html__('Auto scroll', 'chamo'),
						'default'  => false,
					),
					array(
						'id'        => 'testipause',
						'type'      => 'slider',
						'title'     => esc_html__('Pause in (seconds)', 'chamo'),
						'desc'      => esc_html__('Pause time, default value: 3000', 'chamo'),
						"default"   => 3000,
						"min"       => 1000,
						"step"      => 500,
						"max"       => 10000,
						'display_value' => 'text'
					),
					array(
						'id'        => 'testianimate',
						'type'      => 'slider',
						'title'     => esc_html__('Animate in (seconds)', 'chamo'),
						'desc'      => esc_html__('Animate time, default value: 2000', 'chamo'),
						"default"   => 2000,
						"min"       => 300,
						"step"      => 100,
						"max"       => 5000,
						'display_value' => 'text'
					),
                ),
            );
			// Error 404 page
            $this->sections[] = array(
                'title'     => esc_html__('Error 404 Page', 'chamo'),
                'desc'      => esc_html__('Error 404 page options', 'chamo'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
                    array(
                        'id'        => 'background_error',
                        'type'      => 'background',
                        'output'    => array('.main-container.error404'),
                        'title'     => esc_html__('Error 404 background', 'chamo'),
                        'subtitle'  => esc_html__('Upload image or select color.', 'chamo'),
                        'default'   => '#f2f2f2',
                    ),
                ),
            );
			// Custom CSS
            $this->sections[] = array(
                'title'     => esc_html__('Custom CSS', 'chamo'),
                'desc'      => esc_html__('Add your Custom CSS code', 'chamo'),
                'icon'      => 'el-icon-pencil',
                'fields'    => array(
					array(
						'id'       => 'custom_css',
						'type'     => 'ace_editor',
						'title'    => esc_html__('CSS Code', 'chamo'),
						'subtitle' => esc_html__('Paste your CSS code here.', 'chamo'),
						'mode'     => 'css',
						'theme'    => 'monokai', //chrome
						'default'  => ""
					),
                ),
            );
			
			// Less Compiler
            $this->sections[] = array(
                'title'     => esc_html__('Less Compiler', 'chamo'),
                'desc'      => esc_html__('Turn on this option to apply all theme options. Turn of when you have finished changing theme options and your site is ready.', 'chamo'),
                'icon'      => 'el-icon-wrench',
                'fields'    => array(
					array(
                        'id'        => 'enable_less',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Less Compiler', 'chamo'),
						'default'   => true,
                    ),
                ),
            );
			
            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . esc_html__('<strong>Theme URL:</strong> ', 'chamo') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . esc_html__('<strong>Author:</strong> ', 'chamo') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . esc_html__('<strong>Version:</strong> ', 'chamo') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . esc_html__('<strong>Tags:</strong> ', 'chamo') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            $this->sections[] = array(
                'title'     => esc_html__('Import / Export', 'chamo'),
                'desc'      => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'chamo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_html__('Theme Information', 'chamo'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', 'chamo'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'chamo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__('Theme Information 2', 'chamo'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'chamo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'chamo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'chamo_opt',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', 'chamo'),
                'page_title'        => esc_html__('Theme Options', 'chamo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
              } else {
            }

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new chamo_Theme_Config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
