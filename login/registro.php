<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php include("../include/funciones.php"); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link type="text/css" href="../css/registro.css" rel="Stylesheet" />

<div class="wrapper">	
		<div class="section">

			<h1><?php echo getString("signup_title"); ?></h1>
			
			<form id="form1" action="registro1.php" method="post">
				
				<label for="username"><?php echo  getString("signup_username"); ?> 
					
				<span style=color:green><?php echo getString("signup_username_info"); ?></span> 
				</label>
				<input tabindex="2" name="username" id="username" type="text" class="text" value="" />
				
				<label for="password1"><?php echo getString("signup_pass"); ?><span style=color:green><?php echo getString("signup_pass_info"); ?>					números</span></label>
				<input tabindex="3" name="password1" id="password1" type="password" class="text" value="" />
				
				<label for="password2"><?php echo getString("signup_pass2"); ?><span style=color:green><?php echo getString("signup_pass_info2"); ?></span></label>
				<input tabindex="4" name="password2" id="password2" type="password" class="text" value="" />
                                
                                
				<label for="email2"><?php echo getString('signup_mail'); ?></label>
                                <input tabindex="5" name="email" id="email" type="text" class="text" value="<?php //Si hubiera un email se pone aqui con un echo $email; ?>" />
				<div>
                                    <?php //TBD: Quitar cuando haya server de correo.
                                    //if(smtp_online()==true)
                                     echo "<input tabindex='6' name='send' id='send' type='submit' class='submit' value='".getString('signup_mail_send_form')."'/>";
                                    //else
                                     //echo "<h2>".getString('signup_mail_error')."</h2>";
                                    ?>
                                </div>
			</form>
			
			
		</div>
	</div>