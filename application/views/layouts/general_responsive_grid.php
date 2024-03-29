<!DOCTYPE html>
<html>
<!--
  Created using jsbin.com
  Source can be edited via http://jsbin.com/aseram/1/edit
-->
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">

  <!-- Enable responsive view on mobile devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>Responsive Tiled Photo Gallery in Pure CSS</title>
  
  <style type="text/css">
    body {
      margin: 0;
      padding: 0;
      background: #EEE;
      font: 10px/13px 'Lucida Sans',sans-serif;
    }
    .wrap {
      overflow: hidden;
      margin: 10px;
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
    }
    .boxInner img {
      width: 100%;
    }
    .boxInner .titleBox {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      margin-bottom: -50px;
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
  </style>
  <!-- Enable media queries for old IE -->
  <!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->


<style id="jsbin-css">

</style>
</head>

<body class="no-touch">

    <?php echo $template['body']; ?>
  
  <!-- Add some JavaScript to enable toggling the descriptions when an image is tapped on a touchscreen device -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script type="text/javascript">
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
  </script>
  
<script>

</script>
<script src="http://static.jsbin.com/js/render/edit.js?3.13.29"></script>
<script>jsbinShowEdit({"static":"http://static.jsbin.com","root":"http://jsbin.com","csrf":"NBmCE47RkBWLOTeh/s4Nww+J"});</script>
<script>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-1656750-34']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
})();
</script>
</body>
</html>
