<?php 

namespace WalkingText\Commands;

use WalkingText\Main;
use picketmine\Server;
use pocketmine\command\Command; 
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\network\protocol\{Info, PlayerActionPacket, ChangeDimensionPacket, SetCommandsEnabledPacket, SetTitlePacket, EntityEventPacket};


class WSign extends Command{

    private $main;

    public function __construct(Main $main, $name, $dscpr, $usage){ 
        $this->main = $main;
        parent::__construct($name, $dscpr, $usage);
        $this->setPermission("WalkingText");
    }

    public function execute(CommandSender $sender, $label, array $args){
		if($sender instanceof Player){
			switch($args[0]){
				case "walk_on":
				    if(isset($args[1])){
						switch($args[1]){
							case "all":
							    $this->main->mode[$sender->getName()]["type"] = "walk";
								$mtype = "Editing all rows.";
							break;
							case "0":
							    $this->main->mode[$sender->getName()]["type"] = "walk0";
								$mtype = "Editing the zero line.";
							break;
							case "1":
							    $this->main->mode[$sender->getName()]["type"] = "walk1";
								$mtype = "Editing the first line.";
							break;
							case "2":
							    $this->main->mode[$sender->getName()]["type"] = "walk2";
								$mtype = "Editing the second line.";
							break;
							case "3":
							    $this->main->mode[$sender->getName()]["type"] = "walk3";
								$mtype = "Editing the third line.";
							break;
						}
						if(isset($args[2]) && is_numeric($args[2])){
							$this->main->mode[$sender->getName()]["value"] = $args[2];
						}else{
							$this->main->mode[$sender->getName()]["value"] = 1;
						}
						$sender->sendMessage("WalkingText Activated. Click on the sign to shift the text.");
						$sender->sendMessage($mtype);
						$sender->sendMessage("Shift text to " . $this->main->mode[$sender->getName()]["value"]. " characters");
					}
				break;
				case "0":
				    array_shift($args);
					$this->main->mode[$sender->getName()]["type"] = "line0";
					$this->main->mode[$sender->getName()]["value"] = implode(" ", $args);
					$sender->sendMessage("Текст: ". $this->main->mode[$sender->getName()]["value"]);
				break;
				case "1":
				    array_shift($args);
					$this->main->mode[$sender->getName()]["type"] = "line1";
					$this->main->mode[$sender->getName()]["value"] = implode(" ", $args);
					$sender->sendMessage("Текст: ". $this->main->mode[$sender->getName()]["value"]);
				break;
				case "2":
				    array_shift($args);
					$this->main->mode[$sender->getName()]["type"] = "line2";
					$this->main->mode[$sender->getName()]["value"] = implode(" ", $args);
					$sender->sendMessage("Текст: ". $this->main->mode[$sender->getName()]["value"]);
				break;
				case "3":
				    array_shift($args);
					$this->main->mode[$sender->getName()]["type"] = "line3";
					$this->main->mode[$sender->getName()]["value"] = implode(" ", $args);
					$sender->sendMessage("Текст: ". $this->main->mode[$sender->getName()]["value"]);
				break;
				case "walk_off":
				    unset($this->main->mode[$sender->getName()]);
					$sender->sendMessage("WalkingSign деактивирован.");
				break;
				default:
				    $sender->sendMessage("Use /wsign walk_on <all/0/1/2/3> <count> To enable text shifting");
					$sender->sendMessage("Use /wsign walk_off To turn off the shift");
					$sender->sendMessage("Use /wsign <0/1/2/3> <message> To change the text on the line");
			}
		}
        
    }
}