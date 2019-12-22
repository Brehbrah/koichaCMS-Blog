<?php 
    class Posts extends Controller {

        public function __construct() {
            // If not, we want to redirect
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            // We want to check if the SESSION user_id is logged in. If it's logged in, then it's there
            $this -> postModel = $this -> model('Post');
        }

        public function index() {
            // Get posts
            $posts = $this -> postModel -> getPosts();
            $data = [
                'posts' => $posts,
            ];
            $this -> view('posts/index', $data);
        }
    }

?>