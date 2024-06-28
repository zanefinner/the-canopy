<?php namespace Controller;
class Users {
    protected $model = '';
    protected $model2 = '';

    public function __construct($model, $model2 = null) {
        $this->model = $model;
        $this->model2 = $model2;
    }

    public function search($in) {
        $term = $in['search_term'];
        $data = $this->model->getUserById($term);
        $data2 = $this->model2->getPostsByUser($term);
        require 'view/search.php';
    }

    public function login() {
        if (isset($_POST['email'])) {
            $data = $this->model->authenticate($_POST);
            $_SESSION = $data;
            $_SESSION['password'] = '';
            if (isset($data['id'])) {
                header("Location: feed");
            } else {
                header("Location: login");
            }
        } else {
            require 'view/login.php';
        }
    }

    public function signup() {
        if (isset($_POST['email'])) {
            if ((strlen($_POST['email']) > 10) && (strlen($_POST['email']) < 40)) {
                if (strpos($_POST['email'], "@") !== false) {
                    if ((strlen($_POST['alias']) > 4) && (strlen($_POST['alias']) < 17)) {
                        if ((strlen($_POST['name']) > 6) && (strlen($_POST['name']) < 40)) {
                            if (strpos($_POST['name'], ' ') !== false) {
                                if (strlen($_POST['password']) > 7) {
                                    if (strlen($_POST['password']) < 21) {
                                        if (!is_numeric($this->model->getIdByEmail($_POST['email']))) {
                                            $this->model->insert($_POST);
                                            header("Location: login");
                                        } else {
                                            $errors = "Email is already associated with an account";
                                        }
                                    } else {
                                        $errors = 'Password must have less than 21 characters';
                                    }
                                } else {
                                    $errors = 'Password must have over 7 characters';
                                }
                            } else {
                                $errors = 'Name must have a space in it. Example: John Smith';
                            }
                        } else {
                            $errors = 'Name must be over 6 characters and under forty characters, space-inclusive';
                        }
                    } else {
                        $errors = 'Alias must have over 4 characters but less than seventeen';
                    }
                } else {
                    $errors = 'Email must contain the "@" symbol';
                }
            } else {
                $errors = 'Email must be over ten characters but less than forty';
            }
        }
        require 'view/signup.php';
    }

    public function logout() {
        session_destroy();
        header("Location: /");
    }

    public function follow($id) {
        // Start the session (if not already started)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Get the current session ID
        $currentSessionId = $_SESSION['id'];

        // Retrieve the following data
        $dataJSON = $this->model->getFollowing($currentSessionId);
        $dataArr = json_decode($dataJSON, true); // Decode JSON as an associative array

        // Ensure $dataArr is an array
        if (!is_array($dataArr)) {
            $dataArr = [];
        }

        // Check for duplicates and add the ID if not already present
        if (!in_array($id, $dataArr)) {
            $dataArr[] = $id;
            $dataJSON = json_encode($dataArr);
            $this->model->setFollowing($currentSessionId, $dataJSON);
            echo 'User followed successfully';
        } else {
            echo 'User is already being followed';
        }
    }
    public function unfollow($id) {
      // Start the session (if not already started)
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }

      // Get the current session ID
      $currentSessionId = $_SESSION['id'];

      // Retrieve the following data
      $dataJSON = $this->model->getFollowing($currentSessionId);
      $dataArr = json_decode($dataJSON, true); // Decode JSON as an associative array

      // Ensure $dataArr is an array
      if (!is_array($dataArr)) {
          $dataArr = [];
      }

      // Check if the ID exists in the array and remove it if found
      $key = array_search($id, $dataArr);
      if ($key !== false) {
          unset($dataArr[$key]);
          $dataJSON = json_encode(array_values($dataArr)); // Re-encode array to JSON
          $this->model->setFollowing($currentSessionId, $dataJSON); // Update following data in the database
          echo 'User unfollowed successfully';
      } else {
          echo 'User is not currently followed';
      }
  }
}