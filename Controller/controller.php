<?php

class Controller{

    public function view($path, $data=[]){
        if(file_exists("../View/".$path.".php")){
            include "../View/".$path.".php";
        }
    }
}