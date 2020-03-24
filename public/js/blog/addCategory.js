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

function updateCategory() {
	$('.btn-update-category').off('click').on('click', function(e){
		const uid = $(this).data('uid')
		const category = $(`.list-categories li[data-uid=${uid}]`)
		const newName = category.find('.edit-name-category').val()
		const newSlug = category.find('.edit-slug-category').val()

		if(!newName || !newSlug){
			toast('warning', 'You need enter full fields', 3000);
			return;
		}

		console.log(newName, newSlug)
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

$(document).ready(function () {
	updateCategory();
	deleteCategory();

	$('#post-category').on('input', function(e){
		$('#post-slug-category').val(toSlug(this.value))
	})

	$('#btn-add-categories').on('click', function(e){
		const name = $('#post-category').val()
		const slug = toSlug($('#post-slug-category').val())
		const parentCategory = $('#post-parent-category').val()

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
		})
		.done(res => {
			toast('success', res.message)
			if(+parentCategory === 0){
				$('.list-categories').append(res.content)
				$('#post-parent-category').append(res.option)
			} else{
				$(`.list-categories li[data-uid=${parentCategory}]`).append(res.content)
				$(`#post-parent-category option[value=${parentCategory}]`).after(res.option)
			}
			updateCategory();
			deleteCategory();
		})
		.fail(error => {
			$('#post-category').focus();
			toast('error', error.responseJSON['errors'][0]);
		})
		.always(() => {
			$('#post-category').val('')
			$('#post-slug-category').val('')
			$('#post-parent-category').val(0)
		})
	})
});
