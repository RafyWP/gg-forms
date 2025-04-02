import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';

registerBlockType('ggf/gg-option', {
	edit: Edit,
	save: ({ attributes }) => {
		const { linkedStoryId, label } = attributes;

		return (
			<button
				className="ggf-option-button"
				data-story-id={linkedStoryId}
			>
				{label || 'Option'}
			</button>
		);
	}
});
