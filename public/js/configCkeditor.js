let editor;

$(document).ready(function () {

	if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
		CKEDITOR.tools.enableHtml5Elements( document );

	// The trick to keep the editor in the sample quite small
	// unless user specified own height.
	CKEDITOR.config.height = 300;
	CKEDITOR.config.width = 'auto';

	( function() {
		var wysiwygareaAvailable = isWysiwygareaAvailable(),
			isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

		return function() {
			var editorElement = CKEDITOR.document.getById( 'editor' );

			// :(((
			if ( isBBCodeBuiltIn ) {
				editorElement.setHtml(
					'Hello world!\n\n' +
					'I\'m an instance of [url=https://ckeditor.com]CKEditor[/url].'
				);
			}

			// Depending on the wysiwygarea plugin availability initialize classic or inline editor.
			if ( wysiwygareaAvailable ) {
				editor = CKEDITOR.replace( 'editor' );
			} else {
				editorElement.setAttribute( 'contenteditable', 'true' );
				editor = CKEDITOR.inline( 'editor' );

				// TODO we can consider displaying some info box that
				// without wysiwygarea the classic editor may not work.
			}
		};

		function isWysiwygareaAvailable() {
			// If in development mode, then the wysiwygarea must be available.
			// Split REV into two strings so builder does not replace it :D.
			if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
				return true;
			}

			return !!CKEDITOR.plugins.get( 'wysiwygarea' );
		}
	} )()();

	editor.on('change', evt => {
		console.log(evt.editor.getData());
	})

	// ClassicEditor
	// .create( document.querySelector( '#editor' ),{
	// 	cloudServices: {
	// 		tokenUrl: 'https://69605.cke-cs.com/token/dev/KNvYXOd3qBr5Gz1W5lXelj6K9EAKhd93kZPgQUBJlMrRfLiOdoyFhlY12fmx',
	// 		uploadUrl: 'https://69605.cke-cs.com/easyimage/upload/'
	// 	},
	// 	ckfinder: {
	// 		// Upload the images to the server using the CKFinder QuickUpload command.
	// 		uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json',

	// 		// Define the CKFinder configuration (if necessary).
	// 		options: {
	// 				resourceType: 'Images'
	// 		}
	// 	},
	// 	toolbar: {
	// 		items: [
	// 			'heading',
	// 			'|',
	// 			'bold',
	// 			'italic',
	// 			'link',
	// 			'bulletedList',
	// 			'numberedList',
	// 			'|',
	// 			'indent',
	// 			'outdent',
	// 			'|',
	// 			'CKFinder',
	// 			'imageUpload',
	// 			'blockQuote',
	// 			'insertTable',
	// 			'mediaEmbed',
	// 			'undo',
	// 			'redo'
	// 		]
	// 	},
	// 	language: 'en',
	// 	image: {
	// 		toolbar: [
	// 			'imageTextAlternative',
	// 			'imageStyle:full',
	// 			'imageStyle:side'
	// 		]
	// 	},
	// 	table: {
	// 		contentToolbar: [
	// 			'tableColumn',
	// 			'tableRow',
	// 			'mergeTableCells'
	// 		]
	// 	},
	// }).then(newEditor => {
	// 	editor = newEditor
	// }).catch( error => {
	// 	console.error( error );
	// })
});