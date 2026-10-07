<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aesys_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'register_menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function register_menu() {
        add_menu_page(
            'MyInfo.City',
            'MyInfo.City',
            'publish_posts',
            'aesys',
            [ $this, 'render_admin_page' ],
            'dashicons-welcome-view-site'
        );
    }

    public function register_settings() {
        register_setting( 'viewer-for-aesys-infocity', 'aesys_panels', [
            'type' => 'string',
            'sanitize_callback' => [ $this, 'sanitize_panels' ],
            'default' => '',
        ] );
    }

    public function sanitize_panels( $input ) {
        // Only allow numbers and commas
        return preg_replace( '/[^0-9,]/', '', $input );
    }

    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1><span class="dashicons dashicons-welcome-view-site" style="vertical-align:middle;"></span> MyInfo.City</h1>
            <div id="poststuff">
                <?php $this->render_panels(); ?>
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <?php $this->render_instructions_box(); ?>
                        <?php $this->render_settings_box(); ?>
                    </div>
                    <div id="postbox-container-1" class="postbox-container">
                        <?php $this->render_credits_box(); ?>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <style>
            .aesys-panel-box {
                margin: 15px 2% 15px 0;
                width: 30%;
                float: left;
                min-width: 250px;
                padding: 10px;
                border-radius: 4px;
            }
            @media (max-width: 900px) {
                .aesys-panel-box { width: 100%; float: none; margin-right: 0; }
            }
        </style>
        <?php
    }

    private function render_panels() {
        $panels = get_option( 'aesys_panels', '' );
        $ar = array_filter( array_map( 'trim', explode( ',', $panels ) ) );
        echo '<div style="margin-bottom:30px;overflow:auto;">';
        if ( empty( $ar ) ) {
            echo '<div class="notice notice-warning inline"><p><strong>Nessun display inserito</strong></p></div>';
        } else {
            foreach ( $ar as $value ) {
                $id = esc_attr( $value );
                echo '<div class="aesys-panel-box">' . do_shortcode( '[aesys id="' . $id . '" title="Pannello ' . $id . '"]' ) . '</div>';
            }
        }
        echo '<div style="clear:both"></div></div>';
    }

    private function render_instructions_box() {
        ?>
        <div class="postbox aesys-instructions-box">
            <h2><span><span class="dashicons dashicons-info"></span> Istruzioni</span></h2>
            <div class="inside">
                <ul style="list-style: disc; margin-left: 20px;">
                    <li>
                        Per visualizzare i display nei tuoi post, pagine o widget, utilizza lo shortcode:
                        <pre style="background:#f6f7f7; border-radius:4px; padding:8px; margin:8px 0; font-size:1.1em;">[aesys id="XXX" title="XXX" height="XXX" width="XXX"]</pre>
                    </li>
                    <li>
                        Esempio (i campi "height" e "width" sono opzionali):
                        <pre style="background:#f6f7f7; border-radius:4px; padding:8px; margin:8px 0; font-size:1.1em;">[aesys id="696" title="Informazioni Municipali"]</pre>
                    </li>
                    <li>
                        Gli ID devono essere recuperati su
                        <a href="https://myinfo.city" target="_blank" rel="noopener noreferrer">https://myinfo.city</a>
                        &nbsp;|&nbsp;
                        <a href="https://youtu.be/wBKTMcg4Ujs" target="_blank" rel="noopener noreferrer">Video spiegazione</a>
                    </li>
                </ul>
            </div>
        </div>
        <style>
            .aesys-instructions-box pre {
                background: #f6f7f7;
                border: 1px solid #ccd0d4;
                border-radius: 4px;
                padding: 8px;
                margin: 8px 0;
                font-size: 1.1em;
            }
        </style>
        <?php
    }

    private function render_settings_box() {
        ?>
        <div class="postbox aesys-settings-box">
            <h2><span><span class="dashicons dashicons-admin-generic"></span> Impostazioni</span></h2>
            <div class="inside">
                <form method="post" action="options.php" style="max-width:500px;">
                    <?php
                        settings_fields( 'viewer-for-aesys-infocity' );
                        do_settings_sections( 'viewer-for-aesys-infocity' );
                        $value = esc_attr( get_option( 'aesys_panels', '' ) );
                    ?>
                    <label for="aesys_panels" style="font-weight:600; display:block; margin-bottom:6px;">
                        Inserisci gli ID dei display separati da virgola:
                    </label>
                    <input
                        type="text"
                        id="aesys_panels"
                        name="aesys_panels"
                        value="<?php echo $value; ?>"
                        style="width:100%; max-width:400px; font-size:1.1em; padding:6px; border-radius:4px; border:1px solid #ccd0d4;"
                        placeholder="Es: 123,456,789"
                        autocomplete="off"
                    />
                    <p class="description" style="margin-top:6px;">
                        Gli ID inseriti verranno visualizzati in anteprima in cima a questa pagina.
                    </p>
                    <?php submit_button('Salva impostazioni'); ?>
                </form>
            </div>
        </div>
        <style>
            .aesys-settings-box input[type="text"] {
                background: #f6f7f7;
            }
            .aesys-settings-box label {
                margin-bottom: 4px;
            }
        </style>
        <?php
    }

    private function render_credits_box() {
        ?>
        <div class="postbox">
            <h2><span>Credits</span></h2>
            <div class="inside" style="text-align:center;">
                <p>
                    Sviluppo plugin WordPress a cura di<br>
                    <b><a href="https://marcomilesi.com" target="_blank" rel="noopener noreferrer">Marco Milesi</a></b>
                </p>
                <p>
                    nell'ambito del progetto per la Pubblica Amministrazione WPGov.it:
                </p>
                <p>
                    <a href="https://www.wpgov.it" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url( plugins_url( 'img/wpgov.png', __FILE__ ) ); ?>" alt="WPGov.it" style="max-width:120px;" />
                    </a>
                </p>
                <p>
                    <a href="https://www.wpgov.it/soluzioni/" target="_blank" rel="noopener noreferrer">Soluzioni software</a>
                    &bull;
                    <a href="https://www.wpgov.it/servizi/" target="_blank" rel="noopener noreferrer">Servizi</a>
                </p>
                <hr>
                <p style="font-size: 0.8em;">
                    Il marchio "MyInfoCity" e la tecnologia cloud dei display "Informacittà" sono di proprietà di AESYS S.p.A.
                </p>
                <p>
                    <a href="http://www.aesys.com/" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url( plugins_url( 'img/aesys.png', __FILE__ ) ); ?>" alt="Aesys.com" style="max-width:120px;" />
                    </a>
                </p>
            </div>
        </div>
        <?php
    }
}

new Aesys_Admin();
