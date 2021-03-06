$(document).ready(function () {
	$('.post-config').on('click', function(e) {
		e.preventDefault()
		$('.post-toolbar').toggleClass('active')
	})

	$('#btn-add-categories').on('click', function(e) {
		const categoriesId = $('#post-categories').val()
		const categoriesArr = categoriesId.map(id => $(`#post-categories option[value=${id}]`).text().replace('+', '').trim())

		$('.contain-categories').html(categoriesArr.join(', ')).data('ids', categoriesId)
	})

	$('#post-title').on('input', function(e){
		$('#post-slug').val(toSlug($(this).val()))
	})

	$('.btn-public-post').on('click', function(e){
		e.preventDefault()
		
		const categories = $('.contain-categories').data('ids')
		const title = $('#post-title').val().trim()
		const content = CKEDITOR.instances.editor.getData()
		const slug = $('#post-slug').val().trim()
		const tags = $('#post-tag').val().split(',')

		if(!title || !slug || !content){
			toast('warning', 'You need enter title, slug, content post')
			return;
		}

		const icon = $(this).children('.icon')
		icon.html(`<i class="spinner-border spinner-border-sm"></i>`)
		$(this).addClass('disabled')

		$.ajax({
			type: "post",
			url: "./Blog/addNewPost",
			dataType: "json",
			data: { title, content, slug, tags, categories }
		}).done(res => {
			toast('success', res.message, 3000)
			setTimeout(() => location.reload(), 4000);
		}).fail(err => {
			const errStr = err.responseJSON['errors'].join('\n');
			toast('error', errStr, 7000);
		}).always(() => {
			icon.html(`<i class="fas fa-flag"></i>`)
			$(this).removeClass('disabled')
		})
	})

	window.onbeforeunload = function (e) {
		e = e || window.event;
		// For IE and Firefox prior to version 4
		if (e) {
			e.returnValue = 'Sure?';
		}
		// For Safari
		return 'Sure?';
	};
});
