<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="screen.css">
  </head>
  <body>
    <?php
      $payouts = shell_exec("sh get_payouts.sh");
      $payouts = json_decode($payouts, true);
      ?><ul><?php
      foreach ($payouts as $payout) {
        ?><li><a href="/factuur.php?name=<?php echo $payout["submission"]["code"]; ?>&amount=<?php echo $payout["amount"]; ?>&factnr=1"><?php
        echo $payout["submission"]["title"]." [".$payout["submission"]["code"]."] €".$payout["amount"];
        ?></li></a><?php
      }
      ?></ul><?php
    ?>
  </body>
</html>
