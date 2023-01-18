<?php
namespace System\Http;

class Middleware {

    private $listOfMiddleware = ["before_request" => [], "after_request" => []];

    
    public function before($callback){

       return $this->add("before_request", $callback);
        
    }

    public function add($type, $callback){

        return $this->listOfMiddleware[$type][] = [$callback];
    }

    public function after($type, $callback){
    
        return $this->add("after_request", $callback);
    }

    public function runAll($type = "before_request"){

        if($type == "before_request"){

            foreach($this->listOfMiddleware[$type] as $callback){
                echo "Ok";
                dump($callback)
            }
        }
        if($type == "after_request"){

            foreach($this->listOfMiddleware["after_request"] as $callback){

                call_user_func_array($callback, []);
            }
        }
    
    }

    public function getAll() {

        return $this->listOfMiddleware;	
    }

}