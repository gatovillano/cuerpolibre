(function (wp) {
    if (!wp || !wp.hooks || !wp.blocks) return;

    const { addFilter } = wp.hooks;
    const { createHigherOrderComponent } = wp.compose;
    const { Fragment, createElement: el } = wp.element;
    const { InspectorControls } = wp.blockEditor || wp.editor;
    const { PanelBody, ToggleControl } = wp.components;

    // 1. Add custom attribute 'enableMasonry' to 'core/gallery' block
    addFilter(
        'blocks.registerBlockType',
        'cl-masonry/add-attributes',
        function (settings, name) {
            if (name === 'core/gallery') {
                settings.attributes = Object.assign({}, settings.attributes, {
                    enableMasonry: {
                        type: 'boolean',
                        default: false,
                    },
                });
            }
            return settings;
        }
    );

    // 2. Add Inspector Control Toggle in Block Sidebar
    const withMasonryControl = createHigherOrderComponent(function (BlockEdit) {
        return function (props) {
            if (props.name !== 'core/gallery') {
                return el(BlockEdit, props);
            }

            const { attributes, setAttributes } = props;
            const { enableMasonry } = attributes;

            return el(
                Fragment,
                {},
                el(BlockEdit, props),
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        {
                            title: 'Formato Masonry (Cuerpo Libre)',
                            initialOpen: true,
                        },
                        el(ToggleControl, {
                            label: 'Activar Galería Masonry',
                            help: enableMasonry
                                ? 'Galería Masonry activa: Se adaptará automáticamente según la altura de cada imagen sin dejar espacios.'
                                : 'Galería estándar activa.',
                            checked: !!enableMasonry,
                            onChange: function (newValue) {
                                setAttributes({ enableMasonry: newValue });
                            },
                        })
                    )
                )
            );
        };
    }, 'withMasonryControl');

    addFilter(
        'editor.BlockEdit',
        'cl-masonry/with-inspector-control',
        withMasonryControl
    );

    // 3. Add CSS class 'has-masonry-layout' to block wrapper when enabled in Editor
    const withMasonryClass = createHigherOrderComponent(function (BlockListBlock) {
        return function (props) {
            if (props.name === 'core/gallery' && props.attributes && props.attributes.enableMasonry) {
                return el(BlockListBlock, Object.assign({}, props, {
                    className: ((props.className || '') + ' has-masonry-layout').trim()
                }));
            }
            return el(BlockListBlock, props);
        };
    }, 'withMasonryClass');

    addFilter(
        'editor.BlockListBlock',
        'cl-masonry/with-block-class',
        withMasonryClass
    );

    // 4. Add CSS class 'has-masonry-layout' when saved to post content
    addFilter(
        'blocks.getSaveContent.extraProps',
        'cl-masonry/add-save-class',
        function (extraProps, blockType, attributes) {
            if (blockType.name === 'core/gallery' && attributes && attributes.enableMasonry) {
                extraProps.className = ((extraProps.className || '') + ' has-masonry-layout').trim();
            }
            return extraProps;
        }
    );

})(window.wp);
