<?php

namespace Theslowaja\BossBar;

use pocketmine\{Server, player\Player, plugin\PluginBase, event\Listener, event\player\PlayerJoinEvent, event\player\PlayerQuitEvent, utils\Config};
use libs\xenialdan\apibossbar\DiverseBossBar;
use libs\xenialdan\apibossbar\BossBar;

class Loader extends PluginBase implements Listener {

    private BossBar $bossBar;

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
        $this->bossBar = new BossBar();
    }

    public function onJoin(PlayerJoinEvent $event){
        $p = $event->getPlayer();
        $this->bossBar->setPercentage($this->getConfig()->get("percentage") / 100);
        $this->bossBar->setTitle(str_replace("&", "§", $this->getConfig()->get("Top-Title")));
        $this->bossBar->setSubTitle(str_replace("&", "§", $this->getConfig()->get("Sub-Title")));
        $this->bossBar->addPlayer($p);
    }

    public function quit(PlayerQuitEvent $ev){
        $p = $ev->getPlayer();
        $this->bossBar->removePlayer($p);
    }
}
