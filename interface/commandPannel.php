<div id="command_panel">
	<div id="form_activate">
		<input id="shipactivated" type="hidden" value="" />
		<input onclick="button_activate()"  type="button" value="Activate" />
	</div>
	<br />
	<div id="form_pp">
		<div id="nbr" alt="50">50</div>
		<label for="speed">Speed</label><br />
		<div id="speed_default" alt="20">20</div>
		<input id="speed" type="number" value="0" onchange="PP_Change();" /><br />
		<label for="shield">Shield</label><br />
		<input id="shield" type="number" value="0" onchange="PP_Change();" /><br />
		<label for="weapon">Weapon</label><br />
		<input id="weapon" type="number" value="0" onchange="PP_Change();" /><br />
		<label for="repare">Repair</label><br />
		<input id="repare" type="number" value="0" onchange="PP_Change();" /><br />
		<input id="button_use" type="button" onclick="PP_Move(this, -1);" value="Use This Config"/>
	</div>
	<br />
	<div id="form_move">
		<div class="title">Move</div>
		<div id="nbr"></div>
		<input id="left" type="image" src="images/arrow/left.png" onclick="PP_Move(this, 1);" />
		<input id="up" type="image" src="images/arrow/up.png" onclick="PP_Move(this, 1);" />
		<input id="right" type="image" src="images/arrow/right.png" onclick="PP_Move(this, 1);" />
		<input onclick="PP_Weapon(this, 0);" type="button" value="Validate" />
	</div>
	<div id="form_weapon">
		<div class="title">Weapon</div>
		<div id="nbr"></div>
		<input id="less" type="button" value="Less" onclick="PP_Weapon(this, -1);" />
		<input id="more" type="button" value="More" onclick="PP_Weapon(this, 1);" />
		<input id="end_turn" onclick="switchTurn();" type="submit" value="End Turn" />
	</div>
	</br>
</div>
<input id="game_status" type="button" value="Getting status..." />
<form id="disconnect2" action="disconnect.php" method="post">
	<input type="submit" value="Disconnect" />
</form>
