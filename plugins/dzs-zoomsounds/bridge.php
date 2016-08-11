<?php

require_once('get_wp.php');
//print_r($dzsap);
?>
<!doctype html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $dzsap->thepath; ?>audioplayer/audioplayer.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $dzsap->thepath; ?>dzstooltip/dzstooltip.css"/>
</head>
<body>
<?php
$args = array();
if(isset($_GET['type']) && $_GET['type']=='gallery'){
    
    $args = array(
        'id' => $_GET['id'],
        'embedded' => 'on',
    );


            if(isset($_GET['db'])){
                $args['db'] = $_GET['db'];
            };
    echo $dzsap->show_shortcode($args);

}


if(isset($_GET['type']) && $_GET['type']=='player'){
    
    
//    echo $_GET['margs'];
    $args = unserialize(stripslashes($_GET['margs']));
//    print_r($args);
    $args['embedded']='on';


    echo $dzsap->shortcode_player($args);

}


?>
<script type="text/javascript" src="<?php echo $dzsap->thepath; ?>audioplayer/audioplayer.js"></script>
</body>
</html>