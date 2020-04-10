function setPropChecked(element, val){
	element.prop('checked', val)
}

function checkAllTag(listCheckBox, inputCheckAll) {
	inputCheckAll.off('change').on('change', function(){
		setPropChecked(listCheckBox, this.checked)
	})
}

function checkChangeTag(listCheckBox, inputCheckAll) {
	listCheckBox.off('change').on('change', function () {
		const ckArray = [...listCheckBox];
		const allChecked = ckArray.every(el => $(el).prop('checked'))
		
		allChecked ? setPropChecked(inputCheckAll, true) : setPropChecked(inputCheckAll, false)
	})
}

function updateTagName(uid) {
	$('.input-edit-name').off('keypress').on('keypress', function(e){
		if(e.originalEvent.which === 13){
			const newName = $(`input[type="checkbox"][value="${uid}"]`).parent().next()
			
			if(!newName.val() || newName.val().length >= 30) return;
			
			$.post("./Blog/updateTag", { id: uid, name: newName.val() }).always(() => {
				newName.addClass('d-none').removeClass('d-inline-block')
				newName.next().removeClass('d-none')
				newName.next().text(newName.val())

				$(this).html(`<i class="fas fa-pencil-alt mr-1"></i>Edit`)
			});
		}	
	}.bind(this))
}

function editTag() {
	$('.edit-tag').off('click').on('click', function(e){
		e.preventDefault()

		const uid = $(this).data('uid')
		const btnEditText = $(this).text().trim()
		const cbTag = $(`input[type="checkbox"][value="${uid}"]`).parent().next()

		if(btnEditText === 'Edit'){
			cbTag.removeClass('d-none').addClass('d-inline-block').focus()
			cbTag.next().addClass('d-none')
			updateTagName.call(this, uid)

			$(this).html(`<i class="fas fa-ban mr-1"></i>Cancel`)
			return;
		}
		
		if(btnEditText === 'Cancel'){
			cbTag.addClass('d-none').removeClass('d-inline-block')
			cbTag.next().removeClass('d-none')
			cbTag.val(cbTag.next().text().trim())

			$(this).html(`<i class="fas fa-pencil-alt mr-1"></i>Edit`)
			return;
		}

	})
}

function deleteTag() {
	$('.delete-tag').off('click').on('click', function(e){
		e.preventDefault()

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
				$.get(`./Blog/deleteTag/${uid}`, function (_, textStatus) {
						if(textStatus === 'success'){
							$(`.list-tags li[data-uid="${uid}"]`).remove()
						}
					}
				);
			}
		})
	})
}

function deleteTagByCheck() {
	$('#btn-delete-tag-checked').off('click').on('click', function(e){
		const listChecked = $('.list-tags li input[type="checkbox"]:checked')

		if(!listChecked.length){
			toast('warning', 'No tags have been selected', 3000);
			return;
		}

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
				const arrId = [...listChecked].map(el => el.value)
				$.post("./Blog/deleteManyTag", { arrId }, function (_, textStatus){
					if(textStatus === 'success'){
						arrId.map(uid => $(`.list-tags li[data-uid=${uid}]`).remove())
					}
				}
			);
			}
		})
	})
}

$(document).ready(function () {
	const inputCheckAll = $('#input-check-all-tag')
	const listCheckBox = $('.list-tags input[type="checkbox"]')

	checkAllTag(listCheckBox, inputCheckAll)
	checkChangeTag(listCheckBox, inputCheckAll)
	editTag()
	deleteTag()
	deleteTagByCheck()

	$('#btn-add-tag').on('click', function(e){
		const name = $('#post-tag').val();
		if(!name){
			toast('warning', 'You need enter full fields', 3000);
			return;
		}

		$.ajax({
			type: "post",
			url: "./Blog/AddNewTag",
			data: { name },
			dataType: "json"
		}).done(res => {
			toast('success', res.message)

			let inputCheckAll = $('#input-check-all-tag')
			let listCheckBox = $('.list-tags input[type="checkbox"]')

			$('.list-tags').append(res.content)
			checkAllTag(listCheckBox, inputCheckAll)
			checkChangeTag(listCheckBox, inputCheckAll)
			editTag()
			deleteTag()
			deleteTagByCheck()

		}).fail(err => {
			$('#post-tag').focus();
			toast('error', err.responseJSON['errors'][0])
		}).always(() => $('#post-tag').val(''))
	})
});
