<?php
namespace System\Console;

class AppConsole {
    
    private $msg = "\nYou can use your App in console mode now !\n";
    private $prompt = "\n>>>";
    private $statut = true;
    
    public function __construct()
    {
        print $this->msg;
        while ($this->statut){
            $cmd = readline($this->prompt);   
            $this->runCmd($cmd); 
        }
    }

    private function runCmd($cmd = ''){
        if($cmd == 'exit' || $cmd == 'bye'){
            return $this->statut = false;
        }
        print('Run : ' .$cmd);
    }
}