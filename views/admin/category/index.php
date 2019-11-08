<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();


$pdo = Connection::getPDO();
$link = $router->url('admin_categories');
$items= (new CategoryTable($pdo))->all();

?>

<?php if (isset($_GET['delete'])): ?>
<div class="alert alert-success">
    L'enristrement a bien été supprimé
</div>
<?php endif ?>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        La catégorie a bien été crée
    </div>
<?php endif ?>

<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <td>#<?= $item->getId() ?></td>
        <td>
        <a href="<?= $router->url('admin_category', ['id' => $item->getId()]) ?>">
            <?= htmlentities($item->getName()) ?>
        </a>
        </td>
        <td><?= $item->getSlug() ?></td>
        <td>
            <a href="<?= $router->url('admin_category', ['id' => $item->getId()]) ?>" class="btn btn-primary">
                Editer
            </a>
            <form action="<?= $router->url('admin_category_delete', ['id' => $item->getId()]) ?>" method="post"
                  onsubmit="return confirm('Voulez-vous vraiment effectuer cette action?')" style="display: inline">
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

