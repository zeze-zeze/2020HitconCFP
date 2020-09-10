<?php
  include_once 'secret.php';

  // bypass!
  $pass = false;
  if (md5($_COOKIE['permission'] ?? '') == "0e372212347327653797951228669490" && is_numeric($_POST['amount'] ?? '')) {
    $pass = true;
  } 
?>

<?php
  if (isset($_GET['__debug__'])) {
    $content = highlight_file(__FILE__, true);
    die(substr($content, 0, 1600));
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BambooFox Currency Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <section id="parallax-0" class="hero is-fullheight is-flex" style="justify-content: center; align-items: center;">
      <div class="box mx-2 has-background-primary">
        <h1 class="title is-3 has-text-white">
          BambooFox Currency Management
        </h1>
        <h2 class="subtitle has-text-white">
          Print on demand
        </h2>

        <?php if (!isset($_POST['amount'])): ?>
          <article class="message is-info">
            <div class="message-body">
              請到 BambooFox 攤位後再送出列印，才能順利拿到列印出之鈔票喔！
            </div>
          </article>
        <?php else: ?>
          <?php if (!$pass): ?>
            <article class="message is-warning">
              <div class="message-body">
                Permission Denied!
              </div>
            </article>
          <?php elseif ($pass < 0 || $pass > 763): ?>
            <article class="message is-warning">
              <div class="message-body">
                Invalid Amount!
              </div>
            </article>
          <?php else: ?>
            <?php
              secret(trim(substr($_POST['amount'], 0, 10)));
              $success = true;
            ?>
            <article class="message is-success">
              <div class="message-body">
                已順利印出，請到 BambooFox 攤位領取！
                <br>
                領取後可拿到
                <strong>中華資安</strong>
                攤位儲值！
              </div>
            </article>
          <?php endif ?>
        <?php endif ?>
        <form method="POST">
          <div class="field has-addons">
            <p class="control">
              <div class="button is-static">$</div>
            </p>
            <p class="control is-expanded">
              <input name="amount" class="input" type="number" min="0" max="763" placeholder="Amount of money (0 ~ 763)" required <?php echo $success ?? false ? 'disabled' : '' ?>>
            </p>
            <p class="control">
              <button class="button is-info" <?php echo $success ?? false ? 'disabled' : '' ?>>
                Print
              </button>
            </p>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
<!-- ?__debug__ -->
