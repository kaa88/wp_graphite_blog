// Hello World!

//////////////////////////////////////////////

// Constants
const mobileSwitchWidth = parseFloat(getComputedStyle(document.body).getPropertyValue('--media-mobile')) || 768;

//////////////////////////////////////////////

// Cookies
/* Example: 
	setCookie(
		{
			name: '_cookies', // required
			value: 'true', // required
			path: '/ru' // default '/'
			expires: 30, // expire time in days (can be negative to delete cookie)
			// *any other supported params*
		},
		true // log formatted cookie string in console
	);
*/

function setCookie(params = {}, log) {
	if (!params.name || !params.value) return console.log('Error: Required cookie "name" or "value" is missing.');

	let cookieArr = [];
	cookieArr.push(encodeURIComponent(params.name) + '=' +  encodeURIComponent(params.value));
	cookieArr.push('path=' + (params.path ? params.path : '/'));

	if (params.expires) {
		let d = new Date();
		d.setTime(d.getTime() + (params.expires*24*60*60*1000));
		cookieArr.push('expires=' + d.toUTCString());
	}

	let entries = Object.entries(params);
	for (let i = 0; i < entries.length; i++) {
		if (entries[i][0] == 'name' || entries[i][0] == 'value' || entries[i][0] == 'path' || entries[i][0] == 'expires') continue;
		cookieArr.push(entries[i][0] + (entries[i][1] ? ('=' + entries[i][1]) : ''));
	}

	let cookieStr = cookieArr.join('; ');
	document.cookie = cookieStr;
	if (log) console.log('Setting up cookie: ' + cookieStr);
}

function getCookie() {
	let cookiesArr = decodeURIComponent(document.cookie).split('; '),
		cookiesObj = {};
	for (let i = 0; i < cookiesArr.length; i++) {
		let split = cookiesArr[i].split('=');
		cookiesObj[split[0]] = split[1];
	}
	return cookiesObj;
}
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
/*
	Init params {obj}:
	- timeout - timeout between document is loaded and loadscreen begins to fade (default = 0)
	- scrollToTop - force scroll document to top on page reload (default = false)
*/
const loadscreen = {
	init: function(params = {}) {
		this.elem = document.querySelector('.loadscreen');
		if (!this.elem) return;
		let that = this;
		document.body.classList.add('_locked');
		window.addEventListener('load', () => {
			setTimeout(() => {
				document.body.classList.remove('_locked');
				if (params.scrollToTop) window.scrollTo({top: 0, behavior: 'instant'});
				that.elem.classList.remove('_locked');
			}, params.timeout || 0)
		})
	}
}

let loadscreenTimer = 0
if (cookies && cookies.theme) loadscreenTimer = 800
loadscreen.init({
	timeout: loadscreenTimer
})

//////////////////////////////////////////////

