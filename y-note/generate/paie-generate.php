<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <title>Y-Note - Payez vos factures en ligne</title>
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:800%7CPoppins:300i,300,400,500,600,700,400i,500%7CPlayfair+Display:400,700,900" rel="stylesheet">
    <!-- owl Carousel assets -->
    <link href="../assets/css/owl.carousel.css" rel="stylesheet">
    <link href="../assets/css/owl.theme.css" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- hover anmation -->
    <link rel="stylesheet" href="../assets/css/hover-min.css">
    <!-- Nile icon -->
    <link rel="stylesheet" href="../assets/css/nile_icons.css">
    <!-- main style -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/colors/main.css">
    <!-- Nile Slider -->
    <link rel="stylesheet" href="../assets/css/nile-slider.css">
    <!-- elegant icon -->
    <link rel="stylesheet" href="../assets/css/elegant_icon.css">
    <!-- animate -->
    <link rel="stylesheet" href="../assets/css/animate.css">
    <!-- fontawesome  -->
    <link rel="stylesheet" href="../assets/fonts/font-awesome/css/font-awesome.min.css">
        <!-- Fancy Box CSS File -->
    <link rel="stylesheet" href="../assets/css/jquery.fancybox.min.css">

</head>

<body>


    <!--  HEADER  -->
    <header>

        <div class="up-header background-main-color light d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                     
                    </div>
                    <div class="col-lg-4">
                        <div class="welcome-mas"></div>
                    </div>
                    <div class="col-lg-4">
                        <!--  Social -->
                        <ul class="social-media list-inline text-lg-right text-center text-white">
                            <li><a class="facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a class="linkedin" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a class="twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                        <!-- // Social -->
                    </div>
                </div>
            </div>
        </div>

        <div class="header-output">
            <div class="container header-in">
                <div class="position-relative">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12" id="header-logo">
                            <a id="logo" href="index.html" class="d-inline-block flex-center"><img src="https://www.y-note.cm/wp-content/uploads/2020/11/Logo-y-note-black.png" alt=""></a>
                            <a class="mobile-toggle padding-15px background-main-color border-radius-3" href="#"><i class="fa fa-bars"></i></a>
                        </div>
                        <div class="col-xl-7 col-lg-9 col-md-12 position-inherit">

                            <ul id="menu-main" class="nav-menu flex-center float-xl-right text-lg-center link-padding-tb-18px dropdown-light">
                                <li><a href="https://www.y-note.cm/">Accueil</a></li>
                            </ul>

                        </div>
                        <div class="col-lg-2 col-md-12  d-none d-lg-block text-right">
                            <div class="d-none padding-top-4px flex-center d-xl-block search-link pull-right model-link sidebar-var-link">
                                <a id="sidebar-var" class="model-link margin-right-0px text-dark opacity-hover-8" href="#nav">
                                    <i class="fa fa-th-large"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- // HEADER  -->


    <div class="nile-page-title">
        <div class="container">
            <h1>Enregistrement réglement client</h1>
        </div>
    </div>



    <section class="padding-tb-50px section-ba-2">

        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <form method="POST" id="formFacture">
                      <div class="form-group row">
                        <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Nom du Client</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="InputNom" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Email Client</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="InputEmail1" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail1" class="col-sm-2 col-form-label">N° Téléphone Client</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" id="InputTel" minlength="9">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Numéro de Facture</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="InputInvoice" value="FAC-" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Montant à régler</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="InputAmount" minlength="2" value="40000" required>
                        </div>
                      </div>
                      <div class="form-group row">
                          <input class="form-check-input" type="checkbox" id="mailCheck">
                          <label class="form-check-label" for="gridCheck" class="col-sm-10 col-form-label">
                            Envoyer le mail au client
                          </label>
                      </div>
                      <button type="submit" id="saveFactureButton" class="btn btn-lg btn-block btn-success">Enregistrer le réglement</button>
                    </form>
                </div>

            </div>
        </div>

    </section>





    <!-- preloader -->
    <div class="nile-preloader">
        <div class="logo">
            <img src="../assets/img/loading-1.svg" alt="">
        </div>
    </div>
    <!-- end preloader -->

    <a class="go-top box-shadow background-second-color"><span class="arrow_carrot-up"></span></a>



    <footer class="layout-1">
        <div class="container">
            <div class="row">

                <div class="col-lg-3">
                    <div class="nile-widget about-me-widget">
                        <div class="logo-in">
                            <img src="https://www.y-note.cm/wp-content/uploads/2020/11/Logo-y-note-black.png" alt="">
                        </div>
                        <div class="content">
                            © 2020 Broadband. All Rights Reserved. Conception <a href="https://www.y-note.cm">Y-Note</a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3">
                   
                </div>
                <div class="col-lg-3">
                    
                </div>
                <div class="col-lg-3">
                    <div class="nile-widget widget_nav_menu">
                        <ul class="footer-menu">
                            <li><a href="#">Accueil</a></li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </footer>
    <div class="close-nile-sidebar"></div>

    <div id="nile-sidebar" class="nile-sidebar widget-area nile-widget-area">

        <div class="nile-widget about-me-widget">
            <div class="about-me">
                <div class="image"><img src="https://www.y-note.cm/wp-content/uploads/2016/12/logo.png" alt=""></div>

                <div class="text-about margin-tb-25px">
                   Y-Note est une Société de Service Informatique spécialisée dans la digitalisation des processus des entreprises
                </div>
            </div>
        </div>


        <div class="nile-widget layout-1 niletheme_contact_widget">
            <h2 class="title">Contactez nous</h2>
            <p><label>Email : </label> <a href="mailto:contact@y-note.cm">contact@y-note.cm</a>
            </p>
            <p><label>Téléphone : </label> 243 52 52 31</p>
        </div>


    </div>

    <script src="../assets/js/jquery-3.2.1.min.js"></script>
    <script src="../assets/js/scrolla.jquery.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/imagesloaded.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/imagesloaded.min.js"></script>
    <!-- Fancy Box JS File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="../assets/js/jquery.fancybox.min.js"></script>
    <script src="../assets/js/custom-0.0.7.js"></script>
</body>

</html>
