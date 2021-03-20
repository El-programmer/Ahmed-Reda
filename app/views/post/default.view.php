<!-- The Modal -->
<div class="modal " id="searche-model">
    <div class="modal-dialog m-5">
        <div class="modal-overlay text-center d-none  ">
            <h2 class="m-auto card-img-overlay"> plass wait <span class="fa fa-spin" </h2>
        </div>

        <div class="modal-content container-fluid w-100 h-100" >

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">seaech for car now </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="layer-1" >
                    <h4 class="border-bottom-1"> 1 ) select brand  </h4>
                    <div class="models row">
                        <?php if ($brands !== false): foreach ($brands as $brand): ?>
                            <div class="col-6 col-md-3 chosse-car-brand" data-brand-id="<?= $brand->id ?>">
                                <img src="/<?= $brand->image ?>" class=" img-thumbnail select-brand brand-logo mb-2" alt="<?= $brand->tittle ?>" data-brand="<?= $brand->id ?>">
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
                <div class="layer-2 m-auto row d-none">
                    <span class="fa  fa-arrow-alt-circle-right position-absolute back-arrow"></span>
                    <div class="row"></div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="container ">
<?php if ($posts !== false || !empty($posts)  ): ?>
<div class="">
    <h3 class="text-center"> Avaliable cars Now   </h3>
    <div class="row">
        <?php if ($posts !== false): foreach ($posts as $item): ?>

            <div class="card mb-5 col-12 col-sm-12 col-md-4 col-lg-3">
                <div class="card-header">
                    <h2 class="h6  mb-0"> <a class="rounded-right" href="/post/show/<?= $item->id .'/'. substr($item->tittle, 0, 40) ?>"><?= substr($item->tittle, 0, 40) ?></a> </h2>
                </div>
                <div class="card-body">
                    <img src="<?= json_decode($item->images , true)[1] ?>" class="img-fluid">
                </div>
                <p>
                    <span  class="d-inline btn btn-sm btn-<?= $item->state ?'primary' : 'success' ?> " style="width: min-content"><?= $item->state ? 'New' : 'Used' ?></span>
                    <span  class="d-inline btn btn-sm btn-info" style="width: min-content"><?= $item->price ?></span>
                </p>
            </div>
        <?php endforeach; endif;  endif; ?>
    </div>

    <div class="clearfix"></div>
    <?php  require __DIR__ ."/../paginationbuttons.view.php"; ?>

</div>


</div>