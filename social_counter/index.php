<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Innovify :: G+ & YT Social Media Counts</title>

        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link type="text/css" rel="stylesheet" href="css/example.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    </head>
 
    <body>
        
     <div class="webcodo-top" >
        <a href="http://www.webcodo.net/facebook-twitter-google-instagram-dribbble-followers-jquery-ajax">
            <div class="wcd wcd-tuto"> </div>
        </a>
        <a href="http://webcodo.com">
            <div class="wcd wcd-logo">Innovify Social Counters</div>
        </a>
        <div class="wcd"></div>
    </div>

    <script type="text/javascript">

    var count_url = 'social_count.php';
    var social_networks = [
           'wcd_youtube',
            'wcd_gplus',
            'wcd_gplusprfl',
            
        ];
    $(function(){ 
        $.each(social_networks, function(key){
            $('.'+social_networks[key]).html('<img style="margin-left:50px;" src="img/ajax-loader.gif" />');
        });
    
        $.each(social_networks, function(key){
            $.ajax({
                type: "POST",
                url: count_url,
                data: 'act='+social_networks[key],
                error : 'error',
                success:function(html){
                    $('.'+social_networks[key]).html(html);
                    var str = html;
                    var url = str.split('://');
                    if(url[0] =='http' || url[0] == 'https')
                    {
                       $("#seturl").attr('src',str)
                	}}
            });
        });
    });
    
    </script>
	<?php
$json_output = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=aaBrZ2fEX8Y&key=AIzaSyDksehOi4G_812ZPNYgqd2YNP53uLVEbg0");
$youtubeDetail = json_decode($json_output,true);
$viewCounts = $youtubeDetail['items'][0]['statistics']['viewCount'];
	?>
    <div class="tuto-cnt">
<img id="seturl" src="" class="wcd_gplusprfl"></img>
        <div class="horizontal-cnt">

            <div class="soc-cnt">
                <div class="soc-img  gplus-icon"></div>
                <div class="soc-count wcd_gplus"></div>
                <div class="soc-lab">Followers</div>
            </div><!-- gplus container -->
            
          
			
			<div class="soc-cnt">
                <div class="soc-img  gplus-icon"></div>
                <div class="soc-count ">92,323</div>
                <div class="soc-lab">Page View</div>
            </div><!-- gplus container -->
			
			<div class="soc-cnt">
                <div class="soc-img  gplus-icon"></div>
                <div class="soc-count ">4,293</div>
                <div class="soc-lab">Circled</div>
            </div><!-- gplus container -->

			
            

        </div><!-- /horizontal-cnt {horizontal container} -->

			<div class="soc-cnt">
                <div class="soc-img  youtube-icon"></div>
                <div class="soc-count "><?php echo $viewCounts ?></div>
                <div class="soc-lab">viewCount</div>
            </div><!-- gplus container -->

        


    </div><!-- /tuto-cnt -->
    <iframe style="border: 0 none !important;height: 1000px;width: 100%;" id="site"></iframe>
</body>
<script>
$(document).ready(function(){
	site_url = "https://plus.google.com/105286435552581273822/posts";
	        $.ajax({
	            url: 'ajax.php',
	            method: 'post',
	            data: { site_url: site_url },
	            success: function (data) {
	                if(data){
	                	//$('#site').contents().find("body").html( data);
	                } else {
	                	alert('Something went wrong please try again');
	                }
	                
	            },
	            cache: false
	        });	
});


</script>
</html>