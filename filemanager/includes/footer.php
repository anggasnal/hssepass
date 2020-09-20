<?php
/********************************************************************************
 * #                      Advanced File Manager v3.0
 * #******************************************************************************
 * #      Author:     Convergine.com
 * #      Email:      info@convergine.com
 * #      Website:    http://www.convergine.com
 * #
 * #
 * #      Version:    3.0
 * #      Copyright:  (c) 2009 - 2015 - Convergine.com
 * #
 * #*******************************************************************************/
 ?>
<script src="js/jquery.tipTip.js"></script>
<script>
    jQuery(function () {
        jQuery(".tipTip").tipTip({maxWidth: "auto", edgeOffset: 10, defaultPosition: "top"});
    });
</script>
<?php
    if($demo){
        echo "<div class='loginMessage loginError demoWarning'>! DEMO RESETS EVERY 15 MINUTES !</div>";
    }
?>
<!-- <div class="footer">
	<p>Copyright &copy; <?php //echo date("Y")?> Poject Management Officer PT PGN Tbk </p>
</div>-->
</body>
</html>