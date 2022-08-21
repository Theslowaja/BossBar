<?php

namespace Theslowaja\BossBar\task;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;
use Theslowaja\BossBar\Loader;

class BossBarTask extends Task{

    private Loader $pl;
    private $count;

    public function __construct(Loader $pl){
        $this->pl = $pl;
        $this->count = 0;
    }

    public function onRun() : void {
        	$persen = $this->pl->getConfig()->get("percentage");
        	$top = str_replace("&", "§", $this->pl->getConfig()->getAll()["BossBar"]["Top-Title"]);
                $sub = str_replace("&", "§", $this->pl->getConfig()->getAll()["BossBar"]["Sub-Title"]);
    		back:
    		if($this->count < count($top)){
    	    		$this->pl->sendBossBar($top[$this->count], $sub[$this->count], $persen);
    	    		$this->count++;
    		}else{
		    	$this->count = 0;
		    	goto back;
		}
    	}
}
