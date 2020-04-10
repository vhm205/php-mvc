function toast(type, title, time = 3000, showProgress = false) {
	Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: time,
		timerProgressBar: showProgress,
		onOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	}).fire({
		icon: type,
		title: title
	})
}

function toSlug(str)
{
	// Chuyển hết sang chữ thường
	str = str.toLowerCase();

	// xóa dấu
	str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
	str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
	str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
	str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
	str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
	str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
	str = str.replace(/(đ)/g, 'd');

	// Xóa ký tự đặc biệt
	str = str.replace(/([^0-9a-z-\s])/g, '');

	// Xóa khoảng trắng thay bằng ký tự -
	str = str.replace(/(\s+)/g, '-');

	// xóa phần dự - ở đầu
	str = str.replace(/^-+/g, '');

	// xóa phần dư - ở cuối
	str = str.replace(/-+$/g, '');

	// return
	return str;
}

function checkBrowser(browser) {
	// https://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser
	switch (browser) {
		case 'chrome':
			// Chrome 1 - 79
			return !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
		case 'firefox':
			// Firefox 1.0+
			return typeof InstallTrigger !== 'undefined';
		case 'opera':
			// Opera 8.0+
			return (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
		case 'safari':
			// Safari 3.0+ "[object HTMLElementConstructor]" 
			return /constructor/i.test(window.HTMLElement) || (p => { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
		case 'ie':
			// Internet Explorer 6-11
			return /*@cc_on!@*/false || !!document.documentMode;
		case 'edge':
			// Edge 20+
			return !isIE && !!window.StyleMedia;
		case 'edge-chromium':
			// Edge (based on chromium) detection
			return isChrome && (navigator.userAgent.indexOf("Edg") != -1);
		case 'blink':
			// Blink engine detection
			return (isChrome || isOpera) && !!window.CSS;
		default:
			break;
	}
}

$(document).ready(function() {
	'use stricts';


})
