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

	$('.cell').click(function moveTo() {


		var x = Math.abs($('.ship').position().left - $(this).position().left);
		var y = Math.abs($('.ship').position().top - $(this).position().top);


		console.log(x + y);
		$('.ship').animate({ top: (-1000) + ($(this).attr('y') * 10), left: ($(this).attr('x') * 10)}, Math.abs(x + y) * 4);
	});


});
