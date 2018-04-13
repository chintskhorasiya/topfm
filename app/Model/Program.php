<?php
App::uses('AppModel', 'Model');
class Program extends AppModel {
    
    public $name = 'Program';

    public $validate = array(
        'title' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Title can not be blank',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'slug' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Slug can not be blank',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'facebook_link' => array(
            'url' => array(
                'rule' => 'url',
                'message' => 'Facebook URL is not valid',
            )
        ),
        'twitter_link' => array(
            'url' => array(
                'rule' => 'url',
                'message' => 'Twitter URL is not valid',
            )
        ),
        'program_time' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Program time can not be blank',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    
}