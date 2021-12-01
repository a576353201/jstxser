

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css" type="text/css" media="screen" />


<div class="step">

    <?php include_once template("user/userindex");?>
</div>



<script>
    var ismobile=<?php echo $ismobile; ?>;
    var menuid=4;
</script>
<?php include_once template("footer");?>