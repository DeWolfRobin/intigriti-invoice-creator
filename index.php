<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="screen.css">
  </head>
  <body>
    <?php
      $payouts = shell_exec("sh get_payouts.sh");
      $payouts = json_decode($payouts, true);
      $i=0;
      foreach ($payouts as $payout) {
        if ($i % 4 == 0) {
          echo "<div class='row'>";
        }
        ?><div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">[ <?php echo $payout["submission"]["code"]; ?> ] € <?php echo $payout["amount"]; ?>
                <input style="float:right;" type="checkbox" class="check" data-name="<?php echo $payout["submission"]["code"]; ?>" data-amount="<?php echo $payout["amount"]; ?>">
              </h5>
              <p class="card-text"><?php echo $payout["submission"]["title"]; ?></p>
              <a href="/factuur.php?name=<?php echo $payout["submission"]["code"]; ?>&amount=<?php echo $payout["amount"]; ?>&factnr=1" class="btn btn-primary">Create invoice</a>
            </div>
          </div>
        </div><?php
        if ($i % 4 == 3) {
          echo "</div>";
        }
        $i++;
      }
    ?>
      <form class="hidden" action="/factuur.php" method="get">
        <input type="hidden" id="name" name="name" value="">
        <input type="hidden" id="amount" name="amount" value="">
        <input type="hidden" name="factnr" value="1">
        <input type="submit" class="btn btn-primary" name="" value="Bulk Create">
      </form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".check").on("click",function() {
          var name = $("form #name").val();
          var amount = $("form #amount").val();
          //wont work if the first one is deselected when there's more then 1
          if ($(this)[0].checked == true) {
            if (name == "") {
              $("form #name").val(name+$(this).attr("data-name"));
            } else {
                $("form #name").val(name+","+$(this).attr("data-name"));
            }
            if (amount == "") {
              $("form #amount").val(amount+$(this).attr("data-amount"));
            } else {
                $("form #amount").val(amount+","+$(this).attr("data-amount"));
            }
          } else {
              $("form #name").val(name.replace($(this).attr("data-name"),""));
              $("form #amount").val(amount.replace($(this).attr("data-amount"),""));
                name = $("form #name").val();
                amount = $("form #amount").val();
                $("form #name").val(name.replace(/,,/g,","));
                $("form #amount").val(amount.replace(/,,/g,","));
              if (name[0] == ",") {
                name = name.replace(",","");
                $("form #name").val(name);
              }
              if ($("form #amount").val()[0] == ",") {
                amount = amount.replace(",","");
                $("form #amount").val(amount);
              }
          }

        });
      });
    </script>
  </body>
</html>
