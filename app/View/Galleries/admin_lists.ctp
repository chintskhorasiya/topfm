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

                    if($this->Session->read('search_key') != "" && $from_search)
                    {
                       $search_key = $this->Session->read('search_key');
                    }
                    else
                    {
                       $search_key = "";
                    }
                    //var_dump($search_key);
                    ?>
                    <section class="panel">
                        <div class="panel-body">
                            <h4><?php echo $page_heading; ?></h4>
                            <p>List of galleries created by you.</p>
                            <div class="adv-table">
                                <?php
                                echo $this->Html->link(
                                    'Add Gallery',
                                    '/admin/galleries/add',
                                    array('class' => 'btn btn-info btn-submit')
                                );

                                if(isset($galleries) && count($galleries)>0) 
                                {
                                ?>

                                <?php
                                
                                echo $this->Form->create('gallerySearch', array('url' => array('controller' => 'galleries', 'action' => 'search')));
                                echo '<div class="search-bar">';
                                echo $this->Form->input('searchtitle', array('label'=>'Search Title','class' => 'form-control input-lg', 'value'=>$search_key));
                                echo $this->Form->submit('Search');
                                echo '</div>';
                                echo $this->Form->end();

                                echo $this->Form->create('galleriesList',array('url' => array('controller' => 'galleries', 'action' => 'delete_selected')));
                                ?>
                                <input type="submit" class="btn btn-info btn-delete" value="Delete Selected Gallery">
                                
                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th width="5%"></th>
                                            <th width="15%">Created Date</th>
                                            <th width="50%">Title</th>
                                            <th width="10%">Status</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i=0;$i<count($galleries);$i++)
                                            {
                                            ?>
                                            <tr class="gradeA">
                                                
                                                <td>
                                                	<input type="checkbox" name="gallery_checks[]" value ="<?php echo $galleries[$i]['Gallery']['id']; ?>">
                                                </td>
                                                
                                                <td class="align-center">
                                                	<?php echo $galleries[$i]['Gallery']['created']?>
                                                </td>
                                                
                                                <td>
                                                    <div class="btn-group zn-listing-link">
                                                        <?php echo $galleries[$i]['Gallery']['title']; ?>
                                                    </div>
                                                </td>

                                                <td>
                                                	<?php
                                                    if($galleries[$i]['Gallery']['status']=='1'){
                                                        ?>
                                                        <a href="javascript:void(0);" title="Published"><i class="fa fa-check"></i></a>
                                                        <?php
                                                    } else {
                                                    ?>
                                                        <a href="javascript:void(0);" title="Draft"><i class="fa fa-clock-o"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td> 
                                                    <a href="<?php echo DEFAULT_ADMINURL.'galleries/edit/galleryId:'.$galleries[$i]['Gallery']['id'];?>" class="btn btn-default">Edit</a>
                                                    |
                                                    <a href="<?php echo DEFAULT_ADMINURL.'galleries/delete/galleryId:'.$galleries[$i]['Gallery']['id'];?>" class="btn btn-default btn-delete">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>
                                </form>
                            </div>
                            <?php
                            //echo $this->Paginator->sort('user_id', null, array('direction' => 'desc'));
                            ?>
                            <!-- Shows the page numbers -->
                            <?php //echo $this->Paginator->numbers(); ?>
                            <!-- Shows the next and previous links -->
                            <?php echo $this->Paginator->prev('« Previous', array('class' => 'btn btn-default'), null, 
                                array('class' => 'disabled')); ?>
                            <?php echo $this->Paginator->next('Next »', array('class' => 'btn btn-default'), null,
                                array('class' => 'disabled')); ?> 
                            <!-- prints X of Y, where X is current page and Y is number of pages -->
                            <?php echo $this->Paginator->counter(); ?> 

                            <?php
                            } else {
                                if($from_search){
                                    echo $this->Form->create('gallerySearch', array('url' => array('controller' => 'galleries', 'action' => 'search')));
                                    echo '<div class="search-bar">';
                                    echo $this->Form->input('searchtitle', array('label'=>'Search Title', 'class' => 'form-control input-lg'));
                                    echo $this->Form->submit('Search');
                                    echo '</div>';
                                    echo $this->Form->end();

                                    echo "<h4>No Search Results</h4>";
                                } else {
                                    echo "<h4>No Records</h4>";
                                }
                            }
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <script type="text/javascript">
    jQuery(document).ready(function(){
    	jQuery('.btn-delete').click(function(){
    		var confirmed = confirm("Are you sure want to delete it?");
    		if(confirmed){

    		} else {
    			return false;
    		}
    	})
    });
    </script>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>