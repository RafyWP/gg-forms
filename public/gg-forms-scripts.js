document.addEventListener('DOMContentLoaded', function () {
	const videos = document.querySelectorAll('.ggf-story-video');

	videos.forEach((video) => {
		const target = parseFloat(video.dataset.targetTime || 0);
		const container = video.closest('.wp-block-ggf-gg-story');

		if (!container) return;

		const question = container.querySelector('.ggf-question-slide');
		const button = container.querySelector('.ggf-play-button');

		if (question) {
			video.addEventListener('timeupdate', function () {
				if (video.currentTime >= target) {
					question.classList.add('visible');
				}
			});
		}

		if (button) {
			button.addEventListener('click', () => {
				video.play();
				video.muted = false;
				button.style.display = 'none';
			});
		}
	});

	const wrapper = document.querySelector('.wp-block-ggf-gg-forms');

	if (wrapper && typeof Swiper !== 'undefined') {
		requestAnimationFrame(() => {
			const slideElements = Array.from(wrapper.querySelector('.swiper-wrapper').children)
				.filter(el => el.classList.contains('swiper-slide') && !el.classList.contains('swiper-slide-duplicate'));

			const idToIndexMap = {};
			slideElements.forEach((slide, index) => {
				if (slide.id) {
					idToIndexMap[slide.id] = index;
				}
			});

			console.log('Mapeamento corrigido:', idToIndexMap);

			const swiperInstance = new Swiper(wrapper, {
				slidesPerView: 1,
				allowTouchMove: false,
				loop: false,
				effect: 'creative',
				creativeEffect: {
					prev: {
						translate: [0, 0, -200],
						scale: 0.8,
						opacity: 0.3,
					},
					next: {
						translate: [100, 0, 0],
					},
				}				
			});

			document.querySelectorAll('[data-story-id]').forEach((button) => {
				button.addEventListener('click', () => {
					const targetId = button.getAttribute('data-story-id');
					const targetIndex = idToIndexMap[targetId];

					if (typeof targetIndex !== 'undefined' && swiperInstance.activeIndex !== targetIndex) {
						swiperInstance.slideTo(targetIndex);
					}
				});
			});
		});
	}

});
