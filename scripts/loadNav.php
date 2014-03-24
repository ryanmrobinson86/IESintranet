<ul>
	<li><a href="#">Software</a></li>
	<?php if(isset($_COOKIE['username']) && isset($_COOKIE['userLevel'])){
		if($_COOKIE['userLevel'] == 15){?>
			<li><a href="#">Admin</a></li>
		<?php }
	} ?>
</ul>
