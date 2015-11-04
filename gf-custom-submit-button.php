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

        public function filter_form_button_settings($form_settings, $form) {

            // need to add a text field for CSS classes here too and I need to populate it
            // with the CSS classes being used on the button...hmmm, that's the difficult part...

            $subsetting_open  = '
            <tr>
                <td colspan="2" class="gf_sub_settings_cell">
                    <div class="gf_animate_sub_settings">
                        <table>
                            <tr>';
            $subsetting_close = '
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>';

            $form_button_type     = rgars( $form, 'button/type' );
            $text_button_checked  = '';
            $image_button_checked = '';
            $html_button_checked = '';
            $text_style_display   = '';
            $image_style_display  = '';
            $html_style_display = '';
            if ( $form_button_type == 'text' ) {
                $text_button_checked = 'checked="checked"';
                $image_style_display = 'display:none;';
                $html_style_display = 'display:none;';
            } else if ( $form_button_type == 'image' ) {
                $image_button_checked = 'checked="checked"';
                $text_style_display   = 'display:none;';
                $html_style_display = 'display:none;';
            } else if ( $form_button_type == 'html' ) {
                $html_button_checked = 'checked="checked"';
                $image_style_display = 'display:none;';
                $text_style_display   = 'display:none;';
            }

            // form button radio buttons
            $form_settings['Form Button']['form_button_type'] = '
            <tr>
                <th>
                    ' . __( 'Input type', 'gravityforms' ) . '
                </th>
                <td>

                    <input type="radio" id="form_button_text" name="form_button" value="text" onclick="GFSBToggleButton();" ' . $text_button_checked . ' />
                    <label for="form_button_text" class="inline">' .
                __( 'Text', 'gravityforms' ) .
                '</label>

                &nbsp;&nbsp;

                <input type="radio" id="form_button_image" name="form_button" value="image" onclick="GFSBToggleButton();" ' . $image_button_checked . ' />
                    <label for="form_button_image" class="inline">' .
                __( 'Image', 'gravityforms' ) . '</label>

                &nbsp;&nbsp;
                <input type="radio" id="form_button_html" name="form_button" value="html" onclick="GFSBToggleButton();" ' . $html_button_checked . ' />
                <label for="form_button_html" class="inline">' .
                __( 'Button', 'gravityforms' ) . '</label>

                </td>
            </tr>';

            //form button text
            $form_settings['Form Button']['form_button_text'] = $subsetting_open . '
            <tr id="form_button_text_setting" class="child_setting_row" style="' . $text_style_display . '">
                <th>
                    ' .
                __( 'Button text', 'gf-custom-submit-button' ) . ' ' .
                gform_tooltip( 'form_button_text', '', true ) .
                '
            </th>
            <td>
                <input type="text" id="form_button_text_input" name="form_button_text_input" class="fieldwidth-3" value="' . esc_attr( rgars( $form, 'button/text' ) ) . '" />
                </td>
            </tr>';

            // form button image path and html5 button input
            $form_settings['Form Button']['form_button_image_path'] = '
            <tr id="form_button_image_path_setting" class="child_setting_row" style="' . $image_style_display . '">
                <th>
                        ' .
                    __( 'Button image path', 'gf-custom-submit-button' ) . '  ' .
                    gform_tooltip( 'form_button_image', '', true ) .
                    '
                </th>
                <td>
                    <input type="text" id="form_button_image_url" name="form_button_image_url" class="fieldwidth-3" value="' . esc_attr( rgars( $form, 'button/imageUrl' ) ) . '" />
                </td>
            </tr>
            <tr id="form_button_html_setting" class="child_setting_row" style="' . $html_style_display . '">
                <th>
                    <label for="form_button_html_input" style="display:block;">' . 
                        __( 'HTML Button Text', 'gf-custom-submit-button' ) . ' ' .
                        gform_tooltip( 'form_button_html_input', '', true ) .
                    '</label>
                </th>
                <td>
                    <input type="text" id="form_button_html_input" name="form_button_html_input" class="fieldwidth-3" value="' . esc_attr( rgars( $form, 'button/html' ) ) . '" />
                </td>
            </tr>' . $subsetting_close;

            // add CSS Button Class field
            $form_settings['Form Button']['form_button_image_path'] .= '
            <tr>
                <th>
                    <label for="button_css_class" style="display:block;">' .
                __( 'Button CSS Classes', 'gf-custom-submit-button' ) . ' ' .
                gform_tooltip( 'button_css_class', '', true ) .
                '</label>
            </th>
            <td>
                <input type="text" id="button_css_class" name="button_css_class" class="fieldwidth-3" value="' . esc_attr( rgar( $form, 'cssClass' ) ) . '" />
                </td>
            </tr>';

            // the question is how am I going to populate the above guy...with the current CSS classes
            // lets see how those CSS classes are generated on the front end 

           // var_dump( $form_settings );

        	return $form_settings;
        }

        public function save_form_button_settings( $form ) {
              
            $form['button']['type']     = rgpost( 'form_button' );
            $form['button']['text']     = rgpost( 'form_button' ) == 'text' ? rgpost( 'form_button_text_input' ) : '';
            $form['button']['imageUrl'] = rgpost( 'form_button' ) == 'image' ? rgpost( 'form_button_image_url' ) : '';
            $form['button']['html']     = rgpost( 'form_button' ) == 'html' ? rgpost( 'form_button_html_input' ) : '';

            return $form;
        }

        public function disable_form_settings_sanitization() {
            return true;
        }

        public function add_tooltips( $tooltips ) {
            $tooltips['form_button_html_input'] = '<h6>' . __( 'Form HTML Button Text', 'gf-custom-submit-button' ) . '</h6>' . __( 'Enter the text you would like to appear on the form submit button. HTML tags are allowed.', 'gf-custom-submit-button' );
            $tooltips['button_css_class'] = '<h6>' . __( 'Form Button CSS Classes', 'gf-custom-submit-button' ) . '</h6>' . __( 'These are the CSS classes that are attached to the form button. You can change or overwrite them here.', 'gf-custom-submit-button' );
            return $tooltips;
        }

        public function init_admin() {
            // add my own options to the Gforms form settings
        	add_filter('gform_form_settings', array( $this, 'filter_form_button_settings' ), 20, 2  );

            // add tooltips for new form settings inputs
            add_filter( 'gform_tooltips', array( $this, 'add_tooltips' ) );

            // save custom setting to the DB
            add_filter('gform_pre_form_settings_save', array( $this, 'save_form_button_settings' ), 20, 2  );
        
            // disable sanitization which prevents custom 
            // form settings from being saved
            add_filter('gform_disable_form_settings_sanitization', array( $this, 'disable_form_settings_sanitization' ) );

            wp_enqueue_script( 
                'gform-custom-submit-button', 
                plugin_dir_url( __FILE__ ) . 'js/scripts.js', 
                array('jquery'), 
                '1.0.0', 
                true 
            );
        }

        public function filter_form_button_markup( $button_input, $form ) {

            // check to see if HTML button is selected
            if ( $form['button']['type'] == 'html') {

                if ( $form['button']['html'] ) {
                    $text = $form['button']['html'];
                } else {
                    $text = 'Submit';
                }

                $button_input = str_replace( 'input', 'button', $button_input );
                $button_input = str_replace( '/', '', $button_input );
                $button_input .= $text . "</button>";
            }

            return $button_input;
        }

        public function init_frontend() {

            // change button markup
            add_filter( 'gform_submit_button', array( $this, 'filter_form_button_markup' ), 20, 3 );
        }

	}

	// initialize class
	$GF_Custom_Submit_Button = new GFCustomSubmitButton();

}



?>