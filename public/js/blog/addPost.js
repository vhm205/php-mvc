$(document).ready(function () {
	$('.btn-public-post').on('click', function(e){
		e.preventDefault()
		
		const icon = $(this).children('.icon')
		icon.html(`<i class="spinner-border spinner-border-sm"></i>`)
		$(this).addClass('disabled')

		setTimeout(() => {
			icon.html(`<i class="fas fa-flag"></i>`)
			$(this).removeClass('disabled')
		}, 2000)
	})

	$('.post-config').on('click', function(e) {
		e.preventDefault()
		$('.post-toolbar').toggleClass('active')
	})

	$('#btn-add-categories').on('click', function(e) {
		$('.contain-categories').html($('#post-categories').val().join(', '))
	})
});