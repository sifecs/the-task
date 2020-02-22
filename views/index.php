<?php $this->layout('leiOut', ['title' => 'Главная']); ?>

<div class="container">
    <div class="text-right">
        <?php if ($auth->check() ) { ?>
            <a href="/logOut/"> <button type="button" class="btn btn-outline-danger">Выход</button> </a>
            <a href="/profale/"> <button type="button" class="btn btn-outline-primary">Профиль</button> </a>
        <?php } else if(!$auth->check()) {?>
            <a href="/login/"><button type="button" class="btn btn-outline-success">Авторизация</button> </a>
        <?php }
        ?>
    </div>
    <div class="row">

    <?php foreach ($products as $item) {  ?>
        <div class="col-md-4 p-3">
            <div class="card">
                <img src="/views/Upload/<?=$item['img']?>" class="img-fluid" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?=$item['title']?></h5>
                    <p class="card-text"><?=$item['description']?></p>
                   <?php
                    $oneCategory = $queryBuilder->getOne('categories',$item['id_categories']);
                    if ($oneCategory) { ?>
                        <p class="card-text">Категория <?=$oneCategory['title']?></p>
                   <?php } else{ ?>
                        <p class="card-text">Категория отсуствует</p>
                   <?php }
                    ?>
                    <a href="#" class="btn btn-primary">Просто кнопка)</a>
                </div>
            </div>
        </div>
    <?php }
   ?>
    </div>

</div>

