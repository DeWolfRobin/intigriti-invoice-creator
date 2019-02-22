<?php

if (isset($_GET["name"]) && isset($_GET["amount"]) && isset($_GET["factnr"])) {
  $code = explode(",",$_GET["name"]);
  $amount = explode(",",$_GET["amount"]);
  $factnr = $_GET["factnr"];
  $subtotal = array_sum($amount);
} else {
  die("Please provide details");
}

$today = getdate();
$fdate = $today["mday"]."/".$today["mon"]."/".$today["year"];
$xdate = ($today["mday"]+2)."/".($today["mon"]+1)."/".$today["year"];

$logo = "logo.jpg";
$you = ["USER","Address1","Address2","BTW BE 0000.000.000","BE12 1234 1234 1234","BIC: ZZZZZZZZ","0412345678","user@domain.com","https://haywirehax.com"];
$client = ["NV Intigriti","Parklaan 113/8","9300 Aalst","BTW BE 0660.623.646"];
$extra = ["U wordt vriendelijk verzocht om te voldoen aan bovenstaand bedrag binnen de vooropgestelde betalingstermijn."];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Factuur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="factuur.css">
  </head>
  <body>
    <div class="row">
      <div class="col-md-12 centertext">
        <h1>Factuur</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <img src="<?php echo "$logo"; ?>" alt="">
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="you">
          <?php
            foreach ($you as $item) {
              echo "<p>$item</p>";
            }
          ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right">
        <div class="client">
          <?php
            foreach ($client as $item) {
              echo "<p>$item</p>";
            }
          ?>
        </div>
        <div class="details">
          <p>Factuurnummer: <?php echo $factnr ?></p>
          <p>Factuurdatum: <?php echo $fdate ?></p>
          <p>Leveringsdatum: <?php echo $fdate ?></p>
          <p>Vervaldatum: <?php echo $xdate ?></p>
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <div class="overview">
        <table class="center table">
          <tr>
            <th>Aantal</th>
            <th>Omschrijving</th>
            <th>Bedrag</th>
            <th>Totaal</th>
            <th>BTW</th>
          </tr>
          <?php
          $i=0;
            foreach ($code as $item) {
              ?>
              <tr>
                <td>1x</td>
                <td>[ <?php echo "$item"; ?> ]</td>
                <td>€ <?php echo $amount[$i] ?></td>
                <td>€ <?php echo $amount[$i] ?></td>
                <td>21 %</td>
              </tr>
              <?php
              $i++;
            }
          ?>
          <tr>
            <td></td>
            <td></td>
            <td><b>Subtotaal</b></td>
            <td>€ <?php echo $subtotal ?></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><b>BTW 21%</b></td>
            <td>€ <?php echo $subtotal*0.21 ?></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><b>Totaal</b></td>
            <td>€ <?php echo $subtotal*1.21 ?></td>
            <td></td>
          </tr>
        </table>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 centertext">
        <div class="extra">
          <?php
            foreach ($extra as $item) {
              echo "<p>$item</p>";
            }
          ?>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
