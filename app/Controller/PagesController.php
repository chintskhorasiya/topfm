<?php
class PagesController extends AppController
{
	var $name = 'Pages';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');

    //public function beforeFilter(){
    	//$isAuth = $this->checklogin();
    	//var_dump($isAuth);exit;	
    //}

    public function admin_index(){
    	//echo "in Pages:index";exit;
    }

	public function admin_lists()
	{
		//echo "in Pages:lists";exit;
		$userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

        $this->paginate = array(
            'conditions' => array('user_id'=>$userid, 'status IN'=> array(0,1)),
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

        $pages_data = $this->paginate('Page');

        //$this->pre($pages_data);exit;

        $this->set('page_heading','Pages List');
        $this->set('pages',$pages_data);

	}

	public function admin_add() {

		if (!empty($this->data))
		{
			$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
			
			$insert_page_data_array = $this->data['Page'];
			$insert_page_data_array['created'] = date('Y-m-d H:i:s');
			$insert_page_data_array['modified'] = date('Y-m-d H:i:s');
			$insert_page_data_array['user_id'] = $userid;

			//$this->pre($insert_page_data_array);exit;

			$this->Page->set($insert_page_data_array);

			/*echo "invalidFields:";
			$this->pre($this->Page->invalidFields());
			echo "<br><br>";exit;
*/
			if ($this->Page->validates())
			{
				//echo "validates true";exit;
			 	$save = $this->Page->save($insert_page_data_array);
				$_SESSION['success_msg'] = "Page Added Successfully";
                $this->redirect(DEFAULT_ADMINURL . 'pages/lists/');
			}
			else
			{
			    $save_errors = $this->Page->validationErrors;

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
			    //$this->pre($this->data['Page']);exit;

			    $_SESSION['error_msg'] = $errors_html;
			    $this->set('page_data',$this->data);
			    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
			}
		}
		else
		{
			$insert_page_data_array = array();
			$insert_page_data_array['Page']['title'] = '';
			$insert_page_data_array['Page']['slug'] = '';
			$insert_page_data_array['Page']['content'] = '';
			$insert_page_data_array['Page']['status'] = '1';
			$this->set('page_data',$insert_page_data_array);
		}

	}

	public function admin_edit() {

		$pageId = $this->params['named']['pageId'];

		if (!empty($this->data))
		{
			//if($this->data['btn_save_page'] == "Save Page")
			//{

				$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
				
				$insert_page_data_array = $this->data['Page'];
				$insert_page_data_array['id'] = $pageId;
				$insert_page_data_array['created'] = date('Y-m-d H:i:s');
				$insert_page_data_array['modified'] = date('Y-m-d H:i:s');
				$insert_page_data_array['user_id'] = $userid;
				//$this->pre($insert_page_data_array);exit;

				$this->Page->set($insert_page_data_array);

				if ($this->Page->validates())
				{
					//echo "validates true";exit;
				 	//$save = $this->Page->save($insert_page_data_array);
					//$_SESSION['success_msg'] = "Page Added Successfully";
	                //$this->redirect(DEFAULT_ADMINURL . 'pages/lists/');

	                $this->Page->save($insert_page_data_array);
					$_SESSION['success_msg'] = "Page Updated Successfully";
	                $this->redirect(DEFAULT_ADMINURL . 'pages/lists/');
				}
				else
				{
				    $save_errors = $this->Page->validationErrors;

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
				    //$this->pre($this->data['Page']);exit;

				    $_SESSION['error_msg'] = $errors_html;
				    $this->set('page_data',$this->data);
				    //$this->redirect(DEFAULT_ADMINURL . 'pages/add/');
				}

			//}
		}
		
		$page_data = $this->Page->find('first', array('conditions' => array('id' => $pageId)));

		$this->set('page_data',$page_data);
	}

	public function admin_delete() {

		$pageId = $this->params['named']['pageId'];
		
		$this->Page->id = $this->Page->field('id', array('id' => $pageId));

		$this->Page->saveField('status', 2);
		$modified_date = date('Y-m-d H:i:s');
		$this->Page->saveField('modified_date', $modified_date);

		$_SESSION['success_msg'] = "Successfully deleted page";
		$return_url = DEFAULT_ADMINURL.'pages/lists';
		return $this->redirect($return_url);  
	}

	public function admin_delete_selected()
	{
		//$this->pre($this->data['pages_checks']);exit;
		if(isset($this->data['pages_checks']))
        {
            $pagesSelectedArr = $this->data['pages_checks'];
            $pagesNum = count($pagesSelectedArr);

            if($pagesNum > 0)
            {
                //$this->loadmodel('Product');

                $deletedCount = 0;

                foreach ($pagesSelectedArr as $pageDelKey => $pageToDelete) {
                    //var_dump($pageToDelete);

                    $this->Page->id = $this->Page->field('id', array('id' => $pageToDelete));
                    if ($this->Page->id)
                    {
                        //$this->pre($this->Product);exit;
                        $thisDelete = $this->Page->saveField('status', 2);
                        $modified_date = date('Y-m-d H:i:s');
                        $thisDeleteMod = $this->Page->saveField('modified_date', $modified_date);

                        if($thisDelete && $thisDeleteMod){
                            $deletedCount++;
                        }

                    }
                }

                $_SESSION['success_msg'] = "Successfully deleted for ".$deletedCount." page(s).";
                $return_url = DEFAULT_ADMINURL.'pages/lists';
                return $this->redirect($return_url);    
            }
            else
            {
                $_SESSION['error_msg'] = "You have not selected any page.";
                $return_url = DEFAULT_ADMINURL.'pages/lists';
                return $this->redirect($return_url);    
            }
        }
        else
        {
            $return_url = DEFAULT_ADMINURL.'pages/lists';
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
	         	$search_key = trim($this->request->data['pagesSearch']['searchtitle']);
	 
	         	$conditions[] = array(
	         		"OR" => array(
	            		"Page.title LIKE" => "%".$search_key."%",
	            		"Page.content LIKE" => "%".$search_key."%"
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

        $pages_data = $this->paginate('Page');

        //$this->pre($pages_data);exit;

        $this->set('page_heading','Pages List');
        $this->set('pages',$pages_data);

	   	$this->set('from_search',true);

	   	$this->render('/Pages/admin_lists');
	}

}