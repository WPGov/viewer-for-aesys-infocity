(function(wp) {
    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor ? wp.blockEditor.InspectorControls : wp.editor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;

    registerBlockType('aesys/infocity-viewer', {
        title: 'InfoCity Viewer',
        icon: 'format-image',
        category: 'embed',
        attributes: {
            id: { type: 'string', default: '0' },
            title: { type: 'string', default: '' },
            width: { type: 'string', default: '100%' },
            height: { type: 'string', default: '' }
        },
        edit: function(props) {
            var attrs = props.attributes;
            function setAttr(attr) {
                return function(value) {
                    var obj = {};
                    obj[attr] = value;
                    props.setAttributes(obj);
                };
            }
            return [
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Viewer Settings', initialOpen: true },
                        el(TextControl, {
                            label: 'Panel ID',
                            value: attrs.id,
                            onChange: setAttr('id')
                        }),
                        el(TextControl, {
                            label: 'Title',
                            value: attrs.title,
                            onChange: setAttr('title')
                        }),
                        el(TextControl, {
                            label: 'Width',
                            value: attrs.width,
                            onChange: setAttr('width'),
                            help: 'e.g. 100%, 400px'
                        }),
                        el(TextControl, {
                            label: 'Height',
                            value: attrs.height,
                            onChange: setAttr('height'),
                            help: 'e.g. 300px (optional)'
                        })
                    )
                ),
                el(
                    'div',
                    { style: { border: '1px solid #ccc', padding: '8px', borderRadius: '8px', background: '#fafafa' } },
                    el('strong', {}, attrs.title || 'Aesys Viewer'),
                    el('div', { style: { fontSize: '0.9em', color: '#888' } }, 'Panel ID: ' + attrs.id),
                    el('div', { style: { fontSize: '0.8em', color: '#aaa' } }, 'Width: ' + attrs.width + '   Height: ' + attrs.height)
                )
            ];
        },
        save: function() {
            return null; // Rendered in PHP
        }
    });
})(window.wp);