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


class BSign extends Command{

    private $main;

    public function __construct(Main $main, $name, $dscpr, $usage){ 
        $this->main = $main;
        parent::__construct($name, $dscpr, $usage);
        $this->setPermission("WalkingText");
    }

    public function execute(CommandSender $sender, $label, array $args){
		if($sender instanceof Player){
			$message = implode(" ", $args);
			$this->main->mode[$sender->getName()]["type"] = "bigtext";
			$this->main->mode[$sender->getName()]["value"] = $message;
			$sender->sendMessage("Click on the sign on which you want to write the text \n" . $message);
		}
        
    }
}