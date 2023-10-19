<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sdca_Mailer
{
    protected $email;
    protected $load;

/*     public function __construct($arr)
    {
        // parent::_construct();
        $this->load = $arr['load'];
        // 
        // $this->email = $this->load = null;
    }
 */
    public function initialize($arr)
    {
        
        

        // $this->load->library('email');
        // $this->email = $this->email;
    }

    public function webmailer_config()
    {
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_timeout' => '7',
            'SMTPDebug' => '1',
            'SMTPAuth' => true,
            'smtp_user' => 'ojtweb_mailer@sdca.edu.ph',
            'smtp_pass' => 'sdca2022',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'mailtype'  => 'html',
            'validation' => true
        );
        $this->email->initialize($config);
    }

    public function send_email($cp, $from, $from_name, $send_to, $subject, $message, $add_data)
    {
        
        $from = 'des.ict@sdca.edu.ph';
        $this->webmailer_config();
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($send_to);
        $this->email->subject($subject);
        $this->email->message($this->load->view($message, $add_data, true));
        if ($this->email->send()) {
            echo '<pre>' . print_r(array('status' => 'success', 'msg' => 'Email has been sent to ' . $send_to . ' (' . $cp . ')'), 1) . '</pre>';
        } else {
            show_error($this->email->print_debugger());
            echo '<pre>' . print_r(array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to), 1) . '</pre>';
        }
    }

    public function sendVerificationEmail( $from, $from_name, $send_to, $subject, $message)
    {
       /*  $from = 'patrickjeri.garcia@sdca.edu.ph'; */
        $this->load->library('email');
        $this->webmailer_config();
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($send_to);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
            echo '<pre>' . print_r(array('status' => 'success', 'msg' => 'Email has been sent to ' . $send_to . ' (' . $send_to . ')'), 1) . '</pre>';
        } else {
            show_error($this->email->print_debugger());
            echo '<pre>' . print_r(array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to), 1) . '</pre>';
        }
    }

}
