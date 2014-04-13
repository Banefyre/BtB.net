$(document).ready(function(){

 $('.faction').click(function ()
	{
		$.ajax({
				url : 'game.php',
				method : 'POST',
				data : { faction : $(this).attr('id')},
				success : function () {
					$('#faction').hide();
					$('#content').load('grid.php');
				}
			});
	});

	$('#end_turn').click(function ()
	{
		console.log("clikc");
		$.ajax({
				url : 'changeturn.php',
				method : 'POST',
				data : { changeturn : "changeturn"},
				success : function () {
				}
			});
	});


});
