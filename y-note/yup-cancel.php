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

require_once("html/header.php");
?>





    <div class="nile-page-title">
        <div class="container">
            <h1>Paiement échouée</h1>
        </div>
    </div>



    <section class="padding-tb-120px section-ba-2">
        
        <div class="container paiement-failed">
            <div class="row">
                <div class="col-lg-12">
                <h2>Votre paiement n'a pas abouti</h2>
                <p>
                    Vous pouvez refaire une tentative de paiement sur la <a href="./paie-facture.php?id=<?php echo $_GET['id'];?>">page de réglement</a>
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



<?php 
require_once("html/footer.php");
?>
