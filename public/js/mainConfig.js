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

$(document).ready(function() {
	'use stricts';	
})
