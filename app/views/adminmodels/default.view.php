<style>
    .modals-table .model-image-logo{
        height: 150px;
    }
</style>
<div class="jumbotron text-center mb-0">
    <h1>Manage Cars models </h1>
    <p> select brand to show models </p>
    <div class="m-auto col-12 col-md-6 ">
        <form>
            <select id="cars" name="cars" class="custom-select">
                <option value="0" selected> Select Brand</option>
                <?php if ($brands !== false): foreach ($brands as $brand): ?>
                <option value="<?= $brand->id ?>"><?= $brand->tittle ?></option>
                <?php endforeach; endif; ?>
            </select>
        </form>
    </div>
</div>
    <div class="card-header d-flex align-items-center ">
        <h3 class="h4 d-inline-block  col-sm-12 col-md-8 ">Brands list </h3>
        <button type="button"  id="newModel" data-id="0" data-toggle="modal" data-target="#Modalcar" class="btn btn-primary col-sm-12 col-md-3" disabled > Add new Model </button>
    </div>

<div class="container-fluid">
    <div class="card-body price_before-center">
        <!-- Modal-->
        <div id="Modalcar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade price_before-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="" class="modal-title title-add">Add new model   </h4>
                        <h4 id="" class="title-update hidden">update  Brand :   </h4>
                        <span class="seleed-brand badge badge-light"></span>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="message-model"></div>
                    <form id="ModalcarForm" method="POST" action="/adminmodels" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label  for="model-name">  Model Name </label>
                                <input name="name" type="text" required class="form-control" id="model-name">
                            </div>
                            <div class="form-group">
                                <label for="model-text">Descrption Model :</label>
                                <textarea name="text" required class="form-control" rows="5" id="model-text"></textarea>
                            </div>
                            <div class="custom-file col-sm-7">
                                <input type="file" class="custom-file-input" name="file" id="customFile">
                                <label  class="custom-file-label" for="customFile" >Model image</label>
                            </div>
                            <br>
                            <input type="hidden" name="marke_id" id="selcted-id" value="0">
                            <div class="progress h-25 mt-3" >
                                <div id="Modalcarbar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><span class="percent">0%</span> </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                            <input type="submit"  value="Submit" class="btn btn-primary">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div class="message-table"></div>

    <div class="d-flex flex-wrap bg-light modals-table row" id="modals-table">
        <div class="p-2 border bg-white col-12 col-sm-6 col-md-4">
            <img src="/public/img/models/model%20(1).png" class="mx-auto d-block img-fluid">
            <h4>Flex item 1</h4>
            <button> <span class="fa fa-edit" ></span> </button>
            <button> <span class="fa fa-trash" ></span> </button>
        </div>
    </div>


    <script>


        var SITEURL = "";
        var form_lastid = 0;
        var isupdate = 0;
        var brand = {id:-1} ;
        var brands = {};
        $(function() {
            $(document).ready(function()
            {
                var brand_id = 0;
                $("#cars").change(function (){
                    id = $(this).val()
                    if (id > 0 ){
                        $("#newModel").removeAttr('disabled' )
                        $(".seleed-brand").text($("#cars option:selected").html());
                        $("#selcted-id").val(id);
                    }else {
                        $("#newModel").attr('disabled' ,'disabled')
                    }
                    if (id != brand_id){
                        $(".modals-table").text("");
                        $.ajax({
                            url:"/apibrand/modelsonly/"+id,
                            conprice_before: document.body
                        }).done(function(rsult) {
                            rsult = JSON.parse(rsult)
                            for(let i in rsult){
                                node ='<div class="p-2 border bg-white col-12 col-sm-6 col-md-4"><img src="' + rsult[i].images + '" class="img-thumbnail model-image-logo" class="mx-auto d-block img-fluid"><h4>' + rsult[i].name + '</h4>\n' +
                                    '<button data-toggle="modal" data-target="#Modalcar" class="btn btn-primary update-brand" data-marke_id="' + rsult[i].marke_id + '" data-id="' + rsult[i].id + '" data-name="' + rsult[i].name + '" data-text="' + rsult[i].text + '"> <span class="fa fa-edit" ></span> </button>\n' +
                                    '            <button data-delete="' + rsult[i].name + '" href=/adminmodels/delete/"' + rsult[i].name + '" class="delete-model btn btn-danger"> <span class="fa fa-trash" ></span> </button>\n' +
                                    '        </div>';
                                $(".modals-table").append(node);
                            }
                        });
                    }
                    brand_id = id;
                });
























                $("#Modalcar").find('.title-update').hide();
                var model = {id:-1 } ;
                $("#Modalcar").on('show.bs.modal' , function (event){
                    btn = $(event.relatedTarget);
                    modal = $(this);
                    form = modal.find('form');
                    id = btn.data('id');
                    if (id == 0 && form_lastid !== 0) {
                        isupdate = 0;
                        modal.find('form').attr('action' , SITEURL + '/adminmodels');
                        modal.find('.title-add').show();
                        modal.find('.title-update').hide();
                        modal.find('form').resetForm();
                        form_lastid = 0;
                        return ;
                    }
                    if (form_lastid !=  id  && id > 0 ){
                        isupdate = 1;
                        if (  id != form_lastid  && model.id != id ){
                            // get product info
                            $.ajax({
                                url:SITEURL+'/apibrand/model/'+id,
                                conprice_before: document.body,
                                async: false,
                                cache: false,
                                timeout: 30000
                            }).done(function(rsult) {
                                model = JSON.parse(rsult);
                                id = model.id;
                                console.log("ajax " + model.title);
                            });
                        }
                        modal.find('form').attr('action' , SITEURL + '/adminmodels/edit/' + id );
                        modal.find('.title-add').hide();
                        modal.find('.title-update').show();
                        modal.find('.title-update span').text(model.tittle);

                        $('#model-name').val(model.name);
                        $('#model-text').val(model.text);

                    }

                    form_lastid =id;
                });


                $(".delete-model").on('click',function (e){
                    e.preventDefault();
                    var node = $(this).parent().parent();
                    url = $(this).attr('href');
                    console.log(url);
                    $.ajax({
                        url:url,
                        conprice_before: document.body
                    }).done(function(rsult) {
                        console.log(rsult)
                        rsult = JSON.parse(rsult);
                        if (rsult.state == 1){
                            $('#allbrands').find("[data-dalete="+ rsult.data.id + " ]").parent().parent().remove();
                            node = '<div class="alert alert-success alert-dismissible fade show" style="z-index: 999;" role="alert">\n' +
                                rsult.message +
                                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>\n' +
                                '</div>';

                            $(".message-table").append(node);
                            setTimeout(function(){$(".alert").alert('close')},2000);

                        }else {

                        }
                    });
                });
                var bar  ;
                var percent ;
                var myruslt ;
                $('#ModalcarForm').ajaxForm({
                    method : $(this).attr('method'),
                    beforeSend: function() {
                        bar = $('#ModalcarForm .progress-bar ');
                        percent = $('#ModalcarForm .percent');
                        var percentVal = '0%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                    },
                    complete: function(ruslt) {
                        console.log(ruslt.responseText)
                        // ruslt = JSON.parse(ruslt.responseText);
                        ruslt = ruslt.responseText;
                        ruslt = JSON.parse(ruslt);
                        var  data = ruslt.data;
                        console.log(ruslt.error)
                        if(ruslt.error.length > 0){
                            mes = "";
                            for ( i in ruslt.error)
                                mes = mes + '*' + ruslt.error[i] + '<br/>' ;
                            node = '<div class="alert alert-warning alert-dismissible fade show" role="alert">\n' +
                                mes +
                                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>\n' +
                                '</div>';
                            $(".message-model").find('.alert').remove();
                            $(".message-model").append(node);
                            setTimeout(function(){$(".alert").alert('close')},1500);

                        }else{
                            modal.find('form').resetForm();
                            $('#Modalcar').modal('toggle');
                            node = '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                                ruslt.message +
                                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>\n' +
                                '</div>';
                            $(".message-model").find('.alert').remove();
                            $(".message-table").append(node);
                            if (isupdate == 1){
                                $('#modals-table').find("[data-delete="+ ruslt.data.id + " ]").parent().parent().remove();
                            }
                            node ='<div class="p-2 border bg-white"><h4>' + ruslt.data.name + '</h4>\n' +
                                '<button data-toggle="modal" data-target="#Modalcar" class="btn btn-primary update-brand" data-marke_id="' + ruslt.data.marke_id + '" data-id="' + ruslt.data.id + '" data-name="' + ruslt.data.name + '" data-text="' + ruslt.data.text + '"> <span class="fa fa-edit" ></span> </button>\n' +
                                '            <button data-delete="' + ruslt.data.id + '" href=/adminmodels/delete/"' + ruslt.data.name + '" class="delete-model btn btn-danger"> <span class="fa fa-trash" ></span> </button>\n' +
                                '        </div>';
                            $(".modals-table").append(node);
                            brand.id = -1;
                            form_lastid = 0;
                            $('#ModalcarForm .progress-bar ').width(0)
                            $('#ModalcarForm .percent').html('0%');
                            setTimeout(function(){$(".alert").alert('close')},2000);

                        }
                    }
                });
            });
        });
    </script>

</div>


