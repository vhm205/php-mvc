<?php 
	class Message
	{
		static $validErrors = [
			'password_confirm_not_match' => 'Mật khẩu không trùng khớp',
			'password_least_chars' => 'Mật khẩu phải có ít nhất 6 ký tự',
			'password_wrong' => 'Mật khẩu không chính xác',
			'email_invalid' => 'Email không hợp lệ',
			'email_existed' => 'Email này đã được đăng ký',
			'email_not_exists' => 'Email không tồn tại',
			'email_not_active' => 'Tài khoản này chưa được kích hoạt, Vui lòng kiểm tra email để kích hoạt tài khoản',
			'input_required' => 'Bạn cần nhập đầy đủ tất cả các trường!',
			'error_server' => 'Lỗi server! vui lòng liên hệ admin: <b>vuhuynhminh9221@gmail.com</b> để được hỗ trợ',
			'gender_wrong' => 'Giới tính của bạn thật độc đáo',
			'phone_invalid' => 'Số điện thoại giới hạn từ 10 - 11 ký tự và bắt đầu bằng số 0',
			'fullname_too_long' => 'Tên người dùng giới hạn 3 - 30 ký tự',
			'file_too_large' => 'Ảnh có kích thước tối đa 1MB',
			'invalid_file_type' => 'Ảnh không đúng định dạng'
		];

		static $transSuccess = [
			'register_success' => 'Đăng ký tài khoản thành công, Vui lòng kiểm tra email để kích hoạt tài khoản',
			'login_success' => 'Đăng nhập tài khoản thành công',
			'active_success' => 'Tài khoản đã được kích hoạt, bạn có thể đăng nhập ngay bây giờ',
			'send_mail_reset' => 'Gửi email thành công, vui lòng kiểm tra email để reset mật khẩu',
			'reset_pass_success' => 'Reset mật khẩu thành công! bạn đã có thể  đăng nhập bằng mật khẩu mới',
			'update_profile' => 'Cập nhật profile thành công',
			'upload_avatar_success' => 'Cập nhật ảnh đại diện thành công'
		];

		static $transErrors = [
			'register_failed' => 'Đăng ký tài khoản thất bại, vui lòng liên hệ với admin để nhận hỗ trợ. email: vuhuynhminh9221@gmail.com',
			'login_failed' => 'Đăng nhập tài khoản thất bại',
			'token_expired' => 'Token đã hết hạn sử dụng',
			'update_profile' => 'Cập nhật profile thất bại',
			'upload_avatar_failed' => 'Cập nhật ảnh đại diện thất bại'
		];

		static $transSendMail = [
			'send_failed' => 'Có lỗi trong quá trình gửi mail vui lòng liên hệ admin: <b>vuhuynhminh9221@gmail.com</b> để được hỗ trợ'
		];

		/// Blog Validation
		static $validErrorsBlog = [
			'too_long' => 'Giới hạn từ 2 - 30 ký tự',
			'tag_exists' => 'Tag name đã tồn tại',
			'category_exists' => 'Category name đã tồn tại',
			'tag_null' => 'Bạn cần nhập tên tag',
			'category_null' => 'Bạn cần nhập đầy đủ các trường',
			'add_tag_failed' => 'Thêm tag thất bại',
			'add_category_failed' => 'Thêm category thất bại',
			'parent_id_wrong' => 'Parent category không hợp lệ',
			'slug_empty' => 'Slug rỗng ~~',
			'content_empty' => 'Nội dung rỗng ~~',
			'title_incorrect' => 'Tiêu đề  không được trống và tối đa 70 ký tự',
		];

		static $validSuccessBlog = [
			'add_tag' => 'Thêm tag thành công',
			'add_category' => 'Thêm category thành công',
			'add_post' => 'Thêm post thành công',
		];
	}	
?>
