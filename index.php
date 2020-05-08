<?php 
    include('includes/header.php'); 
?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	    <script type="text/javascript" src="./js/jquery.lazy.min.js"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>


    <?php 

        if(isset($_SESSION['folder'])){
        echo "<div id=\"lazy-container\">";
        date_default_timezone_set('America/New_York');
        $mainDir = '../../KG_uploads';
        $subDirectories = scandir($mainDir);
        unset($subDirectories[0]);
        unset($subDirectories[1]);
        
        foreach($subDirectories as $subDirectory) {
            foreach(glob($mainDir.'/'.$subDirectory.'/*') as $file){
            if (!substr($file, 0, 1) != '.') {
                $image_size = getimagesize("$mainDir/$subDirectory/$file");
                $image_name = basename($file);
                
                $directory = dirname($file);
                echo "<img class=\"lazy\" data-src=\"show_image.php?image=$image_name&imgLocation=$directory\"/>";
            }
        }
        
}
        echo "</div>"; } ?>
        
   

    <section id="info">
        <h3>info</h3>
        <p>This is a place to upload pictures of your cats</p>
    </section>
	<script type="text/javascript" src="./js/jquery.lazy.min.js"></script>
	<script>    $(function() {
        $('#lazy-container .lazy').lazy({
            appendScroll: $('#lazy-container')
        });
    });</script>
<?php include('includes/footer.php'); ?>
