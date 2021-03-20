<div class="jumbotron text-center mb-0">
    <h1>Manage Cars </h1>
    <p></p>
</div>
<div class="container">
    <div class="card-header d-flex align-items-center ">
        <h3 class="h4 d-inline-block  col-sm-12 col-md-8 ">Brands list </h3>
        <button type="button"  data-id="0" data-toggle="modal" data-target="#brandModal" class="btn btn-primary col-sm-12 col-md-3"> Add new Brand </button>
    </div>

    <div class="card-body price_before-center">
        <!-- Modal-->
        <div id="brandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade price_before-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="" class="modal-title title-add">Enter new Brand </h4>
                        <h4 id="" class="title-update hidden">update  Brand :  <span></span> . </h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="message-model"></div>
                    <form id="brandModalForm" method="POST" action="/admincars" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label  for="brand-title"> title brand </label>
                                <input name="title" type="text" required class="form-control" id="brand-title">
                            </div>
                            <div class="form-group">
                                <label for="brand-text">Descrption Brand :</label>
                                <textarea name="text" required class="form-control" rows="5" id="brand-text"></textarea>
                            </div>
                            <div class="custom-file col-sm-7">
                                <input type="file" class="custom-file-input" name="file" id="customFile">
                                <label  class="custom-file-label" for="customFile" >Brand logo</label>
                            </div>
                            <br>
                            <div class="progress h-25 mt-3" >
                                <div id="brandModalbar" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><span class="percent">0%</span> </div>
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
    <div class="allbrands row" id="allbrands">
        <?php if ($brands !== false): foreach ($brands as $brand): ?>
            <div class="card col-12 col-sm-6 col-md-3 col-lg-2">
                <img class="card-img-top" src="<?= $brand->image ?>" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title"><?= $brand->tittle ?></h4>
                    <p class="card-text">
                    </p>
                    <a href="#" class="btn btn-primary">See Profile</a>
                    <button type="button"
                            data-id="<?= $brand->id ?>" data-tittle="<?= $brand->tittle ?>" data-text="<?= $brand->text ?>"  data-toggle="modal" data-target="#brandModal" class="btn btn-primary update-brand">  Edit </button>
                    <button type="button" data-dalete="<?= $brand->id ?>"  href="/admincars/delete/<?= $brand->id ?>" class="btn btn-danger delete-brand"> Delete </button>

                </div>
            </div>
            <?php endforeach; endif; ?>
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
                $("#brandModal").find('.title-update').hide();
                $("#brandModal").on('show.bs.modal' , function (event){
                    btn = $(event.relatedTarget);
                    modal = $(this);
                    form = modal.find('form');
                    id = btn.data('id');
                    if (id == 0 && form_lastid !== 0) {
                        isupdate = 0;
                        modal.find('form').attr('action' , SITEURL + '/admincars');
                        modal.find('.title-add').show();
                        modal.find('.title-update').hide();
                        modal.find('form').resetForm();
                        form_lastid = 0;
                        return ;
                    }
                    if (form_lastid !=  id  && id > 0 ){
                        isupdate = 1;
                        modal.find('form').attr('action' , SITEURL + '/admincars/edit/' + id );
                        modal.find('.title-add').hide();
                        modal.find('.title-update').show();
                        modal.find('.title-update span').text(btn.data('tittle'));
                        $('#brand-title').val(btn.data('tittle'));
                        $('#brand-text').val(btn.data('text'));

                    }

                    form_lastid =id;
                });


                $(".delete-brand").on('click',function (e){
                    e.preventDefault();
                    var node = $(this).parent().parent();
                    url = $(this).attr('href');
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
                $('#brandModalForm').ajaxForm({
                    method : $(this).attr('method'),
                    beforeSend: function() {
                        bar = $('#brandModalForm .progress-bar ');
                        percent = $('#brandModalForm .percent');
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
                            mes = ""; // ['title', 'price_before' , 'quantity' , 'price' , 'sizes' ,'category_id' , 'images' ]
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
                            $('#brandModal').modal('toggle');
                            node = '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                                ruslt.message +
                                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                '    <span aria-hidden="true">&times;</span>\n' +
                                '  </button>\n' +
                                '</div>';
                            $(".message-model").find('.alert').remove();
                            $(".message-table").append(node);
                            if (isupdate == 1){
                                $('#allbrands').find("[data-dalete="+ ruslt.data.id + " ]").parent().parent().remove();
                            }
                            node = '<div class="card col-12 col-sm-6 col-md-3 col-lg-2"><img class="card-img-top" src="'+ ruslt.data.image +
                                '" alt="'+ ruslt.data.tittle +'"><div class="card-body"><h4 class="card-title">'+ruslt.data.tittle +
                                ' </h4><p class="card-text"></p><a href="#" class="btn btn-primary">See Profile</a><button type="button"' +
                                'data-id="'+ ruslt.data.id +'" data-tittle="'+ruslt.data.tittle+'" data-text="'+ruslt.data.text +'"  data-toggle="modal" '+
                                ' data-target="#brandModal" class="btn btn-primary update-brand">  Edit </button><button type="button"   href="/admincars/delete/'+
                                '" class="btn btn-danger delete-brand" data-dalete="'+ruslt.data.id+'"> Delete </button></div></div>'
                            $("#allbrands").append(node);

                            brand.id = -1;
                            form_lastid = 0;
                            $('#brandModalForm .progress-bar ').width(0)
                            $('#brandModalForm .percent').html('0%');
                            setTimeout(function(){$(".alert").alert('close')},2000);

                        }
                    }
                });
            });
        });
        function showmessage (message , type){
            node = '<div class="alert alert-success alert-dismissible fade show"  role="alert">\n' +
                message  +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '    <span aria-hidden="true">&times;</span>\n' +
                '  </button>\n' +
                '</div>';

        }
    </script>

</div>


