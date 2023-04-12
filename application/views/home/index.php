<div class="slider sliderv2">
	<div class="container">
		<div class="row">
	    	<div class="slider-single-item">

				<?php $i = 0; ?>
				<?php foreach ($newBooks as $newBook): ?>
					<?php if($i <= 2) : ?>
						<div class="movie-item">
							<div class="row">
								<div class="col-md-8 col-sm-12 col-xs-12">
									<div class="title-in">
										<div class="cate">
											<span class="blue"><a href="#">Sci-fi</a></span>
											<span class="yell"><a href="#">Action</a></span>
											<span class="orange"><a href="#">advanture</a></span>
										</div>
										<h1><a href="#"><?=$newBook['title']?> <span><?=$newBook['publish_year']?></span></a></h1>
										<!-- <div class="social-btn">
											<a href="#" class="parent-btn"><i class="ion-play"></i> Watch Trailer</a>
										</div> -->
										<div class="mv-details">
											<p><i class="ion-android-star"></i><span>7.4</span> /10</p>
											<ul class="mv-infor">
												<li>  Run Time: 2h21’ </li>
												<li>  Rated: PG-13  </li>
												<li>  Release: 1 May 2015</li>
											</ul>
										</div>
										<div class="btn-transform transform-vertical">
											<div><a href="#" class="item item-1 redbtn">more detail</a></div>
											<div><a href= "#" class="item item-2 redbtn hvrbtn">more detail</a></div>
										</div>		
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="mv-img-2">
										<a href="#"><img src="<?=base_url('assets/img/books/').$newBook['cover_img']?>" alt=""></a>
									</div>
								</div>
							</div>	
						</div>
					<?php endif ?>

				<?php $i++; endforeach ?>

	    
	    		
	    	</div>
	    </div>
	</div>
</div>
<div class="movie-items  full-width">
	<div class="row">
		<div class="col-md-12">
			<div class="title-hd">
				<h2>Terbaru</h2>
				<a href="home/newest_book" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
			</div>
			<div class="tabs">
				<ul class="tab-links">
					<li class="active"><a href="#tab1-h2">.</a></li>                  
				</ul>
			    <div class="tab-content">
			        <div id="tab1-h2" class="tab active">
			            <div class="row">
			            	<div class="slick-multiItem2">

								<?php foreach ($newBooks as $key => $newBook) : ?>
									
									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="<?=base_url('assets/img/books/').$newBook['cover_img']?>" alt="">
											</div>
											<div class="hvr-inner">
												<a  href="<?=base_url('/home/book_detail/').$newBook['id']?>"> Read more <i class="ion-android-arrow-dropright"></i> </a>
											</div>
											<div class="title-in">
												<h6><a href="<?=base_url('/home/book_detail/').$newBook['id']?>"><?=$newBook['title']?></a></h6>
												<p><i class="ion-android-star"></i><span>4</span> /5</p>
											</div>
										</div>
									</div>
								
								<?php endforeach; ?>

						
			            		
			            	</div>
			            </div>
			        </div>
			        
			  
			    </div>
			</div>
			<div class="title-hd">
				<h2>Popular</h2>
				<a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
			</div>
			<div class="tabs">
				<ul class="tab-links-2">
					<li class="active"><a href="#tab21-h2">.</a></li>              
				</ul>
			    <div class="tab-content">
			        <div id="tab21-h2" class="tab active">
			            <div class="row">
			            	<div class="slick-multiItem2">

								<?php foreach ($popularBooks as $key => $popularBook) : ?>

									<div class="slide-it">
										<div class="movie-item">
											<div class="mv-img">
												<img src="<?=base_url('assets/img/books/').$popularBook['cover_img']?>" alt="">
											</div>
											<div class="hvr-inner">
												<a  href="<?=base_url('/home/book_detail/').$popularBook['id']?>"> Read more <i class="ion-android-arrow-dropright"></i> </a>
											</div>
											<div class="title-in">
												<h6><a href="<?=base_url('/home/book_detail/').$popularBook['id']?>"><?=$popularBook['title']?></a></h6>
												<p><i class="ion-android-star"></i><span>4</span> /5</p>
											</div>
										</div>
									</div>
								
								<?php endforeach; ?>

			            	</div>
			            </div>
			        </div>
		
		       	 	
			    </div>
			</div>
		</div>
	</div>
</div>


<!-- latest new v2 section-->
<div class="latestnew full-width">
		<div class="row">
			<div class="col-md-12">
				
				<div class="title-hd">
					<h2>Recomended</h2>
					<a href="bloggrid.html" class="viewall">see all news <i class="ion-ios-arrow-right"></i></a>
				</div>
				<div class="latestnewv2">
					<div class="blog-item-style-2">
						<a href="blogdetail.html"><img src="assets/landing-pages/images/uploads/blogv21.jpg" alt=""></a>
						<div class="blog-it-infor">
							<h3><a href="blogdetail.html">Godzilla: King Of The Monsters Adds O’Shea Jackson Jr</a></h3>
							<span class="time">27 Mar 2017</span>
							<p>Looks like Kong: Skull Island started a tradition with its casting of Straight ...</p>
						</div>
					</div>
					<div class="blog-item-style-2">
						<a href="blogdetail.html"><img src="assets/landing-pages/images/uploads/blogv22.jpg" alt=""></a>
						<div class="blog-it-infor">
							<h3><a href="blogdetail.html">First Official Images of Alicia Vikander As Tomb Raider’s Lara Croft</a></h3>
							<span class="time">27 Mar 2017</span>
							<p>Aside from the her digital incarnation, the most recognisable image of Tomb ...</p>
						</div>
					</div>
					<div class="blog-item-style-2">
						<a href="blogdetail.html"><img src="assets/landing-pages/images/uploads/blogv23.jpg" alt=""></a>
						<div class="blog-it-infor">
							<h3><a href="blogdetail.html">New Spider-Man: Homecoming Poster Finds Peter Parker At Rest</a></h3>
							<span class="time">27 Mar 2017</span>
							<p>He might be a primary protector of New York City, but at heart, Peter Parker is ...</p>
						</div>
					</div>
					<div class="blog-item-style-2">
						<a href="blogdetail.html"><img src="assets/landing-pages/images/uploads/blogv24.jpg" alt=""></a>
						<div class="blog-it-infor">
							<h3><a href="blogdetail.html">Joseph Gordon-Levitt Directing Moive Musical Comedy Wingmen</a></h3>
							<span class="time">27 Mar 2017</span>
							<p>A little over a year ago, we learned that Joseph Gordon-Levitt and Channing ...</p>
						</div>
					</div>
				</div>
			</div>
		
		</div>
	
</div>
<!--end of latest new v2 section-->

