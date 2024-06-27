<?php namespace Controller;
class Users{
    protected $model = '';
    protected $model2 = '';

    public function __construct($model, $model2=null)
    {
        $this->model = $model;
        $this->model2 = $model2;
    }
    public function search($in){
      $term = $in['search_term'];
      $data = $this->model->getUserById($term);
      $data2 = $this->model2->getPostsByUser($term);
      require 'view/search.php';
    }
    public function login(){
      if(isset($_POST['email'])){
        $data = $this->model->authenticate($_POST);
        $_SESSION=$data;
        $_SESSION['password']='';
        if(isset($data['id'])){
          header("Location: feed");
        }else{
          header("Location: login");
        }
      }else{
        require 'view/login.php';
      }
    }
    public function signup(){
      if(isset($_POST['email'])){
        if( (strlen($_POST['email'])>10 )&&( strlen($_POST['email'])<40) ){
          if( strpos($_POST['email'], "@") !== false){
            if( (strlen($_POST['alias']) > 4)&&(strlen($_POST['alias']) < 17)){
              if( (strlen($_POST['name']) > 6)&&(strlen($_POST['name']) < 40) ){
                if( strpos($_POST['name'], ' ') !== false){
                  if( strlen($_POST['password']) > 7 ){
                    if( strlen($_POST['password']) < 21){
                      if(!is_numeric($this->model->getIdByEmail($_POST['email']))){
                        $this->model->insert($_POST);
                        header("Location: login");
                      }else{$errors = "Email is already associated with an account";}
                    }else{$errors = 'Password must have less than 21 characters';}
                  }else{$errors = 'Password must have over 7 characters';}
                }else{$errors = 'Name must have a space in it. Example: John Smith';}
              }else{$errors = 'Name must be over 6 characters and under forty characters, space-inclusive';}
            }else{$errors = 'Alias must have over 4 characters but less than seventeen';}
          }else{$errors = 'Email must contain the "@" symbol';}
        }else{$errors = 'Email must be over ten characters but less than forty';}
      }
        require 'view/signup.php';//try again
    }
    public function logout(){
      session_destroy();
      header("Location: /");
    }
    public function follow($id){
      $dataJSON = $this->model->getFollowing($id);
      $dataArr = json_decode($dataJSON);
      $dataArr[]=$id;
      $dataJSON=json_encode($dataArr);
      $test = $this->model->setFollowing($id, $dataJSON);
      echo $test;
    }
}
