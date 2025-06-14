<?php
/*
Template Name: Contact Us page
*/

get_header(); ?>

<?php

// $publickey="6LfZQCQUAAAAAN9Cdi8ZAvpSef0Tj3QBuiswMmdv"; //old v2 key
// $secretkey="6LfZQCQUAAAAAJV6vnqrz7BKBgaijMt2Nl8TafAx"; //v2 key


$publickey = "6Le4N60iAAAAAC1ZQlqX5oq1u8BKnL8BkVcLol6x"; //v3 key
$secretkey = "6Le4N60iAAAAAAPko1rpFkSFTIMGchuK19dHpCaU"; //v3 key


//$publickey="6LemPyQUAAAAACcJ_o3AJPI_HHrJ4gGgsu4PCj_T";

//$secretkey="6LemPyQUAAAAACBZ8ieBeS-reRzWKncoSdpEw89z";



if(isset($_POST['con_sub'])){
$fname = $_POST['f_name'];
$lname = $_POST['l_name'];
$company = $_POST['company'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip_code'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$con_sub = $_POST['con_subject'];
$con_comment = $_POST['con_comment'];
$admin_email = get_option( 'admin_email' );//'baburam.powdal@gmail.com';//'hosting@thebizservices.com';
$headers= "MIME-Version: 1.0\n" .
        "From: ".$fname." <$email>\n" .
        "Content-Type: text/html; charset=\"" .
get_option('blog_charset') . "\"\n";
$subject = "A Person Contacted You";
$content = '<html><body>';
$content .='<b>Hello admin,<br>A visitor contacted to you. Please check the given below.</b><br/><br/>';
$content .= '';
$content .= 'Name : '.$fname.'  '.$lname.'<br/><br/>' ;
 $content .= 'Company : '.$company.'<br/><br/>' ;
 $content .= 'Address : '.$address.'<br/><br/>' ;
 $content .= 'City : '.$city.'<br/><br/>' ;
$content .= 'Province/State: '.$state.'<br/><br/>' ;
$content .= 'Postal/Zip Code: '.$zip.'<br/><br/>' ;
$content .= 'Phone Number: '.$phone.'<br/><br/>' ;
$content .= 'Email Id: '.$email.'<br/><br/>' ;
$content .= 'Subject: '.$con_sub.'<br/><br/>' ;
$content .= 'Comment: '.$con_comment.'<br/><br/>';
$content .= '';
$content .= '</html></body>';

/*$response = $_POST["g-recaptcha-response"];

	$url = 'https://www.google.com/recaptcha/api/siteverify';

	$data = array(

		'secret' => $secretkey,

		'response' => $_POST["g-recaptcha-response"]

	);

	$options = array(

		'http' => array (

			'method' => 'POST',

			'content' => http_build_query($data)

		)

	);

	$context  = stream_context_create($options);

	$verify = file_get_contents($url, false, $context);

	$captcha_success=json_decode($verify);*/
$token = $_POST['token'];
$action = $_POST['action'];
  
// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secretkey, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);

	$err_msg='';

	/*if ($captcha_success->success==false) {

		$err_msg="ReCaptcha not verified. Please verify the ReCaptcha.";

	}*/
  // verify the response

if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    wp_mail($admin_email, $subject, $content, $headers);

  //wp_mail("sudipta.cantrip@gmail.com", $subject, $content, $headers);

  $subject="Moyal.com: Thanking You";
  $message="<html><body><h3>Thank you for your interest. We will come back to you shortly.</h3></body></html>";
  $headers =  "MIME-Version: 1.0\n" .
          "From: ".get_option('blogname')." <$admin_email>\n" .
                      "Content-Type: text/html; charset=\"" .
              get_option('blog_charset') . "\"\n";
  wp_mail($email , $subject, $message, $headers);

  echo '<script>window.location="http://moyal.com/contact-thank-you/"</script>';
}else{
  $err_msg = "You are not a human or not verified user.";
}
}

?>

<section class="padding-t-b-100 cont-contact-page">
	<div class="container">
		<div class="row">
			<div class="col-12 display-flex single-img-content">
				<div class="single-firm-img">
					<?php
						$image = get_field('headoffice_img');
						if( !empty($image) ): ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php endif; 
					?>
				</div>
				<div class="single-firm-content">
					<h2 class="title title-46"><?php echo get_field('headoffice_title'); ?></h2>
					<ul class="office-list-content">
						<?php if( have_rows('headoffice_list') ): ?>
						<?php while( have_rows('headoffice_list') ): the_row(); ?>
						<li>
							<div class="officelist-icon">
								<?php
									$image = get_sub_field('headoffice_list_icon');
									if( !empty($image) ): ?>
										<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
									<?php endif; 
								?>
							</div>
							<div class="officelist-text"><?php echo get_sub_field('headoffice_list_content'); ?></div>
						</li>
						<?php endwhile; ?>
						<?php endif; ?>
					</ul>
					<div class="col-12 call-map-otr">
						<p><?php echo get_field('contact_toll_free'); ?></p>
						<p><?php echo get_field('contact_map_link'); ?></p>
					</div>
				</div>
			</div>
			<div class="col-12 display-flex cont-map">
				<?php echo get_field('map_iframe'); ?>
			</div>
		</div>
	</div>
