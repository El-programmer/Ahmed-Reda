
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
                    <div class="brands row">
                        <?php if ($brands !== false): foreach ($brands as $brand): ?>
                        <div class="col-6 col-md-3 chosse-car-brand" data-brand-id="<?= $brand->id ?>">
                                <img src="<?= $brand->image ?>" class=" img-thumbnail select-brand brand-logo mb-2" alt="<?= $brand->tittle ?>" data-brand="<?= $brand->id ?>">
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

<div class="jumbotron jumbotron-fluid mb-0 text-center jumbotron-home d-none" >

    <div class="container  m-auto">
        <div class="row mb-3">
            <select id="brand-searche" name="cars" class="custom-select col-6">
                <option value="0" selected> Select Brand</option>
                <?php if ($brands !== false): foreach ($brands as $brand): ?>
                    <option value="<?= $brand->id ?>"><?= $brand->tittle ?></option>
                <?php endforeach; endif; ?>
            </select>
            <select id="brand-searche" disabled class="custom-select col-6">
                <option value="0" selected> Select Model</option>
                <?php if ($brands !== false): foreach ($brands as $brand): ?>
                    <option value="<?= $brand->id ?>"><?= $brand->tittle ?></option>
                <?php endforeach; endif; ?>
            </select>

        </div>
        <div class="clearfix mt-3"></div>
        <button class="btn btn-info col-6 mt-3 m-auto " > Searche  </button>

    </div>
</div>



<div class="owl-carousel owl-carousel-markes-index owl-theme ">
    <?php if ($brands !== false): foreach ($brands as $brand): ?>
        <div class="item">
            <img class="owl-logo" src="<?= $brand->image ?>">
        </div>
    <?php endforeach; endif; ?>
</div>
<div class="container">
</div>
