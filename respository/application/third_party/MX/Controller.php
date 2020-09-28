<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller
{
	public $autoload 	= array();
	public $uses 		= array();

	public function __construct()
	{
		$class = str_replace ( CI::$APP->config->item ( 'controller_suffix' ), '', get_class ( $this ) );

		log_message ( 'debug', $class . " MX_Controller Initialized" );

		Modules::$registry [strtolower ( $class )] = $this;

		// copy a loader instance and initialize
		$this->load = clone load_class ( 'Loader' );
		$this->load->initialize ( $this );

		// autoload module items
		$this->load->_autoloader ( $this->autoload );

		$this->load->library ( array('form_validation') );
		
		
		$this->load->helper ( 'form' );
		
		$this->lang->load('ur_lang', 'lang');

		/*
		 * Todo:: Ajax Request Pending
		 * - - - - - - - - - - - - - -
		 *
		 */

		// $this->_boot();
	}

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
	private function _boot()
	{	
		$this->auth_service_provider->autoloadAuthorizingAccess();
	}

    public function __get($class)
    {
        return CI::$APP->$class;
    }

    public function OperationLog($url, $params, $tblName, $modelname , $type , $primarykey = null)
    {
        if (! empty ( $params ))
        {
            $date = date ( 'Y-m-d H:i:s' );
            $checkindate = date ( 'Y-m-d H:i' );

            // get only keys from post
            $keys = "*";
            if($type =='updatemaster' || $type =='updatedetail'){
                $keys = array_keys ( $params);
            }

            $this->load->model ( $modelname);

            if($type=='update' || $type=='updatemaster' || $type=='updatedetail'){

                if($type=='updatemaster'){
                    $operation = 'update master';
                }elseif ($type=='updatedetail'){
                    $operation = 'update detail';
                }else{
                    $operation = 'update';
                }

                $result = $this->$modelname->GateById ($keys , $tblName ,$primarykey);

                if(isset($params['remove_doc_type']) && is_array($params['remove_doc_type']) && $params['remove_doc_type']!=""){
                    unset($params['remove_doc_type']);
                }

                if(isset($params['remove_loc_code']) && is_array($params['remove_loc_code']) && $params['remove_loc_code']!=""){
                    unset($params['remove_loc_code']);
                }

                $SimilarParams = array_diff ($result[0],$params);
                $SimilarParams2 = array_diff ($params,$result[0]);

                $change = array();
                foreach ($SimilarParams as $key => $val) {
                    $change['old_'.$key] = $val;
                }

                if(isset($change['old_deleted_by'])){
                    unset($change['old_deleted_by'],$change['old_deleted_date']);
                }

                $LogUpdate  = array_filter(array_merge($primarykey,$change,$SimilarParams2));
                $doJson     = json_encode ( $LogUpdate);
            }
            else if ($type=='deleted' || $type=='deleteddetail' )
            {
                if($type=='deleteddetail'){
                    $operation = 'delete detail';
                }else{
                    $operation = 'delete';
                }

                $params['is_active']=2;

                unset($params['deleted']);
                $doJson = json_encode ( $params );
            }
            else if($type=='ChangeStatus')
            {
                $operation = 'status update';

                unset($params['ChangeStatus']);
                $doJson = json_encode ( $params );

            }
            elseif($type=='insert')
            {
                $operation  = 'insert';
                $doJson     = json_encode ( $params );
            }
            elseif($type=='insertmaster')
            {
                $operation = 'insert Master';
                $doJson = json_encode ( $params );
            }
            else{
                $operation = 'insert Details';
                $doJson = json_encode ( $params );
            }

            $controller = $this->router->class;

            $dataUserLog = array (
                'form_title' => $controller,
                'user_id' => $this->session->userdata ( 'id' ),
                'action' => $operation,
                'datetime' => $date,
                'screen_dump' => $doJson,
                'is_active' => 1,
                'created_date' => $date,
                'created_by' => $this->session->userdata ( 'id' ),
                'modified_date' => $date,
                'modified_by' => $this->session->userdata ( 'id' )
            );

            $this->$modelname->db_insert ( 'user_operation_log', $dataUserLog );
        }
    }

    protected function send_email($to=NULL, $subject=NULL, $frommail= NULL , $fromname= NULL, $body = NULL , $attachments = NULL,$extra_email=NULL )
    {
	    $this->load->library('PHPMailer/PHPMailer');
	    $this->load->library('PHPMailer/SMTP');

	    $mail = new PHPMailer;

        $mail->CharSet = 'UTF-8'; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.mandrillapp.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'system.support@dawateislami.net'; // SMTP username
        $mail->Password = 'fFbHWBejhFp4PctNWy7yPQ'; // SMTP password
        $mail->SMTPSecure = 'smtp'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to
        $mail->isHTML(true); // Set email format to HTML

        // for sending from localhost email 
        $mail->smtpConnect(
        	array(
        		"ssl" => array(
        			"verify_peer" => false,
        			"verify_peer_name" => false,
        			"allow_self_signed" => true
        		)
        	)
        );

        $mail->setFrom('noreply@dawateislami.net'); //Recipients
        $mail->addAddress($to);
        $mail->Subject = $subject;

        $mail->Body    = $body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        return (int) $mail->send();
    }

    public function send_sms($number, $message) 
    {
    	$mask = "DawatIslami";
    	$user = "1349";
    	$password = "attar2626";

        $destination = '92' . substr($number, 1); // Target Phone no. for sending SMS.
        //echo $destination.'<br>';
        $message = urlencode($message);
        $post_data = "user=" . $user . "&pwd=" . $password . "&mask=" . $mask . "&text=" . $message . "&dest=" . $destination . ""; //post string

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.capitalsms.com/sentadd.asp?" . $post_data );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
        echo $result = curl_exec ($ch);

        curl_close($ch);
    }
}