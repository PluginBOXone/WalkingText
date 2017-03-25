<?php

namespace WalkingText;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use WalkingText\Commands\WSign;
use WalkingText\Commands\BSign;
use pocketmine\tile\Sign;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\event\player\{PlayerInteractEvent, PlayerQuitEvent};

class Main extends PluginBase implements Listener{
	
	public $mode;
	
	public function onEnable(){
		$this->getLogger()->info("WalkingText is enable");
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		$commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("[WalkingText]", new WSign($this, "wsign", "Move the text from the sign!", "Use /wsign on <count>"));
		//$commandMap->register("[WalkingText]", new BSign($this, "bsign", "Move the text from the sign!", "Use /wsign on <count>"));
	}
	
	public function onDisable(){
		$this->getLogger()->info("WalkingText is disable");
	}
	
	public function onQuit(PlayerQuitEvent $event){
		$name = $event->getPlayer()->getName();
		unset($this->mode[$name]);
	}
	
	public function onTap(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$level = $player->getLevel();
		$block = $event->getBlock();
		$tile = $level->getTile($block);
		if($tile instanceof Sign){
			$t = $tile->getText();
			if(isset($this->mode[$name])){
				switch($this->mode[$name]["type"]){
					case "walk":
					    $s = str_repeat(" ", $this->mode[$name]["value"]);
				        $t[0] = $s.$t[0];
				        $t[1] = $s.$t[1];
				        $t[2] = $s.$t[2];
				        $t[3] = $s.$t[3];
				        $tile->setText($t[0], $t[1], $t[2], $t[3]);
					    break;
					case "walk0":
					    $s = str_repeat(" ", $this->mode[$name]["value"]);
				        $t[0] = $s.$t[0];
				        $tile->setText($t[0], $t[1], $t[2], $t[3]);
					    break;
					case "walk1":
					    $s = str_repeat(" ", $this->mode[$name]["value"]);
				        $t[1] = $s.$t[1];
				        $tile->setText($t[0], $t[1], $t[2], $t[3]);
					    break;
					case "walk2":
					    $s = str_repeat(" ", $this->mode[$name]["value"]);
				        $t[2] = $s.$t[2];
				        $tile->setText($t[0], $t[1], $t[2], $t[3]);
					    break;
					case "walk3":
					    $s = str_repeat(" ", $this->mode[$name]["value"]);
				        $t[3] = $s.$t[3];
				        $tile->setText($t[0], $t[1], $t[2], $t[3]);
					    break;
					case "line0":
					    $s = $this->mode[$name]["value"];
						$tile->setText($s, $t[1], $t[2], $t[3]);
						$player->sendMessage("Text successfully installed");
						unset($this->mode[$name]);
					    break;
					case "line1":
					    $s = $this->mode[$name]["value"];
						$tile->setText($t[0], $s, $t[2], $t[3]);
						unset($this->mode[$name]);
					    break;
					case "line2":
					    $s = $this->mode[$name]["value"];
						$tile->setText($t[0], $t[1], $s, $t[3]);
						unset($this->mode[$name]);
					    break;
					case "line3":
					    $s = $this->mode[$name]["value"];
						$tile->setText($t[0], $t[1], $t[2], $s);
						unset($this->mode[$name]);
					    break;
				}
			}
		}
	}
}