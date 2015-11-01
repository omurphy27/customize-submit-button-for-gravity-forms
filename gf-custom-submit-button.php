<?php 
/**
 * Plugin Name: Customize Submit Button for Gravity Forms
 * Description: Change the Gravity Forms submit button text or add CSS classes to it using this plugin
 * Version: 1.0.0
 * Author: Ollie Murphy
 * Author URI: https://github.com/omurphy27
 * Text Domain: gf-custom-submit-button
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

// extend the gravity forms add-on framework

// initialize the class

// define my custom functionality and admin panels

if (class_exists("GFForms")) {

	// this just requires the addon framework class file basically
	// just includes the necessary file
	GFForms::include_addon_framework();

	Class GFCustomSubmitButton extends GFAddOn {
		protected $_version = '1.0'; 
        protected $_min_gravityforms_version = '1.9';
        protected $_slug = 'gf-custom-submit-button';
        protected $_path = 'gf-custom-submit-button/gf-custom-submit-button.php';
        protected $_full_path = __FILE__;
        protected $_title = 'Customize Submit Button for Gravity Forms';
        protected $_short_title = 'GF Custom Submit Button';

        public function plugin_page() {
            ?>
            This page appears in the Forms menu
            <?php
        }

        public function form_settings_fields($form) {
            return array(
                array(
                    'title'  => 'Simple Form Settings',
                    'fields' => array(
                        array(
                            'label'   => 'My checkbox',
                            'type'    => 'checkbox',
                            'name'    => 'enabled',
                            'tooltip' => 'This is the tooltip',
                            'choices' => array(
                                array(
                                    'label' => 'Enabled',
                                    'name'  => 'enabled',
                                )
                            )
                        )
                    )
                )
            );
        }

        public function plugin_settings_fields() {
            return array(
                array(
                    'title'  => 'Simple Add-On Settings',
                    'fields' => array(
                        array(
                            'name'    => 'textbox',
                            'tooltip' => 'This is the tooltip',
                            'label'   => 'This is the label',
                            'type'    => 'text',
                            'class'   => 'small'
                        )
                    )
                )
            );
        }

        public function filter_form_button_settings($form_settings, $form) {

            $form_button_value = rgars( $form, 'button/type' );

            if ( $form_button_value === 'html' ) {
                $html_button_checked = 'checked="checked"';
                $html_style_display = '';
            } else {
                $html_button_checked = '';
                $html_style_display = 'display:none;';
            }

            $form_button_type = $form_settings['Form Button']['form_button_type'];

            $form_button_type_array = explode("</label>",$form_button_type);

            $form_button_type = str_replace( 'ToggleButton', 'GFSBToggleButton', str_replace($form_button_type_array[2], '', $form_button_type) );

            $form_settings['Form Button']['form_button_type'] = $form_button_type . '
                &nbsp;&nbsp;
                <input type="radio" id="form_button_html" name="form_button" value="html" onclick="GFSBToggleButton();" ' . $html_button_checked . ' />
                <label for="form_button_html" class="inline">' .
                __( 'Button', 'gravityforms' ) . '</label>

                </td>
            </tr>';

            $form_button_image_path = $form_settings['Form Button']['form_button_image_path'];

            $form_button_image_path = str_replace("</table>", "", $form_button_image_path);
            $form_button_image_path = str_replace("</div>", "", $form_button_image_path);
            $form_button_image_path = substr($form_button_image_path, 0, -5);

            $form_settings['Form Button']['form_button_image_path'] = $form_button_image_path . '<tr id="form_button_html_setting" class="child_setting_row" style="' . $html_style_display . '">
                                <th>
                                    '. __( 'HTML Button Text', 'gravityforms' ) .' <a href="#"" onclick="return false;"" class="gf_tooltip tooltip tooltip_form_button_image" title="&lt;h6&gt;Form Button Text&lt;/h6&gt;Enter the text you would like to appear on the form submit button. HTML tags are allowed."><i class="fa fa-question-circle"></i></a>
                                </th>
                                <td>
                                    <input type="text" id="form_button_html_input" name="form_button_html_input" class="fieldwidth-3" value="' . esc_attr( rgars( $form, 'button/html' ) ) . '" />
                                </td>
                            </tr>
                        </tr>
                    </table>
                </div>
            </td>';

        	return $form_settings;
        }

        public function save_form_button_settings( $form ) {

            // var_dump( $form );
            // $form['button']['type'] = rgpost( 'form_button' ) == 'html' ? rgpost( 'form_button_html_input' ) : '';
              
            $form['button']['type'] = rgpost( 'form_button' );

            if ( $form['button']['type'] === 'html' ) {
                $form['button']['html'] = rgpost( 'form_button_html_input' );
            }

            //var_dump($form);
            return $form;
        }

        public function init_admin() {

            // add my own options to the Gforms form settings
        	add_filter('gform_form_settings', array( $this, 'filter_form_button_settings' ), 20, 2  );

            // save my custom setting to the DB
            add_filter('gform_pre_form_settings_save', array( $this, 'save_form_button_settings' ), 20, 2  );
        
            wp_enqueue_script( 
                'gform-custom-submit-button', 
                plugin_dir_url( __FILE__ ) . 'js/scripts.js', 
                array('jquery'), 
                '1.0.0', 
                true 
            );
        }

	}

	// initialize class
	$GF_Custom_Submit_Button = new GFCustomSubmitButton();

}



?>