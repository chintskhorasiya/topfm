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
                            <header class="panel-heading btn-primary">Edit Schedule</header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <?php
                                    echo $this->Form->create('Schedule', array('novalidate', 'type'=>'file'));

                                    $weekday_options = array('sunday' => 'Sunday', 'monday' => 'Monday', 'tuesday'=>'Tuesday', 'wednesday'=>'Wednesday', 'thursday'=>'Thursday', 'friday'=>'Friday', 'saturday'=>'Saturday');

                                    echo $this->Form->input('weekday', array('class' => 'form-control input-lg', 'options' => $weekday_options));

                                    echo $this->Form->input('title', array('class' => 'form-control input-lg', 'value' => $schedules_data['Schedule']['title']));

                                    echo $this->Form->input('slug', array('class' => 'form-control input-lg', 'value' => $schedules_data['Schedule']['slug']));
                                    
                                    //echo $this->Form->input('content', array('rows' => '10', 'class' => 'form-control input-lg'));

                                    echo $this->Tinymce->input('Schedule.content', array(
                                                'label' => 'Content',
                                                'class' => 'tinymce-textarea form-control input-lg', 'value' => $schedules_data['Schedule']['content']
                                                ),array(
                                                        'language'=>'en'
                                                ),
                                                'bbcode'
                                    );

                                    echo '<label>Images</label>';
                                    echo $this->Form->input('images.', array('type' => 'file'));

                                    $image_path = DISPLAY_URL_IMAGE.'schedule_images/'.$schedules_data['Schedule']['id'].'/thumb_';

                                    $add_images = $schedules_data['Schedule']['images'];

                                    if(!empty($add_images))
                                    {   
                                        echo '<div class="form-group col-md-12 padding-left-o">';
                                        echo '<div class="col-md-2"><label>Images selected when add:<label></div>';
                                    	echo '<input type="hidden" name="data[Schedule][old_image]" value="'.$add_images.'" />';

                                        $add_images = explode(',', $add_images);

                                        echo '<div class="col-md-10">';
                                        
                                        foreach ($add_images as $add_img_num => $add_img) {

                                            echo '<div class="col-md-2 add_image_div">';
                                            echo '<img src="'.$image_path.$add_img.'" width="50" height="50" />&nbsp;&nbsp;&nbsp;';
                                            echo '<input type="hidden" name="data[Schedule][add_image][]" value="'.$add_img.'" />';
                                            //echo '<input type="button" class="remove-img btn-small btn-info" value="Remove">';
                                            echo '</div>';
                                        }

                                        echo '</div>';

                                        echo '</div>';


                                    }

                                    //var_dump($schedules_data['Schedule']['status']);exit;
                                    ?>

                                    <div class="form-group col-md-12 padding-left-o">
                                        <label>Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Schedule][status]" class="form-control-radio" value="1" <?php if($schedules_data['Schedule']['status'] == "1"){ echo 'checked="checked"'; } ?> />Published
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Schedule][status]" class="form-control-radio" value="0" <?php if($schedules_data['Schedule']['status'] == "0"){ echo 'checked="checked"'; } ?> />Draft
                                            </label>
                                        </div>
                                    </div>

                                    <div class="submit-area">
                                    <?php
                                    echo $this->Form->submit('Submit', array('class' => 'btn btn-info'));
                                    echo $this->Html->link('Cancel', DEFAULT_ADMINURL.'schedules/lists', array('class' => 'btn btn-info'));
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