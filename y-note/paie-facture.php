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

if(($_SESSION['invoice']!=null)&&($_SESSION['invoice']['idOrder'])){
    $_SESSION['invoice']=null;
}

require_once("html/header.php");

?>




    <div class="nile-page-title">
        <div class="container">
            <?php 

            if($_SESSION['invoice']==""){
            ?>
                <h1>Votre facture est déjà réglée</h1>
            <?php       
            }else{
            ?>
                <h1>Réglez votre facture</h1>
            <?php 
                }
            ?>
        </div>
    </div>



    <section class="padding-tb-120px section-ba-2">
        
        <div class="container">
            <?php if($_SESSION['invoice']!=null){
            ?>
            <div class="row">

                <div class="col-lg-6">
                     <h3>Client : </h3>
                    <p>
                        <label><strong>Nom Client : </strong></label>
                        <?php echo $_SESSION['invoice']["nomClient"]; ?>
<input type="hidden" name="invoiceNom" id="invoiceNom" value="<?php echo $_SESSION['invoice']["nomClient"] ?>"/>
                    </p>
                    <p>
                        <label><strong>Numéro Facture : </strong></label>
                        <?php echo $_SESSION['invoice']["invoiceNumber"]; ?>
                        <input type="hidden" name="invoiceNumber" id="invoiceNumber" value="<?php echo $_GET['id']; ?>"/>
                        <input type="hidden" name="numFacture" id="numFacture" value="<?php echo $_SESSION['invoice']["invoiceNumber"]; ?>"/>
                        <input type="hidden" name="emailFacture" id="emailFacture" value="<?php echo $_SESSION['invoice']["emailClient"]; ?>"/>
                    </p>

                    <p>
                        <label><strong>Montant à régler : </strong></label>
                        <?php echo number_format ($_SESSION['invoice']["montant"], 0, ',', ' '); ?> Fcfa
                        <input type="hidden" name="amount" id="invoiceAmount" value="<?php echo $_SESSION['invoice']["montant"] ?>"/>
                    </p>

                </div>


                <div class="col-lg-6 align-self-center">

                    <div id="accordion3" class="fizo-accordion layout-1 sm-mb-45px">

                        <div class="card">
                            <div class="card-header" id="headingOne3">
                                <h5 class="mb-0">
                                    <button class="btn btn-block btn-link active" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3"><img src="assets/img/orangeMoney-small.png"/> Paiement Orange Money</button>
                                </h5>
                            </div>
                            <div id="collapseOne3" class="collapse show" aria-labelledby="headingOne3" data-parent="#accordion3" style="">
                                <div class="card-body">
                                  
                                   <form id="paiementOrangeMoney">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Numéro de téléphone</label>
                                        <input type="tel" class="form-control" id="orangeTel" aria-describedby="Entrer un numéro de téléphone Camerounais du réseau Orange" value="<?php echo echo preg_replace('/\s+/', '',$_SESSION['invoice']["telClient"]); ?>" minlength="9" required>
                                        <small id="emailHelp" class="form-text text-muted">Vous recevrez une demande d'appel de fond du montant correspondant</small>
                                      </div>
                                      <button type="submit" id="submitOrangeForm" class="btn btn-lg btn-block btn-success">Payer</button>
                                    </form>

                                  </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingThree3">
                                <h5 class="mb-0">
                                    <button class="btn btn-block btn-link active" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo2"><img src="assets/img/iconfinder_16-Credit_Card_3213288.png"/>  Paiement Carte Bancaire</button>
                                </h5>
                            </div>
                             <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2" data-parent="#accordion3" style="">
                                <div class="card-body">
                                    <form id="paiementStripe" action="./paiement-interneStripe.php"  method="post" >
                                    <input type="hidden" name="purchaseref" id="purchaseref" value="<?php echo $_GET['id']?>">
                                  <button type="button" id="submitStripeForm" class="btn btn-lg btn-block btn-success">Paiement par Carte Bancaire</button>
                                  
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php }else{
            ?>

            <div class="row">
                <div class="col-lg-12">
                <h1>Vous n’avez pas de facture en attente de paiement</h1>
                <p>
                    Merci de contacter le service commercial de Y-Note
                </p>
            </div>
            </div>
        <?php }
        ?>
        </div>

    </section>


<?php 
require_once("html/footer.php");
?>