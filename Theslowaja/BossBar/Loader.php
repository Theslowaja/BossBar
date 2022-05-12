<?php

namespace Theslowaja\BossBar;

use pocketmine\{Server, player\Player, plugin\PluginBase, event\Listener, event\player\PlayerJoinEvent};

class Loader extends PluginBase implements Listener {

    public function onEnable () : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
    }
}
