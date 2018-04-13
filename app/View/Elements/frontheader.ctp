<div class="container header-container">
<header class="header"> <!-- header start --> 
  	<div class="top-header"> <!-- top header start --> 
	  	<div class="search-box">
	      	<?php
	  		if($this->Session->read('front_search_news_key') != "" && $from_search)
			{
			   $search_key = $this->Session->read('front_search_news_key');
			}
			else
			{
			   $search_key = "";
			}
	  		?>
	      	<form action="<?=DEFAULT_FRONT_NEWS_SEARCH_RESULTS_URL?>" method="POST">
				<input type="text" name="search_query" id="search_query" value="<?=$search_key?>" placeholder="search">
		  	</form>
	  	</div>  
	 	<div class="social">
	 		<a href="<?=$social_data['facebook'];?>" target="_blank"><img src="<?=DEFAULT_URL?>img/facebook.png" alt="facebook" /></a>
	 		<a href="<?=$social_data['twitter'];?>" target="_blank"><img src="<?=DEFAULT_URL?>img/twitter.png" alt="twitter" /></a>
	 		<a href="<?=$social_data['youtube'];?>" target="_blank"><img src="<?=DEFAULT_URL?>img/you-tube.png" alt="you-tube" /></a>
	 		<a href="<?=$social_data['google'];?>" target="_blank"><img src="<?=DEFAULT_URL?>img/google.png" alt="google" /></a>
 		</div>
	 	<div class="clear"></div>
  	</div> <!-- top header end -->
	   
     <div class="logo-header"> <!-- logo header start --> 
	      <div class="logo"><a href="<?=DEFAULT_URL?>"><img src="<?=DEFAULT_URL?>img/logo.png" alt="logo" /></a></div>
 		  	
 		  	<?php
		  	if($ads_home_top_right_data)
		  	{
		  		if(!empty($ads_home_top_right_data['Advertise']['source'])){
		  		?>
		  		<div class="adv1"><a target="_blank" href="<?=$ads_home_top_right_data['Advertise']['link']?>"><img src="<?=$ads_home_top_right_data['Advertise']['source']?>" alt="<?=$ads_home_top_right_data['Advertise']['title']?>" /></a></div>
		  		<?php
		  		}
		  	}
		  	?> 

		   <div class="clear"></div>

		   	<ul class="logo-menu">  
			 <li><a href="<?=DEFAULT_URL?>live-tv">લાઈવ ટીવી</a></li>
			 <li><a href="<?=DEFAULT_URL?>videos">વિડીયો</a></li>
			 <li><a href="<?=DEFAULT_URL?>gallery">ફોટો ગેલેરી</a></li> 
			</ul> 
           
           <div class="clear"></div>

	  </div> <!-- logo header end -->
	  
      <div class="menu-header">  <!-- menu-header start -->
	    <nav class="navbar navbar-inverse"> 
		                       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
		    <ul class="nav navbar-nav navbar-collapse collapse">
				<li class="active home-menu"><a href="<?=DEFAULT_URL?>"><img src="<?=DEFAULT_URL?>img/home-icon.png" alt="home" /></a></li>
				<?php


		  		foreach ($header_cate_menus_data as $newscate_key => $newscate_data) {
		  			?>
		  			<!-- <li><a href="<?=DEFAULT_FRONT_NEWS_CATEGORY_URL.$newscate_data['NewsCategory']['slug']?>"><?=$newscate_data['NewsCategory']['name'];?></a></li> -->

		  			<li><a href="<?=DEFAULT_FRONT_NEWS_CATEGORY_URL.$newscate_data['slug']?>"><?=$newscate_data['name'];?></a>
		  			<?php	

		  			if(!empty($newscate_data['child_categories'])){
		  				?>
		  				<ul>
		  					<?php
		  					$child_cats = $newscate_data['child_categories'];
		  					foreach ($child_cats as $child_key => $child_data) {
		  						//var_dump($child_data);
		  						?>
		  						<li><a href="<?=DEFAULT_FRONT_NEWS_CATEGORY_URL.$child_data['slug']?>"><?=$child_data['name'];?></a></li>
		  						<?php
		  					}
		  					?>
		  				</ul>
		  				<?php
		  			}
		  			?>
		  			</li>
		  			<?php
		  		}
		  		?>
		  		<li><a href="<?=DEFAULT_URL?>marketing">માર્કેટિંગ યાર્ડ ભાવ</a></li>
		  		<li><a href="<?=DEFAULT_URL?>epapers-listing">ઈ-પેપર</a></li>
			</ul>
		</nav>
      </div>  <!-- menu-header end -->	   
 </header> <!-- header end -->
</div>
<div class="container">