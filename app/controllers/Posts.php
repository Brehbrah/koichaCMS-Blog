<?php 
    class Posts extends Controller {

        public function __construct() {
            // If not, we want to redirect
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            // We want to check if the SESSION user_id is logged in. If it's logged in, then it's there
            $this -> postModel = $this -> model('Post');
            $this -> userModel = $this -> model('User');
        }

        public function index() {
            // Get posts
            $posts = $this -> postModel -> getPosts();
            $data = [
                'posts' => $posts,
            ];
            $this -> view('posts/index', $data);
        }

        public function add() {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize the POST Array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate the title
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter title';
                }

                // Validate the body
                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter the body text';
                }

                // Make sure there is no error
                if(empty($data['title_err']) && empty($data['body_err'])) {
                    // Validated
                    if($this -> postModel -> addPost($data)) {
                        flashMsg('post_msg', 'Post Added');
                        redirect('posts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load the view with errors
                    $this -> view('posts/add', $data);
                }

            } else {
                $data = [
                'title' => '',
                'body' => ''
                ];
             $this -> view('posts/add', $data);
            }
        }

        public function edit($id) {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize the POST Array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate the title
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter title';
                }

                // Validate the body
                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter the body text';
                }

                // Make sure there is no error
                if(empty($data['title_err']) && empty($data['body_err'])) {
                    // Validated
                    if($this -> postModel -> updatePost($data)) {
                        flashMsg('post_msg', 'Post Updated');
                        redirect('posts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load the view with errors
                    $this -> view('posts/edit', $data);
                }

            } else {
                // Get the existing post from the model
                $post = $this -> postModel -> getPostById($id);

                // Check for owner to edit the post
                if($post -> user_id != $_SESSION['user_id']) {
                    redirect('posts');
                }

                $data = [
                    'id' => $id,
                    'title' => $post -> title,
                    'body' => $post -> body,
                ];
             $this -> view('posts/edit', $data);
            }
        }

        public function show($id) {
            $post = $this -> postModel -> getPostById($id);
            $user = $this -> userModel -> getUserById($post -> user_id);

            $data = [
                'post' => $post,
                'user' => $user
            ];

            $this -> view('posts/show', $data);
        }
    }

?>