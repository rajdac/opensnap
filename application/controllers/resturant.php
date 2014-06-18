<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resturant extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	
	 */	 
	function __construct()
    {
        parent::__construct();
	 
	    $this->load->library('template');
        $this->template->prepend_metadata('<link href="/opensnap/assets/css/style.css" rel="stylesheet" type="text/css">');
        $this->template->prepend_metadata('<script language="javascript" src="images/menu.js"></script>');

        $this->load->helper('url');
        $this->load->library('opensnap');

    }
	
	private function _getDefaultSearchParams()
	{
	    $params = array(); 
		$params['api_ver']='400';
	    $params['city_id']=1;
		$params['page']=1;
		$params['per_page']=24;
		$params['free_text_tag']='';
		$params['free_text_tag_id']='';
		$params['photo_poi_type']='';
		$params['snap_poi_id']='';
		$params['or_poi_id']='';
		$params['or_region_id']='';
		$params['photo_sub_type']='';
		$params['dish_name']='';
		$params['cuisine_id']='';
		$params['district_id']='';
		$params['landmark_id']='';
		$params['amenity_id']='';
		$params['dish_id']='';
		$params['maplat']='';
		$params['maplng']='';
	    
		return $params; 

    } 
	
	 
	public function index()
	{   
	
		$params =  $this->_getDefaultSearchParams();
		$data = array();
		
		$data['current_tab'] = (trim($this->input->post("current_tab")) != '' )?$this->input->post("current_tab"):'#tabr1';
		$data['search_sav'] = (trim($this->input->post("search")) != '' )?$this->input->post("search"):$this->input->post("search_sav");
		$data['search_type'] = (trim($this->input->post("search_type")) != '' )?$this->input->post("search_type"):14;
		
		$data['ORPoiId'] = (trim($this->input->post("ORPoiId")) != '' )?$this->input->post("ORPoiId"):'';
		$data['ItemId'] = (trim($this->input->post("ItemId")) != '' )?$this->input->post("ItemId"):'';
		$data['ORRegionId'] = (trim($this->input->post("ORRegionId")) != '' )?$this->input->post("ORRegionId"):'';
				
	    $results = $this->_searchLatest($params,$data['search_type']);
			
		$data['latest'] = $this->_parseSearchResults($results);
			
        $results = $this->_searchTop($params,$data['search_type']);
		$data['top'] = $this->_parseSearchResults($results);	
	  
        $this->_displayGrid($data);  		
		
	} 
	
    public function photodetail($id)
	{	   
       $results =  $this->_getPhotodetail($id);  
	  
       $results = $this->_parsePhotoDetails($results);
	   $photo_detail = $results['photo_detail'];
	   $data = array();
	   $data['photo_url'] = $photo_detail->LargePhotoUrl;
	   $data['photo_title'] = $photo_detail->DishName;
	   $data['resturant_name']  = $photo_detail->Poi[0]->Name;
	   
     //  $this->template->set_layout('photodetail');
	   
	   $this->template->set_layout('listing_layout');
	   $this->template->build('photodetail',$data);	 
	}
	
	private function _getPhotodetail($photo_id)
	{  
	   $params = array();
	   $params['photo_id'] = $photo_id;
	   return $this->opensnap->api_ApiGetPhotoDetail_photo_getdetail($params);	    
    }
	
	public function scrollpagination()
	{ 
	    $params = array();
		$data = array();
		
		$data['search_sav'] = trim($this->input->get("search_sav"));
		$data['current_tab'] = trim($this->input->get("current_tab"));
		$data['search_type'] = trim($this->input->get("search_type"));
		
		$offset = ($data['current_tab'] == '#tabr2')?trim($this->input->get("offset2")):trim($this->input->get("offset1"));
		$nop =  trim($this->input->get("nop"));
		
	    $params =  $this->_getDefaultSearchParams();
		$options = $this->_buildSearchOptions($data);
	    $params = array_merge($params,$options);	
		
					
		$params['page']= (ceil($offset/$nop)<2)?2:ceil($offset/$nop);
		
		if($data['current_tab'] == '#tabr2'){		
          $results = $this->_searchTop($params,$data['search_type']);
	  	}else{	
	      $results = $this->_searchLatest($params,$data['search_type']);
		}
		

		$data['data'] = $this->_parseSearchResults($results);		  
        $this->load->view('partials/photoblock',$data);
		   		
	}
	public function search()
	{ 
	    $params = array();
		$data = array();
		
		$data['current_tab'] = (trim($this->input->post("current_tab")) != '' )?$this->input->post("current_tab"):'#tabr1';
		$data['search_sav'] = (trim($this->input->post("search")) != '' )?$this->input->post("search"):$this->input->post("search_sav");	
		$data['search_type'] = (trim($this->input->post("search_type")) != '' )?$this->input->post("search_type"):'14';
		
		$data['ORPoiId'] = (trim($this->input->post("ORPoiId")) != '' )?$this->input->post("ORPoiId"):'';
		$data['ItemId'] = (trim($this->input->post("ItemId")) != '' )?$this->input->post("ItemId"):'';
		$data['ORRegionId'] = (trim($this->input->post("ORRegionId")) != '' )?$this->input->post("ORRegionId"):'';
			
	    $params =  $this->_getDefaultSearchParams();
		/*
			echo '<pre>';
			print_r($params);
			echo '</pre>';
		*/
		$options =  $this->_buildSearchOptions($data);
	    /*
			echo '<pre>';
			print_r($options);
			echo '</pre>';
		*/
        $params = array_merge($params,$options);		
	  	/*
			echo '<pre>';
			print_r($params);
			echo '</pre>';
		*/
		
	    $results = $this->_searchLatest($params,$data['search_type'] );		
		$data['latest'] = $this->_parseSearchResults($results,$data['search_type'] );
      
         	 
          $results = $this->_searchTop($params,$data['search_type']);
		  $data['top'] = $this->_parseSearchResults($results,$data['search_type'] );	
	    
	    
				 
        $this->_displayGrid($data);  		
	}
	
	private function _buildSearchOptions($params)
	{
	
		$options = array();
	    $options['api_ver'] = 302; 
		$options['app_ver'] = '1.1.10'; 
		
		
		switch($params['search_type'])
		{
		  
			case 2:
					 break; 
				   
			case 3:
					 break;
				   
			case 4:  $options['search_type'] = 'cuisine';
					 break; 
				   
			case 5:
					 break;
		   
			case 10:  
			         $options['poi_id'] = $params['ORPoiId'];
					 break; 
				   
			case 11: 			        
			         $options['chain_id'] = $params['ItemId'];
					 $options['region_id'] = 0;
					 break;
				   
			case 12:        
			         $options['dish_name']= "'".trim($params['search_sav'])."'";  
					 break; 
				   
			case 13:
					 break;
			
			case  14: 
			default : 
			          $options['api_ver'] = 302; 
			          $keyword =  preg_replace('/\(All Branches\)/i', ' ', $params['search_sav']);	
					  $options['keyword']= "'".trim($keyword)."'";  			   
					  
		}
			  
	    return $options;
	
	}
	
	private function _searchLatest($params,$search_type)
	{
	
	   $params['order_by']='submittime';
	    
	   switch($search_type)
	   {
          
		 case 10: 
		          return $this->opensnap->callCustomApi('http://cdn.api.snap.hk.openrice.com/api/Sr2ForSnapApi.htm?method=or.poi.getdetailforsnap',$params);
		          break;   
	     case 11: 
		          return $this->opensnap->callCustomApi('http://api.snap.hk.openrice.com/api/Sr1ForSnapApi.htm?method=or.poi.getlistforsnap',$params); 
		          break;
	     default: 
		          return $this->opensnap->api_ApiGetPhotoListLatest_photo_getlist($params);
        }	   
	  
	    
    }
	
	private function _searchTop($params,$search_type)
	{

	   $params['order_by']='24hourslikecount';
	   
	   switch($search_type)
	   {
          
		 case 10: 
		          return $this->opensnap->callCustomApi('http://cdn.api.snap.hk.openrice.com/api/Sr2ForSnapApi.htm?method=or.poi.getdetailforsnap',$params);
		          break;   
	     case 11:
		          return $this->opensnap->callCustomApi('http://api.snap.hk.openrice.com/api/Sr1ForSnapApi.htm?method=or.poi.getlistforsnap',$params); 
		          break;
	     default: 
		          return $this->opensnap->api_ApiGetPhotoListTop_photo_getlist($params);
        }	  
	  
	    
    }
	
    private function _parsePhotoDetails($response)
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
		         			
				$data['photo_detail'] = $Data->Photo[0];	
		}
		   
		     return $data;  			
				
	} 
    
 	
	private function _parseSearchResults($response,$search_type=14)
	{	
	  	switch($search_type)
		{
		
			 case 11:
            		$data = $this->_parseSearchResultsChain($response);
				    break;
			
  			case 4:
			case 14:
			default:
 			        $data = $this->_parseSearchResultsKeyword($response);   		  
                 
        }
      		
		return $data; 		
	}
	
	private function _parseSearchResultsChain($response)
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
		        
								
				$Pois =  $Data->Pois[0];
									
				$data['poi_total_count'] = $Pois->total;
				$data['poi_total_text']  = $Pois->total;
				$data['poi_page_no']     = $Pois->page;
				$data['poi_page_limit']  = $Pois->limit;
				$data['poi_page_count']  = $Pois->count;
				$data['pois_pois']	     = $Pois->Poi;	 
				$data['Check']           = $System->Check;
				$data['Version']         = $System->Version;
		
		}    /*
		      	echo '<pre>';
				print_r($data);
				echo '</pre>';
				exit();
		     */ 
		    return $data;  			
				
	}
	
	private function _parseSearchResultsKeyword($response)
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
		        
				$Photos =  $Data->Photos[0];
								
				$data['photos_total_count'] = $Photos->total;
				$data['photos_total_text']  = $Photos->TotalText;
				$data['photos_page_no']     = $Photos->page;
				$data['photos_page_limit']  = $Photos->limit;
				$data['photos_page_count']  = $Photos->count;
				$data['photos_photos']	    = $Photos->Photo;	 
				$data['TagDetail']          = $Data->TagDetail;
				$data['Check']              = $System->Check;
				$data['Version']            = $System->Version;
		
		}
		    return $data;  			
				
	}
	
	private function _displayGrid($data)
	{
	    $this->template->set_layout('listing_layout');
  
		switch($data['search_type'])
		{
			
			case 11:
			        $this->template->build('poilist',$data);    		
			        break; 
					
			case 14: 
			default:   	 
					 $this->template->build('photoslist',$data);

		}	
    } 				
			
}
/* End of file resturant.php */
/* Location: ./application/controllers/resturant.php */