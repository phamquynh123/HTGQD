<?php
class Controller{

    public function model($model){
        require_once "Model/".$model.".php";
        return new $model;
    }

}
?>
