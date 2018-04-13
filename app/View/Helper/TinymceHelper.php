<?php
App::uses('AppHelper', 'View/Helper');

class TinymceHelper extends AppHelper {

    // Take advantage of other helpers
    public $helpers = array('Js', 'Html', 'Form');

    // Check if the tiny_mce.js file has been added or not
    public $_script = false;

    /**
    * Adds the tiny_mce.js file and constructs the options
    *
    * @param string $fieldName Name of a field, like this "Modelname.fieldname"
    * @param array $tinyoptions Array of TinyMCE attributes for this textarea
    * @return string JavaScript code to initialise the TinyMCE area
    */
    function _build($fieldName, $tinyoptions = array()){
        if(!$this->_script){
            // We don't want to add this every time, it's only needed once
            $this->_script = true;
            echo $this->Html->script('tinymce/tinymce.min');
            //exit;
        }

        // Ties the options to the field
        $tinyoptions['mode'] = 'exact';
        $tinyoptions['elements'] = $this->domId($fieldName);

        // List the keys having a function
        $value_arr = array();
        $replace_keys = array();
        foreach($tinyoptions as $key => &$value){
            // Checks if the value starts with 'function ('
            if(strpos($value, 'function(') === 0){
                $value_arr[] = $value;
                $value = '%' . $key . '%';
                $replace_keys[] = '"' . $value . '"';
            }
        }

        // Encode the array in json
        $json = $this->Js->object($tinyoptions);

        // Replace the functions
        $json = str_replace($replace_keys, $value_arr, $json);
        //$this->Html->scriptStart(array('inline' => false));
        //echo '<script>tinyMCE.init(' . $json . ');</script>';
        echo '<script>tinymce.init({
  selector: \'.tinymce-textarea\',
  file_browser_callback_types: \'file image media\',
  height: 500,
  menubar: false,
  plugins: \'image code\',
  toolbar: \'undo redo | link image | formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat\',
  // enable title field in the Image dialog
  image_title: true, 
  // enable automatic uploads of images represented by blob or data URIs
  automatic_uploads: true,
  file_picker_types: "image", 
file_picker_callback: function(cb, value, meta) {
  var input = document.createElement("input");
  input.setAttribute("type", "file");
  input.setAttribute("accept", "image/*");
  input.onchange = function() {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function () {
      var id = "blobid" + (new Date()).getTime();
      var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
      var base64 = reader.result.split(",")[1];
      var blobInfo = blobCache.create(id, file, base64);
      blobCache.add(blobInfo);
      cb(blobInfo.blobUri(), { title: file.name });
    };
    reader.readAsDataURL(file);
  };
  input.click();
},
  /*plugins: [
    \'advlist autolink lists link image charmap print preview anchor textcolor\',
    \'searchreplace visualblocks code fullscreen\',
    \'insertdatetime media table contextmenu paste code help\'
  ],
  toolbar: \'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help\',*/
  content_css: [
    \'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i\',
    \'//www.tinymce.com/css/codepen.min.css\']
});</script>';
        //$this->Html->scriptEnd();
    }

    /**
    * Creates a TinyMCE textarea.
    *
    * @param string $fieldName Name of a field, like this "Modelname.fieldname"
    * @param array $options Array of HTML attributes.
    * @param array $tinyoptions Array of TinyMCE attributes for this textarea
    * @param string $preset
    * @return string An HTML textarea element with TinyMCE
    */
    function textarea($fieldName, $options = array(), $tinyoptions = array(), $preset = null){
        // If a preset is defined
        if(!empty($preset)){
            $preset_options = $this->preset($preset);

            // If $preset_options && $tinyoptions are an array
            if(is_array($preset_options) && is_array($tinyoptions)){
                $tinyoptions = array_merge($preset_options, $tinyoptions);
            }else{
                $tinyoptions = $preset_options;
            }
        }
        return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
    }

    /**
    * Creates a TinyMCE textarea.
    *
    * @param string $fieldName Name of a field, like this "Modelname.fieldname"
    * @param array $options Array of HTML attributes.
    * @param array $tinyoptions Array of TinyMCE attributes for this textarea
    * @return string An HTML textarea element with TinyMCE
    */
    function input($fieldName, $options = array(), $tinyoptions = array(), $preset = null){
        // If a preset is defined
        if(!empty($preset)){
            $preset_options = $this->preset($preset);

            // If $preset_options && $tinyoptions are an array
            if(is_array($preset_options) && is_array($tinyoptions)){
                $tinyoptions = array_merge($preset_options, $tinyoptions);
            }else{
                $tinyoptions = $preset_options;
            }
        }
        $options['type'] = 'textarea';
        return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
    }

    /**
    * Creates a preset for TinyOptions
    *
    * @param string $name
    * @return array
    */
    private function preset($name){
        // Full Feature
        if($name == 'full'){
            return array(
                'theme' => 'advanced',
                'plugins' => 'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'theme_advanced_buttons1' => 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
                'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
                'theme_advanced_buttons3' => 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
                'theme_advanced_buttons4' => 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'convert_fonts_to_spans' => true,
                'file_browser_callback' => 'ckfinder_for_tiny_mce'
            );
        }

        // Basic
        if($name == 'basic'){
            return array(
                'theme' => 'advanced',
                'plugins' => 'safari,advlink,paste',
                'theme_advanced_buttons1' => 'code,|,copy,pastetext,|,bold,italic,underline,|,link,unlink,|,bullist,numlist',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'center',
                'theme_advanced_statusbar_location' => 'none',
                'theme_advanced_resizing' => false,
                'theme_advanced_resize_horizontal' => false,
                'convert_fonts_to_spans' => false
            );
        }

        // Simple
        if($name == 'simple'){
            return array(
                'theme' => 'simple',
            );
        }

        // BBCode
        if($name == 'bbcode'){
            return array(
                'theme' => 'modern',
                'plugins' => 'bbcode',
                'theme_advanced_buttons1' => 'bold,italic,underline,undo,redo,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_styles' => 'Code=codeStyle;Quote=quoteStyle',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'entity_encoding' => 'raw',
                'add_unload_trigger' => false,
                'remove_linebreaks' => false,
                'inline_styles' => false
            );
        }
        return null;
    }
}