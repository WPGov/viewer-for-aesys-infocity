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

$url = aesys_get_url($id);

$width = aesys_sanitize_css_length($width, '100%');
$height = aesys_sanitize_css_length($height);
$height_style = $height ? ' height: ' . $height . ';' : '';

$loader = plugins_url('img/loader.gif', __FILE__);

echo '
<div style="width: ' . esc_attr($width) . '; display: inline-block; vertical-align: top;">
    <div style="
        width: 100%;
        box-sizing: border-box;
        padding: 4px; border: 2px solid black;
        border-radius: 10px 10px 0px 0px;
        font-size: 0.8em;
        text-align: center;
        font-weight: bold;
        background-color: black;
        color: white;
    ">' . esc_html($title) . '</div>
    <img
        class="aesys-img aesys-img-' . esc_attr(sanitize_html_class($id)) . '"
        style="background: #0E0E0E; border-radius: 0px 0px 10px 10px; display: block; width: 100%;' . esc_attr($height_style) . '"
        src="' . esc_url($loader) . '"
        data-src="' . esc_url($url) . '"
        loading="lazy"
        alt="' . esc_attr($title) . ' preview"
    />
</div>
<script>
<!--eucookielaw_exclude-->
(function() {
    function loadAesysImgs() {
        var imgs = document.querySelectorAll("img.aesys-img[data-src]");
        imgs.forEach(function(img) {
            if (img && img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    }
    if (window.addEventListener) {
        window.addEventListener("DOMContentLoaded", loadAesysImgs, false);
    } else if (window.attachEvent) {
        window.attachEvent("onload", loadAesysImgs);
    }
})();
</script>
';
?>
