<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="screen.css">
  </head>
  <body>
    <div class="row">
      <div class="col-md-12">
        <form class="hidden" action="/factuur.php" method="get">
          <input type="hidden" id="name" name="name" value="">
          <input type="hidden" id="amount" name="amount" value="">
          <input type="hidden" id="date" name="date" value="">
          <label for="">Factuur nr.</label>
          <input type="text" name="factnr" value="1">
          <input type="submit" class="btn btn-primary" name="" value="Bulk Create">
        </form>
      </div>
    </div>
    <?php
      $payouts = shell_exec("sh get_payouts.sh");
      $payouts = json_decode($payouts, true);
      $i=0;
      usort($payouts, function($a, $b) {
         return (strtotime($a['createdDate']) > strtotime($b['createdDate']) ? -1 : 1);
       });
      foreach ($payouts as $payout) {
        if ($i % 4 == 0) {
          echo "<div class='row'>";
        }
        $date = explode("-",explode("T",$payout["createdDate"])[0]);
        $date = $date[2]."/".$date[1]."/".$date[0]
        ?><div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">[ <?php echo $payout["submission"]["code"]; ?> ] € <?php echo $payout["amount"]; ?>
                <input style="float:right;" type="checkbox" class="check" data-name="<?php echo $payout["submission"]["code"]; ?>" data-amount="<?php echo $payout["amount"]; ?>" data-date="<?php echo $date; ?>">
              </h5>
              <p class="card-text"><?php echo $payout["submission"]["title"]; ?> <br><small><?php echo $date; ?></small></p>
              <a href="/factuur.php?name=<?php echo $payout["submission"]["code"]; ?>&amount=<?php echo $payout["amount"]; ?>&factnr=1&date=<?php echo $payout["createdDate"]; ?>" class="btn btn-primary">Create invoice</a>
            </div>
          </div>
        </div><?php
        if ($i % 4 == 3) {
          echo "</div>";
        }
        $i++;
      }
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".check").on("click",function() {
          var name = $("form #name").val();
          var amount = $("form #amount").val();
          var date = $("form #date").val();
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
            if (date == "") {
              $("form #date").val(date+$(this).attr("data-date"));
            } else {
                $("form #date").val(date+","+$(this).attr("data-date"));
            }
          } else {
              $("form #name").val(name.replace($(this).attr("data-name"),""));
              $("form #amount").val(amount.replace($(this).attr("data-amount"),""));
              $("form #date").val(date.replace($(this).attr("data-date"),""));
                name = $("form #name").val();
                amount = $("form #amount").val();
                date = $("form #date").val();
                $("form #name").val(name.replace(/,,/g,","));
                $("form #amount").val(amount.replace(/,,/g,","));
                $("form #date").val(date.replace(/,,/g,","));
              if (name[0] == ",") {
                name = name.replace(",","");
                $("form #name").val(name);
              }
              if (amount[0] == ",") {
                amount = amount.replace(",","");
                $("form #amount").val(amount);
              }
              if (date[0] == ",") {
                date = date.replace(",","");
                $("form #date").val(date);
              }
              if (name[name.length - 1] == ",") {
                name = name.slice(0, -1);
                $("form #name").val(name);
              }
              if (amount[amount.length - 1] == ",") {
                amount = amount.slice(0, -1);
                $("form #amount").val(amount);
              }
              if (date[date.length - 1] == ",") {
                date = date.slice(0, -1);
                $("form #date").val(date);
              }
          }

        });
      });
    </script>
  </body>
</html>
