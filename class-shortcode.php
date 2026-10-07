<?php
    
    extract(shortcode_atts(
        array(
            'id' => '0',
            'height' => '',
            'width' => '100%',
            'title' => ''
        ),
        $atts)
    );

    if (!$id) { echo 'NO ID FOUND'; return; }

	$url = aesys_get_url( $id );

    echo '
    <script>
    <!--eucookielaw_exclude-->
	if (window.addEventListener) {
		window.addEventListener("load", function (){
			document.getElementById("aesys'.$id.'").src = "'.$url.'";
		});
	} else if (window.attachEvent) {
		window.attachEvent("onload", function (){
			document.getElementById("aesys'.$id.'").src = "'.$url.'";
		});	
	}
    </script>

    <div style="
    width: '.$width.';
    padding: 4px;     border: 2px solid black;
    border-radius: 10px 10px 0px 0px;
    font-size: 0.8em;
    text-align: center;
    font-weight: bold;
    background-color: black;
    color: white;
">'.$title.'</div>';
	
	if ( $height ) {
		$height = 'height="'.$height.'"';
	}
    echo '
    <img
        id="aesys'.$id.'"
        style="background: #0E0E0E; border: 6px solid black; border-radius: 0px 0px 10px 10px;"
        src="'.plugins_url('img/loader.gif', __FILE__).'" width="'.$width.'" '.$height.' />';
?>
