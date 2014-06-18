<!DOCTYPE html>
<html>
<head>
	<!-- META -->
	<title>HTML KickStart Elements</title>
		
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="" />
	<style type="text/css">
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-font-smoothing: antialiased;
		-moz-font-smoothing: antialiased;
		-o-font-smoothing: antialiased;
		font-smoothing: antialiased;
		text-rendering: optimizeLegibility;
		/* font-size: 82.5%; */
    }
    	
    body {
      font: 12px Arial,Tahoma,Helvetica,FreeSans,sans-serif;
	  text-transform: inherit;
	  color: #333;
	  background: #e7edee;
	  width: 100%;
    }
    .wrap, .scrollWrap{
		width: 720px;
		margin: 10px auto;
		padding: 10px 10px;
		background: white;
		border: 2px solid #DBDBDB;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		overflow: hidden; 
    }
	.item{
		margin: 10px 0;
		padding: 5px 10px;
		background: #f9f9f9;
		border-radius: 5px;
    }
	a{ text-decoration: none; color: #333}
	h1{
		font-family: Georgia, "Times New Roman", Times, serif;
		font-size: 2.8em;
		text-align: center;
		margin: 15px 0;
	}
	h2{font-size: 1.5em; margin: 8px 0}
	h2 span.name{font-size: 1em}
	h2 span.num{font-size: 1.5em; font-style: italic}
	.item p{text-transform: lowercase}

	/*Loader style*/
	.ias_loader, .ias_trigger {
		text-align:center;
		margin: 30px 0 40px;
	}
	.ias_trigger a:link,
	.ias_trigger a:visited {
		padding: 4px 50px;

		background-color: #f9f9f9;
		border: solid 1px #ddd;
		border-radius: 2px;

		font: bold 12px Arial, sans-serif;
		color: #555;
		text-decoration: none;
	}
	.ias_trigger a:hover,
	.ias_trigger a:active {
		border-color: #ccc;
	}
	
	
	
			loading-bar {
			padding: 10px 20px;
			display: block;
			text-align: center;
			box-shadow: inset 0px -45px 30px -40px rgba(0, 0, 0, 0.05);
			border-radius: 5px;
			margin: 20px 0;
			font-size: 2em;
			font-family: "museo-sans", sans-serif;
			border: 1px solid #ddd;
			margin-right: 1px;
			font-weight: bold;
			cursor: pointer;
			position: relative;
		}

		.loading-bar:hover {
			box-shadow: inset 0px 45px 30px -40px rgba(0, 0, 0, 0.05);
		}

		#content {
			width: 100%;
			margin: 0px auto;
		}

		#content h1 {
			font-family: "chaparral-pro", sans-serif;
			color: #444;
			font-size: 4.2em;
		}

		#content h1 a {
			color: #444;
			text-decoration: none;
		}

		#content h1 a:hover {
			color: #666;
		}

		#content p {
			font-size: 2em;
			line-height: 1.7em;
			font-family: "museo-sans", sans-serif;
			text-align: justify;	
		}

		#content hr {
			border-bottom: 1px solid #eee;
			border-top: 0;
			border-left: 0;
			border-right: 0;
		}


		#travel {
			padding: 10px;
			background: rgba(0,0,0,0.6);
			border-bottom: 2px solid rgba(0,0,0,0.2);
			font-variant: normal;
			text-decoration: none;
		}

		#travel a {
			font-family: 'Georgia', serif;
			text-decoration: none;
			border-bottom: 1px solid #f9f9f9;
			color: #f9f9f9;
			font-size: 1.5em;
		}
	 	
	
/* Caption Style 7 */
.cs-style-7 li:first-child { z-index: 6; }
.cs-style-7 li:nth-child(2) { z-index: 5; }
.cs-style-7 li:nth-child(3) { z-index: 4; }
.cs-style-7 li:nth-child(4) { z-index: 3; }
.cs-style-7 li:nth-child(5) { z-index: 2; }
.cs-style-7 li:nth-child(6) { z-index: 1; }

.cs-style-7 figure img {
	z-index: 10;
}

.cs-style-7 figcaption {
	height: 100%;
	width: 100%;
	opacity: 0;
	pointer-events: none;
	-webkit-backface-visibility: hidden;
	-moz-backface-visibility: hidden;
	backface-visibility: hidden;
	-webkit-transition: opacity 0.3s, height 0.3s, box-shadow 0.3s;
	-moz-transition: opacity 0.3s, height 0.3s, box-shadow 0.3s;
	transition: opacity 0.3s, height 0.3s, box-shadow 0.3s;
	box-shadow: 0 0 0 0px #2c3f52;
}