</section>

<section class="cont-contact-form">
	<div class="container">
		<div class="row">
			<div class="col-12 contact-from-inn">
				<div class="col-12 contact-midd">
					<div class="col-12 contact-from-top">
						<h2 class="title title-46"><?php echo get_field('conact_form_title'); ?></h2>
						<p><?php echo get_field('conact_form_content'); ?></p>
					</div>
					<form id="contact-form" method="post" >
						<div class="free-block">
							<div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label><span class="txt-red">*</span>First Name:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="f_name" name="f_name" value="<?php echo $fname ?>"/>
									<span class="jerror"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Last Name:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="l_name" name="l_name" value="<?php echo $lname ?>"/>
									<span class="jerror"></span>
								</div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Company:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" name="company" id="company" value="<?php echo $company ?>"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Address:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="address" name="address" value="<?php echo $address ?>"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 form-left">
                                <label>City:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="city" name="city" value="<?php echo $city ?>"/>
									<span class="jerror"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Province/State:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="state" name="state" value="<?php echo $state ?>"/>
									<span class="jerror"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Postal/Zip Code:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="zip_code" name="zip_code" value="<?php echo $zip ?>"/>
									<span class="jerror"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label><span class="txt-red">*</span>Phone:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="phone" name="phone" value="<?php echo $phone ?>"/><span id="p_error"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label><span class="txt-red">*</span>E-mail:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<input type="text" id="email" name="email" value="<?php echo $email ?>"/><span id="e_error"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Please select subject related to your question?:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<select name="con_subject" >
										<option selected=""  value="none" <?php echo $con_sub==''?'selected="selected"':''?>>Select subject</option>
										<option value="Independent applications" <?php echo $con_sub=='Independent applications'?'selected="selected"':''?>>Independent applications</option>
										<option value="Skilled professionals" <?php echo $con_sub=='Skilled professionals'?'selected="selected"':''?>>Skilled professionals</option>
										<option value="Foreign students" <?php echo $con_sub=='Foreign students'?'selected="selected"':''?>>Foreign students</option>
										<option value="Business persons" <?php echo $con_sub=='Business persons'?'selected="selected"':''?>>Business persons</option>
										<option value="Self-employed individuals" <?php echo $con_sub=='Self-employed individuals'?'selected="selected"':''?>>Self-employed individuals</option>
										<option value="Entrepreneurs" <?php echo $con_sub=='Entrepreneurs'?'selected="selected"':''?>>Entrepreneurs</option>
										<option value="Investors" <?php echo $con_sub=='Investors'?'selected="selected"':''?>>Investors</option>
										<option value="Family class applications" <?php echo $con_sub=='Family class applications'?'selected="selected"':''?>>Family class applications</option>
										<option value="Appeals" <?php echo $con_sub=='Appeals'?'selected="selected"':''?>>Appeals</option>
										<option value="other" <?php echo $con_sub=='other'?'selected="selected"':''?>>other</option>
									</select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group full-field">
								<div class="col-md-6 col-sm-6 form-left">
									<label>Comments:</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
									<textarea name="con_comment"><?php echo $con_comment ?></textarea>
                                </div>
                                <div class="clearfix"></div>
                            </div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>&nbsp;</label>
                                </div>
                                <!-- <div class="col-md-6 col-sm-6 form-right">
                                  <div class="g-recaptcha" data-sitekey="<?php //echo $publickey; ?>"></div>
                                </div> -->
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
								<div class="col-md-6 col-sm-6 form-left">
									<label>&nbsp;</label>
                                </div>
                                <div class="col-md-6 col-sm-6 form-right">
                                  <div id="frmresponse" style="color: #ff0000"><?php echo $err_msg; ?></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="free-block1">
								<div class="form-bttn-group">
									<div class="col-md-6 col-sm-6 form-left">
										<input type="submit" value="Submit" id="con_sub" class="form-bttn" name="con_sub" /> 
										<!--input type="reset" value="Reset"-->
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>