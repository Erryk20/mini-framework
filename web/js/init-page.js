$( document ).ready(function() {
	const $menu = $('.dropdown');
	
	$menu.tendina({
		animate: true,
		speed: 500,
		onHover: false,
		hoverDelay: 300,
		activeMenu: $('#deepest')
	});
	
	
	$(".dropdown li a").not($('.dropdown li a + ul').siblings('a')).on(
		"click",
		function (e) {
			e.preventDefault();
			const $block = $(e.target);
			$menu.find('li#deepest').removeAttr('id');
			$block.closest('li').attr({id:'deepest'});
			
			Content.run({
				url : $block.attr('href'),
				targetBlock : '.list-products'
			});
			
		}
	);
});



