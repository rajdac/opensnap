<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL	
	 */	 
	function __construct()
    {
        parent::__construct();
	 
	    $this->load->helper('url');
        $this->load->library('opensnap');

    }
	
	private function _getDefaultautocompleteParams()
	{
	    $params = array(); 
	    $params['city_id']=1;
		$params['country_id']=1;
		$params['api_ver']='170';
			    
		return $params; 

    } 
	
	 
	public function index()
	{   
	
		$params =  $this->_getDefaultautocompleteParams();

		$data = array();
	//	http://localhost/opensnap/index.php/autocomplete/?featureClass=P&style=full&maxRows=12&name_startsWith=piz
		
		$params['keyword']= $this->input->get("name_startsWith");
	    $results = $this->_searchTips($params);
				
		$results = $this->_parseAutoCompleteResults($results);
		/*
		echo '<pre>';
		print_r($results['search_tips']);
		echo '</pre>';
		
		die();
		*/
		print json_encode($results['search_tips']);
		flush();
						
	} 
	
	private function _searchTips($params)
	{
	   $params['action_type']='general_search';
	   $params['Misc']='';
	   $params['reloadcache']=1;
       $params['api_ver']=302;  	   
	   //return $this->opensnap->api_api_searchtips_getlist($params);
	   return $this->opensnap->api_ApiGetSearchTipFromSolr_searchtips_solr_getlist($params);
    }
	
    private function _parseAutoCompleteResults($response)
	{	
	  	$data = array();			
		$data['response'] = $response;
		
		$body = json_decode($data['response']['body']);
		$System =  $body->Root->System[0];
		$Data   =  $body->Root->Data[0];
		$data['error'] = array();
		$data['error']['true'] = ( $data['response']['response_info']['http_code'] == '' ||  isset( $Data->Errors) )?TRUE:FALSE; 
				
		$data['Status'] = $System->Status || $data['response']['response_info']['http_code'];
		$data['photos_total_count'] = 0; 
				
		if( $data['error']['true'] )
		{    
				if($data['Status'] == '200')
				{   
					$data['error']['description'] = $Data->Errors[0]->Error[0]->ErrorDescription;
			        $data['error']['id'] = $Data->Errors[0]->Error[0]->Id;
				 
				}else{
				  
					$data['error']['description'] = 'Url ' . $data['request'] . ' cannot be reached';
			        $data['error']['id'] = '404';
				}
		     		  			
		}else{
		         			
				$data['search_tips'] = $Data->SearchTips[0]->SearchTip;	
		}
		        return $data;  			
				
	} 
     	
					
			
}
/* End of file resturant.php */
/* Location: ./application/controllers/resturant.php */