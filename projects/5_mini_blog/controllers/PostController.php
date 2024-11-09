<?php
// controllers/PostController.php
class PostController
{
    public function index()
    {
        $posts = [
            ['title' => 'First Post', 'content' => 'This is the content of the first post.'],
            ['title' => 'Second Post', 'content' => 'This is the content of the second post.']
        ];
        View::render('post/index', ['title' => 'Blog Home', 'posts' => $posts]);
    }
}
