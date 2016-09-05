<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p> <?= Yii::$app->user->identity->username ?> </p>
            </div>
        </div>

        <?php
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu ', 'options' => ['class' => 'header']],
                    ['label' => 'Home', 'icon' => 'fa fa-home', 'url' => ['/site/index' ]],
                    ['label' => 'Personal Profile', 'icon' => 'fa fa-user', 'url' => ['/user-detail/view-me' ]],
                    ['label' => 'Business Profile', 'icon' => 'fa fa-building-o', 'url' => ['/business-detail/view-me' ]],
                    ['label' => 'Documents', 'icon' => 'fa fa-cloud-upload', 'url' => ['/document-detail/index']]
                ],
            ]
        ) ?>

    </section>

</aside>
