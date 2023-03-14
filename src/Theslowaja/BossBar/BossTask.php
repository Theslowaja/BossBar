<?php

namespace Theslowaja\BossBar;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class BossTask extends Task {

    private Loader $plugin;

    public function __construct(Loader $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(): void
    {
        $pl = $this->plugin;
        $cfg = $pl->getConfig()->getAll();
        $bb = $pl->bossBar;
        foreach($pl->enabledPlayer as $player){
            $player = $pl->getServer()->getPlayerByPrefix($player);
            if(!$player instanceof Player){
                //Player Not Found
            } elseif(isset($cfg["bossBar"][$player->getWorld()->getFolderName()])){
                $world = $player->getWorld()->getFolderName();
                if($pl->bossProcess["title"][$player->getName()] >= count($cfg["bossBar"][$world]["title"])-1){
                    $pl->bossProcess["title"][$player->getName()]  = 0;
                    $bb->setTitleFor([$player], $cfg["bossBar"][$world]["title"][0]);
                } else {
                    $pl->bossProcess["title"][$player->getName()] = $pl->bossProcess["title"][$player->getName()] + 1;
                    $bb->setTitleFor([$player], $cfg["bossBar"][$world]["title"][$pl->bossProcess["title"][$player->getName()]]);
                }
                if($pl->bossProcess["sub-title"][$player->getName()] >= count($cfg["bossBar"][$world]["sub-title"])-1){
                    $pl->bossProcess["sub-title"][$player->getName()]  = 0;
                    $bb->setSubTitleFor([$player], $cfg["bossBar"][$world]["sub-title"][0]);
                } else {
                    $pl->bossProcess["sub-title"][$player->getName()] = $pl->bossProcess["sub-title"][$player->getName()] + 1;
                    $bb->setSubTitleFor([$player], $cfg["bossBar"][$world]["sub-title"][$pl->bossProcess["sub-title"][$player->getName()]]);
                }
                $bb->setPercentageFor([$player], $cfg["bossBar"][$world]["percentage"]);
            } else {
                if($pl->bossProcess["title"][$player->getName()] === count($cfg["bossBar"]["default"]["title"])-1){
                    $pl->bossProcess["title"][$player->getName()]  = 0;
                    $bb->setTitleFor([$player], $cfg["bossBar"]["default"]["title"][0]);
                } else {
                    $pl->bossProcess["title"][$player->getName()] = $pl->bossProcess["title"][$player->getName()] + 1;
                    $bb->setTitleFor([$player], $cfg["bossBar"]["default"]["title"][$pl->bossProcess["title"][$player->getName()]]);
                }
                if($pl->bossProcess["sub-title"][$player->getName()] === count($cfg["bossBar"]["default"]["sub-title"])-1){
                    $pl->bossProcess["sub-title"][$player->getName()]  = 0;
                    $bb->setSubTitleFor([$player], $cfg["bossBar"]["default"]["sub-title"][0]);
                } else {
                    $bb->setSubTitleFor([$player], $cfg["bossBar"]["default"]["sub-title"][$pl->bossProcess["sub-title"][$player->getName()]]);
                }
                $bb->setPercentageFor([$player], $cfg["bossBar"]["default"]["percentage"]);
            }
        }
    }
}
