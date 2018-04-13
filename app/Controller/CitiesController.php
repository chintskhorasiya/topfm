<?php
class CitiesController extends AppController
{
	var $name = 'Cities';
    public $components = array('Cookie', 'Session', 'Email', 'Paginator');
    public $helpers = array('Html', 'Form', 'Session', 'Time');

    //public function beforeFilter(){
    	//$isAuth = $this->checklogin();
    	//var_dump($isAuth);exit;	
    //}

    public function admin_index(){
    	//echo "in Cities:index";exit;
    }

	public function admin_lists()
	{
		//echo "in Cities:lists";exit;
		$userid = $this->Session->read(md5(SITE_TITLE) . 'USERID');

        $this->paginate = array(
            'conditions' => array('user_id'=>$userid, 'status IN'=> array(0,1)),
            'limit' => 25,
            'order' => array('id' => 'desc')
        );

        $cities_data = $this->paginate('City');

        //$this->pre($cities_data);exit;

        $this->set('page_heading','Cities List');
        $this->set('cities',$cities_data);

	}

	public function admin_add() {

		if (!empty($this->data))
		{
			$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
			
			$insert_city_data_array = $this->data['City'];
			$insert_city_data_array['created'] = date('Y-m-d H:i:s');
			$insert_city_data_array['modified'] = date('Y-m-d H:i:s');
			$insert_city_data_array['user_id'] = $userid;

			//$this->pre($insert_city_data_array);exit;

			$this->City->set($insert_city_data_array);

			/*echo "invalidFields:";
			$this->pre($this->City->invalidFields());
			echo "<br><br>";exit;
*/
			if ($this->City->validates())
			{
				//echo "validates true";exit;
			 	$save = $this->City->save($insert_city_data_array);
				$_SESSION['success_msg'] = "City Added Successfully";
                $this->redirect(DEFAULT_ADMINURL . 'cities/lists/');
			}
			else
			{
			    $save_errors = $this->City->validationErrors;

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
			    //$this->pre($this->data['City']);exit;

			    $_SESSION['error_msg'] = $errors_html;
			    $this->set('city_data',$this->data);
			    //$this->redirect(DEFAULT_ADMINURL . 'cities/add/');
			}
		}
		else
		{
			$insert_city_data_array = array();
			$insert_city_data_array['City']['title'] = '';
			$insert_city_data_array['City']['slug'] = '';
			$insert_city_data_array['City']['content'] = '';
			$insert_city_data_array['City']['status'] = '1';
			$this->set('city_data',$insert_city_data_array);
		}

	}

	public function admin_edit() {

		$cityId = $this->params['named']['cityId'];

		if (!empty($this->data))
		{
			//if($this->data['btn_save_city'] == "Save City")
			//{

				$userid = (int) $this->Session->read(md5(SITE_TITLE) . 'USERID');
				
				$insert_city_data_array = $this->data['City'];
				$insert_city_data_array['id'] = $cityId;
				$insert_city_data_array['created'] = date('Y-m-d H:i:s');
				$insert_city_data_array['modified'] = date('Y-m-d H:i:s');
				$insert_city_data_array['user_id'] = $userid;
				//$this->pre($insert_city_data_array);exit;

				$this->City->set($insert_city_data_array);

				if ($this->City->validates())
				{
					//echo "validates true";exit;
				 	//$save = $this->City->save($insert_city_data_array);
					//$_SESSION['success_msg'] = "City Added Successfully";
	                //$this->redirect(DEFAULT_ADMINURL . 'cities/lists/');

	                $this->City->save($insert_city_data_array);
					$_SESSION['success_msg'] = "City Updated Successfully";
	                $this->redirect(DEFAULT_ADMINURL . 'cities/lists/');
				}
				else
				{
				    $save_errors = $this->City->validationErrors;

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
				    //$this->pre($this->data['City']);exit;

				    $_SESSION['error_msg'] = $errors_html;
				    $this->set('city_data',$this->data);
				    //$this->redirect(DEFAULT_ADMINURL . 'cities/add/');
				}

			//}
		}
		
		$city_data = $this->City->find('first', array('conditions' => array('id' => $cityId)));

		$this->set('city_data',$city_data);
	}

	public function admin_delete() {

		$cityId = $this->params['named']['cityId'];
		
		$this->City->id = $this->City->field('id', array('id' => $cityId));

		$this->City->saveField('status', 2);
		$modified_date = date('Y-m-d H:i:s');
		$this->City->saveField('modified_date', $modified_date);

		$_SESSION['success_msg'] = "Successfully deleted city";
		$return_url = DEFAULT_ADMINURL.'cities/lists';
		return $this->redirect($return_url);  
	}

	public function admin_delete_selected()
	{
		//$this->pre($this->data['cities_checks']);exit;
		if(isset($this->data['cities_checks']))
        {
            $citiesSelectedArr = $this->data['cities_checks'];
            $citiesNum = count($citiesSelectedArr);

            if($citiesNum > 0)
            {
                //$this->loadmodel('Product');

                $deletedCount = 0;

                foreach ($citiesSelectedArr as $cityDelKey => $cityToDelete) {
                    //var_dump($cityToDelete);

                    $this->City->id = $this->City->field('id', array('id' => $cityToDelete));
                    if ($this->City->id)
                    {
                        //$this->pre($this->Product);exit;
                        $thisDelete = $this->City->saveField('status', 2);
                        $modified_date = date('Y-m-d H:i:s');
                        $thisDeleteMod = $this->City->saveField('modified_date', $modified_date);

                        if($thisDelete && $thisDeleteMod){
                            $deletedCount++;
                        }

                    }
                }

                $_SESSION['success_msg'] = "Successfully deleted for ".$deletedCount." city(s).";
                $return_url = DEFAULT_ADMINURL.'cities/lists';
                return $this->redirect($return_url);    
            }
            else
            {
                $_SESSION['error_msg'] = "You have not selected any city.";
                $return_url = DEFAULT_ADMINURL.'cities/lists';
                return $this->redirect($return_url);    
            }
        }
        else
        {
            $return_url = DEFAULT_ADMINURL.'cities/lists';
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
	         	$search_key = trim($this->request->data['citiesSearch']['searchtitle']);
	 
	         	$conditions[] = array(
	         		"City.title LIKE" => "%".$search_key."%",
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

        $cities_data = $this->paginate('City');

        //$this->pre($cities_data);exit;

        $this->set('page_heading','Cities List');
        $this->set('cities',$cities_data);

	   	$this->set('from_search',true);

	   	$this->render('/Cities/admin_lists');
	}

}