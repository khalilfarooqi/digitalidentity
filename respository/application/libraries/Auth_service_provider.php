<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Service_Provider {

    private $ci;

    protected $except_methods = array(
        'authentication' => array(
            'index',
            'logout',
            'authenticate',
            'authorize',
            'migration',
            'execute_migrate',
        ),
        'default' => array(
            'Authentication',
            'Errors',
            'Dashboard',
            'Users'
        ),
        'users' => array(
            'show',
            'putProfile'
        ),
    );

    protected $except_urls = array();

    /**
     * Type of Routes
     *
     * @params (url|class)
     * @return (string)
     *
     */
    public static $TYPE_OF_ROUTE = 'class';

    private $type_of_route = null;

    private $is_route = false;

    protected $autoload_action_button = null;

    protected $_define_resource_route = null;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->type_of_route = self::$TYPE_OF_ROUTE;

        $this->_define_resource_route = $this->ci->uri->segment(1);
    }

    public function defineRouteButtonPermissions( $perms )
    {
        $data = [];

        if( count($perms) )
        {
            $register_policies = array(
                'add' => 'action',
                'edit' => 'action-$1',
                'delete' => 'delete-$1',
                'show' => 'show-$1',
            );

            foreach ( $perms as $value )
            {
                $data[] = strtolower($value['prefix_or_url']) .'-'. $value['value_btn'];
            }
        }

        return $data;
    }

    /**
     * Note:
     *
     * All Routes lower case
     *
    */
    public function defineRouteAccessPermissions( $perms )
    {
        $data = [];

        if( count($perms) )
        {
            $register_policies = array(
                'add' => 'action',
                'edit' => 'action/$1',
                'delete' => 'delete/$1',
                'show' => 'show/$1',
                'report' => 'index',
            );

            foreach ( $perms as $value )
            {
                $route_url  = (isset($register_policies[$value['value_btn']]) ? $register_policies[$value['value_btn']] : $value['value_btn']);

                if( strpos($value['prefix_or_url'], '/') !== false && !in_array($route_url, $register_policies)) {
                    $data[]     = $value['prefix_or_url'];
                }
                else {

                    if( strpos($value['btn_option'], '/') !== false && !in_array($route_url, $register_policies)) {
                        $data[] = $value['btn_option'];
                    }
                    else{
                        $data[] = $value['prefix_or_url'] .'/'. $route_url;
                    }
                }
            }
        }

        return $data;
    }

    public function autoloadAuthorizingAccess()
    {
        if( $this->ci->session->userdata('is_admin') ) {
            return TRUE;
        }

        if( $this->ci->input->is_ajax_request()){
            return TRUE;
        }

        $this->_validationUrlPermission();
        //exit('authoload authorize action');
    }

    private function _validationUrlPermission()
    {
        $route_access       = $this->ci->session->userdata('define_route_access');
        $loggedin           = $this->ci->session->userdata('loggedin');
        $routes             = $this->ci->router;
        $is_access_route    = $routes->class . '/' . $routes->method;

        if( $this->ci->uri->segment(3) ) {
            $is_access_route = $is_access_route .'/$1';
        }

        /*dd($this->ci->session->userdata(), false, 'All Session');
        dd($is_access_route, false, 'is_access_route');
        dd($route_access, true, 'all permissions');*/

        //Permission :: Check of User Permissions
        if( isset($route_access) && count($route_access) )
        {
            if( in_array($is_access_route, $route_access)) {
                return TRUE;
            }
        }

        //Except of Default Modules Permissions
        if( in_array($routes->class, $this->except_methods['default']) ) {
            return TRUE;
        }

        //Except of Specific Modules & Methods Permissions
        if( count($this->except_methods) )
        {
            foreach ($this->except_methods as $class => $methods )
            {
                if( $class ==  'default' ) {
                    continue;
                }

                foreach ($methods as $method)
                {
                    $except_url = ucfirst( $class ).'/'. $method;
                    //dd($except_url, false, 'except_url');

                    if( $except_url == $is_access_route ) {
                        return TRUE;
                    }
                }
            }
        }

        redirect( !$loggedin ? 'Authentication'  : 'Errors/access_denied' );

        dd($route_access, true, '404 error permissions');
    }

    public static function forAllows( $param )
    {
        $ci = get_ci_instance();

        if( $ci->session->userdata('is_admin') ) {
            return TRUE;
        }

        $define_route_button = $ci->session->userdata('define_route_button') ?? array();

        return (bool) in_array($param, $define_route_button);
    }

    public static function forDefineButtons()
    {
        $ci = get_ci_instance();

        return $ci->session->userdata('define_route_button');
    }

    public function setResourceRoute( $route )
    {
        $this->_define_resource_route = $route;
    }

    public function setOfActionButton()
    {
        $this->autoload_action_button = null;
    }

    private function _autoloadActionButtons( $action_id, $give_permissions, $excepts_permissions )
    {
        $route_name     = $this->_define_resource_route;
        $action_id      = ($action_id ?: '-');
        $define_route   = strtolower($route_name);

        $sync_permissions = array('edit', 'delete', 'show');

        // Sync Route Permissions
        if( $give_permissions && count($give_permissions) ){
            $sync_permissions = $give_permissions;
        }

        // Sync Route Permissions
        if( $excepts_permissions && count($excepts_permissions) ){
            $sync_permissions = array_only($sync_permissions, $excepts_permissions);
        }

        //dd( $this->forDefineButtons(), false );
        //var_dump( self::forAllows( $define_route . '-edit')  );exit;

        $htmlBody = '<center>
            <div class="tools">
        ';

        if( in_array('edit', $sync_permissions) && self::forAllows( $define_route . '-edit' ) ){

            $htmlBody .= '<a href="'.base_url( $route_name.'/action/'. $action_id ).'" title="Edit" class="edit_button">
                <i class="fa fa-pencil"></i>
            </a>';
        }

        if( in_array('delete', $sync_permissions) && self::forAllows( $define_route . '-delete' ) ){

            $htmlBody .= '<a href="javascript:void(0);" title="Delete" data-id="'.$action_id.'" class="delete text-danger">
                <i class="fa fa-trash"></i>
            </a>';
        }

        if( in_array('show', $sync_permissions) && self::forAllows( $define_route . '-show' ) ){

            $htmlBody .= '<a href="' . base_url($route_name . '/show/' . $action_id) . '" title="Show">
                <i class="fa fa-eye"></i>
            </a>';
        }

        $htmlBody .= '
            </div>
        </center>
        ';

        return $htmlBody;
    }

    public function getOfActionButtons( $action_id, $give_permissions = array(), $excepts_permissions = array() )
    {
        return $this->_autoloadActionButtons( $action_id, $give_permissions, $excepts_permissions );
    }
}