<?php

use App\Model\Post;
use App\Connection;
use App\PaginatedQuery;
use App\Model\Category;

$pdo = Connection::getPDO();

$paginatedQuery = new PaginatedQuery(
        "SELECT * FROM post ORDER BY created_at DESC",
    "SELECT COUNT(id) FROM post"
);

$posts = $paginatedQuery->getItems(Post::class);
$postsByID = [];
foreach($posts as $post){
    $postsByID[$post->getId()] = $post;
}
$categories= $pdo->query('
                    SELECT c.*, pc.post_id 
                    FROM post_category pc 
                    JOIN category c ON c.id = pc.category_id
                    WHERE pc.post_id IN (' . implode(',', array_keys($postsByID)) . ')'
)->fetchAll(PDO::FETCH_CLASS, Category::class);
foreach ($categories as $category){
    $postsByID[$category->getPostId()]->addCategory($category);
}

$link = $router->url('home');
?>

<h1>Mon blog</h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justfify-content-between my-4">
    <?= $paginatedQuery->previousLink($link); ?>
    <?= $paginatedQuery->nextLink($link); ?>
</div>
