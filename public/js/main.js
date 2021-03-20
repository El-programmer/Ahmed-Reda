$(document).ready(function () {
    $('.owl-carousel-markes-index').owlCarousel({
        items:5,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:1000,
        autoplayHoverPause:true
    });

    $('.owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 1000,
        autoplayHoverPause: true
    });
    //
    // $('.owl-carousel-markes').owlCarousel({
    //     items: 5,
    //     loop: true,
    //     margin: 10,
    //     autoplay: true,
    //     autoplayTimeout: 1000,
    //     autoplayHoverPause: true
    // });
// $('.play').on('click',function(){
//     owl.trigger('play.owl.autoplay',[1000])
// })
// $('.stop').on('click',function(){
//     owl.trigger('stop.owl.autoplay')
// });


    $(".toglle-form").on('click', function (e) {
        e.preventDefault();
        $(".sin-in").toggle(1000);
        $(".log-in").toggle(1000);
        $(".log-message").hide(1000);

    });
    $('.log-form').ajaxForm({
        method: 'post',
        beforeSend: function () {
            $(".log-message").hide(1000);
            $(".log-message").removeClass("text-danger");
            $(".log-message").removeClass("text-success");
            $(".log-form btn").attr('disabled')
        }, complete: function (ruslt) {
            ruslt = ruslt.responseText;
            ruslt = JSON.parse(ruslt);
            error = "";
            if (ruslt.state == 1) {
                $(".log-message").addClass("text-success");
                window.location = "/";
            } else {
                $(".log-form btn").removeAttr('disabled');
                $(".log-message").addClass("text-danger");
                if (ruslt.error.length > 0) {
                    for (i in ruslt.error) {
                        error += "<p> * " + ruslt.error[i] + " </p>";
                    }
                }
                ruslt.message = error;
            }
            $(".log-message").html(ruslt.message);
            $(".log-message").toggle()
        }
    });


    var brand_id = 0 ;
    var brand_name = "";
    var model_id = 0;
    var model_name = 0;
    $(".back-arrow").on('click',function (e){
        $(".layer-2").addClass("d-none").fadeIn(300).delay(1000)
        // show loder
        $(".layer-1").removeClass("d-none").fadeIn(300).delay(1000)

    });
    $(".chosse-car-brand").on('click',function (e){
        id = $(this).data('brand-id');
        brand_name = $(this).find('img').attr('alt');
        console.log(id);
        $(".layer-1").addClass("d-none").fadeIn(300).delay(1000)
        // show loder
        $(".layer-2").removeClass("d-none").fadeIn(300).delay(1000)

        $(".layer-1").show().delay(1000)
        if (id != brand_id){
            $(".layer-2 .row").text("");
            $.ajax({
                url:"/apibrand/modelsonly/"+id,
                conprice_before: document.body
            }).done(function(rsult) {
                rsult = JSON.parse(rsult)
                for(let i in rsult){
                    node = '<div class="col-12 col-sm-6 col-md-4 text-center mb-2 chosse-model-brand" data-model-id="' + rsult[i].id + '"><button type="button" class="btn btn-lg btn-outline-warning w-100">' +
                        '<img src="' + rsult[i].images + '" class="img-thumbnail model-image-logo" class="mx-auto d-block img-fluid" alt="' + rsult[i].text + '"></button>' +
                        '' + rsult[i].name + '</div>';
                    $(".layer-2 .row").append(node);
                }
            });
        }
        brand_id = id;
    });


    $(document).on('click' , ".chosse-model-brand" ,function (e){
        model_id = $(this).data('model-id');
        model_name = $(this).text().replaceAll(" " ,'-' );
        brand_name.replaceAll(" " ,'-' );
        window.location = "/brand/showmodel/"+model_id+"/"+model_name;

    });


});