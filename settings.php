<?php session_start(); ?>
<!-- HTML Code -->
<!DOCTYPE html>
<html>
	<head>
		<!-- load header from header.php -->
    	<?php require(dirname(__FILE__)."/header.php"); ?>
		<title><?=ABOUT_TITLE; ?></title>
	</head>
	<script type="text/javascript">
    function ShowConfirmResetAllData() {
      window.confirm("Do you really want to reset everything?");
    }

		function ShowDivDeleteAccount() {
			document.getElementById("deleteAccountDiv").style.display = "block";
		}
	</script>
	<body>
		<!-- load navbar from navbar.php -->
		<?php require(dirname(__FILE__)."/navbar.php"); ?>
		<div class="page-content">
			<div class="page-header">Settings</div>
			<div class="page-content-box content-box-shadow">
      <h2>Account Information:</h2>
				<form method="post">
				<h5>Change Username</h4>
        		<div class="input-control text full-size" data-role="input">
          			<span class="mif-user prepend-icon"></span>
          			<input type="text" placeholder="<?=INPUT_TEXT_TIMETABLE_PLACEHOLDER; ?>" name="table">
          			<div class="button-group">
            			<button class="button helper-button clear"><span class="mif-cross"></span></button>
            			<button class="button" name="create" type="submit"><?=BUTTON_CREATE; ?></button>
          			</div> 
        		</div>
        		<h5>Change Password</h5>
        		<div class="input-control password full-size" data-role="input">
            		<span class="mif-lock prepend-icon"></span>
            		<input type="password" placeholder="<?=INPUT_TEXT_PASSWORD_PLACEHOLDER; ?>" name="password">
            		<div class="button-group">
            			<button class="button helper-button reveal"><span class="mif-looks"></span></button>
            			<button class="button" name="create" type="submit"><?=BUTTON_CREATE; ?></button>
          			</div> 
          		</div>
          		<div class="input-control password full-size" data-role="input">
            		<span class="mif-lock prepend-icon"></span>
            		<input type="password" placeholder="<?=INPUT_TEXT_PASSWORD_PLACEHOLDER; ?>" name="password">
            		<div class="button-group">
            			<button class="button helper-button reveal"><span class="mif-looks"></span></button>
            			<button class="button" name="create" type="submit"><?=BUTTON_CREATE; ?></button>
          			</div> 
          		</div>
            </div>
            <br/>
            <div class="page-content-box content-box-shadow">
              <h2 style="color: red;">Danger Zone:</h2>
              <h5 style="color: red;">Reset all data</h5>
              <div class="input-control text error full-size" data-role="input">
                <span class="mif-user prepend-icon"></span>
                <input id="deleteAccountInput" type="text" onclick="ShowConfirmResetAllData()" placeholder="<?=INPUT_TEXT_TIMETABLE_PLACEHOLDER; ?>" name="table">
                <div class="button-group">
                  <button class="button helper-button clear"><span class="mif-cross"></span></button>
                  <button class="button" name="create" type="submit" style="border-color: red; color: red;"><?=BUTTON_CREATE; ?></button>
                </div>
              </div>
          		<h5 style="color: red;">Delete Account</h5>
          		<div class="input-control text error full-size" data-role="input">
          			<span class="mif-user prepend-icon"></span>
          			<input type="text" onclick="ShowDivDeleteAccount()" placeholder="<?=INPUT_TEXT_TIMETABLE_PLACEHOLDER; ?>" name="table">
          			<div class="button-group">
            			<button class="button helper-button clear"><span class="mif-cross"></span></button>
            			<button class="button" name="create" type="submit" style="border-color: red; color: red;"><?=BUTTON_CREATE; ?></button>
          			</div>
              </div>
            </div>
            <div id="deleteAccountDiv" class="popover marker-on-top bg-red fg-grayLighter page-content-popover" style="box-shadow: 7px 7px #4C0000; display: none;">
                <?=DIV_POPOVER_TEXTFIELD_CANNOT_BE_EMPTY; ?>
              </div>
      			</form>
			</div>			
		</div>
	</body>
</html>