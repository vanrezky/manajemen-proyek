<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class M_pdf { 

    private $mgl 	= 15;	// margin left
    private $mgr 	= 15;	// margin right
    private $mgt 	= 16;	// margin top
    private $mgb 	= 16; 	// margin boottom
    private $mgh 	= 9;		
    private $mgf 	= 9;
    private $mode   = 'c';
    private $format = 'A4';	// size document
    private $default_font      = '';	// font family
    private $orientation 	   = 'l';	// landscape, potralite
    private $default_font_size = 0;		// font size

    // function m_pdf() {
    //     $CI = & get_instance();
    // }

    public function __construct() {}
 
    function load($param=array()) {
    	if(is_array($param) AND count($param) > 0) {
    		if(isset($param["mgl"])) $this->mgl = $param["mgl"];
    		if(isset($param["mgr"])) $this->mgr = $param["mgr"];
    		if(isset($param["mgt"])) $this->mgt = $param["mgt"];
    		if(isset($param["mgb"])) $this->mgb = $param["mgb"];
    		if(isset($param["mgh"])) $this->mgh = $param["mgh"];
    		if(isset($param["mgf"])) $this->mgf = $param["mgf"];
    		if(isset($param["mode"])) $this->mode = $param["mode"];
    		if(isset($param["format"])) $this->format = $param["format"];
    		if(isset($param["default_font"])) $this->default_font = $param["default_font"];
    		if(isset($param["orientation"])) $this->orientation = $param["orientation"];
    		if(isset($param["default_font_size"])) $this->default_font_size = $param["default_font_size"];
    	} 
		include_once APPPATH. '/third_party/mpdf60/mpdf.php'; 
		$mpdf = new mPDF($this->mode, $this->format, $this->default_font_size, $this->default_font, $this->mgl, $this->mgr, $this->mgt, $this->mgb, $this->mgh, $this->mgf, $this->orientation);
        // $mpdf->showImageErrors = true;
        return $mpdf;
	}
}