.no-touch .cs-style-7 figure:hover figcaption,
.cs-style-7 figure.cs-hover figcaption {
	pointer-events: auto;
	opacity: 1;
	height: 130%;
	box-shadow: 0 0 0 10px #2c3f52;
}

.cs-style-7 figcaption h3 {
	margin-top: 86%;
}

.cs-style-7 figcaption h3,
.cs-style-7 figcaption span,
.cs-style-7 figcaption a {
	opacity: 0;
	-webkit-transition: opacity 0s;
	-moz-transition: opacity 0s;
	transition: opacity 0s;
}

.cs-style-7 figcaption a {
	position: absolute;
	bottom: 20px;
	right: 20px;
}

.no-touch .cs-style-7 figure:hover figcaption h3,
.no-touch .cs-style-7 figure:hover figcaption span,
.no-touch .cs-style-7 figure:hover figcaption a,
.cs-style-7 figure.cs-hover figcaption h3,
.cs-style-7 figure.cs-hover figcaption span,
.cs-style-7 figure.cs-hover figcaption a {
	-webkit-transition: opacity 0.3s 0.2s;
	-moz-transition: opacity 0.3s 0.2s;
	transition: opacity 0.3s 0.2s;
	opacity: 1;
}	



		
    .box {
      float: left;
      position: relative;
      width: 20%;
      padding-bottom: 20%;

    }
    .boxInner {
      position: absolute;
      left: 10px;
      right: 10px;
      top: 10px;
      bottom: 10px;
      overflow: hidden;
	  margin: 1% 0 1% 2.6%;
	  box-shadow:0 0 5px #aaa;
	  -webkit-box-shadow:0 0 5px #aaa;
	  -moz-box-shadow:0 0 5px #aaa;
	  -o-box-shadow:0 0 5px #aaa;
    }
    .boxInner img {
     display: block;
	 width:100%;
     border: 1px solid #f0f0f0;
    }
   .titleBox {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      margin-bottom: -150px;
      background: #000;
      background: rgba(0, 0, 0, 0.5);
      color: #FFF;
      padding: 10px;
      text-align: center;
      -webkit-transition: all 0.3s ease-out;
      -moz-transition: all 0.3s ease-out;
      -o-transition: all 0.3s ease-out;
      transition: all 0.3s ease-out;
    }
    body.no-touch .boxInner:hover .titleBox, body.touch .boxInner.touchFocus .titleBox {
      margin-bottom: 0;
    }
    @media only screen and (max-width : 480px) {
      /* Smartphone view: 1 tile */
      .box {
        width: 100%;
        padding-bottom: 100%;
      }
    }
    @media only screen and (max-width : 650px) and (min-width : 481px) {
      /* Tablet view: 2 tiles */
      .box {
        width: 50%;
        padding-bottom: 50%;
      }
    }
    @media only screen and (max-width : 1050px) and (min-width : 651px) {
      /* Small desktop / ipad view: 3 tiles */
      .box {
        width: 33.3%;
        padding-bottom: 33.3%;
      }
    }
    @media only screen and (max-width : 1290px) and (min-width : 1051px) {
      /* Medium desktop: 4 tiles */
      .box {
        width: 25%;
        padding-bottom: 25%;
      }
    }
	
  .ui-autocomplete-loading {
    background: white url('assets/images/ui-anim_basic_16x16.gif') right center no-repeat;
  }
     .ui-autocomplete-category {
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
	.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
  </style>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/HTML-KickStart-master/css/kickstart.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/HTML-KickStart-master/style.css" media="all" /> 
	
	<!-- Javascript -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js-lib/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/HTML-KickStart-master/js/kickstart.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js-lib/jquery/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="<?php echo base_url(); ?>assets/js-lib/jquery/ui/1.10.4/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url(); ?>assets/js-lib/jquery/ui/1.10.4/js/jquery-ui-1.10.4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js-lib/jquery/plugins/jquery-ias.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js-lib/jquery/g3debug-master/g3debug.js"></script>
	
</head>
<body class="no-touch" data-baseurl="<?php echo base_url();?>">
	<div class="grid">		
		<div class="col_12" style="margin-top:100px;">
			
			<?php 
				
				$this->load->helper('form');	
				echo form_open('resturant/search');
			?>	
				<input type="hidden" name="search_sav" id="search_sav" value="<?php echo $search_sav; ?>">	
                <input type="hidden" name="current_tab" id="current_tab" value="<?php echo $current_tab; ?>">
                <input type="hidden" name="search_type" id="search_type" value="<?php echo $search_type; ?>"> 
                <input type="hidden" name="ORPoiId" id="ORPoiId" value="<?php echo $ORPoiId; ?>">
                <input type="hidden" name="ItemId" id="ItemId" value="<?php echo $ItemId; ?>">
				<input type="hidden" name="ORRegionId" id="ORRegionId" value="<?php echo $ORRegionId; ?>">
				                
				<div class="control-group">
					<div class="ui-widget">
						<label for="search">Search: </label>
						<input id="search" name="search" >&nbsp;<input type="submit" name="Go" value="Go">
					</div>					
				</div>
				<!-- Debug
					<div class="ui-widget" style="margin-top:2em; font-family:Arial">
					  Result:
					<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
				-->				
				<?php 	echo form_close(); ?>
		</div>
		 
		<?php echo $template['body']; ?>

	</div> <!-- End Grid -->
    <script type="text/javascript">
	
		$(document).ready(function () {
		
		    $.widget( "custom.catcomplete", $.ui.autocomplete, {
			 _renderMenu: function( ul, items ) {
				var self = this,
					currentCategory = "";
				$.each( items, function( index, item ) {
					if ( item.SearchType != currentCategory && item.SearchType != 14 ) {
						ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
						currentCategory = item.SearchType;
					}
					self._renderItemData( ul, item );
				});
			  },
		    });
		  
		    $("#tabr1 .scrollwrap").scrollPagination({

				nop     : 24, // The number of photos per scroll to be loaded
				offset  : 25, // Initial offset, begins at 0 in this case
				error   : 'No More photos!', // When the user reaches the end this is the message that is
											// displayed. You can change this if you want.
				delay   : 2000, // When you scroll down the photos will load after a delayed amount of time.
							   // This is mainly for usability concerns. You can alter this as you see fit
				scroll  : true // The main bit, if set to false photos will not load as the user scrolls. 
							   // but will still load if the user clicks.
		
		    });
			
			
			$("#tabr2 .scrollwrap").scrollPagination({

				nop     : 24, // The number of photos per scroll to be loaded
				offset  : 25, // Initial offset, begins at 0 in this case
				error   : 'No More photos!', // When the user reaches the end this is the message that is
											// displayed. You can change this if you want.
				delay   : 2000, // When you scroll down the photos will load after a delayed amount of time.
							   // This is mainly for usability concerns. You can alter this as you see fit
				scroll  : true // The main bit, if set to false photos will not load as the user scrolls. 
							   // but will still load if the user clicks.
		
		    });
		    
		});
		
		$(function() {
		
		        var sr2url = 'http://www.openrice.com/english/restaurant/sr2.htm'; 
				function log( message ) {
				  $( "<div>" ).text( message ).prependTo( "#log" );
				  $( "#log" ).scrollTop( 0 );
				}
				 var cache = {};
				$( "#search" ).catcomplete({
				  source: function( request, response ) {
				  var term = request.term;
					if ( term in cache ) {
					  response( cache[ term ] );
					  return;
					}
					$.ajax({
								 url: $('body').data('baseurl') + "index.php/autocomplete",
							dataType: "json",
							  data: {
										featureClass: "P",
										style: "full",
										maxRows: 12,
										name_startsWith: request.term,
										search_type:$("#search_type").val()
									},
						success: function( items ) 
						{
							cache[ term ] = items;				
							response( $.map( items, function( item )
							{
								var searchCat = {
													1:'District',
													2:'Landmark', 
													3:'Dish',     // code table Dish
													4:'Cuisine',
													5:'Amenity',
													10:'Poi',
													11:'Chain',
													12:'DishName',    // SnapPhoto Dish Name Id (SnapDishNameId)
													13:'FreeTextTag', 
												    14:'Keyword'																									
												}
												
										return {
												/*
													[CountryId] => 1
													[ItemId] => 510
													[Keyword] => piz
													[Name] => Pizza
													[ORPoiId] => 
													[ORRegionId] => 
													[PhotoCount] => 348
													[PhotoCountText] => 348
													[SearchTipType] => 12
													label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
													value: item.name
												*/
													label: item.Name + (item.PhotoCount > 0 ? ' ('+item.PhotoCountText+')' : ""),
													value: item.Name,
													id: item.ItemId,
													CountryId:item.CountryId,
													ORRegionId:item.ORRegionId,
													ORPoiId: item.ORPoiId,
													SearchType:item.SearchTipType,
													category:searchCat[item.SearchTipType]
												}
												
							}));
						}
					});
				},
			    minLength: 2,
				  
				focus: function(event, ui) {
						$('#search').val(ui.value);						
						return false;
				},
				select: function( event, ui ) {
				
				        $("#ItemId").val(ui.item.id);
                        $("#search_type").val(ui.item.SearchType);
						
						switch(parseInt(ui.item.SearchType))
						{
							case 10:
								$("#ORPoiId").val(ui.item.ORPoiId);
								var url = sr2url + '?shopid=' + ui.item.ORPoiId;
							    window.open(url);	
								break;
							case 11:
								
								break;
							default:
								   
						}
						
					// g3.debug(ui).popup('o');
					
					/*
					  log( ui.item ?
					  "Selected: " + ui.item.label :
					  "Nothing selected, input was " + this.value);
					*/  
				},
				open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
					$("#search").css('width', '250px');
				},
				close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				}
			});
		});
	  
		$(function(){
			// See if this is a touch device
			if ('ontouchstart' in window)
			{
				// Set the correct body class
				$('body').removeClass('no-touch').addClass('touch');
				
				// Add the touch toggle to show text
				$('div.boxInner img').click(function(){
				  $(this).closest('.boxInner').toggleClass('touchFocus');
				});
			}
		});

		(function($) {

			$.fn.scrollPagination = function(options) {
			
				var settings = { 
			
								nop     : 10, // The number of photos per scroll to be loaded
								offset  : 10, // Initial offset, begins at 0 in this case
								error   : 'No More photos!', // When the user reaches the end this is the message that is
															// displayed. You can change this if you want.
								delay   : 500, // When you scroll down the photos will load after a delayed amount of time.
											   // This is mainly for usability concerns. You can alter this as you see fit
								scroll  : true // The main bit, if set to false photos will not load as the user scrolls. 
											   // but will still load if the user clicks.
				}
			
				// Extend the options so they work with the plugin
				if(options) {
					$.extend(settings, options);
				}
			
				$settings = settings;
				var offset = $settings.offset;
				var offset1 = $settings.offset;
				var offset2 = $settings.offset;
				var busy = false;
			
				// For each so that we keep chainability.
				return this.each(function() {		
			
					// Some variables 
					$this = $(this);
					
					// Checks if the scroll action is happening 
					// so we don't run it multiple times
				
					// Custom messages based on settings
					if($settings.scroll == true) $initmessage = 'Scroll for more or click here';
					else $initmessage = 'Click for more';
				
					// Append custom messages and extra UI
					$this.append('<div class="content"></div><div class="loading-bar">'+$initmessage+'</div>');
								
					function getData()
					{
										   
						$.ajax({    dataType: "html",
									 url: $('body').data('baseurl') + "index.php/resturant/scrollpagination",
									 cache: false,
									 timeout: 30000,
								data: {
										  nop         : $settings.nop,
										  offset1      : offset1,
										  offset2      : offset2,
										  search_sav: $("#search_sav").val(),
										  current_tab:$("#current_tab").val()
										  
									 },
							success: function(items_html) 
									{
										// Change loading bar content (it may have been altered)
										$('.loading-bar').html($initmessage);
											
										// If there is no data returned, there are no more photos to be shown. Show error
										if(items_html == "")
										{ 							
											$('.loading-bar').html($settings.error);	
											
										}else {
											
											var tab = $("#current_tab").val();
											// Offset increases
											
											if(tab == '#tabr2')
											 offset2 = offset2+$settings.nop; 
											else
											 offset1 = offset1+$settings.nop; 
										      
											//alert(items_html);	
											// Append the data to the content div
											
											$(".content").append(items_html);
											
											// No longer busy!	
											busy = false;
										}								
									}
						});
											
					}	
				
					// getData(); // Run function initially			
					// If scrolling is enabled
					if($settings.scroll == true) {
						// .. and the user is scrolling
						$(window).scroll(function() {
						
							// Check the user is at the bottom of the element
							if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
								
								// Now we are working, so busy is true
								busy = true;					
								// Tell the user we're loading photos
								$('.loading-bar').html('Loading Photos');
								
								// Run the function to fetch the data inside a delay
								// This is useful if you have content in a footer you
								// want the user to see.
								setTimeout(function() {						
									getData();							
								}, $settings.delay);						
							}	
						});
					}
				
					// Also content can be loaded by clicking the loading bar/
					$('.loading-bar').click(function() {
				
						if(busy == false)
						{
							busy = true;
							getData();
						}
				
					});
				
				});
			}

		})(jQuery);
</script>
</body>
</html>