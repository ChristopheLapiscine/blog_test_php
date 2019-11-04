<?php

use App\Connection;
use App\Table\PostTable;

$pdo = Connection::getPDO();

$table = new PostTable($pdo);
list($posts, $pagination)= $table->findPaginated();


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
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>
