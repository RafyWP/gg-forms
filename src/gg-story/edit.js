import {
	useBlockProps,
	InnerBlocks,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	Button,
	TextControl,
	__experimentalNumberControl as NumberControl
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useRef, useState, useEffect } from '@wordpress/element';
import { useSelect } from '@wordpress/data';

export default function Edit({ attributes, setAttributes, clientId }) {
	const {
		storyId,
		videoUrl,
		aspectRatio,
		thumbnail,
		playIcon,
		playIconTop,
		transitionQuestion,
		showMinute,
		showSecond,
	} = attributes;

	const videoRef = useRef();

	const onSelectVideo = (media) => {
		if (media && media.url) {
			setAttributes({ videoUrl: media.url });
		}
	};

	const onLoadedMetadata = (e) => {
		const ratio = e.target.videoWidth / e.target.videoHeight;
		if (ratio && !isNaN(ratio)) {
			setAttributes({ aspectRatio: parseFloat(ratio.toFixed(3)) });
		}
	};

	useEffect(() => {
		if (!attributes.storyId) {
			const id = `story-${Date.now().toString(36)}`;
			setAttributes({ storyId: id });
		}
	}, []);

	var targetTime = (showMinute || 0) * 60 + (showSecond || 0);

	const optionBlocks = useSelect((select) => {
		const { getBlock, getBlocks } = select('core/block-editor');
		const currentBlock = getBlock(clientId);
		if (!currentBlock?.innerBlocks) return [];
	
		const getAllBlocksRecursive = (blocks) => {
			return blocks.reduce((acc, block) => {
				acc.push(block);
				if (block.innerBlocks?.length) {
					acc.push(...getAllBlocksRecursive(block.innerBlocks));
				}
				return acc;
			}, []);
		};
		
		const allBlocks = getAllBlocksRecursive(getBlocks());
		
		const allStories = allBlocks.filter(
			block => block.name === 'ggf/gg-story'
		);		
	
		return currentBlock.innerBlocks
			.filter((block) => block.name === 'ggf/gg-option')
			.map((block) => {
				const linkedId = block.attributes.linkedStoryId || '';
	
				const targetBlock = allStories.find(
					(b) => b.attributes?.storyId === linkedId
				);
	
				const targetLabel =
					targetBlock?.attributes?.transitionQuestion ||
					targetBlock?.attributes?.storyId ||
					'—';
	
				return {
					label: block.attributes.label || '—',
					target: targetLabel,
				};
			});
	}, [clientId]);	

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'gg-forms')}>
					<div className='settings'>
						<TextControl
							label={__('Story Id', 'gg-forms')}
							value={storyId}
							onChange={(value) => setAttributes({ storyId: value })}
						/>
					</div>
				</PanelBody>

				<PanelBody title={__('Video Settings', 'gg-forms')}>
					<div className='video-settings'>
						<MediaUploadCheck>
							<MediaUpload
								onSelect={onSelectVideo}
								allowedTypes={['video']}
								render={({ open }) => (
									<div>
										<p style={{ marginBottom: '0.4rem', wordBreak: 'break-all' }}>
											{videoUrl ? (
												<>
													{__('Video:', 'gg-forms')} <strong>{decodeURIComponent(videoUrl.split('/').pop())}</strong>
												</>
											) : (
												<em style={{ color: '#888' }}>{__('No file selected.', 'gg-forms')}</em>
											)}
										</p>
										<Button
											onClick={open}
											variant="primary"
											style={{ width: '100%' }}
										>
											{__('Select Video', 'gg-forms')}
										</Button>
									</div>
								)}							
							/>
						</MediaUploadCheck>

						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ thumbnail: media?.url || '' })}
								allowedTypes={['image']}
								render={({ open }) => (
									<div>
										<p style={{ marginBottom: '0.4rem' }}>
											{thumbnail ? (
												<>
													{__('Thumbnail:', 'gg-forms')} <strong>{decodeURIComponent(thumbnail.split('/').pop())}</strong>
												</>
											) : (
												<em style={{ color: '#888' }}>{__('No file selected.', 'gg-forms')}</em>
											)}
										</p>
										<Button
											onClick={open}
											variant="secondary"
											style={{ width: '100%' }}
										>
											{__('Select Thumbnail', 'gg-forms')}
										</Button>
									</div>
								)}						
							/>
						</MediaUploadCheck>

						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ playIcon: media?.url || '' })}
								allowedTypes={['image']}
								render={({ open }) => (
									<div>
										<p style={{ marginBottom: '0.4rem' }}>
											{playIcon ? (
												<>
													{__('Play Icon:', 'gg-forms')} <strong>{decodeURIComponent(playIcon.split('/').pop())}</strong>
												</>
											) : (
												<em style={{ color: '#888' }}>{__('No file selected.', 'gg-forms')}</em>
											)}
										</p>
										<Button
											onClick={open}
											variant="secondary"
											style={{ width: '100%' }}
										>
											{__('Select Play Icon', 'gg-forms')}
										</Button>
									</div>
								)}
							/>
						</MediaUploadCheck>

						<NumberControl
							label={__('Play icon – Top (px)', 'gg-forms')}
							value={playIconTop ?? 250}
							onChange={(val) => setAttributes({ playIconTop: parseInt(val) || 0 })}
						/>
					</div>
				</PanelBody>

				<PanelBody title={__('Transition Question', 'gg-forms')} initialOpen={false}>
					<TextControl
						label={__('Question', 'gg-forms')}
						value={transitionQuestion}
						onChange={(val) => setAttributes({ transitionQuestion: val })}
					/>

					
					{targetTime > 59 && (
					<NumberControl
						label={__('Show time – Minute', 'gg-forms')}
						value={showMinute ?? 0}
						onChange={(val) => {
							const safe = parseInt(val);
							setAttributes({ showMinute: isNaN(safe) ? 0 : safe });
							setAttributes({ showSecond: safe === 0 && showSecond === 0 ? 59 : 0 });
						}}
						min={0}
						name="showMinute"
					/>
					)}

					<NumberControl
						label={__('Show time – Second', 'gg-forms')}
						value={showSecond ?? 0}
						onChange={(val) => {
							const safe = parseInt(val);
							setAttributes({ showSecond: isNaN(safe) || safe > 59 ? 0 : safe });
							setAttributes({ showMinute: safe > 59 ? showMinute + 1 : showMinute });
							if (safe > 59) {
								setTimeout(() => {
									const minuteInput = document.querySelector('input[name="showMinute"]');
									if (minuteInput) {
										minuteInput.focus();
										minuteInput.select();
									}
								}, 50);
								setTimeout(() => {
									const secondInput = document.querySelector('input[name="showSecond"]');
									if (secondInput) {
										secondInput.focus();
										secondInput.select();
									}
								}, 100);
							}
						}}
						min={0}
						max={60}
						name="showSecond"
					/>

					{optionBlocks.length > 0 && (
						<table style={{ width: '100%', marginTop: '1rem' }}>
							<thead>
								<tr>
									<th style={{ textAlign: 'left' }}>{__('Option', 'gg-forms')}</th>
									<th style={{ textAlign: 'left' }}>{__('Leads to', 'gg-forms')}</th>
								</tr>
							</thead>
							<tbody>
								{optionBlocks.map((opt, index) => (
									<tr key={index}>
										<td>{opt.label}</td>
										<td>{opt.target}</td>
									</tr>
								))}
							</tbody>
						</table>
					)}
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				{videoUrl ? (
					<>
						<video
							ref={videoRef}
							src={videoUrl}
							poster={thumbnail || undefined}
							onLoadedMetadata={onLoadedMetadata}
							style={{ width: '100%', aspectRatio: aspectRatio || '16/9' }}
						/>

						{playIcon && (
							<img
								src={playIcon}
								alt="Play"
								style={{
									position: 'absolute',
									top: `${playIconTop}px`,
									left: '50%',
									marginLeft: '-64px',
									width: '128px',
									cursor: 'pointer',
									pointerEvents: 'none'
								}}
							/>
						)}

						<div className='ggf-question'>
							{transitionQuestion ? (
								<strong>{transitionQuestion}</strong>
							) : (
								<em>{__('Not configured.', 'gg-forms')}</em>
							)}

							<InnerBlocks
								allowedBlocks={['ggf/gg-option']}
								template={[['ggf/gg-option']]}
							/>

							{targetTime ? (
								<div className="ggf-question-show-after">
									{__('Show after', 'gg-forms')} <strong>{targetTime}</strong> {__('seconds', 'gg-forms')}
								</div>
							) : (
								<em>{__('Not configured.', 'gg-forms')}</em>
							)}
						</div>
					</>
				) : (
					<p>{__('No video selected yet.', 'gg-forms')}</p>
				)}
			</div>
		</>
	);
}
