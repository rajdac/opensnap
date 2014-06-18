<div class="scrollwrap">
    <!-- Define all of the tiles: -->  
	<?php 
		
	if( $data['error']['true'] )
	{		
			
	?>  
			<div class="box">	       
			   <?php echo $data['error']['description'];  ?>  
			</div>
		
	<?php  }else{ 
	
			if(count($data['pois_pois'])){ 
			
				foreach($data['pois_pois'] as $poi){
                  
				
				   $resturant_door_photo = $poi->DoorPhotos[0]->DoorPhoto[0]->UrlMedium;
                   $resturant_name = $poi->Name;
				?>
			  
					<div class="box">
					  <div class="boxInner">
						<a href="<?php echo  $poi->PoiUrl;?>"  target="_blank" ><img src="<?php echo  $resturant_door_photo; ?>" /></a>
						<div class="titleBox"><?php echo $resturant_name; ?></div>
					  </div>
					</div>
			
	<?php 
				}
			}
	
    }
  
    ?>
</div>                         