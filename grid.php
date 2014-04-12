<div id ="grid">
	<table border = 1>
<?PHP
		for ($i = 0 ; $i < 100; $i++)
		{
			echo "<tr>";
			for ($j = 0 ; $j < 150 ; $j++)
			{
				echo "<td x=".$j." y=".$i."></td>";
			}
			echo "</tr>";
		}
?>
	</table>
	<?PHP include('interface/commandPannel.php');?>

</div>
