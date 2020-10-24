
<?php 
$numOrange = 693600164;
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Check Num Téléphone <?php echo $numOrange ?></title>
  </head>
  <body>
    <h1>Check Num Téléphone <?php echo $numOrange ?></h1>

<div id='status'>Resultat: </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


<script>
  $(document).ready(function() {
    var returnTxt="Le solde du compte du payeur est insuffisant";
    do{
      $.post('checkCredit.php', {
          delay: 1
      }, function(data, textStatus, jqXHR) {
          // called after the 3 second delay
          $("#status").append("<p>"+textStatus+" : "+data.montant+" - "+data.txt);
          console.log(data.txt);
          returnTxt=data.txt;
      })
    }while(returnTxt=="Le solde du compte du payeur est insuffisant");
});
</script>

  </body>
</html>