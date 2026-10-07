<?php

add_action('admin_menu', function() {
    add_menu_page('MyInfo.City', 'MyInfo.City ', 'publish_posts', 'aesys', 'aesys_welcome', 'dashicons-welcome-view-site');
});

function aesys_welcome() {
    echo '<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1>MyInfo.City</h1>

	<div id="poststuff">

    ';
    $ar =  explode( ',', get_option('aesys_panels'));
    if ( get_option('aesys_panels') == '' || !is_array( $ar ) ) {
        echo '<br><br><strong>Nessun display inserito</strong><br><br><br><br>';
    } else {
        foreach (  $ar as $value) {
            echo '<div style="margin: 15px;
            width: 30%;
            float: left;">'.do_shortcode('[aesys id="'.$value.'" title="Pannello '.$value.'"]').'</div>';
        }
    }
echo '<div class="clear"></div>
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">
                        <h2><span>Istruzioni</span></h2>

						<div class="inside">
                            <p>Per visualizzare i display nei tuoi post, pagine o widget, utilizza lo shortcode:</p>
                            <code>[aesys id="XXX" title="XXX" height="XXX" width="XXX"]</code>
                            <p>Esempio (i campi "height" e "width" sono opzionali):</p>
                            <code>[aesys id="696" title="Informazioni Municipali"]</code>
                            <p>Gli ID devono essere recuperati su <a href="https://myinfo.city" title="myinfocity">https://myinfo.city</a> &bull; <a href="https://youtu.be/wBKTMcg4Ujs" title="istruzioni">Video spiegazione</a></p>
                            <p></p>
                        </div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
                <!-- .meta-box-sortables .ui-sortable -->
                
                <div class="meta-box-sortables ui-sortable">

					<div class="postbox">
						<h2><span>Impostazioni</span></h2>

						<div class="inside">
                            <p>Per aggiungere display in cima a questa pagina, inserisci i loro ID separati da virgola qui sotto.</p>
                            <form name="form" method="post" action="options.php">';
                            settings_fields( 'viewer-for-aesys-infocity' );
                            do_settings_sections( 'viewer-for-aesys-infocity' );
                            
                            echo '<input type="text" name="aesys_panels" value="'.esc_attr( get_option('aesys_panels') ).'" />';
                                submit_button();
                                echo '
                            </form>
                        </div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<h2><span>Credits</span></h2>

						<div class="inside">
                            <p style="text-align:center;">
                                Sviluppo plugin WordPress a cura di<br>
                                <b><a href="https://marcomilesi.com" title="Marco Milesi">Marco Milesi</a></b>
                            </p>
                            <p>
                                nell\'ambito del progetto per la Pubblica Amministrazione WPGov.it:
                            </p>
                            <p style="text-align:center;">
                                <a href="https://www.wpgov.it" target="_blank" title="WPGov.it">
                                    <img src="'.plugins_url('img/wpgov.png', __FILE__).'" />
                                </a>
                                <a href="https://www.wpgov.it/soluzioni/" title="Soluzioni">Soluzioni software</a> &bull; <a href="https://www.wpgov.it/servizi/" title="Servizi">Servizi</a>
                            </p>
                            <hr>
                            <p style="text-align:center;font-size: 0.8em;">
                                Il marchio "MyInfoCity" e la tecnologia cloud dei display "Informacittà" sono di proprietà di AESYS S.p.A.
                            </p>
                            <p style="text-align:center;">
                                <a href="http://www.aesys.com/" target="_blank" title="Aesys.com"><img src="'.plugins_url('img/aesys.png', __FILE__).'" /></a>
                            </p>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->';
}
?>
