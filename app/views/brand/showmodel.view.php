<div class="container">


    <div class="card row">
        <img src="/public/uploads/images/postimage.png" class="img-thumbnail img-fluid w-100">

        <div class="card-header">
            <ul class="nav nav-tabs m-auto d-none" style="width: max-content">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">Lock</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">fature</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">All info</a>
                </li>
            </ul>
            <h3 class="d-inline-block"><?= $mybrand->tittle . ' ' . $mymodel->name ?><span class="badge badge-blue"> <?=  $mymodel->price ?> </span> </h3>
        </div>
        <div class="card-body">
            <h5> <?= $mymodel->text ?> </h5>
            <div class="tab-content row d-none">
                <div id="home" class="container tab-pane active"><br>
                    <div class="col-sm-6 col-md-6">
                    </div>
                </div>
                <div id="menu1" class="container tab-pane fade"><br>
                    <h3>Menu 1</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</p>
                </div>
                <div id="menu2" class="container tab-pane fade"><br>
                    <h3>Menu 2</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                        totam rem aperiam.</p>
                </div>
            </div>

<!--            --><?php if ($samemodel !== false ): ?>
            <h3 class="text-center"> Avaliable cars with same Model </h3>
            <div class="row border-blue border-thick border-dark border-gray-100 border-secondary border-1 ">
                <?php  foreach ($samemodel as $item): ?>
                    <div class="card mb-5 col-12 col-sm-6 col-md-4 col-lg-3">
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
            <?php endforeach; else: echo '<h3 class="text-center"> No cars Avaliable in same Model </h3>'; endif; ?>


        </div>
            <div class="clearfix "></div>
            <?php if ($sameprice !== false || !empty($sameprice)  ): ?>
        <div class="">
            <h3 class="text-center"> Avaliable cars with same price </h3>
            <div class="row">
                <?php if ($sameprice !== false): foreach ($sameprice as $item): ?>

                    <div class="card mb-5 col-12 col-sm-6 col-md-4 col-lg-3">
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
</div>