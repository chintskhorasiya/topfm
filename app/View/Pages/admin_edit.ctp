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
                            <header class="panel-heading btn-primary">Edit Page</header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <?php
                                    echo $this->Form->create('Page', array('novalidate'));
                                    
                                    echo $this->Form->input('title', array('class' => 'form-control input-lg', 'value' => $page_data['Page']['title']));

                                    echo $this->Form->input('slug', array('class' => 'form-control input-lg', 'value' => $page_data['Page']['slug']));
                                    
                                    //echo $this->Form->input('content', array('rows' => '10', 'class' => 'form-control input-lg'));

                                    echo $this->Tinymce->input('Page.content', array(
                                                'label' => 'Content',
                                                'class' => 'tinymce-textarea form-control input-lg', 'value' => $page_data['Page']['content']
                                                ),array(
                                                        'language'=>'en'
                                                ),
                                                'bbcode'
                                    );

                                    //var_dump($page_data['Page']['status']);exit;
                                    ?>
                                    <div class="form-group col-md-12 padding-left-o">
                                        <label>Status</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Page][status]" class="form-control-radio" value="1" <?php if($page_data['Page']['status'] == "1"){ echo 'checked="checked"'; } ?> />Published
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="data[Page][status]" class="form-control-radio" value="0" <?php if($page_data['Page']['status'] == "0"){ echo 'checked="checked"'; } ?> />Draft
                                            </label>
                                        </div>
                                    </div>
                                    <div class="submit-area">
                                    <?php
                                    echo $this->Form->submit('Submit', array('class' => 'btn btn-info'));
                                    
                                    echo $this->Html->link('Cancel', DEFAULT_ADMINURL.'pages/lists', array('class' => 'btn btn-info'));
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