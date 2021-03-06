<legend class="text-center"><?= $text_legend ?></legend>
<div id="error" style="display: none">
    <div class="alert alert-danger">
        <strong><?= $text_error ?> </strong> <?= $text_error_text ?>
    </div>
</div>
<div class="clearfix"></div>
<div class="bill-info ">

    <div class="  input_wrapper col-xs-4 col-sm-3">
        <?= $text_bill ?> <span><?= $id ?></span>
    </div>

    <div class="  input_wrapper col-xs-4 col-sm-3 ">  <?= date("Y-m-d") . " , " . date("h:i") ?> </div>
    <div class="input_wrapper col-xs-4 col-sm-3 ">
        <select style="width:100%" id="suppliertype">
            <option value="0" selected> exist</option>
            <option value="1"> new</option>
        </select>
    </div>
</div>
<script>
    $('#suppliertype').change(function () {
        console.log("ss");
        $(".existSupplier").toggle();
        $(".newSupplier").toggle();
        if ($("#suppliertype").val() == 0) {
            suplier = 0;
            $("#suppliername").val('');
        } else {
            $("#newSupplier").val('');
        }

    });
</script>
<div class="existSupplier  input_wrapper col-xs-12 col-sm-3 ">
    <label><?= $text_client_Name ?></label>
    <input type="Name" id="suppliername" maxlength="50" style="width: 80%">
    <ul id="suplierslist" class="list-group searchlist col-xs-12 col-sm-4 ">
        <?php if (false !== $supliers): foreach ($supliers as $suplier): ?>
            <li class="list-group-item" onclick="setSuplier(<?= $suplier->SupplierId ?>)">
                <span><?= $suplier->Name ?></span></li>
        <?php endforeach;endif; ?>
    </ul>
</div>
<div class="newSupplier  input_wrapper col-xs-12 col-sm-3 " style="display:none">
    <label><?= $text_client_Name ?></label>
    <input type="Name" id="newSupplier" maxlength="50" style="width: 80%">
</div>

<div class="clearfix"></div>

<div class="clearfix  row bill">
    <div class="col-xs-4 col-sm-2">
        <input placeholder="<?= $text_code ?>" id="Productcode">
        <ul id="Productscodes" class="list-group searchlist col-xs-12">
            <?php if (false !== $Products): foreach ($Products as $Product): ?>
                <li class="list-group-item" onclick="setProduct(<?= $Product->ProductId ?>)">
                    <span><?= $Product->ProductId ?></span>
                </li>
            <?php endforeach;endif; ?>
        </ul>
    </div>
    <div class="col-xs-4 col-sm-2">
        <input placeholder="<?= $text_name ?>" id="Productname">
        <ul id="Productsnames" class="list-group searchlist col-xs-12">
            <?php if (false !== $Products): foreach ($Products as $Product): ?>
                <li class="list-group-item" onclick="setProduct(<?= $Product->ProductId ?>)">
                    <span><?= $Product->Name ?></span>
                </li>
            <?php endforeach;endif; ?>
        </ul>
    </div>
    <div class="col-xs-4 col-sm-2"><input placeholder="<?= $text_priceone ?>" id="priceone"></div>
    <div class="col-xs-4 col-sm-2"><input placeholder="<?= $text_quentity ?>" id="quentity"></div>
    <div class="col-xs-4 col-sm-2"><input placeholder="<?= $text_price ?>" id="price" readonly></div>
    <div class="col-xs-4 col-sm-2"><input class="btn-success" type="button" readonly id="addproduct"
                                          value="<?= $text_add ?>"></div>
</div>

<br><br><br>
<table class="table table-bordered table-responsive">
    <thead>
    <tr>
        <th><?= $text_code ?></th>
        <th><?= $text_name ?></th>
        <th><?= $text_priceone ?></th>
        <th><?= $text_quentity ?></th>
        <th><?= $text_price ?></th>
    </tr>
    </thead>
    <tbody id="mytable">

    </tbody>
</table>


<br><br><br>

<div class="clearfix"></div>
<div class="row info">
    <div class="col-xs-2" style="float: right"><?= $text_old_babnce ?></div>
    <div class="col-xs-2" style="float: right" id="oldbalance"></div>
    <div class="col-xs-2" style="float: right"><?= $text_bill_price ?></div>
    <div class="col-xs-2" style="float: right" id="bill"></div>
    <div class="col-xs-2" style="float: right"><?= $text_total ?></div>
    <div class="col-xs-2" style="float: right" id="total"></div>

    <div class="col-xs-2" style="float: right"><?= $text_payed ?></div>
    <div class="col-xs-3" style="float: right;padding: 0">
        <input min="0" placeholder="0" type="number" value="0" id="payed"
               style="width: 100%;height: 100%;padding-right:10px;">
    </div>
    <div class="col-xs-2" style="float: right"><?= $text_new_balnce ?></div>
    <div class="col-xs-3" style="float: right" id="newbalance"></div>

    <button class="col-xs-2 btn btn-success" id="finsh-bill" style="float: right;height: 35px;"><?= $text_finsh ?>
    </button>

</div>