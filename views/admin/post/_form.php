<form action="" method="post">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>

    <button class="btn btn-primary">
        <?php if ($post->getID() !== null) : ?>
        Modifier
        <?php else: ?>
        Créer
        <?php endif; ?>
    </button>
</form>