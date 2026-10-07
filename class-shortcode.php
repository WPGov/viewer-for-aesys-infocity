<?php

if (!defined('ABSPATH')) {
    exit;
}

$atts = shortcode_atts(
    array(
        'id' => '0',
        'height' => '',
        'width' => '100%',
        'title' => ''
    ),
    $atts
);
$id = $atts['id'];
$title = $atts['title'];

if (!$id) { echo 'NO ID FOUND'; return; }

$url = aesys_get_url($id);
if (!$url) { return; }

// Keep only the first declaration and filter it with core's safecss_filter_attr(); unitless numbers are pixels
$width = trim((string) strtok((string) $atts['width'], ';'));
$height = trim((string) strtok((string) $atts['height'], ';'));
$width_css = $width !== '' ? safecss_filter_attr('width: ' . (is_numeric($width) ? $width . 'px' : $width)) : '';
$height_css = $height !== '' ? safecss_filter_attr('height: ' . (is_numeric($height) ? $height . 'px' : $height)) : '';
$width = $width_css ? trim(substr($width_css, strpos($width_css, ':') + 1)) : '100%';
$height = $height_css ? trim(substr($height_css, strpos($height_css, ':') + 1)) : '';

$loader = plugins_url('img/loader.gif', __FILE__);

// One shared loader script for all displays on the page
wp_enqueue_script('aesys-viewer');

// Same markup and look as v2.2, in a wrapper so block themes keep title and image aligned
echo '<div class="aesys-display">';
echo '
    <div style="
    width: ' . esc_attr($width) . ';
    padding: 4px;     border: 2px solid black;
    border-radius: 10px 10px 0px 0px;
    font-size: 0.8em;
    text-align: center;
    font-weight: bold;
    background-color: black;
    color: white;
">' . esc_html($title) . '</div>';

echo '
    <img
        id="aesys' . esc_attr($id) . '"
        class="aesys-img"
        style="background: #0E0E0E; border: 6px solid black; border-radius: 0px 0px 10px 10px;"
        src="' . esc_url($loader) . '"
        data-src="' . esc_url($url) . '"
        width="' . esc_attr($width) . '"' . ($height ? ' height="' . esc_attr($height) . '"' : '') . '
        loading="lazy"
        alt="' . esc_attr('Anteprima del display ' . ($title !== '' ? $title : $id)) . '" />';
echo '</div>';
