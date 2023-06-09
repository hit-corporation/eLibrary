<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<base href="<?=base_url()?>">
	<!-- Basic need -->
	<title>eLibrary</title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<link rel="profile" href="#">

    <!--Google Font-->
    <link rel="stylesheet" href='<?=base_url()?>assets/landing-pages/fonts/googleapis.css?family=Dosis:400,700,500|Nunito:300,400,600' />
	<!-- Mobile specific meta -->
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone-no">

	<!-- CSS files -->
	<link rel="stylesheet" href="<?=base_url()?>assets/landing-pages/css/semantic-ui.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/landing-pages/css/plugins.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/landing-pages/css/style.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" integrity="sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.0/css/ionicons.min.css" integrity="sha512-JApjWRnfonFeGBY7t4yq8SWr1A6xVYEJgO/UMIYONxaR3C9GETKUg0LharbJncEzJF5Nmiv+Pr5QNulr81LjGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- JQUERY -->
	<script src="<?=base_url()?>assets/js/jquery-3.5.1.min.js"></script>
	<script>
		BASE_URL = document.querySelector('base').href;
	</script>
	<!-- Sweetalert -->
	<!-- import from node_modules -->
	<link rel="stylesheet" href="<?=base_url()?>assets/node_modules/sweetalert2/dist/sweetalert2.min.css">
	<script src="<?=base_url()?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

</head>
<body>
<!--preloading-->
<div id="preloader">
    <img class="logo" src="<?=base_url()?>assets/landing-pages/images/logo1.png" alt="" width="100" height="100">
    <div id="status">
        <span></span>
        <span></span>
    </div>
</div>
<!--end of preloading-->
<!--login form popup-->
<div class="login-wrapper" id="login-content">
    <div class="login-content">
        <a href="#" class="close">x</a>
        <h3>Login</h3>
        <form name="form-login" method="post" action="<?=html_escape(base_url('home/login'))?>">
        	<div class="row">
        		 <label for="username">
                    Username:
                    <input type="text" name="username" id="username" placeholder="Username / Email" required="required" />
                </label>
        	</div>
           
            <div class="row">
            	<label for="password">
                    Password:
                    <input type="password" name="password" id="password" placeholder="******" required="required" />
                </label>
            </div>
            <div class="row">
            	<div class="remember">
					<div>
						<input type="checkbox" name="remember" value="Remember me"><span>Remember me</span>
					</div>
            		<a href="#">Forget password ?</a>
            	</div>
            </div>
           <div class="row">
           	 <button type="submit" name="submit">Login</button>
           </div>
        </form>
        <!-- <div class="row">
        	<p>Or via social</p>
            <div class="social-btn-2">
            	<a class="fb" href="#"><i class="ion-social-facebook"></i>Facebook</a>
            	<a class="tw" href="#"><i class="ion-social-twitter"></i>twitter</a>
            </div>
        </div> -->
    </div>
</div>
<!--end of login form popup-->


<!-- BEGIN | Header -->
<header class="ht-header full-width-hd">
		<div class="row">
			<nav id="mainNav" class="navbar navbar-default navbar-custom">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header logo">
				    <div class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					    <span class="sr-only">Toggle navigation</span>
					    <div id="nav-icon1">
							<span></span>
							<span></span>
							<span></span>
						</div>
				    </div>
				    <a href="<?=base_url()?>"><img class="logo" src="<?=base_url()?>assets/landing-pages/images/logo1.png" alt="" width="70" height="70"></a>
			    </div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav flex-child-menu menu-left">
						<li class="hidden">
							<a href="#page-top"></a>
						</li>
						<li class="dropdown first">
							<a href="<?=base_url()?>" class="btn btn-default">Home</a>
						</li>	
						<li class="dropdown first">
							<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
							Buku<i class="fa fa-angle-down" aria-hidden="true"></i>
							</a>
							<ul class="dropdown-menu level1">

								<!-- get data category -->
								<?php 
								$categories = $this->db->where('parent_category', null)->get('categories')->result_array();
								foreach ($categories as $category) :?>

									<!-- query check data has parent -->
									<?php $check_parent = $this->db->where('parent_category', $category['id'])->get('categories')->num_rows();

									// count data book
									$count_book = $this->db->where('category_id', $category['id'])->get('books')->num_rows();

									if ($check_parent > 0) :?>
										<li class="dropdown">
											<a href="" class="dropdown-toggle" data-toggle="dropdown" ><?=$category['category_name']?><i class="ion-ios-arrow-forward"></i></a>
											<ul class="dropdown-menu level2">
												<?php
												$sub_categories = $this->db->where('parent_category', $category['id'])->get('categories')->result_array();
												foreach ($sub_categories as $sub_category) :?>

													<!-- query check data has parent -->
													<?php $check_parent = $this->db->where('parent_category', $sub_category['id'])->get('categories')->num_rows();

													// count data book
													$count_book = $this->db->where('category_id', $sub_category['id'])->get('books')->num_rows();
													
													if ($check_parent > 0) :?>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown" ><?=$sub_category['category_name']?><i class="ion-ios-arrow-forward"></i></a>
															<ul class="dropdown-menu level3">
																<?php
																$sub_sub_categories = $this->db->where('parent_category', $sub_category['id'])->get('categories')->result_array();
																foreach ($sub_sub_categories as $sub_sub_category) :
																	//query count sub sub category
																	$count_sub_sub_category = $this->db->where('parent_category', $sub_sub_category['id'])->get('categories')->num_rows(); 
																?>
																	
																	<li><a href="<?=base_url('book?viewStyle=grid&viewGroup=newest&category_id='.$sub_sub_category['id'])?>"><?=$sub_sub_category['category_name']?>
																			<i class="" style="opacity:0.4"><?=($count_sub_sub_category!=0) ? '('.$count_sub_sub_category.')' : '' ?></i>
																		</a>
																	</li>
																<?php endforeach; ?>
															</ul>
														</li>

													<?php else :?>
														<li><a href="<?=base_url('book?viewStyle=grid&viewGroup=newest&category_id='.$sub_category['id'])?>"><?=$sub_category['category_name']?><i><span class="" style="opacity: 0.4"><?=($count_book!=0) ? '('.$count_book.')' : ''?></span></i></a></li>
													<?php endif; ?>

												<?php endforeach; ?>
											</ul>
										</li>

									<?php else :?>
										<li><a href="<?=base_url('book?viewStyle=grid&viewGroup=newest&category_id='.$category['id'])?>"><?=$category['category_name']?><i><?=($count_book!=0) ? $count_book : ''?></i></a></li>
									<?php endif; ?>
							
								<?php endforeach; ?>
								
							</ul>
						</li>
						
					</ul>
					<ul class="nav navbar-nav flex-child-menu menu-right">
						<li class="dropdown first">
							
							<ul class="dropdown-menu level1">
								<li><a href="landing.html">Landing</a></li>
								<li><a href="404.html">404 Page</a></li>
								<li class="it-last"><a href="comingsoon.html">Coming soon</a></li>
							</ul>
						</li>                
						<?php if(isset($_SESSION['user']['user_name'])): ?>
						<li><a href="<?=base_url('user')?>">Profile</a></li>
						<li><a href="<?=base_url('user/logout')?>">Logout</a></li>
						<?php else: ?>
						<li class="loginLink"><a href="#">Login</a></li>
						<?php endif ?>
					</ul>
				</div>
			<!-- /.navbar-collapse -->
	    </nav>
	    <!-- search form -->
		</div>
	
</header>
<!-- END | Header -->

