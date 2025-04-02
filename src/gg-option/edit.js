import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes, clientId }) {
	const { linkedStoryId, label } = attributes;

	const storyOptions = useSelect((select) => {
		const { getBlockParentsByBlockName, getBlocks } = select('core/block-editor');
	
		const formParents = getBlockParentsByBlockName(clientId, ['ggf/gg-forms']);
		if (!formParents.length) return [];
	
		const formBlockId = formParents[0];
		const formInnerBlocks = getBlocks(formBlockId);
	
		const stories = formInnerBlocks.filter((block) => block.name === 'ggf/gg-story');
	
		return stories.map((story) => {
			const id = story.attributes.storyId || story.clientId;
			const label = story.attributes.transitionQuestion || `Story ${id}`;
			return {
				label,
				value: id,
			};
		});
	}, [clientId]);	

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Option Settings', 'gg-forms')}>
					<SelectControl
						label={__('GG Story', 'gg-forms')}
						value={linkedStoryId}
						options={[
							{ label: __('Select a story...', 'gg-forms'), value: '' },
							...storyOptions,
						]}
						onChange={(value) => setAttributes({ linkedStoryId: value })}
					/>

					<TextControl
						label={__('Option', 'gg-forms')}
						value={label}
						onChange={(value) => setAttributes({ label: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				<button className="ggf-option-button">{label || __('Option', 'gg-forms')}</button>
			</div>
		</>
	);
}
