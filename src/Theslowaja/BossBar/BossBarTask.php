<?php

namespace BossBar\task;

use pocketmine\scheduler\Task;

class BossBarTask extends Task{

    private Loader $plugin;

    public __construct(Loader $pl, Player $p){
        $this->pl = $pl;
        $this->player = $p;
        $this->count = 0;
    }

    public function onRun() : void {
        	$persen = $this->getConfig()->get("percentage");
        	$top = str_replace("&", "§", $this->plugin->getConfig()->getAll()["BossBar"]["Top-Title"]);
                $top = str_replace("&", "§", $this->plugin->getConfig()->getAll()["BossBar"]["Sub-Title"]);
    		back:
    		if($this->count < count($messages)){
    	    		$this->pl->sendBossBar($this->player, $top[$this->count], $sub[$this->count], $persen);
    	    		$this->count++;
    		}else{
		    	$this->count = 0;
		    	goto back;
		}
    	}
}
