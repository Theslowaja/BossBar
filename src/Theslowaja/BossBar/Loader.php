<?php

namespace Theslowaja\BossBar;

use pocketmine\{Server, player\Player, plugin\PluginBase, event\Listener, event\player\PlayerJoinEvent, event\player\PlayerQuitEvent, event\entity\EntityTeleportEvent};
use xenialdan\apibossbar\DiverseBossBar;

class Loader extends PluginBase implements Listener {

    public DiverseBossBar $bossBar;
    public array $enabledPlayer = [];
    public array $bossProcess = [];

    public function onEnable() : void{
        if(!class_exists(DiverseBossBar::class)){
            $this->getLogger()->critical("Class DiverseBossBar Not Found, Please Install From Poggit");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
        $this->bossBar = new DiverseBossBar();
        $this->updateColor($this->getConfig()->get("color"));
        $this->getScheduler()->scheduleRepeatingTask(new BossTask($this), $this->getConfig()->get("task-delay") * 20);
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        foreach($this->getConfig()->get("disabled-world") as $wname){
            if($wname === $player->getWorld()->getFolderName()){
                return;
            }
        }
        $this->bossBar->addPlayer($player);
        $this->enabledPlayer[] = $player->getName();
        $this->bossProcess["title"][$player->getName()] = 0;
        $this->bossProcess["sub-title"][$player->getName()] = 0;
    }

    public function onWorldChange(EntityTeleportEvent $event){
        $entity = $event->getEntity();
        if(!$entity instanceof Player){
            return;
        }
        $player = $entity;
        foreach($this->getConfig()->get("disabled-world") as $wname){
            if($wname === $player->getWorld()->getFolderName()){
                unset($this->enabledPlayer[$player->getName()]);
                unset($this->bossProcess["title"][$player->getName()]);
                unset($this->bossProcess["sub-title"][$player->getName()]);
                $this->bossBar->removePlayer($player);
                return;
            }
        }
        $this->bossProcess["title"][$player->getName()] = 0;
        $this->bossProcess["sub-title"][$player->getName()] = 0;
    }

    public function quit(PlayerQuitEvent $ev){
        $player = $ev->getPlayer();
        unset($this->enabledPlayer[$player->getName()]);
        unset($this->bossProcess["title"][$player->getName()]);
        unset($this->bossProcess["sub-title"][$player->getName()]);
        $this->bossBar->removePlayer($player);
    }
    
    public function updateColor($color){
        //Minimalize Line
        $colordata = ["pink" => 0, "blue" => 1, "red" => 2, "green" => 3, "yellow" => 4, "purple" => 5, "white" => 6];
        if(isset($colordata[strtolower($color)])){
            $this->bossBar->setColor($colordata[$color]);
            return;
        }
        $this->bossBar->setColor(0);
    }
}
