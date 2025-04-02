import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => (
		<div className={`swiper ${wp.blockEditor.useBlockProps.save().className}`}>
			<div className="swiper-wrapper">
				<wp.blockEditor.InnerBlocks.Content />
			</div>
		</div>
	)	
} );
