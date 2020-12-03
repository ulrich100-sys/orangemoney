/* Global jQuery */

/* Contents
// --------------------------------------------- -->
     1. wow animation
     2. Menu Mobile
     3. Cart
     4. Search
     5. Owl Slider
     6. Light Box
     7. Fixed Header
*/

(function ($) {
    "use strict";

    /* ------------------  2. Menu Mobile ------------------ */
    var $menu_show = $('.mobile-toggle'),
        $menu = $('header #menu-main'),
        $onepage_menu = $('header a.onepage-mobile-toggle'),
        $onepage_sidebare = $('.fizo-one-page #onpage-sidebar-mobile'),
        $menu_yoga = $('header .yoga-menu'),
        $list = $("ul.nav-menu li a"),
        $list_firo = $("ul.firo-nav-menu li a"),
        $menu_list_firo = $('ul.firo-nav-menu li.has-dropdown'),
        $menu_list = $('header li.has-dropdown'),
        $menu_ul = $('ul.sub-menu'),
        $cart_model = $('.cart-model'),
        $cart_link = $('#cart-link'),
        $search_bar = $('#search_bar'),
        $search_close = $('.close-search'),
        $search_bot = $('#search-header'),
        $fixed_header = $('#fixed-header'),
        $fixed_header_dark = $('#fixed-header-dark'),
        $fixed_header_light = $('#fixed-header-light');

    $menu_show.on("click", function (e) {
        $menu.slideToggle();
        $menu_yoga.slideToggle();
    });
    $onepage_menu.on("click", function (e) {
        $onepage_sidebare.slideToggle();
    });

    $(".fizo-one-page #onpage-sidebar-mobile ul.fizo-sidebar-menu li a").mouseup(function () {
        $onepage_sidebare.slideToggle();
    });



    $list.on("click", function (event) {
        var submenu = this.parentNode.getElementsByTagName("ul").item(0);
        if (submenu != null) {
            event.preventDefault();
            $(submenu).slideToggle();
        }
    });

    $list_firo.on("click", function (e) {
        var submenu = this.parentNode.getElementsByTagName("ul").item(0);
        if (submenu != null) {
            event.preventDefault();
            $(submenu).slideToggle();
        }
    });

    /*==============================
    Loading
    ==============================*/

    $(window).on('load', function () {
        $('body').imagesLoaded(function () {
            $('.nile-preloader').fadeOut();
        });
    });

    /*==============================
    Animation
    ==============================*/
    $('.animate').scrolla({
        once: true, // only once animation play on scroll
        mobile: false, // disable animation on mobiles 
    });


    /*-------------------  Firo Menu  --------------- */
    var $firo_menu = $('#firo-menu'),
        $open_firo_menu = $('.sidebar-menu-toggle'),
        $close_firo_menu = $('.close-firo-menu');

    $close_firo_menu.on("click", function (e) {
        $firo_menu.slideUp();
    });
    $open_firo_menu.on("click", function (e) {
        $firo_menu.slideDown();
    });



    /* ------------------  3. Cart ------------------ */
    $cart_link.on("click", function (e) {
        $cart_model.slideToggle("fast");
    });

    $(window).on("click", function (e) {
        $cart_model.hide("fast");
    });
    $cart_link.on("click", function (e) {
        event.stopPropagation();
    });





    /* ------------------  4. Search ------------------ */
    $search_bot.on("click", function (e) {
        $search_bar.slideToggle("fast");
    });
    $search_close.on("click", function (e) {
        $search_bar.hide("fast");
    });




    /* ------------------  5.Owl Slider ------------------ */
    var icon_slider = $(".icons-slider");
    var portfolio_slider = $(".portfolio-home-slider");
    var work_slider_1 = $(".work-slider-1");
    var testimonial_slider = $(".testimonial-slider");
    var testimonial_slider_2 = $(".testimonial-slider-2");
    var client_slider = $(".fizo-client-slider");
    var about_slider = $(".about-slider");
    var text_slider = $(".text-slider");
    var fizo_blog_slider = $(".fizo-blog-slider");


    icon_slider.owlCarousel({
        slideSpeed: 1000,
        autoplay: true,
        autoplayTimeout: 1000,
        loop: true,
        nav: false,
        margin: 40,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    portfolio_slider.owlCarousel({
        slideSpeed: 1000,
        autoPlay: true,
        loop: true,
        nav: true,
        dots: true,
        navText: ["<span class='arrow_carrot-left box-shadow'></span>", "<span class='arrow_carrot-right box-shadow'></span>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    testimonial_slider.owlCarousel({
        slideSpeed: 1000,
        autoPlay: true,
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    fizo_blog_slider.owlCarousel({
        slideSpeed: 1000,
        autoPlay: true,
        loop: true,
        margin: 30,
        nav: true,
        dots: true,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    testimonial_slider_2.owlCarousel({
        slideSpeed: 1000,
        autoPlay: true,
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    about_slider.owlCarousel({
        slideSpeed: 1000,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        loop: true,
        nav: true,
        dots: true,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    text_slider.owlCarousel({
        slideSpeed: 1500,
        autoplay: true,
        autoplayTimeout: 3500,
        autoplayHoverPause: true,
        loop: true,
        nav: false,
        dots: false,
        animateOut: 'slideOutUp',
        animateIn: 'slideInUp',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    work_slider_1.owlCarousel({
        slideSpeed: 1000,
        autoPlay: true,
        center: true,
        items: 1,
        loop: true,
        margin: 0,
        dots: false,
        responsive: {
            600: {
                items: 4
            }
        }
    });

    client_slider.owlCarousel({
        slideSpeed: 1000,
        autoPlay: true,
        loop: true,
        nav: false,
        dots: false,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 6
            }
        }
    });


    /* ------------------  Darmail Sidebar ------------------ */
    var $sidebar_bottom = $(".sidebar-var-link"),
        $body = $("body"),
        $close_sidebar = $(".close-nile-sidebar"),
        $sidebar_in = $(".nile-sidebar");
    $sidebar_bottom.on("click", function (e) {
        $sidebar_in.addClass("open");
        $close_sidebar.addClass("open");
        $body.css('overflow', 'hidden');
    });

    $close_sidebar.on("click", function (e) {
        $sidebar_in.removeClass("open");
        $(this).removeClass("open");
        $body.css('overflow', 'auto');
    });



    /* ------------------  6. Light Box ------------------ */
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });




    /* ------------------  7. Fixed Header ------------------ */
    $(window).on("scroll", function () {
        if ($(window).scrollTop() >= 50) {
            $fixed_header.addClass('fixed-header');
            $fixed_header_dark.addClass('fixed-header-dark');
            $fixed_header_light.addClass('fixed-header-light');
        } else {
            $fixed_header.removeClass('fixed-header');
            $fixed_header_dark.removeClass('fixed-header-dark');
            $fixed_header_light.removeClass('fixed-header-light');
        }
    });

    $('a[href="#search"]').on("click", function (event) {
        event.preventDefault();
        $("#search").addClass("open");
        $('#search > form > input[type="search"]').focus();
    });

    $("#search, #search button.close").on("click keyup", function (event) {
        if (
            event.target == this ||
            event.target.className == "close" ||
            event.keyCode == 27
        ) {
            $(this).removeClass("open");
        }
    });


    /* ------------------  Filtr Container ------------------ */
    if ($(".filtr-container")[0]) {
        var $container_in = $('.filtr-container');

        if (typeof $('.filtr-container').filterizr === "function") {
            $container_in.imagesLoaded(function () {
                var filterizd = $('.filtr-container').filterizr({    //options object
                });
            });
        }
    }

    /* ------------------  Scroll ------------------ */
    $('a[href^="#"]').bind('click.smoothscroll', function (e) {
        e.preventDefault();
        var target = this.hash,
            $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - 40
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });



    /*==============================================================
    // Animate the scroll to top
    ==============================================================*/
    $(window).on('scroll', function (e) {
        if ($(this).scrollTop() > 200) {
            $('.go-top').fadeIn(200);
        } else {
            $('.go-top').fadeOut(200);
        }
    });


    $('.go-top').on("click", function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0
        }, 300);
    })

    /**************
     Sticky Sidebar 
    **************/
    if ($(".sticky-content")[0]) {
        var $sticky_content = $('.sticky-content'),
            $sticky_sidebar = $('.sticky-sidebar');

        $sticky_content.theiaStickySidebar({
            additionalMarginTop: 30
        });
        $sticky_sidebar.theiaStickySidebar({
            additionalMarginTop: 30
        });
    }



    $("#formFacture").submit(function(e){

        console.log($("#InputNom").val());
        $("#formFacture").validate();
        if($("#InputNom").val()==""){
            var contentFancy = "Le formulaire n'est pas conforme, merci de corriger";
            $.fancybox.open('<div>'+contentFancy+'</div>');
            return false;
        }

            e.preventDefault();

            $("#saveFactureButton").html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Chargement...').addClass('disabled');


            $.post("save-invoice.php",
                {
                    nom: $("#InputNom").val(),
                    email: $("#InputEmail1").val(),
                    tel: $("#InputTel").val(),
                    invoice: $("#InputInvoice").val(),
                    amount: $("#InputAmount").val(),
                    mail: $("#mailCheck").is(":checked"),
                }, function(data, status){
                console.log(data)
                console.log(data.data);
                $("#saveFactureButton").html('Enregistrer le réglement').removeClass('disabled');
                $.fancybox.close();
                if(data.error!=undefined){
                    var contentFancy = "Erreur dans votre formulaire.";
                }else{
                    var contentFancy = "<h3>La facture a été enregistrée</h3>";
                    contentFancy += "Voici le lien à communiquer à votre client : <br/>";
                    var lienFancy = "https://www.y-note.cm/facture/paie-facture.php?id="+data.data.codeInvoice;
                    contentFancy += "<a href='"+lienFancy+"' target=='_blank'>"+lienFancy+"</a><br/>"; 
                    contentFancy += "<img src='./qrcode/"+data.data.codeInvoice+".png' />"; 
                       
                }
                $.fancybox.open('<div>'+contentFancy+'</div>');
                $("#InputNom").val("");
                $("#InputEmail1").val("");
                $("#InputTel").val("");
                $("#InputInvoice").val("");
                $("#InputAmount").val("");

            });
        });


    $("#paiementOrangeMoney").submit(function(e){

        e.preventDefault();
        $("#paiementOrangeMoney").validate();
        if($("#orangeTel").val()==""){
            var contentFancy = "Le formulaire n'est pas conforme, merci de corriger";
            $.fancybox.open('<div>'+contentFancy+'</div>');
            return false;
        }

        

        $("#submitOrangeForm").html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Chargement...').addClass('disabled');


        $.post("paiement-interneOM.php",
            {
                Nom: $("#invoiceNom").val(),
                NumberInvoice: $("#invoiceNumber").val(),
                Tel: $("#orangeTel").val(),
                amount: $("#invoiceAmount").val(),
            }, function(data, status){
            console.log(data)
            $("#submitOrangeForm").html('Payer').removeClass('disabled');
            if(data==null){
                $.fancybox.open('<div"><h2>Erreur</h2>Vérifier les éléments de votre formulaire</div>');
            }else{
                if(data.status=="PENDING"){
                    $.fancybox.close();
                    $.fancybox.open('<div>Vous avez reçu les éléments de paiement sur ce numéro de téléphone<br/>Après votre paiement, vous recevrez un <strong>mail de confirmation</strong>.</div>');
                    console.log("Confirmer");
                }
                if(data.status=="FAILED"){
                    $.fancybox.open('<div"><h2>Erreur</h2>Vérifier les éléments de votre formulaire</div>');
                    console.log("Erreur");
                }
            }
        });
    });

    $("#paiementYup").submit(function(e){

        e.preventDefault();
        $("#paiementYup").validate();
        if($("#yupTel").val()==""){
            var contentFancy = "Le formulaire n'est pas conforme, merci de corriger";
            $.fancybox.open('<div>'+contentFancy+'</div>');
            return false;
        }

        

        $("#submitYupForm").html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Chargement...').addClass('disabled');


        $.post("paiement-interneYup.php",
            {
                Nom: $("#invoiceNom").val(),
                NumberInvoice: $("#invoiceNumber").val(),
                Tel: $("#yupTel").val(),
                amount: $("#invoiceAmount").val(),
            }, function(data, status){
            console.log(data)
            console.log(data.data);
            $("#paiementYup").attr("action", "https://" + data.tagPayUrl+".tagpay.fr/api/online");
            $("#submitYupForm").html('Payer').removeClass('disabled');
            $("#merchandIdYup").val(data.merchantid);
            $("#refYup").val(data.refYup+"-"+data.refid);
            $("#sessionIdYup").val(data.session);

            // Execute default action
            setTimeout(() => {  console.log("World!"); }, 10000);
            e.currentTarget.submit();

        });
    });

     // Create an instance of the Stripe object with your publishable API key
      var stripe = Stripe('pk_test_Z6FagYK4bwAvwmI91KeooA6I');
      var checkoutButton = document.getElementById('submitStripeForm');

      var stripeFormElment = {
        Nom: $("#invoiceNom").val(),
        invoiceNum: $("#numFacture").val(),
        purchaseref: $("#purchaseref").val(),
        amount: $("#invoiceAmount").val(),
        emailFacture: $("#emailFacture").val()
      };

      if($("#invoiceAmount").val()<0.5*655.957){
        $("#submitStripeForm").html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Impossible de payer ce montant par Carte').addClass('disabled');
      }

      checkoutButton.addEventListener('click', function(e) {
        e.preventDefault();
        $("#submitStripeForm").html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Chargement...').addClass('disabled');
        // Create a new Checkout Session using the server-side endpoint you
        // created in step 3.
        fetch('./paiement-interneStripe.php', {
          method: 'POST',
          body: JSON.stringify(stripeFormElment)
        })
        .then(function(response) {
          return response.json();
        })
        .then(function(session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function(result) {
          // If `redirectToCheckout` fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using `error.message`.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function(error) {
          console.error('Error:', error);
        });
      });

}(jQuery));
