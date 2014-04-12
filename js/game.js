$(document).ready(function(){

 $('.faction').click(function ()
	{
		$.ajax({
				url : 'game.php',
				method : 'POST',
				data : { faction : $(this).attr('id')},
				success : function (res) {
					$('#faction').hide();
					$('#content').load('grid.php');
					console.log(res);
				}
			});
	});


});
