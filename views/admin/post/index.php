<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();

$pdo = Connection::getPDO();
$link = $router->url('admin_posts');
list($posts, $pagination)= (new PostTable($pdo))->findPaginated();

?>

<?php if (isset($_GET['delete'])): ?>
<div class="alert alert-success">
    L'enristrement a bien été supprimé
</div>
<?php endif ?>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article a bien été crée
    </div>
<?php endif ?>

<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>
            <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
    <tr>
        <td>#<?= $post->getId() ?></td>
        <td>
        <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>">
            <?= htmlentities($post->getName()) ?>
        </a>
        </td>
        <td>
            <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>" class="btn btn-primary">
                Editer
            </a>
            <form action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]) ?>" method="post"
                  onsubmit="return confirm('Voulez-vous vraiment effectuer cette action?')" style="display: inline">
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="d-flex justfify-content-between my-4">
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>
