$(document).ready(function(){
	'use stricts';

	let frmData = null
	let userId  = $('#userId').val()
	let newInfo = Object.create(null)
	let infoOrigin = {
		fullname: $("#fullname").val(),
		phone: 	  $("#phone").val(),
		gender:   $("input[type=radio]:checked").val(),
		avatar:   $(".avatar-preview").attr('src')
	}

	function resetAll() {
		$("#fullname").val(infoOrigin.fullname)
		$("#phone").val(infoOrigin.phone)
		$(`input[value=${infoOrigin.gender}]`).attr('checked', true)
		$(".avatar-preview").attr('src', infoOrigin.avatar)
		$(this).find('.is-invalid').removeClass('is-invalid')
		newInfo = Object.create(null)
	}

	function callUpdateAvatar() {
		// Don't remove avatar_default.png
		const filename = infoOrigin.avatar.split('/')[3];
		if(filename !== 'avatar_default.png'){
			frmData.append('old-avatar', infoOrigin.avatar);
		}

		$.ajax({
			type: "post",
			url: `./Request/UpdateAvatar/${userId}`,
			data: frmData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json'
		}).done(res => {
			// Toast a message
			toast('success', res.message);

			const newDirAvatar = `./public/images/${res.filename}`;
			// Update avatar on navbar
			$('#avatar-navbar').attr('src', newDirAvatar)

			// Reset infoOrigin, get update new value
			infoOrigin = {
				...infoOrigin,
				avatar: newDirAvatar
			}
		}).fail(err => {
			if(err.status === 500){
				toast('error', err.statusText);
			}

			if('responseJSON' in err){
				// Toast a message
				if('message' in err.responseJSON){
					toast('error', err.responseJSON['message'])
				}

				if('errors' in err.responseJSON){
					let errors = '';
					err.responseJSON['errors'].map(error => {
						errors += `${error}\n`
					})

					toast('warning', errors, 5000);
				}
			}
		}).always(() => {
			delete newInfo.avatar;
		})
	}

	function callUpdateProfile() {  
		$.ajax({
			type: "post",
			url: `./Request/UpdateProfile/${userId}`,
			data: newInfo,
			dataType: 'json',
			statusCode: {
				404: function() { }
			}
		}).done(res => {
			// Toast a message
			toast('success', res.message);
			$(this).find('.is-invalid').removeClass('is-invalid');

			// Update fullname on navbar
			if('fullname' in newInfo){
				$('#fullname-navbar').text(newInfo.fullname)
			}

			// Reset infoOrigin, get update new value
			infoOrigin = {
				...infoOrigin,
				fullname: $("#fullname").val(),
				phone: 	  $("#phone").val(),
				gender:   $("input[name=gender]:checked").val()
			}
		}).fail(err => {
			// Toast a message
			toast('error', err.responseJSON['message']);

			if('errors' in err.responseJSON){

				// Show validate message for Phone Number
				if('PHONE' in err.responseJSON['errors']){
					$('#phone').addClass('is-invalid').next().text(err.responseJSON['errors'].PHONE);
				}

				// Show validate message for Full Name
				if('FULLNAME' in err.responseJSON['errors']){
					$('#fullname').addClass('is-invalid').next().text(err.responseJSON['errors'].FULLNAME);
				}
				
			}
		})
	}
	
	$(".custom-file-input").on("change", function() {
		const fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);

		const filedata = $(this).prop('files')[0]
		const limit = 1048576;
		const allowtypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
		
		// Check file type
		if(!allowtypes.includes(filedata.type)){
			toast('warning', 'Invalid file format');
			$(this).val(null)
			return;
		}
		// Check Size of image
		if(filedata.size > limit){
			toast('warning', 'Size is too large');
			$(this).val(null)
			return;
		}
		// Check Browser support FileReader
		if(typeof FileReader === undefined){
			toast('warning', 'Your browser is not support FileReader');
			$(this).val(null)
			return;
		}

		// Use FileReader to preview avatar
		const fileReader = new FileReader()
		fileReader.onload = function(el){
			let src = el.target.result
			$('.avatar-preview').attr('src', src);
			newInfo.avatar = src
		}
		fileReader.readAsDataURL(filedata)

		// Add filedata into FormData to update
		frmData = new FormData()
		frmData.append('avatar', filedata)
	});

	$('#btn-cancel').click(resetAll)

	$('#fullname').on('change', function(){
		let fullname = $(this).val()
		if(fullname !== infoOrigin.fullname && fullname){
			newInfo.fullname = fullname
			return;
		}

		delete newInfo.fullname
	})

	$('#phone').on('change', function(){
		let phone = $(this).val()
		if(phone !== infoOrigin.phone && phone){
			newInfo.phone = phone
			return;
		}

		delete newInfo.phone
	})

	$("input[name=gender]").on('change', function(){
		let gender = $(this).val()
		if(gender !== infoOrigin.gender && gender){
			newInfo.gender = gender
			return;
		}

		delete newInfo.gender
	})

	// Submit Update Profile 
	$("form[name='frmUpdateProfile'").submit(function(e){
		e.preventDefault()

		const len = Object.keys(newInfo).length

		if(len > 0){
			if('avatar' in newInfo){
				callUpdateAvatar();
			}

			if((('avatar' in newInfo) && len > 1) || !('avatar' in newInfo)){
				callUpdateProfile();
			}
		}
	})

})
