<?php namespace Controller;
class Home{
    protected $model = '';

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
      if( isset( $_SESSION['id'])){
        require 'view/feed.php';
      }else{
        header('Location: /');
      }
    }
    public function present(){
      if( isset ($_SESSION['id']) ){
        header('Location: feed');
      }else{
        require 'view/home.php';
      }
    }

    public function error($error){
      require 'view/error.php';
    }
}
