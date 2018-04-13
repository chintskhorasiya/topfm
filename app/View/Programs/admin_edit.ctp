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
                            <header class="panel-heading btn-primary">Edit Program</header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <?php
                                    echo $this->Form->create('Program', array('novalidate'));
                                    
                                    echo $this->Form->input('title', array('class' => 'form-control input-lg', 'value' => $program_data['Program']['title']));

                                    echo $this->Form->input('slug', array('class' => 'form-control input-lg', 'value' => $program_data['Program']['slug']));
                                    
                                    //echo $this->Form->input('content', array('rows' => '10', 'class' => 'form-control input-lg'));

                                    echo $this->Tinymce->input('Program.content', array(
                                                'label' => 'Content',
                                                'class' => 'tinymce-textarea form-control input-lg', 'value' => $program_data['Program']['content']
                                                ),array(
                                                        'language'=>'en'
                                                ),
                                                'bbcode'
                                    );

                                    
                                    echo $this->Form->input('facebook_link', array('class' => 'form-control input-lg', 'value' => $program_data['Program']['facebook_link']));

                                    echo $this->Form->input('twitter_link', array('class' => 'form-control input-lg', 'value' => $program_data['Program']['twitter_link']));

                                    echo $this->Form->input('program_time', array('class' => 'form-control', 'value' => $program_data['Program']['program_time']));
                                    ?>
                                    <div class="form-group col-md-12 padding-left-o">
                                        <label>Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Program][status]" class="form-control-radio" value="1" <?php if($program_data['Program']['status'] == "1"){ echo 'checked="checked"'; } ?> />Published
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Program][status]" class="form-control-radio" value="0" <?php if($program_data['Program']['status'] == "0"){ echo 'checked="checked"'; } ?> />Draft
                                            </label>
                                        </div>
                                    </div>
                                    <div class="submit-area">
                                    <?php
                                    echo $this->Form->submit('Submit', array('class' => 'btn btn-info'));
                                    
                                    echo $this->Html->link('Cancel', DEFAULT_ADMINURL.'programs/lists', array('class' => 'btn btn-info'));
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>