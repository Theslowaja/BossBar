<?php

namespace Theslowaja\BossBar\task;

use pocketmine\scheduler\Task;
use Theslowaja\BossBar\Loader;

class BossBarTask extends Task{

    private Loader $plugun;

    private $count;

    public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        $this->count = 0;
    }

    public function onRun() : void {
        	$persen = $this->plugin->getConfig()->get("percentage");
        	$top = str_replace("&", "§", $this->plugin->getConfig()->getAll()["BossBar"]["Top-Title"]);
                $sub = str_replace("&", "§", $this->plugin->getConfig()->getAll()["BossBar"]["Sub-Title"]);
    		back:
    		if($this->count < count($top)){
    	    		$this->plugin->sendBossBar($top[$this->count], $sub[$this->count], $persen);
    	    		$this->count++;
    		}else{
		    	$this->count = 0;
		    	goto back;
		}
    	}
}
