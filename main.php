<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>PHP Task</title>
      <style>
        <?php include 'CSS/main.css'; ?>
      </style>
  </head>
  <body>
      <?php include("functions/addresses_manipulation.php");?>
      <?php include("functions/config.php");?>
      <h1>PHP Task</h1>
      <br>
      <label>Please select one of the following US Social Security Administration Offices Address</label>
      <br>
      <br>
      <form method="post" action="">
        <select name="addressSelect" onChange="this.form.submit();">
          <option value="">Choose one</option>
          <?php
            foreach($ADDRESSES as $address) { ?>
              <option value="<?= $address ?>" <?php if ($_POST["addressSelect"] === $address) echo 'selected'; ?>><?= $address ?></option>
              <?php
            }
          ?>
        </select>
      </form>
      <br>
      <?php
        if (!empty($_POST['addressSelect'])) {
          ?>
            <div id="map"></div>
          <?php
        }
      ?>
      <?php echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$GOOGLE_API_KEY.'&libraries=places"></script>'; ?>
  </body>
</html>