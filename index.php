<?php
/*
	https://docs.google.com/spreadsheets/d/1v4aH_2YanTp8cv8VSZfpvmHnFai_v4Gnb0Q9PwEduyc/edit#gid=2117561204
	https://www.myth-weavers.com/generate_town.php?
	https://donjon.bin.sh/fantasy/inn/
	https://www.masterthedungeon.com/creating-encounters/
	https://www.masterthedungeon.com/dnd-npc-generators/
	https://watabou.itch.io/medieval-fantasy-city-generator
	https://www.masterthedungeon.com/dd-town-generator/

 */

require_once("./inc/inc.ajax_handler.php");
require_once("./inc/inc.settings.php");
require_once("./services/class.pdo_handler.php");

class pageFactory{
	private $scripts;
	private $styles;
	private $css;

	public function constructScriptsAndStyles(){
		$output = "";
		foreach ( $this->scripts as $value ) {
			$output .= "<script src='./src/js/" . $value . "'></script>\n";
		}
		foreach ($this->css as $value) {
			$output .= "<link rel='stylesheet' href='./src/css/" . $value . "' />\n";
		}
		return $output;
	}
	public function constructMenu(){
		$menuItems = [ "Generators" ];
		$menuButtons = "";
		foreach ($menuItems as $key => $value) {
			$menuButtons .= "<li class='menu-button'><label class='menu-button-label'><div class='menu-button-label-div'>" . $value . "</div><input id='menu-button" . $key . "' class='menu-button-label-input' type='radio' value='" . $value . "'></label></li>";
		}

		return "<ul id='menubar'>" . $menuButtons . "</ul><div class='content'></div>";
	}
 	function __construct(){
 		$this->scripts = array_diff( scandir( "./src/js/" ), [ ".", ".." ] );
 		$this->css = array_diff( scandir( "./src/css/" ), [ ".", ".." ] );
 	}
}
$pf = new pageFactory();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8' />
		<?php echo $pf->constructScriptsAndStyles(); ?>
	</head>
	<body>
		<div class="content-wrapper">
			<?php echo $pf->constructMenu(); ?>
		</div>
	</body>
</html>