// Scroll lock
/* 
	Module prevents window scrolling with menu, modals, etc. and
	prevents content jumps when scrollbar fades out.
	Script will find elements in default groups (main, footer) and 
	set 'padding-right' property to them.
	You can exclude them by setting a 'useDefaultGroups' param to 'false'.
	Header is not a default group, these elems must be added manually.
	
	Set an additional elems to list by setting classes to HTML:
	- 'scroll-lock-item-p' class - for static elems ('padding-right' prop.)
	- 'scroll-lock-item-m' class - for fixed elems ('margin-right' prop.)
	- 'scroll-lock-item-pm' class - for static elems that will be hidden in menu
		(they will get a 'padding-right' prop. only on desktop width)

	Usable functions: 
		scrollLock.lock()
		scrollLock.unlock( #timeout# )

	Init params {obj}: useDefaultGroups (default = true)
*/
const scrollLock = {
	refs: {
		mobile: mobileSwitchWidth
	},
	defaultElems: ['main', 'footer'],
	paddingItemClassName: 'scroll-lock-item-p',
	paddingMenuItemClassName: 'scroll-lock-item-pm',
	marginItemClassName: 'scroll-lock-item-m',
	lockedClassName: '_locked',

	init: function(params = {}) {
		this.paddingItems = document.querySelectorAll('.' + this.paddingItemClassName);
		this.paddingMenuItems = document.querySelectorAll('.' + this.paddingMenuItemClassName);
		this.marginItems = document.querySelectorAll('.' + this.marginItemClassName);

		if (params.useDefaultGroups === false || params.useDefaultGroups === 'false')
			this.useDefaultGroups = false;
		else this.useDefaultGroups = true;

		if (this.useDefaultGroups) {
			let selector = '';
			for (let i = 0; i < this.defaultElems.length; i++) {
				selector += '.' + this.defaultElems[i] + '>*';
				if (i < this.defaultElems.length - 1) selector += ',';
			}
			let defaultItems = document.querySelectorAll(selector);
			let joinedPaddingItems = Array.from(defaultItems);
			for (let i = 0; i < this.paddingItems.length; i++) {
				let exist = false;
				for (let j = 0; j < defaultItems.length; j++) {
					if (defaultItems[j] == this.paddingItems[i]) exist = true;
				}
				if (!exist) joinedPaddingItems.push(this.paddingItems[i]);
			}
			this.paddingItems = joinedPaddingItems;
		}
	},

	lock: function() {
		if (document.body.classList.contains(this.lockedClassName)) return;
		this.scrollbarWidth = window.innerWidth - document.body.offsetWidth;
		let that = this;
		function f(items, prop) {
			for (let i = 0; i < items.length; i++) {
				items[i][prop] = parseFloat(getComputedStyle(items[i])[prop]);
				items[i].style[prop] = items[i][prop] + that.scrollbarWidth + 'px';
			}
		}
		if (window.innerWidth > this.refs.mobile)
			f(this.paddingMenuItems, 'paddingRight');
		f(this.paddingItems, 'paddingRight');
		f(this.marginItems, 'marginRight');
		document.body.classList.add(this.lockedClassName);
	},

	unlock: function(timeout = 0) {
		let that = this;
		setTimeout(() => {
			function f(items, prop) {
				for (let i = 0; i < items.length; i++) {
					items[i].style[prop] = '';
				}
			}
			f(this.paddingMenuItems, 'paddingRight');
			f(this.paddingItems, 'paddingRight');
			f(this.marginItems, 'marginRight');
			document.body.classList.remove(that.lockedClassName);
		}, timeout);
	}
}
scrollLock.init()

//////////////////////////////////////////////

// Transition lock
/* 
	Module prevents double-clicking on transitions, e.g. when menu slides.
	Use: if (transitionLock.check( #timeout# )) return;
*/
const transitionLock = {
	locked: false,
	check: function(timeout = 0) {
		let that = this,
		    result = this.locked;
			 if (that.locked == false) {
			that.locked = true;
			setTimeout(function(){
				that.locked = false;
			}, timeout);
		}
		return result;
	}
}

//////////////////////////////////////////////

