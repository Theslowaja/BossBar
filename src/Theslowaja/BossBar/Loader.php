<?php

namespace Theslowaja\BossBar;

use pocketmine\{Server, player\Player, plugin\PluginBase, event\Listener, event\player\PlayerJoinEvent, event\player\PlayerQuitEvent, utils\Config};
use Theslowaja\Bossbar\libs\xenialdan\apibossbar\DiverseBossBar;
use Theslowaja\Bossbar\libs\xenialdan\apibossbar\BossBar;

class Loader extends PluginBase implements Listener {

    private BossBar $bossBar;

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
        $this->bossBar = new BossBar();
        $this->updateColor($this->getConfig()->get("color"));
    }

    public function onJoin(PlayerJoinEvent $event){
        $p = $event->getPlayer();
        if($this->getConfig()->get("EnableJoinBossbar") == true){
            $this->bossBar->addPlayer($p);
        }
    }
    
    public function addBossbar(Player $p, $title, $sub){
        $this->bossBar->setPercentage($this->getConfig()->get("percentage") / 100);
        $this->bossBar->setTitle(str_replace("&", "§", $this->getConfig()->get("Top-Title")));
        $this->bossBar->setSubTitle(str_replace("&", "§", $this->getConfig()->get("Sub-Title")));
        $this->bossBar->addPlayer($p);
    }

    public function quit(PlayerQuitEvent $ev){
        $p = $ev->getPlayer();
        $this->bossBar->removePlayer($p);
    }

    public function removeBossBar(Player $player){
        $this->bossBar->removePlayer($player);
    }
    
    public function updateColor($color){
        switch(strtolower($color)){
             case "pink":
                $color = 0;
                break; 
             case "blue":
                $color = 1;
                break;
             case "red":
                $color = 2;
                break;
             case "green":
                $color = 3;
                break;
             case "yellow":
                $color = 4;
                break;
             case "purple":
                $color = 5;
                break;
             case "white":
                $color = 6;
                break;
             default:
                $color = 0;
                break;
        }
        $this->bossBar->setColor($color);
    }
}
