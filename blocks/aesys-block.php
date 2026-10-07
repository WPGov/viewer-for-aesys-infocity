<?php
function aesys_register_block() {
    wp_register_script(
        'aesys-block-editor',
        plugins_url('blocks/aesys-block.js', dirname(__DIR__) . '/viewer-for-aesys-infocity.php'),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        filemtime(plugin_dir_path(__DIR__) . 'blocks/aesys-block.js')
    );

    register_block_type('aesys/infocity-viewer', array(
        'editor_script' => 'aesys-block-editor',
        'render_callback' => 'aesys_render_block',
        'attributes' => array(
            'id' => array('type' => 'string', 'default' => '0'),
            'title' => array('type' => 'string', 'default' => ''),
            'width' => array('type' => 'string', 'default' => '100%'),
            'height' => array('type' => 'string', 'default' => ''),
        ),
    ));
}
add_action('init', 'aesys_register_block');

function aesys_render_block($attributes) {
    ob_start();
    $atts = shortcode_atts(array(
        'id' => $attributes['id'] ?? '0',
        'title' => $attributes['title'] ?? '',
        'width' => $attributes['width'] ?? '100%',
        'height' => $attributes['height'] ?? '',
    ), $attributes);
    // Reuse the shortcode template
    require plugin_dir_path(__DIR__) . 'class-shortcode.php';
    return ob_get_clean();
}