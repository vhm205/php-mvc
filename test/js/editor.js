document.addEventListener('DOMContentLoaded', function(){
	ClassicEditor
	.create( document.querySelector( '#editor' ),{
		cloudServices: {
            tokenUrl: 'https://69605.cke-cs.com/token/dev/KNvYXOd3qBr5Gz1W5lXelj6K9EAKhd93kZPgQUBJlMrRfLiOdoyFhlY12fmx',
            uploadUrl: 'https://69605.cke-cs.com/easyimage/upload/'
		},
		ckfinder: {
            // Upload the images to the server using the CKFinder QuickUpload command.
            uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json',

            // Define the CKFinder configuration (if necessary).
            options: {
                resourceType: 'Images'
            }
        },
		toolbar: {
			items: [
				'heading',
				'|',
				'bold',
				'italic',
				'link',
				'bulletedList',
				'numberedList',
				'|',
				'indent',
				'outdent',
				'|',
				'CKFinder',
				'imageUpload',
				'blockQuote',
				'insertTable',
				'mediaEmbed',
				'undo',
				'redo'
			]
		},
		language: 'en',
		image: {
			toolbar: [
				'imageTextAlternative',
				'imageStyle:full',
				'imageStyle:side'
			]
		},
		table: {
			contentToolbar: [
				'tableColumn',
				'tableRow',
				'mergeTableCells'
			]
		},
	})
	.catch( error => {
		console.error( error );
	} )
})