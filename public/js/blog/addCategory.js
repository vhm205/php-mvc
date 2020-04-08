function bindingSlugValue() {
	$('.edit-name-category').off('input').on('input', function(e){
		$(this).parent().next().find('.edit-slug-category').val(toSlug(this.value))
	})
}

function updateCategory() {
	$('.btn-update-category').off('click').on('click', function(e){
		const uid = $(this).data('uid')
		const category = $(`.list-categories li[data-uid=${uid}]`)
		const newName = category.find('.edit-name-category').val()
		const newSlug = category.find('.edit-slug-category').val()
		const oldName = category.find('a > h6')

		if(oldName.text().trim() === newName.trim()) return;

		if(!newName || !newSlug){
			toast('warning', 'You need enter full fields', 3000);
			return;
		}

		$.post("./Blog/updateCategory", {
			id: uid,
			name: newName,
			slug: newSlug
		}, (_, textStatus) => {
				if(textStatus === 'success'){
					toast('success', 'Update category successful', 2000);
					oldName.text(newName);
				}
			}
		);
	})
}

function deleteCategory() {
	$('.btn-delete-category').off('click').on('click', function(e){
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then(result => {
			if (result.value) {
				const uid = $(this).data('uid')
				$.get(`./Blog/deleteCategory/${uid}`, function (_, textStatus) {
					if(textStatus === 'success'){
						$(`.list-categories li[data-uid=${uid}]`).remove()
						$(`#post-parent-category option[value=${uid}]`).remove()
					}
				});
			}
		})
	})
}

function updateDetailCategory() {
	$('.link-edit-category').off('click').on('click', function(e){
		e.preventDefault()

		const uid = $(this).data('uid')
		const category = $(`.list-categories li[data-uid=${uid}]`)
		const nameCategory = category.find('.edit-name-category').val()
		const slugCategory = category.find('.edit-slug-category').val()
		const parentId = +category.find('a > span').text().trim()

		$('#categoryModal').find('#btn-update-detail-category').data('uid', uid)
		$('#categoryModal').find('#input-update-name-category').val(nameCategory)
		$('#categoryModal').find('#input-update-slug-category').val(slugCategory)
		$('#categoryModal').find(`#input-update-parent-category option[value=${parentId}]`).prop('selected', true)
	})
}

$(document).ready(function () {
	deleteCategory();
	updateCategory();
	updateDetailCategory();
	bindingSlugValue();

	$('#post-category').on('input', function(e){
		$('#post-slug-category').val(toSlug(this.value))
	})
	$('#input-update-name-category').on('input', function(e){
		$('#input-update-slug-category').val(toSlug(this.value))
	})

	$('#btn-update-detail-category').on('click', function(e){
		const uid = $(this).data('uid');
		const category = $(`.list-categories li[data-uid=${uid}]`);
		const newName = $('#input-update-name-category').val().trim();
		const newSlug = $('#input-update-slug-category').val().trim();
		const newParentId = +$('#input-update-parent-category').val();
		const oldParentId = +category.find('a > span').text().trim();
		const oldName = category.find('a > h6');

		if(newName === oldName.text().trim() && newParentId === oldParentId) return;

		if(!newName || !newSlug){
			toast('warning', 'You need enter full fields', 3000);
			return;
		}

		$.post("./Blog/updateDetailCategory", {
			id: uid,
			name: newName,
			slug: newSlug,
			parent_id: newParentId
		}, (_, textStatus) => {
				if(textStatus === 'success'){
					$('#categoryModal').modal('hide');
					toast('success', 'Update category successful', 2000);
					category.find('.edit-name-category').attr('value',newName)
					category.find('.edit-slug-category').attr('value',newSlug)
					oldName.text(newName);

					const htmlInfo = category.get(0);
					$(htmlInfo).find('a > span').text(newParentId);

					const htmlCategory = `<ul class="card shadow mb-1">${htmlInfo.outerHTML}</ul`;
					if(newParentId === 0){
						$(htmlCategory).appendTo('.list-categories');
					} else{
						$(htmlCategory).appendTo(`.list-categories li[data-uid=${newParentId}]`);
					}
					deleteCategory();
					updateCategory();
					updateDetailCategory();
					bindingSlugValue();
					category.parent().remove();
				}
			}
		);
	})

	$('#btn-add-categories').on('click', function(e){
		const name = $('#post-category').val();
		const slug = toSlug($('#post-slug-category').val());
		const parentCategory = $('#post-parent-category').val();

		if(!name || !slug){
			toast('warning', 'You need enter full fields', 3000);
			return;
		}

		$.ajax({
			type: "post",
			url: "./Blog/addNewCategory",
			data: {
				name: name,
				slug: slug,
				parent_id: parentCategory
			},
			dataType: "json"
		}).done(res => {
			toast('success', res.message)
			if(+parentCategory === 0){
				$('.list-categories').append(res.content);
				$('#post-parent-category').append(res.option);
			} else{
				$(`.list-categories li[data-uid=${parentCategory}]`).append(res.content);
				$(`#post-parent-category option[value=${parentCategory}]`).after(res.option);
			}
			deleteCategory();
			updateCategory();
			updateDetailCategory();
			bindingSlugValue();
		})
		.fail(error => {
			$('#post-category').focus();
			toast('error', error.responseJSON['errors'][0]);
		})
		.always(() => {
			$('#post-category').val('');
			$('#post-slug-category').val('');
			$('#post-parent-category').val(0);
		})
	})
});
