<?php
/**
 * TP Piebuilder Setting Page
 *
 * @package TP PieBuilder
 * @since 0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TP_PieBuilder_Setting_Page
{

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'tp_piebuilder_add_plugin_page' ) );
    }

    /**
     * Add options page
     */
    public function tp_piebuilder_add_plugin_page()
    {
        // This page will be under "Settings"
        add_media_page(
            esc_html__( 'Settings Admin', 'tp-piebuilder' ), 
            esc_html__( 'TP PieBuilder', 'tp-piebuilder' ),
            'manage_options', 
            'tp-piebuilder-admin', 
            array( $this, 'tp_piebuilder_create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function tp_piebuilder_create_admin_page()
    {
    ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'TP PieBuilder', 'tp-piebuilder' ); ?></h1>

            <p><a class="button-primary" href="https://themepalace.com/downloads/tp-piebuilder-pro/"><?php esc_attr_e( 'Upgrade To Pro', 'tp-piebuilder' ); ?></a></p>

            <div class="img-wrap">
                <img src="<?php echo TP_PIEBUILDER_URL_PATH . 'assets/screenshot-1.png' ?>" width="900" alt="<?php esc_attr_e( 'Default Pie Chart', 'tp-piebuilder' ); ?>">
                <p><tt>
                    <code>[TP_PIEBUILDER title="Pie Chart" values="20, 30, 50" labels="Design, Development, Production" colors="#E6E6FA, #E0FFFF, #F8B4BC"]</code>
                </tt></p>                    
            </div>
            <br>
            <div class="img-wrap">
                <img src="<?php echo TP_PIEBUILDER_URL_PATH . 'assets/screenshot-2.png' ?>" width="900" alt="<?php esc_attr_e( 'Doughnut Pie Chart', 'tp-piebuilder' ); ?>">
                <p><tt>
                    <code>[TP_PIEBUILDER_DOUGHNUT title="Pie Chart" values="20, 30, 50" labels="Design, Development, Production" colors="#E6E6FA, #E0FFFF, #F8B4BC"]</code>
                </tt></p>                    
            </div>
            <br>
            <div class="img-wrap">
                <img src="<?php echo TP_PIEBUILDER_URL_PATH . 'assets/screenshot-3.png' ?>" width="900" alt="<?php esc_attr_e( 'Polar Pie Chart', 'tp-piebuilder' ); ?>">
                <p><tt>
                    <code>[TP_PIEBUILDER_POLAR title="Pie Chart" values="20, 30, 50" labels="Design, Development, Production" colors="#E6E6FA, #E0FFFF, #F8B4BC"]</code>
                </tt></p>                    
            </div>
            <br>
            <div class="img-wrap">
                <img src="<?php echo TP_PIEBUILDER_URL_PATH . 'assets/screenshot-4.png' ?>" width="900" alt="<?php esc_attr_e( 'Bar Graph Chart', 'tp-piebuilder' ); ?>">
                <p><tt>
                    <code>[TP_PIEBUILDER_BAR title="Pie Chart" values="20, 30, 50" labels="Design, Development, Production" colors="#E6E6FA, #E0FFFF, #F8B4BC"]</code>
                </tt></p>                    
            </div>

            <br>
            <div class="img-wrap">
                <img src="<?php echo TP_PIEBUILDER_URL_PATH . 'assets/screenshot-5.png' ?>" width="900" alt="<?php esc_attr_e( 'Horizontal Bar Graph Chart', 'tp-piebuilder' ); ?>">
                <p><tt>
                    <code>[TP_PIEBUILDER_HORIZONTAL_BAR title="Pie Chart" values="20, 30, 50" labels="Design, Development, Production" colors="#E6E6FA, #E0FFFF, #F8B4BC"]</code>
                </tt></p>                    
            </div>

            <p><a class="button-primary" href="https://themepalace.com/downloads/tp-piebuilder-pro/"><?php esc_attr_e( 'Upgrade To Pro', 'tp-piebuilder' ); ?></a></p>

        </div>
    <?php
    }

}

if( is_admin() )
    new TP_PieBuilder_Setting_Page();