// Header
/* 
	Always init header to keep css variables working, even if header is empty
	Set transition timeout in CSS only
	
	Init params {obj}: (defaults = false)
	- menu - add menu module
	- submenu - add submenu module
	- hidingHeader - add hidingHeader module
	- elemAboveHeader - if there is something above the header, e.g. WordPress adminbar, set 'true' to calculate it as well
*/
const header = {
	refs: { // dependences
		mobile: mobileSwitchWidth,
		translock: transitionLock,
		scrlock: scrollLock
	},
	names: {
		// selectors:
		elemAboveHeader: '#wpadminbar',
		header: '.header',
		menu: '.header-menu-hide-wrapper',
		menuItems: '.header-menu__items',
		menuItem: '.header-menu__item',
		menuOpenBtn: '.header-menu-open-btn',
		menuCloseBtn: '.header-menu-close-btn',
		menuBackBtn: '.header-submenu-back-btn',
		menuArea: '.header-menu-turn-off-area',
		menuOptions: '#header-menu-options',
		submenu: '.header-submenu-hide-wrapper',
		submenuDropLink: '.submenu-drop-link',
		// classnames:
		noheader: 'header--empty',
		thisPageClass: 'this-page',
		// css variable names:
		varTimer: '--timer-menu',
		varHeight: '--header-height',
		varTop: '--header-offset-top',
		varTopDef: '--header-offset-top-default',
	},
	init: function(params = {}) {
		this.headerElem = document.querySelector(this.names.header);
		// new
		if (!this.headerElem) {
			this.headerElem = document.createElement('header');
			this.headerElem.className = this.names.noheader;
			document.body.prepend(this.headerElem);
		}
		// /new

		let timeout = parseFloat(getComputedStyle(document.body).getPropertyValue(this.names.varTimer))*1000 || 0;

		this.headerHeight =
		this.headerHeightPrev =
		this.headerOffsetTop =
		this.headerOffsetTopPrev =
		this.headerOffsetTopDefault =
		this.headerOffsetTopDefaultPrev = 0;

		let elemAboveHeader = document.querySelector(this.names.elemAboveHeader);
		if (params.elemAboveHeader && elemAboveHeader)
			this.elemAboveHeader = elemAboveHeader;
		else this.elemAboveHeader = false;

		this.calcHeaderHeight();
		window.addEventListener('resize', this.calcHeaderHeight.bind(this));

		if (params.menu) this.menu.init(this, timeout, this.names);
		if (params.submenu) this.submenu.init(this, timeout, this.names);
		if (params.hidingHeader) window.addEventListener('load', () => this.hidingHeader.init(this));
	},
	calcHeaderHeight: function() {
		// This func controls the mobile menu height variable in css
		this.headerHeight = parseFloat(getComputedStyle(this.headerElem).height);
		if (this.elemAboveHeader) {
			this.headerOffsetTopDefault = this.headerOffsetTop = parseFloat(getComputedStyle(this.elemAboveHeader).height);
		}
		else this.headerOffsetTopDefault = this.headerOffsetTop = 0;
		this.setCssVar();
		this.hidingHeader.calc();
	},
	setCssVar: function() {
		if (this.headerHeight != this.headerHeightPrev) {
			document.body.style.setProperty(this.names.varHeight, this.headerHeight + 'px');
			this.headerHeightPrev = this.headerHeight;
		}
		if (this.headerOffsetTop != this.headerOffsetTopPrev) {
			document.body.style.setProperty(this.names.varTop, this.headerOffsetTop + 'px');
			this.headerOffsetTopPrev = this.headerOffsetTop;
		}
		if (this.headerOffsetTopDefault != this.headerOffsetTopDefaultPrev) {
			document.body.style.setProperty(this.names.varTopDef, this.headerOffsetTopDefault + 'px');
			this.headerOffsetTopDefaultPrev = this.headerOffsetTopDefault;
		}
	},
	mobileViewService: function() {
		this.menu.toggle();
		this.menu.hideOnViewChange();
		// this.hidingHeader.calc();
	},

	// Menu
	menu: {
		isLoaded: false,
		init: function(that, timeout, names) {
			this.isLoaded = true;
			this.root = that;
			this.timeout = timeout;
			this.menuElem = this.root.headerElem.querySelector(names.menu);
			this.buttons = this.root.headerElem.querySelectorAll(`${names.menuOpenBtn}, ${names.menuCloseBtn}, ${names.menuArea}`);
			let newMenu = this.menuElem.querySelector(names.menuItems);
			let options = {};
			if (typeof headerMenuOptions !== 'undefined') options = headerMenuOptions;
			if (options.links) {
				let clone = {};
				for (let i = 0; i < newMenu.children.length; i++) {
					clone[newMenu.children[i].dataset.name] = newMenu.children[i];
				}
				newMenu.innerHTML = '';
				for (let i = 0; i < options.links.length; i++) {
					newMenu.appendChild(clone[options.links[i]]);
				}
			}
			if (options.activeLink) {
				for (let i = 0; i < newMenu.children.length; i++) {
					if (newMenu.children[i].dataset.name == options.activeLink) {
						newMenu.children[i].firstElementChild.classList.add(names.thisPageClass);
						break;
					}
				}
			}
			options.elem = document.querySelector(names.menuOptions);
			if (options.elem) options.elem.parentElement.removeChild(options.elem);

			for (let i = 0; i < this.buttons.length; i++) {
				this.buttons[i].addEventListener('click', this.toggle.bind(this));
			}
		},
		toggle: function(e) {
			if (!this.isLoaded) return;
			if (this.root.refs.translock.check(this.timeout)) return;
			
			if (this.menuElem.classList.contains('_active')) {
				this.menuElem.classList.remove('_active');
				for (let i = 0; i < this.buttons.length; i++) {
					this.buttons[i].classList.remove('_active');
				}
				this.root.refs.scrlock.unlock(this.timeout);
				this.root.submenu.closeAll(); // submenu reference
			}
			else {
				if (e) {
					this.menuElem.classList.add('_active');
					for (let i = 0; i < this.buttons.length; i++) {
						this.buttons[i].classList.add('_active');
					}
					this.root.refs.scrlock.lock();
					this.root.hidingHeader.scroll(0, true); // hidingHeader reference
				}
			}
		},
		hideOnViewChange: function() {
			// this func prevents menu blinking on mobile view switch
			if (this.isLoaded) {
				let that = this;
				this.menuElem.style.display = 'none';
				setTimeout(() => {
					that.menuElem.style.display = '';
					that.root.calcHeaderHeight();
				}, that.timeout)
			}
		}
	},
	// /Menu

	// SubMenu
	submenu: {
		isLoaded: false,
		init: function(that, timeout, names){
			this.isLoaded = true;
			this.root = that;
			this.timeout = timeout;
			this.sMenuElems = this.root.headerElem.querySelectorAll(names.submenu);
			if (this.sMenuElems.length == 0) {
				console.log('Error: No submenu detected');
				return;
			}
			this.links = this.root.headerElem.querySelectorAll(names.submenuDropLink);
			this.backButtons = this.root.headerElem.querySelectorAll(names.menuBackBtn);
			// if menu-item contains submenu
			if (this.links[0]) {
				if (this.links[0].closest(names.menuItem).querySelector(names.submenu)) this.isOutside = false;
				else this.isOutside = true;
			}
			// setting events
			for (let i = 0; i < this.backButtons.length; i++) {
				this.backButtons[i].addEventListener('click', this.toggle.bind(this));
			}
			for (let i = 0; i < this.links.length; i++) {
				this.links[i].addEventListener('click', this.toggle.bind(this));
				this.links[i].addEventListener('mouseover', this.toggle.bind(this));
				if (!this.isOutside)
					this.links[i].closest(names.menuItem).addEventListener('mouseleave', this.toggle.bind(this));
			}
			if (this.isOutside)
				this.root.headerElem.addEventListener('mouseleave', this.toggle.bind(this));
		},
		toggle: function(e) {
			if (!e) return;
			let that = this, mobile = false;
			if (window.innerWidth <= this.root.refs.mobile) mobile = true;

			function is(name) {
				let str = that.root.names[name];
				if (str.match(/[#.]/)) str = str.substring(1);
				return e.currentTarget.classList.contains(str);
			}
			
			if (mobile) {
				if (e.type == 'click') {
					if (is('submenuDropLink')) this.open(e, mobile);
					if (is('menuBackBtn')) this.close(e, mobile);
				}
			}
			else {
				if (e.type == 'mouseover') {
					if (is('submenuDropLink')) this.open(e, mobile);
				}
				if (e.type == 'mouseleave') {
					if (is('menuItem') || is('header')) this.close(e, mobile);
				}
			}
		},
		open: function(e, m) {
			e.preventDefault();
			if (m && this.root.refs.translock.check(this.timeout)) return;
			if (this.isOutside) {
				for (let i = 0; i < this.links.length; i++) {
					this.links[i].classList.add('_active');
				}
				for (let i = 0; i < this.sMenuElems.length; i++) {
					this.sMenuElems[i].classList.add('_active');
				}
			}
			else {
				e.currentTarget.classList.add('_active');
				e.currentTarget.nextElementSibling.classList.add('_active');
			}
		},
		close: function(e, m) {
			if (m && this.root.refs.translock.check(this.timeout)) return;
			if (this.isOutside) {
				let items = this.root.headerElem.querySelectorAll(`${this.root.names.menuItem} ._active, ${this.root.names.submenu}._active`);
				for (let i = 0; i < items.length; i++) {
					items[i].classList.remove('_active');
				}
			}
			else {
				let parent = e.currentTarget.closest(this.root.names.submenu).parentElement;
				for (let i = 0; i < parent.children.length; i++) {
					parent.children[i].classList.remove('_active');
				}
			}
		},
		closeAll: function() {
			if (this.isLoaded) {
				for (let i = 0; i < this.links.length; i++) {
					this.links[i].classList.remove('_active');
				}
				for (let i = 0; i < this.sMenuElems.length; i++) {
					this.sMenuElems[i].classList.remove('_active');
				}
			}
		}
	},
	// /SubMenu

	// Hiding Header
	hidingHeader: {
		isLoaded: false,
		init: function(that) {
			this.isLoaded = true;
			this.root = that;
			this.hiddenPositionOffset = 0; // set this one if you want to move header by value that differs it's height
			this.firstScroll = true;
			window.addEventListener('scroll', this.scroll.bind(this));
		},
		calc: function() {
			if (!this.isLoaded) return;
			this.Y = this.YPrev = pageYOffset;
			this.diff = 0;
			this.currentPos = this.root.headerOffsetTopDefault;
		},
		scroll: function(e, click) {
			if (!this.isLoaded) return;
			if (window.innerWidth > this.root.refs.mobile) return;

			// this 'if' prevents header's jump after page reloading in the middle of the content
			if (this.firstScroll) {
				this.firstScroll = false;
				this.calc();
				return;
			}
			// click-move
			if (click) {
				this.currentPos = this.root.headerOffsetTop = this.root.headerOffsetTopDefault;
				this.root.setCssVar();
				return;
			}
			// lazyLoad check
			if ((pageYOffset < (this.Y + this.diff) && this.Y > this.YPrev) || (pageYOffset > (this.Y + this.diff) && this.Y < this.YPrev)) {
				this.diff = pageYOffset - this.Y;
			}
			// scroll-move
			let currentPos = this.root.headerOffsetTop;
			let visiblePos = this.root.headerOffsetTopDefault;
			let hiddenPos = visiblePos - this.root.headerHeight - this.hiddenPositionOffset;
			this.YPrev = this.Y;
			this.Y = pageYOffset - this.diff;
			currentPos -= this.Y - this.YPrev;
			if (currentPos > visiblePos) currentPos = visiblePos;
			if (currentPos < hiddenPos) currentPos = hiddenPos;
			this.root.headerOffsetTop = currentPos;
			this.root.setCssVar();
		}
	},
	// /Hiding Header
}
header.init({
	// menu: true,
	// submenu: true,
	// hidingHeader: true,
	elemAboveHeader: true
})

//////////////////////////////////////////////

// Footer //
/* 
	This module calculates footer's height and sets css variable.
*/
const footer = {
	init: function() {
		this.footerElem = document.querySelector('.footer');
		if (!this.footerElem) return;
		this.footerHeight = this.footerHeightPrev = 0;
		this.calcFooterHeight();
		window.addEventListener('resize', this.calcFooterHeight.bind(this));
	},
	calcFooterHeight: function() {
		this.footerHeight = this.footerElem.offsetHeight;
		if (this.footerHeight != this.footerHeightPrev) {
			document.body.style.setProperty('--footer-height', this.footerHeight + 'px');
			this.footerHeightPrev = this.footerHeight;
		}
	}
}
footer.init()

//////////////////////////////////////////////

// Modal window
/* 
	Set transition timeout in CSS only.
	
	Init params {obj}: 
	- elem - element name (default = 'modal'),
	- linkName - modal link name (default = 'modal-link')
	- on: {'modal-window': {open, close}} - event function(event, content, timeout){}

	On-func example:
	modal.init({
		on: {
			'modal-contact': {
				close: function(event, content, timeout) {setTimeout(() => {formToEmail.clean(document.querySelector('.question-form'))}, 700)}
			},
			'modal-imgpreview': {
				open: function(event, content, timeout) {
					let source = event.currentTarget.children[event.currentTarget.children.length-1];
					let img = document.querySelector('#modal-imgpreview img');
					img.src = source.getAttribute('src').replace('.','-preview.');
					if (source.srcset) img.srcset = source.srcset.replace('@2x.','-preview@2x.');
					else img.srcset = '';
				},
				close: function(event, content) {
					let img = document.querySelector('#modal-imgpreview img');
					setTimeout(() => {
						img.src = img.srcset = '';
					}, modal.timeout)
				},
			},
			'modal-video': {
				open: function(event, content, timeout) {setTimeout(() => {videoPlayer.play(content)}, timeout)},
				close: function(event, content, timeout) {videoPlayer.pause(content)}
			}
		}
	})
*/
const modal = {
	refs: {
		translock: transitionLock,
		scrlock: scrollLock,
		// header: header.menu.menuElem
	},
	init: function(params = {}){
		this.elemName = params.elem || 'modal';
		this.elem = document.querySelector('.' + this.elemName);
		if (!this.elem) return;
		this.timeout = parseFloat(getComputedStyle(document.body).getPropertyValue('--timer-modal'))*1000 || 0;
		this.windows = this.elem.querySelectorAll('.' + this.elemName + '__window');
		this.links = document.querySelectorAll(params.linkName ? '.' + params.linkName : '.modal-link');
		let that = this;
		for (let i = 0; i < this.links.length; i++) {
			this.links[i].addEventListener('click', this.open.bind(this));
		}
		this.elem.addEventListener('click', function(e) {
			if (!e.target.closest('.' + this.elemName + '__wrapper')) this.closeAll();
		}.bind(this));
		let closeButtons = this.elem.querySelectorAll('.' + this.elemName + '__close-button');
		for (let i = 0; i < closeButtons.length; i++) {
			closeButtons[i].addEventListener('click', this.closeThis.bind(this));
		}
		this.on = params.on || {};
	},
	open: function(e){
		if (this.refs.translock.check(this.timeout)) return;
		e.preventDefault();
		let currentModal = this.elem.querySelector(e.currentTarget.getAttribute('href'));
		currentModal.classList.add('_open');
		if (this.on[currentModal.id] && this.on[currentModal.id].open)
			this.on[currentModal.id].open(
				e, 
				currentModal.querySelector('.' + this.elemName + '__content > *:not(.' + this.elemName + '__close-button)'),
				this.timeout
			);
		modal.check();
	},
	closeThis: function(e){
		if (this.refs.translock.check(this.timeout)) return;
		let currentModal = e.target.closest('.' + this.elemName + '__window');
		currentModal.classList.remove('_open');
		if (this.on[currentModal.id] && this.on[currentModal.id].close)
			this.on[currentModal.id].close(
				e, 
				currentModal.querySelector('.' + this.elemName + '__content > *:not(.' + this.elemName + '__close-button)'),
				this.timeout
			);
		modal.check();
	},
	closeAll: function(){
		if (this.refs.translock.check(this.timeout)) return;
		for (let i = 0; i < this.windows.length; i++) {
			if (this.windows[i].classList.contains('_open')) {
				this.windows[i].classList.remove('_open');
				if (this.on[this.windows[i].id] && this.on[this.windows[i].id].close)
					this.on[this.windows[i].id].close(0,0,this.timeout);
			}
		}
		modal.check();
	},
	check: function(){
		let openedWindows = 0;
		for (let i = 0; i < this.windows.length; i++) {
			if (this.windows[i].classList.contains('_open')) openedWindows++;
		}
		if (openedWindows) {
			this.elem.classList.add('_visible');
			this.refs.scrlock.lock();
		}
		else {
			this.elem.classList.remove('_visible');
			// if (!this.refs.header.classList.contains('_active'))
				this.refs.scrlock.unlock(this.timeout);
		}
	}
}
modal.init()

//////////////////////////////////////////////

// Popup
/*	
	Init params {obj}:
	- elem - element name (default = 'popup')
*/
class Popup {
	constructor(params = {}) {
		this.elemName = params.elem || 'popup';
		this.elem = document.querySelector('.' + this.elemName);
		if (!this.elem) return;

		this.isLoaded = true;

		let closeBtn = this.elem.querySelector('.popup__close-btn');
		if (closeBtn) closeBtn.addEventListener('click', this.close.bind(this));
	}
	open() {
		if (this.isLoaded)
			this.elem.classList.add('_visible');
	}
	close() {
		if (this.isLoaded)
			this.elem.classList.remove('_visible');
	}
}
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
const spoiler = {
	names: {
		spoiler: '.spoiler',
		wrapper: '.spoiler__wrapper'
	},
	init: function() {
		this.wrappers = document.querySelectorAll(this.names.wrapper);
		if (this.wrappers.length == 0) return;
		this.calcHeight();
		let that = this;
		window.addEventListener('load', () => {
			for (let i = 0; i < that.wrappers.length; i++) {
				that.wrappers[i].closest(that.names.spoiler).children[0].addEventListener('click', that.toggle.bind(that));
			}
			that.calcHeight(); // calc in case fonts are not loaded yet, so the height might be wrong
			window.addEventListener('resize', that.calcHeight.bind(that));
		})
	},
	calcHeight: function() {
		let changes = false;
		for (let i = 0; i < this.wrappers.length; i++) {
			let newMaxHeight = this.wrappers[i].children[0].offsetHeight;
			if (newMaxHeight != this.wrappers[i].itemMaxHeight)
				changes = true;
			this.wrappers[i].itemMaxHeight = newMaxHeight;
		};
		if (changes) this.setHeight();
	},
	setHeight() {
		for (let i = 0; i < this.wrappers.length; i++) {
			if (this.wrappers[i].closest(this.names.spoiler).classList.contains('_visible'))
				this.wrappers[i].style.height = this.wrappers[i].itemMaxHeight + 'px';
			else
				this.wrappers[i].style.height = '';
		}
	},
	toggle: function(e) {
		e.currentTarget.parentElement.classList.toggle('_visible');
		this.setHeight();
	}
}
spoiler.init();

//////////////////////////////////////////////
