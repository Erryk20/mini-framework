$( document ).ready(function() {
	const $menu = $('.dropdown');
	
	$menu.tendina({
		animate: true,
		speed: 500,
		onHover: false,
		hoverDelay: 300,
		activeMenu: $('#deepest')
	});
	
	if(typeof itemsInfo === 'object'){
		Content.init(itemsInfo).run();
	}
	
	
	$(".dropdown li a").not($('.dropdown li a + ul').siblings('a')).on(
		"click",
		function (e) {
			if (location.pathname !== '/category') return true;
			
			e.preventDefault();
			const $menuItem = $(e.target);
			
			$menuItem.closest('li').attr({id:'deepest'});
			$menu.find('li#deepest').removeAttr('id');
			
			Content.init($menuItem.data()).run();
		}
	);
	
	$('#sort select').on('change', function(e) {
		const $block = $(e.target);
		let sortByField = $block.val();
		
		Content.doSorting(sortByField);
	});
	
	
	$('#productModal').on('show.bs.modal', function (event) {
		var $button = $(event.relatedTarget);
		
		
		$.ajax({
			type     : "POST",
			dataType : 'json',
			async    : false,
			url      : $button.data('url'),
			success  : function(response) {
				let HtmlItem =  response.template;
				
				for (var key in response.item) {
					HtmlItem = HtmlItem.split('{' + key + '}').join(response.item[key]);
				}
				
				$('.modal-body tbody').html(HtmlItem);
			},
			error    : function(error) {
				throw Error(error.responseText);
			},
		});
	})
});



