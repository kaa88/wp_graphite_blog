// Hello World!

//////////////////////////////////////////////

// Constants
const mobileSwitchWidth = parseFloat(getComputedStyle(document.body).getPropertyValue('--media-mobile')) || 768;

//////////////////////////////////////////////

// Cookies
@@include('front/cookies.js')
let cookies = getCookie();

//////////////////////////////////////////////

// Theme & Lang
let pageOptions = {
	themePrefix: 'theme-',
	themeName: 'dark',
	themeTimer: 1000,
	langPrefix: 'lang-',
	langName: 'ru',
	setOpt: function(param) {
		if (!param) return;
		document.body.classList.toggle(param);
	},
};
// console.log(pageOptions)

if (cookies) {
	if (cookies.theme) pageOptions.setOpt(pageOptions.themePrefix + cookies.theme);
	if (cookies.lang) pageOptions.setOpt(pageOptions.langPrefix + cookies.lang);
}

function setupControls() {
	let themeBtn = document.querySelector('.controls__theme');
	if (themeBtn) themeBtn.addEventListener('click', () => {
		if (transitionLock.check(pageOptions.themeTimer)) return;
		pageOptions.setOpt(pageOptions.themePrefix + pageOptions.themeName);

		setTimeout(() => {
			if (cookies) {
				if (cookies.cookies_accepted) {
					if (document.body.classList.contains('theme-dark')) {
						setCookie({
							name: 'theme',
							value: pageOptions.themeName,
							expires: 365
						});
					}
					else {
						setCookie({
							name: 'theme',
							value: pageOptions.themeName,
							expires: -1
						});
					}
				}
				else {
					if (document.body.classList.contains('theme-dark')) {
						setCookie({
							name: 'theme',
							value: pageOptions.themeName,
						});
					}
					else {
						setCookie({
							name: 'theme',
							value: pageOptions.themeName,
							expires: -1
						});
					}
				}
			}
		}, 100);
	})

	// let langBtn = document.querySelector('.controls__lang');
	// if (langBtn) langBtn.addEventListener('click', () => {
	// 	if (transitionLock.check(1000)) return;
	// 	pageOptions.setOpt(pageOptions.langPrefix + pageOptions.langName);
	// 		// setCookie({
	// 		// 	name: 'lang',
	// 		// 	value: 'en',
	// 		// 	expires: 365
	// 		// });
	// 	})
}
setupControls();

//////////////////////////////////////////////

// Loadscreen
@@include('front/loadscreen.js')

let loadscreenTimer = 0
if (cookies && cookies.theme) loadscreenTimer = 800
loadscreen.init({
	timeout: loadscreenTimer
})

//////////////////////////////////////////////

// Scroll lock
@@include('front/scroll_lock.js')
scrollLock.init()

//////////////////////////////////////////////

// Transition lock
@@include('front/trans_lock.js')

//////////////////////////////////////////////

// Header
@@include('front/header.js')
header.init({
	// menu: true,
	// submenu: true,
	// hidingHeader: true,
	elemAboveHeader: true
})

//////////////////////////////////////////////

// Footer //
@@include('front/footer.js')
footer.init()

//////////////////////////////////////////////

// Modal window
@@include('front/modal.js')
modal.init()

//////////////////////////////////////////////

// Popup
@@include('front/popup.js')
let test_popup = new Popup({
	// elem: 'test-popup'
});
// Place each popup's code below
const cookieAlert = {
	popup: test_popup,
	aboutLink: document.querySelector('.cookie-alert__link'),
	closeButton: document.querySelector('.cookie-alert__close'),
	acceptButton: document.querySelector('.cookie-alert__accept'),
}
cookieAlert.init = function() {
	if (cookies && cookies.cookies_accepted != 'true') {
		this.popup.open();
	}
	if (this.aboutLink) {
		this.aboutLink.addEventListener('click', function() {
			this.closest('.cookie-alert').classList.add('_opened');
		})
	}
	if (this.closeButton) {
		this.closeButton.addEventListener('click', () => {
			this.popup.close();
		})
	}
	if (this.acceptButton) {
		this.acceptButton.addEventListener('click', () => {
			setCookie({
				name: 'cookies_accepted',
				value: 'true',
				expires: 365
			});
			this.popup.close();
		})
	}
}
window.addEventListener('load', () => {
	setTimeout(() => {
		cookieAlert.init();
	}, 2000);
})

//////////////////////////////////////////////

// Spoiler
@@include('front/spoiler.js')
spoiler.init();

//////////////////////////////////////////////
