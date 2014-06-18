<ul class="tabs center">
	<li><a href="#tabr1">Latest Photos</a></li>
	<li><a href="#tabr2">Top Photos</a></li>
	<li><a href="#tabr3">Resturants</a></li>
</ul>
<div id="tabr1" class="tab-content" class="wrap tab-content">
	<div class="scrollwrap">
	<?php 
		   $data['data'] = $latest;
		   $this->load->view('partials/photoblock',$data); 
	?>
	</div>
</div>
<div id="tabr2" class="tab-content">  <!-- Define all of the tiles: -->  
	<div class="scrollwrap">
	 <?php 
		   $data['data'] = $top;
		   $this->load->view('partials/photoblock',$data);
	  ?>   
	</div>
</div>
<div id="tabr3" class="tab-content">Tab3</div>
<!-- /#wrap -->