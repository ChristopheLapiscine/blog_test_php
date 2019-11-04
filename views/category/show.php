<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;

$id = $params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$query = $pdo->prepare('SELECT * FROM category WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
$category = $query->fetch();
if ($category === false) {
    throw new Exception('Aucune catégorie ne correspond à cet ID');
}

if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
};

$paginatedQuery = new PaginatedQuery("
SELECT p.* 
FROM post p
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = {$category->getId()} 
ORDER BY created_at DESC",
"SELECT COUNT(category_id) FROM post_category WHERE category_id =  {$category->getId()}"
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

$link = $router->url('category',['id' => $category->getId(), 'slug' => $category->getSlug()]);
?>

<h1>Catégorie <?= htmlentities($category->getName()) ?></h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-3">
            <?php require dirname(__DIR__) . '/post/card.php' ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="d-flex justfify-content-between my-4">
    <?= $paginatedQuery->previousLink($link); ?>
    <?= $paginatedQuery->nextLink($link); ?>
</div>
