<?php $this->layout('leiOut', ['title' => 'Профиль']); ?>

<div class="container">

    <a href="/editCategories/"><button type="button" class="btn btn-outline-success">Добавить-изменить категории</button> </a>
    <a href="/addProduct/"> <button type="button" class="btn btn-outline-primary">Добавить товар</button> </a>

    <div class="row">

        <?php foreach ($products as $item) {  ?>
            <div class="col-md-4 mt-5">
                <form method="post" enctype="multipart/form-data" >
                    <div class="card">
                        <img src="/views/Upload/<?=$item['img']?>" class="img-fluid" alt="...">
                        <input class="p-2" name="fileImg" type="file">
                        <div class="card-body">
                            <h5 class="card-title"><input name="title" type="text" value="<?=$item['title']?>"></h5>
                            <p class="card-text"> <textarea name="description" class="w-100"> <?=$item['description']?> </textarea> </p>
                            <select class="form-control" id="categoryAddProduct" name="id_categories">

                                <?php foreach ($categories as $item2) {
                                    if (in_array($item['id_categories'], $item2)){ ?>
                                         <option disabled selected="selected" value="<?=$item['id_categories']?>"><?=$item2['title']?></option>
                                  <?php  } else { ?>
                                        <option value="<?=$item2['id']?>"> <?=$item2['title']?> </option>
                                <?php }
                                } ?>
                            </select>
                            <input type="hidden" name="id"  value="<?=$item['id']?>">
                            <a href="/deleteProduct/"> <button type="submit" formaction="/deleteProduct/" class="btn btn-sm btn-primary">Удалить</button> </a>
                            <a href="/editProduct/"> <button type="submit" formaction="/updateProduct/" class="btn btn-sm btn-primary">Изменить</button> </a>
                        </div>
                    </div>
                </form>
            </div>


        <?php }
        ?>

    </div>
</div>

