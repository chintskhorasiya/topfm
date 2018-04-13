<?php
App::uses('AppModel', 'Model');
class Page extends AppModel {
    
    public $name = 'Page';

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
    
}