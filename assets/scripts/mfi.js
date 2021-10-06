$(function(){

	/* [BEGIN] CHANGE THEMES *******************************************/
	
	$("ul.inline li","div.color-mode").click(function(){
		themes = $(this).attr('data-style');
		$.ajax({
			type: "POST",
			url: site_url+"administration/change_themes",
			data: {themes:themes},
			dataType: "json",
			success: function(response){

			}
		})
	})

	/* [END] CHANGE THEMES *******************************************/

})