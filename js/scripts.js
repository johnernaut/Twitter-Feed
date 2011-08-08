var singleFeature = function() {
	
	var popUl = $("#popular");
	
	return {
		
		getItems : function(src, username, num) {
			if(src) $.post(src, { username : username, num : num }, this.switchFeature);
			else throw new Error('No src passed.');
		},
		
		switchFeature : function(results) {
			if(!results) return;
			
			popUl
				.append(results)
				.children('li:not(:first)')
				.hide();
				
			setInterval(function() {
				popUl.children('li:visible').fadeOut(200, function() {
					$(this).index() === $(this).parent().children().length - 1
					? $(this).parent().children("li").eq(0).fadeIn(100)
					: $(this).next().fadeIn(100);
				});
			}, 2000);
		}
		
	}
	
}();