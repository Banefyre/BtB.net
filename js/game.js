var i = 0;
var turn = true;

function button_activate()
{
	console.log('activate');
	$('#form_activate').fadeOut('slow', function() { $('#form_pp').fadeIn('slow'); });
}
$(document).ready(function(){
	if ($('#faction').attr('game') === 'true')
	{
		$('#disconnect').hide();
		$('#choose').hide();
		$('#faction').hide();
		$('#box').width((8 + 2) * 150 + 350);
		$('#box').height((8 + 2) * 100);
		$('#content').show();
	}
	else
		$('#faction').fadeIn();

	setInterval(function() {
		i += 5;
		$.ajax({
			url : 'status.php',
				method: 'POST',
				data : { update : 'update' },
				success : function(res) {
					res = res.trim();
					console.log(res);
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

	$('#faction img.true').click(function ()
	{
		turn = false;
		$.ajax({
				url : 'game.php',
				method : 'POST',
				data : { faction : $(this).attr('id')},
				success : function (data) {
					console.log('faction(' + data + ')')
					$('#disconnect').fadeOut('slow');
					$('#choose').fadeOut('slow');
					$('#faction img').fadeOut('slow');
					$('#faction').fadeOut('slow', function() {
						$('#box').width((8 + 2) * 150 + 350);
						$('#box').height((8 + 2) * 100);
						$('#content').load('grid.php', function() { $('#content').fadeIn('slow'); });
					});
					$('#disconnect').attr('class', 'ingame');
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
				data : { changeturn : 'changeturn' }
		});
	}
}
function PP_Change()
{
	$nbr = parseInt($('#form_pp #nbr').attr('alt'));
	$org = parseInt($('#form_pp #nbr').attr('alt'));
	$('#form_pp input[type=number]').each(function() {
		$nbr -= parseInt($(this).val());
	});
	$('#form_pp #nbr').text($nbr);
	if ($nbr < 0 || $nbr > $org)
	{
		$('#form_pp #nbr').text($org);
		$('#form_pp #nbr').attr('class', 'full');
		$('#form_pp #button_use').prop('disabled', true);
	}
	else
	{
		$('#form_pp #nbr').attr('class', '');
		$('#form_pp #button_use').prop('disabled', false);
		return (true);
	}
	return (false);
}
function PP_Move()
{
	if (PP_Change())
	{
		$('#form_move #nbr').attr('alt', $('#form_pp #speed').val());
		$('#form_move #nbr').text($('#form_pp #speed').val());
		if ($('#form_move').is(':hidden'))
			$('#form_pp').fadeOut('slow', function() { $('#form_move').fadeIn('slow'); });
	}
}
