/**
 * Daiei Keibi LP interactions.
 *
 * No library dependencies.
 */
(function () {
	'use strict';

	const root = document.documentElement;
	const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	root.classList.add('js');

	const header = document.querySelector('.site-header');
	const menuButton = document.querySelector('.menu-toggle');
	const navigation = document.querySelector('.site-nav');
	const progress = document.querySelector('.scroll-progress span');
	const backToTop = document.querySelector('.back-to-top');
	const heroPattern = document.querySelector('.hero__pattern');
	let lastFocused = null;

	const focusableSelector = [
		'a[href]',
		'button:not([disabled])',
		'input:not([disabled])',
		'select:not([disabled])',
		'textarea:not([disabled])',
		'[tabindex]:not([tabindex="-1"])'
	].join(',');

	function closeMenu(returnFocus) {
		if (!menuButton || !navigation) {
			return;
		}
		menuButton.setAttribute('aria-expanded', 'false');
		menuButton.setAttribute('aria-label', 'メニューを開く');
		navigation.classList.remove('is-open');
		document.body.classList.remove('menu-open');
		if (returnFocus && lastFocused) {
			lastFocused.focus();
		}
	}

	function openMenu() {
		if (!menuButton || !navigation) {
			return;
		}
		lastFocused = document.activeElement;
		menuButton.setAttribute('aria-expanded', 'true');
		menuButton.setAttribute('aria-label', 'メニューを閉じる');
		navigation.classList.add('is-open');
		document.body.classList.add('menu-open');
		const firstItem = navigation.querySelector(focusableSelector);
		if (firstItem) {
			firstItem.focus();
		}
	}

	if (menuButton && navigation) {
		menuButton.addEventListener('click', function () {
			const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
			if (isOpen) {
				closeMenu(true);
			} else {
				openMenu();
			}
		});

		navigation.addEventListener('click', function (event) {
			if (event.target.closest('a')) {
				closeMenu(false);
			}
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && navigation.classList.contains('is-open')) {
				closeMenu(true);
				return;
			}

			if (event.key !== 'Tab' || !navigation.classList.contains('is-open')) {
				return;
			}

			const items = Array.from(navigation.querySelectorAll(focusableSelector));
			if (!items.length) {
				return;
			}
			const first = items[0];
			const last = items[items.length - 1];
			if (event.shiftKey && document.activeElement === first) {
				event.preventDefault();
				last.focus();
			} else if (!event.shiftKey && document.activeElement === last) {
				event.preventDefault();
				first.focus();
			}
		});

		window.addEventListener('resize', function () {
			if (window.innerWidth > 900 && navigation.classList.contains('is-open')) {
				closeMenu(false);
			}
		});
	}

	function updateScrollUI() {
		const scrollTop = window.scrollY || document.documentElement.scrollTop;
		const scrollable = document.documentElement.scrollHeight - window.innerHeight;
		const percent = scrollable > 0 ? Math.min(100, (scrollTop / scrollable) * 100) : 0;

		if (header) {
			header.classList.toggle('is-scrolled', scrollTop > 20);
		}
		if (progress) {
			progress.style.width = percent + '%';
		}
		if (backToTop) {
			backToTop.classList.toggle('is-visible', scrollTop > 500);
		}
		if (heroPattern && !reducedMotion && scrollTop < window.innerHeight) {
			heroPattern.style.transform = 'translate3d(0,' + (scrollTop * 0.08) + 'px,0)';
		}
	}

	let scrollTicking = false;
	window.addEventListener('scroll', function () {
		if (scrollTicking) {
			return;
		}
		scrollTicking = true;
		window.requestAnimationFrame(function () {
			updateScrollUI();
			scrollTicking = false;
		});
	}, { passive: true });
	updateScrollUI();

	if (backToTop) {
		backToTop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
		});
	}

	const revealItems = document.querySelectorAll('.reveal');
	if (reducedMotion || !('IntersectionObserver' in window)) {
		revealItems.forEach(function (item) {
			item.classList.add('is-visible');
		});
	} else {
		const revealObserver = new IntersectionObserver(function (entries, observer) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		}, {
			rootMargin: '0px 0px -8% 0px',
			threshold: 0.08
		});

		revealItems.forEach(function (item) {
			revealObserver.observe(item);
		});
	}

	function animateCounter(element) {
		const target = Number.parseInt(element.dataset.counter || '0', 10);
		if (!Number.isFinite(target)) {
			return;
		}
		if (reducedMotion) {
			element.textContent = String(target);
			return;
		}

		const duration = 900;
		const start = performance.now();
		element.textContent = '0';

		function frame(now) {
			const progressValue = Math.min(1, (now - start) / duration);
			const eased = 1 - Math.pow(1 - progressValue, 3);
			element.textContent = String(Math.round(target * eased));
			if (progressValue < 1) {
				window.requestAnimationFrame(frame);
			}
		}
		window.requestAnimationFrame(frame);
	}

	const counters = document.querySelectorAll('[data-counter]');
	if ('IntersectionObserver' in window) {
		const counterObserver = new IntersectionObserver(function (entries, observer) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					animateCounter(entry.target);
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.6 });
		counters.forEach(function (counter) {
			counterObserver.observe(counter);
		});
	} else {
		counters.forEach(animateCounter);
	}

	document.querySelectorAll('.accordion__trigger').forEach(function (button, index) {
		const panelId = button.getAttribute('aria-controls');
		const panel = panelId ? document.getElementById(panelId) : null;
		if (!panel) {
			return;
		}

		button.setAttribute('aria-expanded', index === 0 ? 'true' : 'false');
		panel.hidden = index !== 0;

		button.addEventListener('click', function () {
			const expanded = button.getAttribute('aria-expanded') === 'true';
			button.setAttribute('aria-expanded', expanded ? 'false' : 'true');
			panel.hidden = expanded;
		});
	});

	const tabs = Array.from(document.querySelectorAll('[data-form-tab]'));
	const panels = Array.from(document.querySelectorAll('[data-form-panel]'));

	function activateTab(type, moveFocus) {
		tabs.forEach(function (tab) {
			const active = tab.dataset.formTab === type;
			tab.setAttribute('aria-selected', active ? 'true' : 'false');
			tab.setAttribute('tabindex', active ? '0' : '-1');
			if (active && moveFocus) {
				tab.focus();
			}
		});
		panels.forEach(function (panel) {
			const active = panel.dataset.formPanel === type;
			panel.classList.toggle('is-active', active);
			panel.hidden = !active;
		});
	}

	if (tabs.length && panels.length) {
		const selected = tabs.find(function (tab) {
			return tab.getAttribute('aria-selected') === 'true';
		});
		activateTab(selected ? selected.dataset.formTab : 'business', false);

		tabs.forEach(function (tab, index) {
			tab.addEventListener('click', function () {
				activateTab(tab.dataset.formTab, false);
			});
			tab.addEventListener('keydown', function (event) {
				if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) {
					return;
				}
				event.preventDefault();
				let nextIndex = index;
				if (event.key === 'ArrowLeft') {
					nextIndex = (index - 1 + tabs.length) % tabs.length;
				} else if (event.key === 'ArrowRight') {
					nextIndex = (index + 1) % tabs.length;
				} else if (event.key === 'Home') {
					nextIndex = 0;
				} else if (event.key === 'End') {
					nextIndex = tabs.length - 1;
				}
				activateTab(tabs[nextIndex].dataset.formTab, true);
			});
		});
	}

	const feedback = document.querySelector('[data-form-feedback]');
	if (feedback) {
		window.setTimeout(function () {
			feedback.focus({ preventScroll: true });
			feedback.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'center' });
		}, 100);
	}
}());
