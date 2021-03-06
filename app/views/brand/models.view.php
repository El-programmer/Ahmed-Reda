

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
<div class="owl-carousel owl-theme">

    <div class="item" style="height: 400px;" >
        <div >
            <img src="/public/img/slider/slider1.jpg" class="w-100 h-100">
            <div class="position-absolute m-auto item-word text-center p-4">
                <h1>Cars shop</h1>
                <p>buy car now </p>
                <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#searche-model">
                    Searche Now
                </button>
            </div>
        </div>

    </div>

</div>


</div>
<div class="container mt-4 ">

    <div class="card">
        <div class="card-header">
            <h2 class="h6 text-uppercase mb-0 d-inline-block "> <?=  isset($mybrand) ? 'Mosdels of Brand' . $mybrand->tittle : " All Models " ?>  </h2>  <?=  isset($mybrand) ? '<img src="/'. $mybrand->image .'" class="d-inline-block owl-logo">' : "  " ?>
        </div>
        <div class="card-body">
            <div class="row">

                <?php if ($models !== false): foreach ($models as $brand): ?>
                    <div class="col-12 col-sm-6 col-mt-5 mb-auto col-lg-3 brand-card  text-center">
                        <div class="card " >
                            <img class="card-img-top" src="<?= $brand->images ?>" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title"><?= $brand->name ?> <a href="/brand/models/<?= $brand->marke()->id .'/'.$brand->marke()->tittle?>" class=" btn btn-primary" style="width: min-content"><?= $brand->marke()->tittle ?></a>
                                </h4>
                                <a href="/brand/showmodel/<?= $brand->id .'/' . str_replace(' ' , '-',$brand->tittle ) ?>" class="btn btn-primary">See Posts</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>

        </div>
    </div>




<?php  require __DIR__ ."/../paginationbuttons.view.php"; ?>
</div>


