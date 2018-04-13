<?php
App::uses('AppModel', 'Model');
class Video extends AppModel {
    
    public $name = 'Video';

    public $validate = array(
        'title' => array(
            'between' => array(
                'rule' => array('lengthBetween', 5, 255),
                'message' => 'Title can not be empty, And length should be between 5 to 255'
            )
        ),
        'slug' => array(
            'between' => array(
                'rule' => array('lengthBetween', 2, 100),
                'message' => 'Slug can not be empty, And length should be between 2 to 100'
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
            'minLength' => array(
                'rule' => array('minLength', 1),
                'message' => 'Content can not be empty'
            )
        )
    );

    /**
     * Upload Directory relative to WWW_ROOT
     * @param string
     */
    public $uploadDir = 'img/uploads/news_images';

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

                // build full images
                $images = $images_move_dir . Inflector::slug(pathinfo($image['name'], PATHINFO_FILENAME)).'.'.pathinfo($image['name'], PATHINFO_EXTENSION);

                // @todo check for duplicate images

                // try moving file
                if (!move_uploaded_file($image['tmp_name'], $images)) {
                    return FALSE;

                // file successfully uploaded
                } else {
                    // save the file path relative from WWW_ROOT e.g. uploads/example_images.jpg
                    //$this->data[$this->alias]['filepath'] = str_replace(DS, "/", str_replace(WWW_ROOT, "", $images) );

                    $succeed_images[] = DEFAULT_URL.str_replace(DS, "/", str_replace(WWW_ROOT, "", $images));;
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