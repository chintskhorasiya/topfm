<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $helpers = array('Html', 'Form', 'Time', 'Session');
    //var $components = array('Email','Session','Cookie','RequestHandler','DebugKit.Toolbar' => array(/* array of settings */));
    var $components = array('Email', 'Session', 'Cookie', 'RequestHandler');
    var $uses = array('User');

    function beforeFilter() {

    	date_default_timezone_set('Asia/Kolkata');

        if($this->params['controller'] == "pages" || $this->params['controller'] == "videos" || $this->params['controller'] == "galleries" || $this->params['controller'] == "cities" || $this->params['controller'] == "programs" || $this->params['controller'] == "settings" || $this->params['controller'] == "settings" || $this->params['controller'] == "settings" || $this->params['controller'] == "settings" || $this->params['controller'] == "settings")
        {
            $this->checklogin();
        }

        if($this->params['controller'] == "pages" || $this->params['controller'] == "videos" || $this->params['controller'] == "galleries" || $this->params['controller'] == "galleries"  || $this->params['controller'] == "cities" || $this->params['controller'] == "programs" || $this->params['controller'] == "settings")
        {
            $pagenames = $this->params['controller'].'/'.$this->params['action'];
        }
        else
        {
            $pagenames = $this->params['action'];
        }

        $this->set('og_enabled', false);
        $this->set('front', false);

        if($this->params['controller'] == "front") {
            $this->set_title($pagenames, $this->params['pass']);
        } else {
            $this->set_title($pagenames);
        }

    }

    function set_title($pagenames, $params='') {
        //echo $pagenames;
        //var_dump($params);
        $dynamic_name = '';
        
        if($pagenames == "video_detail")
        {
            $this->loadmodel('Video');
            $video_data = $this->Video->find('first', array('conditions' => array('status IN'=> array(1), 'slug'=>$params[0])));
            //$this->pre($news_data);
            if(!empty($video_data['Video']['title']))
            {
                $dynamic_name .= 'Video - '.$video_data['Video']['title'];
            }
        }

        if($pagenames == "gallery_detail")
        {
            $this->loadmodel('Gallery');
            $gallery_data = $this->Gallery->find('first', array('conditions' => array('status IN'=> array(1), 'slug'=>$params[0])));
            //$this->pre($news_data);
            if(!empty($gallery_data['Gallery']['title']))
            {
                $dynamic_name .= 'Photo Gallery - '.$gallery_data['Gallery']['title'];
            }
        }

        $title_arr = array(
            'index'=>'Login',
            'admin_dashboard'=>'Dashboard',
            'admin_editprofile'=>'Edit Profile',
            'admin_change_password'=>'Change Password',
            'registration'=>'Registration',
            'forgot_password'=>'Forgot Password',
            'pages/admin_search'=>'Searched Pages List',
            'pages/admin_lists'=>'Pages List',
            'pages/admin_add'=>'Add Page',
            'pages/admin_edit'=>'Edit Page',
            'home'=>'Home page',
            'videos/admin_search'=>'Searched Videos List',
            'videos/admin_lists'=>'Videos List',
            'videos/admin_add'=>'Add Video',
            'videos/admin_edit'=>'Edit Video',
            'videos_listing'=>'Videos',
            'video_detail'=>$dynamic_name,
            'settings/admin_general'=>'General Settings',
            'galleries/admin_search'=>'Searched Galleries List',
            'galleries/admin_lists'=>'Galleries List',
            'galleries/admin_add'=>'Add Gallery',
            'galleries/admin_edit'=>'Edit Gallery',
            'gallery_listing'=>'Photo Gallery',
            'gallery_detail'=>$dynamic_name,
            'cities/admin_search'=>'Searched Cities List',
            'cities/admin_lists'=>'Cities List',
            'cities/admin_add'=>'Add City',
            'cities/admin_edit'=>'Edit City',
            'programs/admin_search'=>'Searched Programs List',
            'programs/admin_lists'=>'Programs List',
            'programs/admin_add'=>'Add Program',
            'programs/admin_edit'=>'Edit Program',
            'schedules/admin_search'=>'Searched Schedules List',
            'schedules/admin_lists'=>'Schedules List',
            'schedules/admin_add'=>'Add Schedule',
            'schedules/admin_edit'=>'Edit Schedule',
            'reviews/admin_search'=>'Searched Reviews List',
            'reviews/admin_lists'=>'Reviews List',
            'reviews/admin_add'=>'Add Review',
            'reviews/admin_edit'=>'Edit Review',
            'events/admin_search'=>'Searched Events List',
            'events/admin_lists'=>'Events List',
            'events/admin_add'=>'Add Event',
            'events/admin_edit'=>'Edit Event',
            'blogs/admin_search'=>'Searched Blogs List',
            'blogs/admin_lists'=>'Blogs List',
            'blogs/admin_add'=>'Add Blog',
            'blogs/admin_edit'=>'Edit Blog',
            'rjs/admin_search'=>'Searched Rjs List',
            'rjs/admin_lists'=>'Rjs List',
            'rjs/admin_add'=>'Add Rj',
            'rjs/admin_edit'=>'Edit Rj'
        );
//
        //echo $title_arr[$pagenames];
        $this->set('page_title_tag',(isset($title_arr[$pagenames]) && $title_arr[$pagenames]!='')?$title_arr[$pagenames]:'');
    }

    //Function for check admin session
    function checklogin() {
        // if the admin session hasn't been set  3
        if ($this->Session->check(md5(SITE_TITLE) . 'USERID') == false) {
            //$this->Session->setFlash('The URL you\'ve followed requires you login.');
            //$this->redirect(DEFAULT_URL);
            $this->redirect(DEFAULT_ADMINURL);
            exit();
        }
    }


}
