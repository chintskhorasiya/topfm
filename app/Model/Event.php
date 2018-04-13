<?php
App::uses('AppModel', 'Model');
App::import('Vendor', 'resize_img');

class Event extends AppModel {
    
    public $name = 'Event';

    public $validate = array(
        'title' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Title can not be blank',
            ),
        ),
        'subtitle' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Subtitle can not be blank',
            ),
        ),
        'slug' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Slug can not be blank',
            ),
            'alphaNumericDashUnderscore' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'message' => 'Slug can only be letters, numbers, dash and underscore'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This slug has already been taken.'
            ),
        ),
        'content' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Content can not be blank',
            ),
        )
    );

    /**
     * Upload Directory relative to WWW_ROOT
     * @param string
     */
    public $uploadDir = 'img/uploads/event_images';

    /**
     * Process the Upload
     * @param array $check
     * @return boolean
     */
    public function processMultipleUpload($check=array(), $folderId = '') {
        //echo '<pre>';print_r($check);exit;
        //echo "in process upload";exit;

        $failed_images = array();
        $succeed_images = array();
        
        foreach ($check['images'] as $img_num => $image) {

            // deal with uploaded file
            if (!empty($image['tmp_name'])) {

                // check file is uploaded
                if (!is_uploaded_file($image['tmp_name'])) {
                    $failed_images[] = $image['name'];
                }

                if($folderId){
                    $images_move_dir = WWW_ROOT . $this->uploadDir . DS . $folderId . DS;
                } else {
                    $images_move_dir = WWW_ROOT . $this->uploadDir . DS;
                }

                if (!is_dir($images_move_dir)) {
                    $oldmask = umask(0);
                    mkdir($images_move_dir, 0777, true);
                    chmod($images_move_dir, 0755);
                    umask($oldmask);
                }
                
                    
                $new_image_name = Inflector::slug(pathinfo($image['name'], PATHINFO_FILENAME)).'.'.pathinfo($image['name'], PATHINFO_EXTENSION);
                //echo "<br>";
                // build full images
                $images = $images_move_dir . $new_image_name;

            	$res_images = $images_move_dir . 'thumb_'.$new_image_name;


                // @todo check for duplicate images

                // try moving file
                if (!move_uploaded_file($image['tmp_name'], $images)) {
                    return FALSE;
                }
                else
                {
                    // save the file path relative from WWW_ROOT e.g. uploads/example_images.jpg
                    //$this->data[$this->alias]['filepath'] = str_replace(DS, "/", str_replace(WWW_ROOT, "", $images) );

                    //$succeed_images[] = DEFAULT_URL.str_replace(DS, "/", str_replace(WWW_ROOT, "", $images));;
                    $succeed_images[] = $new_image_name;


					//For create thumb 150x150
                    $resizeObj = new resize_image();
	                $resizeObj->resize($images, $res_images, '150', '150','100');
                    chmod($res_images,0777);

                }
            }
        }

        //echo "<pre>";
        //print_r($failed_images);
        //print_r($succeed_images);

        $total_images = array('succeed_images' => $succeed_images, 'failed_images' => $failed_images);

        //print_r($total_images);
        //exit;

        return $total_images;
    }

    /**
     * Before Save Callback
     * @param array $options
     * @return boolean
     */
    /*public function beforeSave($options = array()) {
        // a file has been uploaded so grab the filepath
        if (!empty($this->data[$this->alias]['filepath'])) {
            $this->data[$this->alias]['images'] = $this->data[$this->alias]['filepath'];
        }
        
        return parent::beforeSave($options);
    }*/
    
}