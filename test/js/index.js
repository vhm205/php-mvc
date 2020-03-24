document.addEventListener('DOMContentLoaded', function(){

	const menu 	   = document.querySelector('.menu-icon'),
		  menuOpen = document.querySelector('.menu-open'),
		  page	   = document.querySelector('.page');

	menu.addEventListener('click', function(){
		this.classList.toggle('active')
	})

	menuOpen.addEventListener('click', function(){
		page.classList.toggle('active')
	})

	$('.menu ul li').on('click', function(e){
		e.stopPropagation()
		$(this).children('ul').toggleClass('active')
	})
})