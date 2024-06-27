<?php namespace Controller;
class Posts{
  protected $model = '';

  public function __construct($model)
  {
      $this->model = $model;
  }

  public function getUserPosts($author){
    $data = $this->model->getPostsByUser($author);
    require('view/user-posts.php');
  }
  public function create($data){
    $data = $this->model->insert($data['content'], $_SESSION['id']);
    header('Location: /feed');
  }
}
