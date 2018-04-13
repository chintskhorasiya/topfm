<?php
class VideosController extends AppController
{
	var $name = 'Videos';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');

    //public function beforeFilter(){
    	//$isAuth = $this->checklogin();
    	//var_dump($isAuth);exit;	
    //}

    public function admin_index(){
    	//echo "in Newss:index";exit;
    }

	public function admin_lists()
	{
		//echo "in Videos:lists";exit;
		$userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

        $this->paginate = array(
            'conditions' => array('user_id'=>$userid, 'status IN'=> array(0,1)),
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

        $videos_data = $this->paginate('Video');

        //$this->pre($videos_data);exit;

        $this->set('page_heading','Videos List');
        $this->set('videos_data',$videos_data);

	}

	public function admin_add() {

		if (!empty($this->data))
		{
			$customValidate = true;

			$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');

			//$this->pre($this->data['Video']);exit;
			
			$insert_videos_data_array = $this->data['Video'];
			$insert_videos_data_array['created'] = date('Y-m-d H:i:s');
			$insert_videos_data_array['modified'] = date('Y-m-d H:i:s');
			$insert_videos_data_array['user_id'] = $userid;
			//$this->pre($insert_videos_data_array);exit;

			$this->Video->set($insert_videos_data_array);

			if ($this->Video->validates() && $customValidate) //$this->Video->validates() && 
			{
				//echo "validates true";exit;
				//$this->pre($insert_videos_data_array);exit;
			 	$save = $this->Video->save($insert_videos_data_array, true);
				$_SESSION['success_msg'] = "Video Added Successfully";
                $this->redirect(DEFAULT_ADMINURL . 'videos/lists/');
			}
			else
			{

				$save_errors = $this->Video->validationErrors;

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
			    $videos_data['Video'] = $this->data['Video'];
			    //$this->pre($videos_data['Video']);exit;

			    $_SESSION['error_msg'] = $errors_html;
			    $this->set('videos_data',$videos_data);
			    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
			}
		}
		else
		{
			$insert_videos_data_array = array();
			$insert_videos_data_array['Video']['title'] = '';
			$insert_videos_data_array['Video']['slug'] = '';
			$insert_videos_data_array['Video']['content'] = '';
			$insert_videos_data_array['Video']['status'] = '1';
			
			$this->set('videos_data',$insert_videos_data_array);
		}

	}

	public function admin_edit() {

		$videoId = $this->params['named']['videoId'];

		if (!empty($this->data))
		{
			//if($this->data['btn_save_page'] == "Save News")
			//{

				$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
				
				$insert_videos_data_array = $this->data['Video'];
				$insert_videos_data_array['id'] = $videoId;
				$insert_videos_data_array['created'] = date('Y-m-d H:i:s');
				$insert_videos_data_array['modified'] = date('Y-m-d H:i:s');
				$insert_videos_data_array['user_id'] = $userid;
				//$this->pre($insert_videos_data_array);exit;

				//$this->pre($insert_videos_data_array);exit;

				$this->Video->set($insert_videos_data_array);

				if ($this->Video->validates())
				{
					//echo "validates true";exit;
				 	//$save = $this->Video->save($insert_videos_data_array);
					//$_SESSION['success_msg'] = "News Added Successfully";
	                //$this->redirect(DEFAULT_ADMINURL . 'videos/lists/');

	                $this->Video->save($insert_videos_data_array);
					$_SESSION['success_msg'] = "Video Updated Successfully";
	                $this->redirect(DEFAULT_ADMINURL . 'videos/lists/');
				}
				else
				{
				    $save_errors = $this->Video->validationErrors;

				    //$this->pre($save_errors);exit;
				    $errors_html = "<ul>";
				    foreach ($save_errors as $error_field => $field_errors)
				    {
						foreach ($field_errors as $err_no => $error)
						{
							$errors_html .= "<li>".$error."</li>";	
						}
				    }

				    $errors_html .= "</ul>";

				    //$this->pre($errors_html);exit;
				    //$this->pre($this->data['Video']);exit;

				    $_SESSION['error_msg'] = $errors_html;
				    $this->set('videos_data',$this->data);
				    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
				}

			//}
		}
		
		$videos_data = $this->Video->find('first', array('conditions' => array('id' => $videoId)));
		$this->set('videos_data',$videos_data);
	}

	public function admin_delete() {

		$videoId = $this->params['named']['videoId'];
		
		$this->Video->id = $this->Video->field('id', array('id' => $videoId));

		$this->Video->saveField('status', 2);
		$modified_date = date('Y-m-d H:i:s');
		$this->Video->saveField('modified_date', $modified_date);

		$_SESSION['success_msg'] = "Successfully deleted video";
		$return_url = DEFAULT_ADMINURL.'videos/lists';
		return $this->redirect($return_url);  
	}

	public function admin_delete_selected()
	{
		//$this->pre($this->data['newss_checks']);exit;
		if(isset($this->data['videos_checks']))
        {
            $videosSelectedArr = $this->data['videos_checks'];
            $videosNum = count($videosSelectedArr);

            if($videosNum > 0)
            {
                //$this->loadmodel('Product');

                $deletedCount = 0;

                foreach ($videosSelectedArr as $videoDelKey => $videoToDelete) {
                    //var_dump($videoToDelete);

                    $this->Video->id = $this->Video->field('id', array('id' => $videoToDelete));
                    if ($this->Video->id)
                    {
                        //$this->pre($this->Product);exit;
                        $thisDelete = $this->Video->saveField('status', 2);
                        $modified_date = date('Y-m-d H:i:s');
                        $thisDeleteMod = $this->Video->saveField('modified_date', $modified_date);

                        if($thisDelete && $thisDeleteMod){
                            $deletedCount++;
                        }

                    }
                }

                $_SESSION['success_msg'] = "Successfully deleted for ".$deletedCount." videos.";
                $return_url = DEFAULT_ADMINURL.'videos/lists';
                return $this->redirect($return_url);    
            }
            else
            {
                $_SESSION['error_msg'] = "You have not selected any videos.";
                $return_url = DEFAULT_ADMINURL.'videos/lists';
                return $this->redirect($return_url);    
            }
        }
        else
        {
            $return_url = DEFAULT_ADMINURL.'videos/lists';
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
	         	$search_key = trim($this->request->data['videoSearch']['searchtitle']);
	 
	         	$conditions[] = array(
	         		"OR" => array(
	            		"Video.title LIKE" => "%".$search_key."%",
	            		"Video.content LIKE" => "%".$search_key."%"
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

	   	$videos_data = $this->paginate('Video');

	   	//$this->pre($videos_data);exit;

	   	$this->set('page_heading','News List');

	   	$this->set('videos_data',$videos_data);

	   	$this->set('from_search',true);

	   	$this->render('/Videos/admin_lists');
	}

}