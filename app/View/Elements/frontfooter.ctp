<footer>
	<div class="footer"> 
		<div class="clear"></div>
		<div class="middle-footer"> 
		   	<?php
			if(count($footer_pages_data) > 0){
			$last_foo_page_num = count($footer_pages_data)-1;
			?>
		   	<ul>
			    <li><a href="<?=DEFAULT_URL?>">Home</a></li> |
			    <?php
			    foreach ($footer_pages_data as $foo_page_key => $foo_page_data) {
			    	?>
			    	<li><a href="<?php echo DEFAULT_URL.'page/'.$foo_page_data['Page']['slug']; ?>"><?php echo mb_substr($foo_page_data['Page']['title'], 0, 19); ?></a></li><?php if($foo_page_key < $last_foo_page_num) { ?>|<?php } ?>
			    	<?php
			    }
			    ?>
		   	</ul>
		   	<?php
		   	}
		   	?>
		   	<!--<ul>
			    <li><a href="#">Home</a></li> |
				<li><a href="#">About Us</a></li> |
	            <li><a href="#">Disclaimer</a></li> |  
	            <li><a href="#">Sitemap</a></li> |
				<li><a href="#">Contact Us</a></li> 
		   	</ul>-->  
			<div class="copy">
		   		<div class="copy-left">Copyright © 2017 Krushi Prabhat. | Design & Developed By <a href="http://www.seawindsolution.com" target="_blank">Seawind Solution Pvt. Ltd.</a></div> 
		   		<div class="clear"></div>
			</div>
		</div>
	</div>
</footer>
</div>