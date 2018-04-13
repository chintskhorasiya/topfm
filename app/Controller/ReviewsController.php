<?php
class ReviewsController extends AppController
{
	var $name = 'Reviews';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');

    public function admin_lists()
	{
		$userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

        $this->paginate = array(
            'conditions' => array('user_id'=>$userid, 'status IN'=> array(0,1)),
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

        $reviews_data = $this->paginate('Review');
        //var_dump($reviews_data);exit;

        $this->set('page_heading','Review List');
        $this->set('reviews',$reviews_data);
	}

	public function admin_add() {


		if (!empty($this->data))
		{

			$customValidate = true;

			$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');

			//$this->pre($this->data['Review']);exit;
			
			$insert_reviews_data_array = $this->data['Review'];
			$insert_reviews_data_array['created'] = date('Y-m-d H:i:s');
			$insert_reviews_data_array['modified'] = date('Y-m-d H:i:s');
			$insert_reviews_data_array['user_id'] = $userid;

			//$this->pre($insert_reviews_data_array);exit;
			$lastRecord = $this->Review->find('first', array('colomns' => array('id'), 'order' => 'id DESC'));

			//var_dump($lastRecord);exit;

			$lastId = 0;
			if(!empty($lastRecord))
				$lastId = (int) $lastRecord['Review']['id'];

			$lastId++;
			

			//print_r($insert_reviews_data_array['images']);

			//exit;

			// for news images
			$first_fail_imgs = array();
			$valid_img_types = array('image/gif','image/png','image/jpg','image/jpeg');

			if(count($insert_reviews_data_array['images']) > 0){
				foreach ($insert_reviews_data_array['images'] as $ff_img_num => $ff_img) {
					//var_dump($ff_img);

					if($ff_img['error'] > 0 || !in_array($ff_img['type'], $valid_img_types)){
						$first_fail_imgs[] = $ff_img['name'];
					}
				}

				if(count($first_fail_imgs) > 0){
					
					$insert_reviews_data_array['images'] = '';
					$customValidate = false;
					$imp_failed_imgs = implode(',', $first_fail_imgs);
					if(!empty($imp_failed_imgs)){
						$customErrors[] = 'No valid images found, Some problems in images :'.implode(',', $first_fail_imgs);
					} else {
						$customErrors[] = 'No valid images found';
					}

				} else {

					//echo "Else ".$lastId;
					//exit;

					$images_result = $this->Review->processMultipleUpload($insert_reviews_data_array, $lastId);

					//$this->pre($images_result);
					//exit;
					
					$fail_imgs = array();

					if(isset($images_result['failed_images']) && count($images_result['failed_images']) > 0){
						foreach ($images_result['failed_images'] as $fail_img_num => $fail_img) {
							$fail_imgs[] = $fail_img;
						}
						$insert_reviews_data_array['images'] = '';
						$customValidate = false;
						$customErrors[] = 'These images got failed when upload :'.implode(',', $images_result['failed_images']);

					} 
					else {
						$suc_imgs = array();
						if(isset($images_result['succeed_images']) && count($images_result['succeed_images']) > 0){

							$insert_reviews_data_array['images'] = implode(',', $images_result['succeed_images']);
						} else {
							$insert_reviews_data_array['images'] = false;
						}
					}
				}
				
			} else {
				$insert_reviews_data_array['images'] = false;
			}

			//$this->pre($insert_reviews_data_array);
			//exit;
			
			//$this->pre($insert_reviews_data_array);exit;

			$this->Review->set($insert_reviews_data_array);

			if ($this->Review->validates() && $customValidate) //$this->Review->validates() && 
			{
				//echo "validates true";exit;
				//$this->pre($insert_reviews_data_array);exit;
			 	$save = $this->Review->save($insert_reviews_data_array, true);
				$_SESSION['success_msg'] = "Review Added Successfully";
                $this->redirect(DEFAULT_ADMINURL . 'reviews/lists/');
			}
			else
			{

				$save_errors = $this->Review->validationErrors;

			    //$this->pre($save_errors);
			    //$this->pre($customErrors);
			    //exit;

			    $errors_html = "<ul>";
			    foreach ($save_errors as $error_field => $field_errors)
			    {
					foreach ($field_errors as $err_no => $error)
					{
						$errors_html .= "<li>".$error."</li>";	
					}
			    }

			    if(count($customErrors) > 0)
			    {
			    	foreach ($customErrors as $errKey => $custom_error) {
			    		$errors_html .= "<li>".$custom_error."</li>";	
			    	}
			    }

			    /*if(count($imgErrors) > 0)
			    {
			    	foreach ($imgErrors as $imgerror_field => $imgfield_errors)
				    {
						foreach ($imgfield_errors as $imgerr_no => $imgerror)
						{
							$errors_html .= "<li>".$imgerror[0]."</li>";	
						}
				    }
			    }*/

			    $errors_html .= "</ul>";

			    //$this->pre($errors_html);exit;
			    $reviews_data['Review'] = $this->data['Review'];

			    $_SESSION['error_msg'] = $errors_html;
			    $this->set('reviews_data',$reviews_data);
			    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
			}
		}
		else
		{
			$insert_reviews_data_array = array();
			$insert_reviews_data_array['Review']['title'] = '';
			$insert_reviews_data_array['Review']['slug'] = '';
			$insert_reviews_data_array['Review']['content'] = '';
			$insert_reviews_data_array['Review']['status'] = '1';
			
			//$insert_reviews_data_array['Review']['all_categories'] = $news_categories_data;
			$this->set('reviews_data',$insert_reviews_data_array);
		}

	}

	public function admin_edit() {

		$reviewId = $this->params['named']['reviewId'];

		if (!empty($this->data))
		{	
			//if($this->data['btn_save_page'] == "Save Review")
			//{
				$customValidate = true;

				$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
				
				$insert_reviews_data_array = $this->data['Review'];
				$insert_reviews_data_array['id'] = $reviewId;
				$insert_reviews_data_array['created'] = date('Y-m-d H:i:s');
				$insert_reviews_data_array['modified'] = date('Y-m-d H:i:s');
				$insert_reviews_data_array['user_id'] = $userid;

				//$this->pre($insert_reviews_data_array);exit;

				// for news images
				$first_fail_imgs = array();
				$valid_img_types = array('image/gif','image/png','image/jpg','image/jpeg');

				$no_image_selected = false;

				if(count($insert_reviews_data_array['images']) > 0){
					
					if(count($insert_reviews_data_array['images']) == 1 && empty($insert_reviews_data_array['images'][0]['name']) && $insert_reviews_data_array['images'][0]['error'] == 4){

						$no_image_selected = true;
						
					} else {
						foreach ($insert_reviews_data_array['images'] as $ff_img_num => $ff_img) {
							//var_dump($ff_img);
							if($ff_img['error'] > 0 || !in_array($ff_img['type'], $valid_img_types)){
								$first_fail_imgs[] = $ff_img['name'];
							}
						}
					}
					
					//$this->pre($this->data);
					//exit;

					if(count($first_fail_imgs) > 0){
						
						$insert_reviews_data_array['images'] = '';
						$customValidate = false;
						$imp_failed_imgs = implode(',', $first_fail_imgs);
						if(!empty($imp_failed_imgs)){
							$customErrors[] = 'No valid images found, Some problems in images :'.implode(',', $first_fail_imgs);
						} else {
							$customErrors[] = 'No valid images found';
						}

					} else {


						$images_result = $this->Review->processMultipleUpload($insert_reviews_data_array, $reviewId);
						
						//$this->pre($images_result);exit;
						$fail_imgs = array();

						if(isset($images_result['failed_images']) && count($images_result['failed_images']) > 0){
							foreach ($images_result['failed_images'] as $fail_img_num => $fail_img) {
								$fail_imgs[] = $fail_img;
							}

							$insert_reviews_data_array['images'] = '';
							$customValidate = false;
							$customErrors[] = 'These images got failed when upload :'.implode(',', $fail_imgs);

						} else {
							$suc_imgs = array();
							if(isset($images_result['succeed_images']) && count($images_result['succeed_images']) > 0){
								foreach ($images_result['succeed_images'] as $suc_img_num => $suc_img) {
									$suc_imgs[] = $suc_img;
								}

								$insert_reviews_data_array['images'] = implode(',', $suc_imgs);
							} else {
								$insert_reviews_data_array['images'] = false;
							}
						}
					}
					
				} else {
					$insert_reviews_data_array['images'] = false;
				}
				
				
				//exit;


				//For delete images
				$old_image_array = explode(',',$this->data['Review']['old_image']);
				//$this->pre($old_image_array);

				if(isset($old_image_array) && count($old_image_array)>0)
				{
					for($i=0;$i<count($old_image_array);$i++)
					{
						if(isset($this->data['Review']['add_image']) && !empty($this->data['Review']['add_image']))
						{
							if(!in_array($old_image_array[$i],$this->data['Review']['add_image']))
							{
								//Remove images
								//echo '<br>'.UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i];
								//echo '<br>'.UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i];
								if(file_exists(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i]))
									unlink(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i]);
								if(file_exists(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i]))
                					unlink(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i]);

							}
						}
						else
						{
							//Remove images
							//echo '<br>'.UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i];
							//echo '<br>'.UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i];

							if(file_exists(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i]))
								unlink(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i]);
							if(file_exists(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i]))
            					unlink(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i]);
						}
					}					
				}

				//$this->pre($insert_reviews_data_array);
				//exit;


				// for edit images only
				if(isset($insert_reviews_data_array['add_image'])){
					if (count($insert_reviews_data_array['add_image']) > 0)
					{
						//$this->pre($insert_reviews_data_array);
						//exit;

						if(!empty($insert_reviews_data_array['images'])){
							$insert_reviews_data_array['images'] = explode(',', $insert_reviews_data_array['images']);
							//$insert_reviews_data_array['images'] = array_merge($insert_reviews_data_array['add_image'], $insert_reviews_data_array['images']);
							$insert_reviews_data_array['add_image'] = false;
							$insert_reviews_data_array['images'] = implode(',', $insert_reviews_data_array['images']);
						} else {
							$insert_reviews_data_array['images'] = $insert_reviews_data_array['add_image'];
							$insert_reviews_data_array['add_image'] = false;
							$insert_reviews_data_array['images'] = implode(',', $insert_reviews_data_array['images']);
						}

						//$this->pre($insert_reviews_data_array);
						//exit;
					}
				}
				// for edit images only

				//$this->pre($insert_reviews_data_array);exit;

				$this->Review->set($insert_reviews_data_array);

				if ($this->Review->validates() && $customValidate)
				{
					//echo "validates true";exit;
				 	//$save = $this->Review->save($insert_reviews_data_array);
					//$_SESSION['success_msg'] = "Review Added Successfully";
	                //$this->redirect(DEFAULT_ADMINURL . 'reviews/lists/');

	                $this->Review->save($insert_reviews_data_array);
					$_SESSION['success_msg'] = "Review Updated Successfully";
	                $this->redirect(DEFAULT_ADMINURL . 'reviews/lists/');
				}
				else
				{
				    $save_errors = $this->Review->validationErrors;

				    //$this->pre($save_errors);exit;
				    $errors_html = "<ul>";
				    foreach ($save_errors as $error_field => $field_errors)
				    {
						foreach ($field_errors as $err_no => $error)
						{
							$errors_html .= "<li>".$error."</li>";	
						}
				    }

				    if(count($customErrors) > 0)
				    {
				    	foreach ($customErrors as $errKey => $custom_error) {
				    		$errors_html .= "<li>".$custom_error."</li>";	
				    	}
				    }


				    $errors_html .= "</ul>";

				    //$this->pre($errors_html);exit;
				    //$this->pre($this->data['Review']);exit;

				    $_SESSION['error_msg'] = $errors_html;
				    $this->set('reviews_data',$this->data);
				    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
				}

			//}
		}
		
		$reviews_data = $this->Review->find('first', array('conditions' => array('id' => $reviewId)));

		$this->set('reviews_data',$reviews_data);
	}

	public function admin_delete() {

		$reviewId = $this->params['named']['reviewId'];

		$reviews_data = $this->Review->find('first', array('conditions' => array('id' => $reviewId)));
		
		//$this->pre($reviews_data);
		//exit;

		/* *
		//For delete images
		$old_image_array = explode(',',$reviews_data['Review']['images']);
		//$this->pre($old_image_array);

		if(isset($old_image_array) && count($old_image_array)>0)
		{
			for($i=0;$i<count($old_image_array);$i++)
			{
				//echo '<br>'.UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i];
				//echo '<br>'.UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i];

				if(file_exists(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i]))
					unlink(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/'.$old_image_array[$i]);
				if(file_exists(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i]))
					unlink(UPLOAD_FOLDER . 'review_images/'.$reviewId.'/thumb_'.$old_image_array[$i]);				
			}					
		}
		/* */
		
		$update_review_data['modified_date'] = date('Y-m-d H:i:s');
		$update_review_data['status'] = 2;
		$update_review_data['id'] = $reviewId;

		//$this->Review->saveField('status', 2);
		//$modified_date = date('Y-m-d H:i:s');
		$this->Review->save($update_review_data);

		$_SESSION['success_msg'] = "Successfully deleted Review";
		$return_url = DEFAULT_ADMINURL.'reviews/lists';
		return $this->redirect($return_url);  
	}

	public function admin_delete_selected()
	{
		//$this->pre($this->data['reviews_checks']);exit;
		if(isset($this->data['review_checks']))
        {
            $reviewSelectedArr = $this->data['review_checks'];
            $reviewNum = count($reviewSelectedArr);

            if($reviewNum > 0)
            {
                //$this->loadmodel('Product');

                $deletedCount = 0;

                foreach ($reviewSelectedArr as $reviewDelKey => $reviewToDelete) {
                    //var_dump($reviewToDelete);

                    $this->Review->id = $this->Review->field('id', array('id' => $reviewToDelete));
                    if ($this->Review->id)
                    {
                        //$this->pre($this->Product);exit;
                        $thisDelete = $this->Review->saveField('status', 2);
                        $modified_date = date('Y-m-d H:i:s');
                        $thisDeleteMod = $this->Review->saveField('modified_date', $modified_date);

                        if($thisDelete && $thisDeleteMod){
                            $deletedCount++;
                        }

                    }
                }

                $_SESSION['success_msg'] = "Successfully deleted for ".$deletedCount." review.";
                $return_url = DEFAULT_ADMINURL.'reviews/lists';
                return $this->redirect($return_url);    
            }
            else
            {
                $_SESSION['error_msg'] = "You have not selected any review.";
                $return_url = DEFAULT_ADMINURL.'reviews/lists';
                return $this->redirect($return_url);    
            }
        }
        else
        {
            $return_url = DEFAULT_ADMINURL.'reviews/lists';
            return $this->redirect($return_url);
        }
	}

	public function admin_search()
	{
	    $userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

	    if ($this->request->is('post'))
	    {
	      	if(!empty($this->request->data) && isset($this->request->data) )
	      	{
	         	//$this->pre($this->request->data);exit;
	         	$search_key = trim($this->request->data['reviewSearch']['searchtitle']);
	 
	         	$conditions[] = array(
	         		"OR" => array(
	            		"Review.title LIKE" => "%".$search_key."%",
	            		"Review.content LIKE" => "%".$search_key."%"
	            	)
	         	);

	         	$this->Session->write('searchCond', $conditions);
         		$this->Session->write('search_key', $search_key);
	      	}
	    }

	    $mainConditions = array('user_id'=>$userid, 'status IN'=> array(0,1));

	    if ($this->Session->check('searchCond')) {
	    	$conditions = $this->Session->read('searchCond');
	    	$allConditions = array_merge($mainConditions, $conditions);
	   	} else {
	      	$conditions = null;
	      	$allConditions = array_merge($mainConditions, $conditions);
	   	}

	    //$this->pre($allConditions);exit;

	   	$this->paginate = array(
            'conditions' => $allConditions,
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

	   	$reviews_data = $this->paginate('Review');

	   	//$this->pre($reviews_data);exit;

	   	$this->set('page_heading','Review List');

	   	$this->set('reviews',$reviews_data);

	   	$this->set('from_search',true);

	   	$this->render('/Reviews/admin_lists');
	}

}