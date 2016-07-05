<?php 
  require('bootstrap.php');
  if (!ALLOW_REGISTRATIONS) header('Refresh:0; url=./index.html');
  if (isset($_SESSION['username'])) header('Refresh:0; url=./dashboard-js.html');
?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
  <head>
    <!-- load header from header.php -->
    <?php require('header.php'); ?>
    <title><?=_('registration-title');?></title>
    <script type="text/javascript">
      function registerUser() {
        var index = -1, formElements = document.getElementById('registerForm').children;
        var data = new Array(formElements[0].children[1].value, formElements[1].children[1].value, formElements[2].children[1].value);
        
        if (data[0].length > 0 && data[1].length > 0 && data[2].length > 0) {
          if (data[1] === data[2]) {
            $.ajax({
              url: './resources/library/php/ProcessAjaxRequests.php',
              data: { data: data, action: 'RegisterUser' },
              type: 'post',
              success: function(output) {
                switch(output) {
                  case 'RegistrationSuccess':
                    document.getElementById('user').innerHTML = data[0];
                    index = 1;
                    break;
                  case 'RegistrationError':
                    index = 2;
                    break;
                  case 'AlreadyExists':
                    index = 3;
                    break;
                }
                DisplayResponse(index);
              }
            });
          }
          else index = 4;
        }
        else DisplayResponse(0);
      }

      function DisplayResponse(index) {
        if (index > -1) document.getElementById('popover').innerHTML = document.getElementById('response').children[index].innerHTML;
      }
    </script>
  </head>
  <body>
    <!-- load navbar from navbar.php -->
    <?php require('navbar.php'); ?>
    <div class="page-content">
      <div class="page-header"><?=_('registration-page-header'); ?></div>
      <div class="page-content-box content-box-shadow" style="width: 27.5rem;">
        <h3><?=_('registration-page-content-box-header'); ?></h3>
        <form action="registration.php" id="registerForm" method="post">
          <div class="input-control text full-size" data-role="input">
            <span class="mif-user prepend-icon"></span>
            <input type="text" placeholder="<?=_('input-text-username-placeholder'); ?>" name="username">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
          </div>
          <div class="input-control password full-size" data-role="input">
            <span class="mif-lock prepend-icon"></span>
            <input type="password" placeholder="<?=_('input-text-registration-placeholder'); ?>" name="password">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
          </div>
          <div class="input-control password full-size" data-role="input">
            <span class="mif-lock prepend-icon"></span>
            <input type="password" placeholder="<?=_('input-text-password-placeholder'); ?>" name="password2">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
          </div>
          <button class="button" onclick="registerUser();
          " type="button"><?=_('button-registration'); ?></button>
          <a class="button link" href="./login.html"><?=_('button-login'); ?></a>
        </form>
      </div>
      <div id="popover"></div>
    </div>
    <div id="response" style="display: none;">
      <div><div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">
          Please fill the required fields (username, passwords)
      </div></div>
      <div><div class="popover marker-on-top bg-green fg-black" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #003E00;">
        User <b id="user"></b> successfully registered
      </div></div>
      <div><div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">
        Oops something went wrong :( Please try again!
      </div></div>
      <div><div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">
        Username already exists. Please try again.
      </div></div>
      <div><div class="popover marker-on-top bg-red fg-grayLighter" style="margin: 15px auto 0px auto; width: 300px; display: block; box-shadow: 7px 7px #4C0000;">
        Password does not match the confirm password. Please try again.
      </div></div>
    </div>
  </body>
</html>
