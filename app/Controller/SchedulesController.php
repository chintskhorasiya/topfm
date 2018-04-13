<?php
class SchedulesController extends AppController
{
	var $name = 'Schedules';
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

        $schedules_data = $this->paginate('Schedule');
        //var_dump($schedules_data);exit;

        $this->set('page_heading','Schedule List');
        $this->set('schedules',$schedules_data);
	}

	public function admin_add() {


		if (!empty($this->data))
		{

			$customValidate = true;

			$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');

			//$this->pre($this->data['Schedule']);exit;
			
			$insert_schedules_data_array = $this->data['Schedule'];
			$insert_schedules_data_array['created'] = date('Y-m-d H:i:s');
			$insert_schedules_data_array['modified'] = date('Y-m-d H:i:s');
			$insert_schedules_data_array['user_id'] = $userid;

			//$this->pre($insert_schedules_data_array);exit;
			$lastRecord = $this->Schedule->find('first', array('colomns' => array('id'), 'order' => 'id DESC'));

			//var_dump($lastRecord);exit;

			$lastId = 0;
			if(!empty($lastRecord))
				$lastId = (int) $lastRecord['Schedule']['id'];

			$lastId++;
			

			//print_r($insert_schedules_data_array['images']);

			//exit;

			// for news images
			$first_fail_imgs = array();
			$valid_img_types = array('image/gif','image/png','image/jpg','image/jpeg');

			if(count($insert_schedules_data_array['images']) > 0){
				foreach ($insert_schedules_data_array['images'] as $ff_img_num => $ff_img) {
					//var_dump($ff_img);

					if($ff_img['error'] > 0 || !in_array($ff_img['type'], $valid_img_types)){
						$first_fail_imgs[] = $ff_img['name'];
					}
				}

				if(count($first_fail_imgs) > 0){
					
					$insert_schedules_data_array['images'] = '';
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

					$images_result = $this->Schedule->processMultipleUpload($insert_schedules_data_array, $lastId);

					//$this->pre($images_result);
					//exit;
					
					$fail_imgs = array();

					if(isset($images_result['failed_images']) && count($images_result['failed_images']) > 0){
						foreach ($images_result['failed_images'] as $fail_img_num => $fail_img) {
							$fail_imgs[] = $fail_img;
						}
						$insert_schedules_data_array['images'] = '';
						$customValidate = false;
						$customErrors[] = 'These images got failed when upload :'.implode(',', $images_result['failed_images']);

					} 
					else {
						$suc_imgs = array();
						if(isset($images_result['succeed_images']) && count($images_result['succeed_images']) > 0){

							$insert_schedules_data_array['images'] = implode(',', $images_result['succeed_images']);
						} else {
							$insert_schedules_data_array['images'] = false;
						}
					}
				}
				
			} else {
				$insert_schedules_data_array['images'] = false;
			}

			//$this->pre($insert_schedules_data_array);
			//exit;
			
			//$this->pre($insert_schedules_data_array);exit;

			$this->Schedule->set($insert_schedules_data_array);

			if ($this->Schedule->validates() && $customValidate) //$this->Schedule->validates() && 
			{
				//echo "validates true";exit;
				//$this->pre($insert_schedules_data_array);exit;
			 	$save = $this->Schedule->save($insert_schedules_data_array, true);
				$_SESSION['success_msg'] = "Schedule Added Successfully";
                $this->redirect(DEFAULT_ADMINURL . 'schedules/lists/');
			}
			else
			{

				$save_errors = $this->Schedule->validationErrors;

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
			    $schedules_data['Schedule'] = $this->data['Schedule'];

			    $_SESSION['error_msg'] = $errors_html;
			    $this->set('schedules_data',$schedules_data);
			    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
			}
		}
		else
		{
			$insert_schedules_data_array = array();
			$insert_schedules_data_array['Schedule']['title'] = '';
			$insert_schedules_data_array['Schedule']['slug'] = '';
			$insert_schedules_data_array['Schedule']['content'] = '';
			$insert_schedules_data_array['Schedule']['status'] = '1';
			
			//$insert_schedules_data_array['Schedule']['all_categories'] = $news_categories_data;
			$this->set('schedules_data',$insert_schedules_data_array);
		}

	}

	public function admin_edit() {

		$scheduleId = $this->params['named']['scheduleId'];

		if (!empty($this->data))
		{
			//if($this->data['btn_save_page'] == "Save Schedule")
			//{
				$customValidate = true;

				$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
				
				$insert_schedules_data_array = $this->data['Schedule'];
				$insert_schedules_data_array['id'] = $scheduleId;
				$insert_schedules_data_array['created'] = date('Y-m-d H:i:s');
				$insert_schedules_data_array['modified'] = date('Y-m-d H:i:s');
				$insert_schedules_data_array['user_id'] = $userid;

				//$this->pre($insert_schedules_data_array);exit;

				// for news images
				$first_fail_imgs = array();
				$valid_img_types = array('image/gif','image/png','image/jpg','image/jpeg');

				$no_image_selected = false;

				if(count($insert_schedules_data_array['images']) > 0){
					
					if(count($insert_schedules_data_array['images']) == 1 && empty($insert_schedules_data_array['images'][0]['name']) && $insert_schedules_data_array['images'][0]['error'] == 4){

						$no_image_selected = true;
						
					} else {
						foreach ($insert_schedules_data_array['images'] as $ff_img_num => $ff_img) {
							//var_dump($ff_img);
							if($ff_img['error'] > 0 || !in_array($ff_img['type'], $valid_img_types)){
								$first_fail_imgs[] = $ff_img['name'];
							}
						}
					}
					
					//$this->pre($this->data);
					//exit;

					if(count($first_fail_imgs) > 0){
						
						$insert_schedules_data_array['images'] = '';
						$customValidate = false;
						$imp_failed_imgs = implode(',', $first_fail_imgs);
						if(!empty($imp_failed_imgs)){
							$customErrors[] = 'No valid images found, Some problems in images :'.implode(',', $first_fail_imgs);
						} else {
							$customErrors[] = 'No valid images found';
						}

					} else {


						$images_result = $this->Schedule->processMultipleUpload($insert_schedules_data_array, $scheduleId);
						
						//$this->pre($images_result);exit;
						$fail_imgs = array();

						if(isset($images_result['failed_images']) && count($images_result['failed_images']) > 0){
							foreach ($images_result['failed_images'] as $fail_img_num => $fail_img) {
								$fail_imgs[] = $fail_img;
							}

							$insert_schedules_data_array['images'] = '';
							$customValidate = false;
							$customErrors[] = 'These images got failed when upload :'.implode(',', $fail_imgs);

						} else {
							$suc_imgs = array();
							if(isset($images_result['succeed_images']) && count($images_result['succeed_images']) > 0){
								foreach ($images_result['succeed_images'] as $suc_img_num => $suc_img) {
									$suc_imgs[] = $suc_img;
								}

								$insert_schedules_data_array['images'] = implode(',', $suc_imgs);
							} else {
								$insert_schedules_data_array['images'] = false;
							}
						}
					}
					
				} else {
					$insert_schedules_data_array['images'] = false;
				}
				
				
				//exit;


				//For delete images
				$old_image_array = explode(',',$this->data['Schedule']['old_image']);
				//$this->pre($old_image_array);

				if(isset($old_image_array) && count($old_image_array)>0)
				{
					for($i=0;$i<count($old_image_array);$i++)
					{
						if(isset($this->data['Schedule']['add_image']) && !empty($this->data['Schedule']['add_image']))
						{
							if(!in_array($old_image_array[$i],$this->data['Schedule']['add_image']))
							{
								//Remove images
								//echo '<br>'.UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i];
								//echo '<br>'.UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i];
								if(file_exists(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i]))
									unlink(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i]);
								if(file_exists(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i]))
                					unlink(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i]);

							}
						}
						else
						{
							//Remove images
							//echo '<br>'.UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i];
							//echo '<br>'.UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i];

							if(file_exists(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i]))
								unlink(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i]);
							if(file_exists(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i]))
            					unlink(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i]);
						}
					}					
				}

				//$this->pre($insert_schedules_data_array);
				//exit;


				// for edit images only
				if(isset($insert_schedules_data_array['add_image'])){
					if (count($insert_schedules_data_array['add_image']) > 0)
					{
						//$this->pre($insert_schedules_data_array);
						//exit;

						if(!empty($insert_schedules_data_array['images'])){
							$insert_schedules_data_array['images'] = explode(',', $insert_schedules_data_array['images']);
							//$insert_schedules_data_array['images'] = array_merge($insert_schedules_data_array['add_image'], $insert_schedules_data_array['images']);
							$insert_schedules_data_array['add_image'] = false;
							$insert_schedules_data_array['images'] = implode(',', $insert_schedules_data_array['images']);
						} else {
							$insert_schedules_data_array['images'] = $insert_schedules_data_array['add_image'];
							$insert_schedules_data_array['add_image'] = false;
							$insert_schedules_data_array['images'] = implode(',', $insert_schedules_data_array['images']);
						}

						//$this->pre($insert_schedules_data_array);
						//exit;
					}
				}
				// for edit images only

				//$this->pre($insert_schedules_data_array);exit;

				$this->Schedule->set($insert_schedules_data_array);

				if ($this->Schedule->validates() && $customValidate)
				{
					//echo "validates true";exit;
				 	//$save = $this->Schedule->save($insert_schedules_data_array);
					//$_SESSION['success_msg'] = "Schedule Added Successfully";
	                //$this->redirect(DEFAULT_ADMINURL . 'schedules/lists/');

	                $this->Schedule->save($insert_schedules_data_array);
					$_SESSION['success_msg'] = "Schedule Updated Successfully";
	                $this->redirect(DEFAULT_ADMINURL . 'schedules/lists/');
				}
				else
				{
				    $save_errors = $this->Schedule->validationErrors;

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
				    //$this->pre($this->data['Schedule']);exit;

				    $_SESSION['error_msg'] = $errors_html;
				    $this->set('schedules_data',$this->data);
				    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
				}

			//}
		}
		
		$schedules_data = $this->Schedule->find('first', array('conditions' => array('id' => $scheduleId)));

		$this->set('schedules_data',$schedules_data);
	}

	public function admin_delete() {

		$scheduleId = $this->params['named']['scheduleId'];

		$schedules_data = $this->Schedule->find('first', array('conditions' => array('id' => $scheduleId)));
		
		//$this->pre($schedules_data);
		//exit;

		/* *
		//For delete images
		$old_image_array = explode(',',$schedules_data['Schedule']['images']);
		//$this->pre($old_image_array);

		if(isset($old_image_array) && count($old_image_array)>0)
		{
			for($i=0;$i<count($old_image_array);$i++)
			{
				//echo '<br>'.UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i];
				//echo '<br>'.UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i];

				if(file_exists(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i]))
					unlink(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/'.$old_image_array[$i]);
				if(file_exists(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i]))
					unlink(UPLOAD_FOLDER . 'schedule_images/'.$scheduleId.'/thumb_'.$old_image_array[$i]);				
			}					
		}
		/* */
		
		$update_schedule_data['modified_date'] = date('Y-m-d H:i:s');
		$update_schedule_data['status'] = 2;
		$update_schedule_data['id'] = $scheduleId;

		//$this->Schedule->saveField('status', 2);
		//$modified_date = date('Y-m-d H:i:s');
		$this->Schedule->save($update_schedule_data);

		$_SESSION['success_msg'] = "Successfully deleted Schedule";
		$return_url = DEFAULT_ADMINURL.'schedules/lists';
		return $this->redirect($return_url);  
	}

	public function admin_delete_selected()
	{
		//$this->pre($this->data['schedules_checks']);exit;
		if(isset($this->data['schedule_checks']))
        {
            $scheduleSelectedArr = $this->data['schedule_checks'];
            $scheduleNum = count($scheduleSelectedArr);

            if($scheduleNum > 0)
            {
                //$this->loadmodel('Product');

                $deletedCount = 0;

                foreach ($scheduleSelectedArr as $scheduleDelKey => $scheduleToDelete) {
                    //var_dump($scheduleToDelete);

                    $this->Schedule->id = $this->Schedule->field('id', array('id' => $scheduleToDelete));
                    if ($this->Schedule->id)
                    {
                        //$this->pre($this->Product);exit;
                        $thisDelete = $this->Schedule->saveField('status', 2);
                        $modified_date = date('Y-m-d H:i:s');
                        $thisDeleteMod = $this->Schedule->saveField('modified_date', $modified_date);

                        if($thisDelete && $thisDeleteMod){
                            $deletedCount++;
                        }

                    }
                }

                $_SESSION['success_msg'] = "Successfully deleted for ".$deletedCount." schedule.";
                $return_url = DEFAULT_ADMINURL.'schedules/lists';
                return $this->redirect($return_url);    
            }
            else
            {
                $_SESSION['error_msg'] = "You have not selected any schedule.";
                $return_url = DEFAULT_ADMINURL.'schedules/lists';
                return $this->redirect($return_url);    
            }
        }
        else
        {
            $return_url = DEFAULT_ADMINURL.'schedules/lists';
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
	         	$search_key = trim($this->request->data['scheduleSearch']['searchtitle']);
	 
	         	$conditions[] = array(
	         		"OR" => array(
	            		"Schedule.title LIKE" => "%".$search_key."%",
	            		"Schedule.content LIKE" => "%".$search_key."%"
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

	   	$schedules_data = $this->paginate('Schedule');

	   	//$this->pre($schedules_data);exit;

	   	$this->set('page_heading','Schedule List');

	   	$this->set('schedules',$schedules_data);

	   	$this->set('from_search',true);

	   	$this->render('/Schedules/admin_lists');
	}

}