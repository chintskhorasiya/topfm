<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            <?php echo SITE_TITLE;?> |
            <?php echo (isset($page_title_tag) && $page_title_tag!='')?$page_title_tag:'';?>
        </title>
        <link rel="shortcut icon" href="<?php echo IMAGE_URL;?>favicon.png" type="image/png-icon"/>
        <link rel="icon" href="<?php echo IMAGE_URL;?>favicon.png" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <?php
        if($og_enabled){
            ?>
            <meta property="og:url"           content="<?=$og_url?>" />
            <meta property="og:type"          content="website" />
            <meta property="og:title"         content="<?=$og_title?>" />
            <meta property="og:description"   content="<?=$this->Common->limit_text($og_description, 15)?>" />
            <meta property="og:image"         content="<?=$og_image?>" />
            <?php
        }
        ?>
        <noscript>Your browser does not support JavaScript!</noscript>

        <?php /* */ ?>
        <script type="text/javascript"> var siteurl = "<?php echo SITE_URL; ?>";</script>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <?php if($front){ ?>
            <?php echo $this->Html->css(array('bootstrap.min','jquery-ui-1.10.1.custom.min', 'bootstrap-reset', 'frontstyle', 'font-awesome')); ?>
            <?php echo $this->Html->script(array('jquery-1.10.2.min','jquery-ui.min','bootstrap.min','accordion-menu/jquery.dcjqaccordion.2.7','jquery.scrollTo.min','jquery.nicescroll','jquery.slimscroll','scripts','acco-nav', 'moment-with-locales','bootstrap-datetimepicker')); ?>
            <?php
            if(isset($owl_enabled) && $owl_enabled == 'enabled'){
                echo $this->Html->css(array('owlcarousel/owl.carousel.min.css', 'owlcarousel/owl.theme.default.min.css'));
                echo $this->Html->script(array('owlcarousel/owl.carousel.js'));
            }
            ?>
            <?php
            if(isset($popup_enabled) && $popup_enabled == 'enabled'){
                echo $this->Html->css(array('mobilepopup/mobilepopup.min.css', 'mobilepopup/main1.css'));
                echo $this->Html->script(array('mobilepopup/mobilepopup.min.js', 'mobilepopup/common.js'));
            }
            ?>
        <?php } else { ?>
            <?php /* */ ?>
            <?php echo $this->Html->css(array('bootstrap.min','jquery-ui-1.10.1.custom.min', 'bootstrap-reset', 'style', 'font-awesome')); ?>
            <?php echo $this->Html->script(array('jquery-1.10.2.min','jquery-ui.min','bootstrap.min','accordion-menu/jquery.dcjqaccordion.2.7','jquery.scrollTo.min','jquery.nicescroll','jquery.slimscroll','scripts','acco-nav', 'moment-with-locales','bootstrap-datetimepicker')); ?>
        <?php //echo $this->Html->script(array('common')); ?>
        <?php } ?>
    </head>
    <?php
    $body_class = ($this->params['controller'] == 'users' && ($this->params['action']=='index' || $this->params['action']=='registration' || $this->params['action']=='forgot_password'))?$body_class = 'class="login-body"':'';
    ?>
    <body <?php echo $body_class;?> >
        <?php echo $content_for_layout; ?>
    </body>
</html>
<?php echo $this->element('sql_dump'); ?>