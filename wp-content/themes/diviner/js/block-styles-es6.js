const { registerBlockStyle } = wp.blocks;
const { __ } = wp.i18n;

registerBlockStyle("core/gallery", {
	name: 'carousel',
	label: __('Carousel')
} );