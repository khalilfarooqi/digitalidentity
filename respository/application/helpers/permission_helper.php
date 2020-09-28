
<?php defined('BASEPATH') OR exit('No direct script access allowed');



 function check_permission($class,$method){
    $ci =& get_instance();
    if(strpos($class,'-')){
       
        if( true ==  check_route_permission($class)){
    
        }else{
           echo '404';
           exit;
        }
    
    }else{
    
    if( true==  check_class_method($class,$method)){
    
    }else{
       echo '404';
       exit;
    }
      
    }
    
    }



    function check_permission_and_make_button($class,$method,$id,$default){

        $ci =& get_instance();
        
            $data  = check_permission_button($class);
           $html='<center>
           <div class="tools">';
            if(!empty( $data)){

                foreach($data  as $value){
                 
                   switch(strtolower($value['btn_option'])){
                    
                       
                     case'delete' :  if( $default != 1) {
                           $html .= '<a href="javascript:void(0);" title="Delete" data-id="'.encrypt($id).'" class="delete text-danger"><i class="fa fa-trash"></i></a>';    
                        }else{
                            $html.='<span>(Default)</span>';
                     };
                     break;
                     case'show' :  
                     if($value['type']=="class"){
                        $html .= '     <a href="'.base_url(current_controller().'/'.$value['value_btn'].'/'.encrypt($id)).'" title="Show">
                        <i class="fa fa-eye"></i>
                     </a>   ';
                    }
                        else{
                            $html .= '     <a href="'.base_url().$value['value_btn'].'/'.encrypt($id).'" title="Show">
                            <i class="fa fa-eye"></i>
                         </a>   ';
                        }
                     break;
                     
                     case'update' : 
                     if($value['type']=="class"){
                       $html.= '
                         <a href="'.base_url(current_controller().'/'.$value['value_btn'].'/'.encrypt($id)).'" title="Edit " class="edit_button">
                         <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
                     }else{
                        $html.= '
                         <a href="'.base_url().$value['value_btn'].'/'.encrypt($id).'" title="Edit " class="edit_button">
                         <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
                     }
                     break;


                   }
                }
                $html .= '   </div>  </center>';
                
                return $html;

            }
        

   


    }

    
    function check_permiison_create_big_Button($class,$method){

        $ci =& get_instance();
        
            $data  = check_permission_button($class);
           $html='';
            if(!empty( $data)){

                foreach($data  as $value){
                 
                   switch(strtolower($value['btn_option'])){
      
                       
                    //  case'delete' :  if( $default != 1) {
                    //        $html .= '<a href="javascript:void(0);" class="pull-right btn bigger-50 ws-btn-font  btn-success" title="Delete" data-id="'.encrypt($id).'" class="delete text-danger"><i class="fa fa-trash"></i></a>';    
                    //     }else{
                    //         $html.='<span>(Default)</span>';
                    //  };
                    //  break;
                   
                     
                    //  case'update' : 
                    //  if($value['type']=="class"){
                    //    $html.= '
                    //      <a href="'.base_url(current_controller().'/'.$value['value_btn'].'/'.encrypt($id)).'" title="Edit "  class="pull-right btn bigger-50 ws-btn-font  btn-success">
                    //      <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
                    //  }else{
                    //     $html.= '
                    //      <a href="'.base_url().$value['value_btn'].'/'.encrypt($id).'" title="Edit "  class="pull-right btn bigger-50 ws-btn-font  btn-success">
                    //      <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
                    //  }
                    //  break;


                     case'add' : 
                     if($value['type']=="class"){
                       $html.= '
                         <a href="'.base_url(current_controller().'/'.$value['value_btn']).'" title="Add "  class="pull-right btn bigger-50 ws-btn-font  btn-success">
                        Add New</a>&nbsp;&nbsp;';
                     }else{
                        $html.= '
                         <a href="'.base_url().$value['value_btn'].'" title="Add "  class="pull-right btn bigger-50 ws-btn-font  btn-success">
                         Add New</a>&nbsp;&nbsp;';
                     }
                     break;


                   }
                }
            
                
                return $html;

            }
        

   


    }
    
    function check_permission_button($url){
        $ci =& get_instance();

        $permission =  $ci->session->userdata('User_permission');
        $data =[]; 
        //dd($permission);  
        
        $main_routes= $ci->router->routes;
       
        $routes_key=[];    
        $route_lower_name=[];    
        $route_name=[];    
        $route_value=[];    
        $key;
        
        foreach ($main_routes as $key => $value)
        {
       if(strpos(strtolower($key),'/')){
           $route_lower_name[] =  substr(strtolower($key), 0, strpos(strtolower($key), "/"));
           $route_name[] =  substr($key, 0, strpos($key, "/"));
       }else{

           $route_lower_name[] =  strtolower($key);
          $route_name[] =  ($key);
       }
                //$route_name[]       =  $key;
                $route_value[]      =  $value;
                
        }
            
            $main_routes['name']    =  $route_name;
            $main_routes['value']   =  $route_value;
            $main_routes['lower_name']    =  $route_lower_name;
            
          
            

        foreach ($permission as $key => $value) {    
            if($value['prefix_or_url']==$url || strtolower($value['prefix_or_url'])==strtolower($url)) 
            {
            $index=array_search(strtolower($url.'-'.$value['btn_option']),$main_routes['lower_name']); 
            if($index){
                $data[$key]=array(
                    'btn_option' => $value['btn_option'],
                    'value_btn' => $main_routes['name'][$index],
                    'type' =>'route'                
                   );
            }
           
           else if($value['prefix_or_url']==$url)
           {
               $data[$key]=array(
                 'btn_option' => $value['btn_option'],
                 'value_btn' => $value['value_btn'],
                 'type' =>'class'                       
                );
           }

        }
            
        }
       
      
       //dd($data);
        return $data;


    }

    //check routes
     function check_route_permission($url)
    {
        $ci =& get_instance();
        $main_routes= $ci->router->routes;
       
            $routes_key=[];    
            $route_lower_name=[];    
            $route_name=[];    
            $route_value=[];    
            $key;
            
            // foreach ($main_routes as $key => $value)
            // {
            //     $route_lower_name[] =  strtolower($key);
            //         $route_name[]       =  $key;
            //         $route_value[]      =  $value;
                    
            //     }
                
            //     $main_routes['name']    =  $route_name;
            //     $main_routes['value']   =  $route_value;
            //     $main_routes['lower_name']    =  $route_lower_name;
            //     dd(explode($url,'-'));
                
            //     if(array_search(strtolower($url),$main_routes['lower_name']))
            //  {
            //         return  true;
            //  }
            // else
            // {
            //     return false;
            // }

            

            $permission = $ci->session->userdata('User_permission');
             
            foreach ($permission as $key => $value) {               
           
         if( strtolower( $value['prefix_or_url'].'-'.$value['btn_option']) ==  strtolower($url)  ||  $value['prefix_or_url'].'-'.$value['btn_option'] ==  $url   ){
            return  true;
         }
         

         if(  $value['prefix_or_url'].'-'.$value['value_btn'] ==  $url || strtolower( $value['prefix_or_url'].'-'.$value['value_btn']) ==  strtolower($url)  ){
            return  true;
         }
                  
                   
                
                
            }


    
    }
    
    
    
    //check class
      function check_class_method($class,$method){
        $ci =& get_instance();
    
        $permission = $ci->session->userdata('User_permission');

            foreach ($permission as $key => $value) {               
           
                if($value['prefix_or_url']==($class) || strtolower($value['prefix_or_url'])==strtolower($class)){
    
                   if(strtolower($value['btn_option'])==strtolower($method) || $value['btn_option']==$method){
                     
                       return true;
                   }
                   if(strtolower($value['value_btn'])==strtolower($method) || $value['value_btn']==$method){
                     
                       return true;
                   }
                   if(($value['btn_option']=="List" || $value['btn_option']=="list")  && empty($method)){
                 
                       return true;
                   }  
                 
                   if( ($value['value_btn']=="List" || $value['value_btn']=="list"  || strpos($value['value_btn'],"list"))  && empty($method)){
                 
                    return true;
                }  
              
                   
                }
                
            }
         
            return false;
    
    }
    
    