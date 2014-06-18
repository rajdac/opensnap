    <!-- Define all of the tiles: -->  
	<?php 
		
	if( $data['error']['true'] )
	{		
			
	?>  
			<div class="box">	       
			   <?php echo $data['error']['description'];  ?>  
			</div>
		
	<?php  }else{ 
	
			if(count($data['photos_photos'])){ 
			
				foreach($data['photos_photos'] as $photo){ ?>
			  
					<div class="box">
					  <div class="boxInner">					  
						<a href="<?php echo site_url('resturant/photodetail');?>/<?php echo $photo->SnapPhotoId; ?>" ><img src="<?php echo $photo->SmallPhotoUrl; ?>" /></a>
						<div class="titleBox"><?php echo $photo->DishName; ?></div>
					  </div>
					</div>
			
	<?php 
				}
			}	
    }
  
?>
