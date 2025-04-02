import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import './style.scss';

registerBlockType('ggf/gg-story', {
    edit: Edit,
	save: () => (
		<div className={`swiper-slide ${wp.blockEditor.useBlockProps.save().className}`}>
			<wp.blockEditor.InnerBlocks.Content />
		</div>
	)	
});
