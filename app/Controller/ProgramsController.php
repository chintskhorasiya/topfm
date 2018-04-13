<?php
class ProgramsController extends AppController
{
	var $name = 'Programs';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');

    //public function beforeFilter(){
    	//$isAuth = $this->checklogin();
    	//var_dump($isAuth);exit;	
    //}

    public function admin_index(){
    	//echo "in Programs:index";exit;
    }

	public function admin_lists()
	{
		//echo "in Programs:lists";exit;
		$userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

        $this->paginate = array(
            'conditions' => array('user_id'=>$userid, 'status IN'=> array(0,1)),
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

        $programs_data = $this->paginate('Program');
        //var_dump($programs_data);exit;
        //$this->pre($programs_data);exit;

        $this->set('page_heading','Programs List');
        $this->set('programs',$programs_data);

	}

	public function admin_add() {

		if (!empty($this->data))
		{
			$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
			
			$insert_program_data_array = $this->data['Program'];
			$insert_program_data_array['created'] = date('Y-m-d H:i:s');
			$insert_program_data_array['modified'] = date('Y-m-d H:i:s');
			$insert_program_data_array['user_id'] = $userid;

			//$this->pre($insert_program_data_array);exit;

			$this->Program->set($insert_program_data_array);

			/*echo "invalidFields:";
			$this->pre($this->Program->invalidFields());
			echo "<br><br>";exit;
*/
			if ($this->Program->validates())
			{
				//echo "validates true";exit;
			 	$save = $this->Program->save($insert_program_data_array);
				$_SESSION['success_msg'] = "Program Added Successfully";
                $this->redirect(DEFAULT_ADMINURL . 'programs/lists/');
			}
			else
			{
			    $save_errors = $this->Program->validationErrors;

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
			    //$this->pre($this->data['Program']);exit;

			    $_SESSION['error_msg'] = $errors_html;
			    $this->set('program_data',$this->data);
			    //$this->redirect(DEFAULT_ADMINURL . 'programs/add/');
			}
		}
		else
		{
			$insert_program_data_array = array();
			$insert_program_data_array['Program']['title'] = '';
			$insert_program_data_array['Program']['slug'] = '';
			$insert_program_data_array['Program']['content'] = '';
			$insert_program_data_array['Program']['status'] = '1';
			$this->set('program_data',$insert_program_data_array);
		}

	}

	public function admin_edit() {

		$programId = $this->params['named']['programId'];

		if (!empty($this->data))
		{
			//if($this->data['btn_save_program'] == "Save Program")
			//{

				$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
				
				$insert_program_data_array = $this->data['Program'];
				$insert_program_data_array['id'] = $programId;
				$insert_program_data_array['created'] = date('Y-m-d H:i:s');
				$insert_program_data_array['modified'] = date('Y-m-d H:i:s');
				$insert_program_data_array['user_id'] = $userid;
				//$this->pre($insert_program_data_array);exit;

				$this->Program->set($insert_program_data_array);

				if ($this->Program->validates())
				{
					//echo "validates true";exit;
				 	//$save = $this->Program->save($insert_program_data_array);
					//$_SESSION['success_msg'] = "Program Added Successfully";
	                //$this->redirect(DEFAULT_ADMINURL . 'programs/lists/');

	                $this->Program->save($insert_program_data_array);
					$_SESSION['success_msg'] = "Program Updated Successfully";
	                $this->redirect(DEFAULT_ADMINURL . 'programs/lists/');
				}
				else
				{
				    $save_errors = $this->Program->validationErrors;

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
				    //$this->pre($this->data['Program']);exit;

				    $_SESSION['error_msg'] = $errors_html;
				    $this->set('program_data',$this->data);
				    //$this->redirect(DEFAULT_ADMINURL . 'programs/add/');
				}

			//}
		}
		
		$program_data = $this->Program->find('first', array('conditions' => array('id' => $programId)));

		$this->set('program_data',$program_data);
	}

	public function admin_delete() {

		$programId = $this->params['named']['programId'];
		
		$this->Program->id = $this->Program->field('id', array('id' => $programId));

		$this->Program->saveField('status', 2);
		$modified_date = date('Y-m-d H:i:s');
		$this->Program->saveField('modified_date', $modified_date);

		$_SESSION['success_msg'] = "Successfully deleted program";
		$return_url = DEFAULT_ADMINURL.'programs/lists';
		return $this->redirect($return_url);  
	}

	public function admin_delete_selected()
	{
		//$this->pre($this->data['programs_checks']);exit;
		if(isset($this->data['programs_checks']))
        {
            $programsSelectedArr = $this->data['programs_checks'];
            $programsNum = count($programsSelectedArr);

            if($programsNum > 0)
            {
                //$this->loadmodel('Product');

                $deletedCount = 0;

                foreach ($programsSelectedArr as $programDelKey => $programToDelete) {
                    //var_dump($programToDelete);

                    $this->Program->id = $this->Program->field('id', array('id' => $programToDelete));
                    if ($this->Program->id)
                    {
                        //$this->pre($this->Product);exit;
                        $thisDelete = $this->Program->saveField('status', 2);
                        $modified_date = date('Y-m-d H:i:s');
                        $thisDeleteMod = $this->Program->saveField('modified_date', $modified_date);

                        if($thisDelete && $thisDeleteMod){
                            $deletedCount++;
                        }

                    }
                }

                $_SESSION['success_msg'] = "Successfully deleted for ".$deletedCount." program(s).";
                $return_url = DEFAULT_ADMINURL.'programs/lists';
                return $this->redirect($return_url);    
            }
            else
            {
                $_SESSION['error_msg'] = "You have not selected any program.";
                $return_url = DEFAULT_ADMINURL.'programs/lists';
                return $this->redirect($return_url);    
            }
        }
        else
        {
            $return_url = DEFAULT_ADMINURL.'programs/lists';
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
	         	$search_key = trim($this->request->data['programsSearch']['searchtitle']);
	 
	         	$conditions[] = array(
	         		"OR" => array(
	            		"Program.title LIKE" => "%".$search_key."%",
	            		"Program.content LIKE" => "%".$search_key."%"
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

	    $this->paginate = array(
            'conditions' => $allConditions,
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

        $programs_data = $this->paginate('Program');

        //$this->pre($programs_data);exit;

        $this->set('page_heading','Programs List');
        $this->set('programs',$programs_data);

	   	$this->set('from_search',true);

	   	$this->render('/Programs/admin_lists');
	}

}