<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= wp_title('·', false, 'right') . get_bloginfo('name'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?= dw_mix('css/style.css'); ?>" />
    <script type="text/javascript" src="<?= dw_mix('js/script.js'); ?>"></script>
    <?php wp_head(); ?>
</head>
<body>
<header class="header">
    <nav class="header__nav nav">
        <?= wp_get_attachment_image(13, 'thumbnail', 'true',['class'=>'logoBD','alt'=>'logo Baptiste Dombard'])?>
        <h2 class="nav__title"><?= __('Navigation principale', 'dw'); ?></h2>
        <ul class="nav__container">
            <?php foreach(dw_get_menu_items('primary') as $link): ?>
                <li class="<?= $link->getBemClasses('nav__item'); ?>">
                    <a  href="<?= $link->url; ?>"
                        <?= $link->title ? ' title="' . $link->title . '"' : ''; ?>
                        class="nav__link"
                    >
                        <?= $link->label; ?>
                    </a>
                    <?php if($link->hasSubItems()): ?>
                        <ul class="nav__subcontainer">
                            <?php foreach($link->subitems as $sub): ?>
                                <li class="<?= $sub->getBemClasses('nav__subitem'); ?>">
                                    <a  href="<?= $sub->url; ?>"
                                        <?= $sub->title ? ' title="' . $sub->title . '"' : ''; ?>
                                        class="nav__link"
                                    >
                                        <?= $sub->label; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
</header>