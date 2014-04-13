<div id="command_panel">
	<div id="form_activate">
		<!--<input id="shipactivated" type="text" value="" />-->
		<input onclick="button_activate()"  type="button" value="Activate" />
	</div>
	<br />
	<div id="form_pp">
		<div id="nbr" alt="50">50</div>
		<label for="speed">Speed</label><br />
		<input id="speed" type="number" value="0" onchange="PP_Change();" /><br />
		<label for="shield">Shield</label><br />
		<input id="shield" type="number" value="0" onchange="PP_Change();" /><br />
		<label for="weapon">Weapon</label><br />
		<input id="weapon" type="number" value="0" onchange="PP_Change();" /><br />
		<label for="repare">Repair</label><br />
		<input id="repare" type="number" value="0" onchange="PP_Change();" /><br />
		<input id="button_use" type="button" onclick="PP_Move();" value="Use This Config"/>
	</div>
	<br />
	<div id="form_move">
		<div id="nbr"></div>
		<input id="move" type="number" value="" />
		<input id="button_move" type="button" value="Move" />
		<input id="right" type="button" value="Right" />
		<input id="left" type="button" value="Left" /><br />
	</div>
	<input onclick="switchTurn()" id="end_turn" type="button" value="End Turn" />
	</br>
</div>
<input id="game_status" type="button" value="Getting status..." />
<form id="disconnect2" action="disconnect.php" method="post">
	<input type="submit" value="Disconnect" />
</form>
