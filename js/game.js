
var i = 0;
var turn = true;
$(document).ready(function(){

setInterval(function (){
	i += 5;
		$.ajax({
			url : 'status.php',
				method: 'POST',
				data : { update : 'update' },
				success : function(res) {
					res = res.trim();
					if (res == "waiting")
						$('#game_status').text("Waiting for player to connect since " + i + " seconds");
					else if (res == "my_turn")
					{
						//alert(res);
						$('#game_status').text("It\'s your turn !");
						if (turn == false)
							updategrid();
					}
					else if (res == "finished")
					{
						$('#game_status').text("The other player disconnected, you won !");
						setTimeout(function() {
							window.location.replace("disconnect.php");
						}, 5000);
					}
					else if (turn == false)
					{
						$('#game_status').text("It\'s "+res+" turn, wait a min :)");
					}
				}
		});

}, 1000);

 $('.faction').click(function ()
	{
		turn = false;
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


	$('.cell').click(function moveTo() {
		var x = Math.abs($('.ship').position().left - $(this).position().left);
		var y = Math.abs($('.ship').position().top - $(this).position().top);
		$('.ship').animate({ top: ($(this).attr('y') * 10), left: ($(this).attr('x') * 10)}, Math.abs(x + y) * 4);
	});

	function updategrid()
	{
		turn = true;
		$('#grid').empty();
		$('#content').load('grid.php');
	}
});


	function switchTurn()
		{
		if (turn == true)
		{
			turn = false;
		$.ajax({
				url : 'changeturn.php',
				method : 'POST',
				data : { changeturn : "changeturn"}
		});
		}
	}
