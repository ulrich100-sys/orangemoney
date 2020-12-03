<?php 

require_once("classeInvoice.php");
session_start();

$invoice = new Ynote_Invoice();

if(isset($_GET['id'])){
    $invoiceInfo = $invoice->getInvoiceAction($_GET['id']); 
    $_SESSION['invoice'] = $invoiceInfo;
}else{
    $_SESSION['invoice']=null;
}

?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <title>Broadband - Payez vos factures en ligne</title>
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:800%7CPoppins:300i,300,400,500,600,700,400i,500%7CPlayfair+Display:400,700,900" rel="stylesheet">
    <!-- owl Carousel assets -->
    <link href="assets/css/owl.carousel.css" rel="stylesheet">
    <link href="assets/css/owl.theme.css" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- hover anmation -->
    <link rel="stylesheet" href="assets/css/hover-min.css">
    <!-- Nile icon -->
    <link rel="stylesheet" href="assets/css/nile_icons.css">
    <!-- main style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/colors/main.css">
    <!-- Nile Slider -->
    <link rel="stylesheet" href="assets/css/nile-slider.css">
    <!-- elegant icon -->
    <link rel="stylesheet" href="assets/css/elegant_icon.css">
    <!-- animate -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- fontawesome  -->
    <link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">
            <!-- Fancy Box CSS File -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">

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
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            <a id="logo" href="index.html" class="d-inline-block flex-center"><img src="assets/img/logo-final-cm-inline.png" alt=""></a>
                            <a class="mobile-toggle padding-15px background-main-color border-radius-3" href="#"><i class="fa fa-bars"></i></a>
                        </div>
                        <div class="col-xl-7 col-lg-9 col-md-12 position-inherit">

                            <ul id="menu-main" class="nav-menu flex-center float-xl-right text-lg-center link-padding-tb-18px dropdown-light">
                                <li><a href="https://www.broadband.cm/">Accueil</a></li>
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
            <h1>Votre facture est payée</h1>
        </div>
    </div>



    <section class="padding-tb-120px section-ba-2">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <h2>Vos fonds sont en cours de transfert</h2>
                <p>
                    Nous vous enverrons un mail dès réception de votre paiement
                </p>

<p>
                        <label><strong>Nom Client : </strong></label>
                        <?php echo $_SESSION['invoice']["nomClient"]; ?>
<input type="hidden" name="invoiceNom" id="invoiceNom" value="<?php echo $_SESSION['invoice']["nomClient"] ?>"/>
                    </p>
                    <p>
                        <label><strong>Numéro Facture : </strong></label>
                        <?php echo $_SESSION['invoice']["invoiceNumber"]; ?>
<input type="hidden" name="invoiceNumber" id="invoiceNumber" value="<?php echo $_GET['id']; ?>"/>
                    </p>

                    <p>
                        <label><strong>Montant à régler : </strong></label>
                        <?php echo number_format ($_SESSION['invoice']["montant"], 0, ',', ' '); ?>
                        <input type="hidden" name="amount" id="invoiceAmount" value="<?php echo $_SESSION['invoice']["montant"] ?>"/>
                    </p>
            </div>
            </div>
        </div>

    </section>





    <!-- preloader -->
    <div class="nile-preloader">
        <div class="logo">
            <img src="assets/img/loading-1.svg" alt="">
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
                            <img src="assets/img/logo-final-cm-inline.png" alt="">
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
                <div class="image"><img src="assets/img/logo-final-cm-inline.png" alt=""></div>

                <div class="text-about margin-tb-25px">
                    Broadband est la nouvelle marque dédiée aux solutions par satellite pour télétravailleur et entreprise : vitesse 5 mégas illimité à partir de 185 000 F HT / mois
                </div>
            </div>
        </div>


        <div class="nile-widget layout-1 niletheme_contact_widget">
            <h2 class="title">Contactez nous</h2>
            <p><label>Email : </label> <a href="mailto:contact@broadband.cm">contact@broadband.cm</a>
            </p>
            <p><label>Téléphone : </label> 6 99 41 73 83</p>
        </div>


    </div>

    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/scrolla.jquery.min.js"></script>
    <script src="assets/js/YouTubePopUp.jquery.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/imagesloaded.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/imagesloaded.min.js"></script>
    <script src="assets/js/jquery.filterizr.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
        <!-- Fancy Box JS File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/custom-0.0.5.js"></script>
</body>

</html>
