<?php echo $this->Html->docType(); ?>
<?php echo $this->Html->layout('meta'); ?>
<html>
<head>
	<title><?php echo (isset($title_for_layout) && $title_for_layout) ? $title_for_layout : "ENK-Generator"; ?></title>
	<?php echo $this->Html->charset('utf-8'); ?>
	
	<?php echo $this->Html->meta('viewport', 'width=device-width, initial-scale=1.0'); ?>
	<?php echo $this->Html->meta('icon', 'img/favicon.ico'); ?>

	<?php echo $this->Html->layout('meta'); ?>

	<?php echo $this->Html->css('bootstrap', true); ?>
	<?php echo $this->Html->css('generator', true); ?>

	<?php echo $this->Html->layout('css'); ?>
</head>
<body>
	<?php echo $this->Session->flash(); ?>

	<?php echo $this->Html->element('menu'); ?>

	<section>
	    <div class="row">
	        <div id="right-panel">
				<?php echo $content_for_layout; ?>
	        </div>  
	    </div>
	</section>

	<?php echo $this->Html->script('jquery-1.11.2.min', true); ?>
	<?php echo $this->Html->script('bootstrap.min', true); ?>
	<?php echo $this->Html->script('generator', true); ?>

	<?php echo $this->Html->layout('js'); ?>
</body>
</html>