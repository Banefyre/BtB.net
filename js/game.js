
var i = 0;
var turn = true;
$(document).ready(function(){

setInterval(function (){
	i++;
		$.ajax({
			url : 'status.php',
				method: 'POST',
				data : { update : 'update' },
				success : function(res) {
					res = res.trim();
					console.log(res);
					if (res == "waiting")
						$('#game_status').text("Waiting for player to connect since " + i + " seconds");
					else if (res == "my_turn" && turn == false)
					{
						//alert(res);
						turn = true;
						$('#game_status').text("It\'s your turn !");
						//updategrid();
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
		console.log(21);
		turn = false;
		$.ajax({
				url : 'game.php',
				method : 'POST',
				data : { faction : $(this).attr('id')},
				success : function () {
					$('#faction').hide();
					$('#content').load('grid.php');
					console.log(42);
				}
			});
	});


	$('.cell').click(function moveTo() {
		var x = Math.abs($('.ship').position().left - $(this).position().left);
		var y = Math.abs($('.ship').position().top - $(this).position().top);
		$('.ship').animate({ top: (-1000) + ($(this).attr('y') * 10), left: ($(this).attr('x') * 10)}, Math.abs(x + y) * 4);
	});

	function updategrid()
	{
		//remove all grid child
		//load grid
	}



});


	function switchTurn()
		{
			console.log("turn: " + turn);
		if (turn == true)
		{
			turn = false;
			console.log(1);
		$.ajax({
				url : 'changeturn.php',
				method : 'POST',
				data : { changeturn : "changeturn"}
		});
		}
	}
