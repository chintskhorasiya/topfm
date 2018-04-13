<section id="container">
    <!--header start-->
    <?php echo $this->element('header'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        //print_r($_SESSION);
                        if(!empty($_SESSION['error_msg'])){
                            ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['error_msg'];unset($_SESSION['error_msg']); ?>
                            </div>
                            <?php
                        }

                        if(!empty($_SESSION['warning_msg'])){
                            ?>
                            <div class="alert alert-warning" style="display: none;">
                                <?php
                                echo $_SESSION['warning_msg'];
                                unset($_SESSION['warning_msg']);
                                ?>
                            </div>
                            <?php
                        }

                        if(!empty($_SESSION['success_msg'])){
                            ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION['success_msg'];unset($_SESSION['success_msg']); ?>
                            </div>
                            <?php
                        }
                        ?>
                        <section class="panel  border-o">
                            <header class="panel-heading btn-primary">Edit Rj</header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <?php
                                    echo $this->Form->create('Rj', array('novalidate', 'type'=>'file'));

                                    echo $this->Form->input('title', array('class' => 'form-control input-lg', 'value' => $rjs_data['Rj']['title']));

                                    echo $this->Form->input('slug', array('class' => 'form-control input-lg', 'value' => $rjs_data['Rj']['slug']));

                                    echo $this->Tinymce->input('Rj.content', array(
                                                'label' => 'Content',
                                                'class' => 'tinymce-textarea form-control input-lg', 'value' => $rjs_data['Rj']['content']
                                                ),array(
                                                        'language'=>'en'
                                                ),
                                                'bbcode'
                                    );

                                    echo '<label>Images</label>';
                                    echo $this->Form->input('images.', array('type' => 'file'));

                                    $image_path = DISPLAY_URL_IMAGE.'rj_images/'.$rjs_data['Rj']['id'].'/thumb_';

                                    $add_images = $rjs_data['Rj']['images'];

                                    if(!empty($add_images))
                                    {   
                                        echo '<div class="form-group col-md-12 padding-left-o">';
                                        echo '<div class="col-md-2"><label>Images selected when add:<label></div>';
                                    	echo '<input type="hidden" name="data[Rj][old_image]" value="'.$add_images.'" />';

                                        $add_images = explode(',', $add_images);

                                        echo '<div class="col-md-10">';
                                        
                                        foreach ($add_images as $add_img_num => $add_img) {

                                            echo '<div class="col-md-2 add_image_div">';
                                            echo '<img src="'.$image_path.$add_img.'" width="50" height="50" />&nbsp;&nbsp;&nbsp;';
                                            echo '<input type="hidden" name="data[Rj][add_image][]" value="'.$add_img.'" />';
                                            //echo '<input type="button" class="remove-img btn-small btn-info" value="Remove">';
                                            echo '</div>';
                                        }

                                        echo '</div>';

                                        echo '</div>';


                                    }

                                    //var_dump($rjs_data['Rj']['status']);exit;

                                    echo $this->Form->input('facebook_link', array('class' => 'form-control input-lg', 'value' => $rjs_data['Rj']['facebook_link']));
                                    echo $this->Form->input('twitter_link', array('class' => 'form-control input-lg' , 'value' => $rjs_data['Rj']['twitter_link']));
                                    echo $this->Form->input('instagram_link', array('class' => 'form-control input-lg', 'value' => $rjs_data['Rj']['instagram_link']));
                                    ?>

                                    <div class="form-group col-md-12 padding-left-o">
                                        <label>Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Rj][status]" class="form-control-radio" value="1" <?php if($rjs_data['Rj']['status'] == "1"){ echo 'checked="checked"'; } ?> />Published
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Rj][status]" class="form-control-radio" value="0" <?php if($rjs_data['Rj']['status'] == "0"){ echo 'checked="checked"'; } ?> />Draft
                                            </label>
                                        </div>
                                    </div>

                                    <div class="submit-area">
                                    <?php
                                    echo $this->Form->submit('Submit', array('class' => 'btn btn-info'));
                                    echo $this->Html->link('Cancel', DEFAULT_ADMINURL.'rjs/lists', array('class' => 'btn btn-info'));
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
        <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.remove-img').click(function(){
                console.log(jQuery(this).parent());
                jQuery(this).parent().remove();
            })
        });
        </script>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>