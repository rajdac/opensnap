<ul class="tabs center">
	<li><a href="#tabr1">Resturants</a></li>
</ul>

<div id="tabr1" class="tab-content" class="wrap tab-content">
	<?php 
       $data['data'] = $latest;
       $this->load->view('partials/poiblock',$data); 
	?>
</div>

<!-- /#wrap -->