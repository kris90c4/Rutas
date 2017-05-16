<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title ?></title>
    </head>
    <body>
    <?php if(isset($name)&&!is_array($name)):?>
    	<?php $name=array($name);?>
    <?php endif;?>
    <?php if(isset($name)):?>
    	<?php foreach ($name as $n) :?>
        	Hola <?php echo $n ?><br>
        <?php endforeach;?>
       <?php endif;?>
    </body>
</html>