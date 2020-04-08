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
		const content = editor.getData() || ''
		const slug = $('#post-slug').val().trim()
		const tags = $('#post-tag').val().replace(' ', '').split(',')

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
			data: { title, content, slug, tags, categories },
			dataType: "json"
		}).done(res => {
			console.log(res);

			
		}).fail(err => {
			const errStr = err?.responseJSON['errors'].join('\n');
			toast('error', errStr, 7000);
		}).always(() => {
			icon.html(`<i class="fas fa-flag"></i>`)
			$(this).removeClass('disabled')
		})
	})
});
