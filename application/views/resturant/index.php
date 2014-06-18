<div id="container">
	<h1>Welcome to Opensanp!!</h1>
	<div id="body">
		<p>The page you are looking at is being generated dynamically by framework.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/resturant/index.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/resturant.php</code>
		<h3>Sample Request api</h3>
		<p>
			<?php
				  echo $request;					
			?>
		</p>
		      
	    <p>
			<form name="form1" method="post" action="/resturant/search/">
			  search :<input type="text" name="search" >&nbsp;<input type="submit" name="Search">	
            </form>						
		</p>
		
	</div>
	<div>
	  <h3>Sample output of api</h3>
		<p>
			<?php
				    echo '<pre>';
					  print_r($response);
				    echo '</pre>';
			
			?>
		</p>	
	</div>
	