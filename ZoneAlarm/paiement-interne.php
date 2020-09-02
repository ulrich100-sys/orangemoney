<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Paiement iDocta</title>
  </head>
  <body>

    <div class="container">
       <div class="row">
          <div class="col-sm-2">
            <img src="http://www.idocta.africa/wp-content/uploads/2019/07/logo-transparent.png" alt="Logo iDocta" class="img-fluid"/>
          </div>
          <div class="col-sm-10">
            <h1>Achetez ZoneAlarm</h1>
          </div>
      </div>
      <div class="row">
        <div class="col-sm">
          <?php if(isset($_SESSION["PaymentError"])){ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3> Votre paiement a échoué</h3>
              <p> Merci de vérifier votre formulaire et les données entrées</p>
              <p>
                <strong>Erreur de paiement :</strong> <?php echo $_SESSION["PaymentError"] ?><br/>
                <strong>Erreur Message :</strong> <?php echo $_SESSION["PaymentMessage"] ?>
              </p>
            </div>
          <?php 
                unset($_SESSION["PaymentError"]);
              }
          ?>

            <form action="paiement-traitement.php" method="POST">
              <div class="form-group">
                <label for="exampleInputNom"><strong>Nom</strong></label>
                <input type="text" class="form-control" id="exampleInputNom" aria-describedby="emailHelp" name="exampleInputNom" required <?php 
                        if(isset($_SESSION["exampleInputNom"])){
                          echo 'value="'.$_SESSION["exampleInputNom"].'"';
                      } ?>
                      >
              </div>
              <div class="form-group">
                <label for="exampleInputNom"><strong>Prénom</strong></label>
                  <input type="text" class="form-control" id="exampleInputPrenom" aria-describedby="emailHelp" name="exampleInputPrenom" required <?php 
                          if(isset($_SESSION["exampleInputPrenom"])){
                            echo 'value="'.$_SESSION["exampleInputPrenom"].'"';
                        } ?>
                        >
              </div>
              <div class="form-group">
                <label for="exampleInputNom"><strong>Email</strong></label>
                  <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" name="exampleInputEmail" required <?php 
                          if(isset($_SESSION["exampleInputEmail"])){
                            echo 'value="'.$_SESSION["exampleInputEmail"].'"';
                        } ?>
                        >
              </div>
              
              <button type="submit" class="btn btn-primary btn-block ">Envoyer</button>
            </form>
          </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>