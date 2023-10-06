<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sdca_Mailer
{
    public function __construct($parameters)
    {
        $this->email = $parameters['email'];
        $this->load = $parameters['load'];
    }
    public function webmailer_config()
    {
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            // 'smtp_port' => '587',
            'smtp_timeout' => '7',
            'SMTPDebug' => '1', // enables SMTP debug information (for testing)
            'SMTPAuth' => true,
            'smtp_user' => 'patrickjeri.garcia@gmail.com',
            'smtp_pass' => 'uyao eihs mulz wovy',
            // 'smtp_user' => 'ictmailer@sdca.edu.ph',
            // 'smtp_pass' => 'sdca2021',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'mailtype'  => 'html',
            'validation' => true
        );
        // des.ict@sdca.edu.ph
        // password: digitalcampus
        $this->email->initialize($config);
    }
    public function send_email($cp, $from, $from_name, $send_to, $subject, $message, $add_data)
    {
        $from = '';
        $this->webmailer_config();
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($send_to);
        $this->email->subject($subject);
        $this->email->message($this->load->view($message, $add_data, true));
        if ($this->email->send()) {
            // echo  'Email has been sent to ' . $cp;
            // show_error($this->email->print_debugger());
            //return array('status' => 'success', 'msg' => 'Email has been sent to ' . $send_to . ' (' . $cp . ')');
            echo '<pre>'.print_r(array('status' => 'success', 'msg' => 'Email has been sent to ' . $send_to . ' (' . $cp . ')'),1).'</pre>';
        } else {
            // show_error($this->email->print_debugger());
            // echo json_encode(array('error' => 'There was a problem sending an email'));
            // echo  "There was a problem with sending an email.";
            // echo  "<br><br>For any concers, proceed to our <a href'#' style'font-size:15px; color:#00F;'>Helpdesk</a> or the MIS Office.";
            //return array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to);
            echo '<pre>'.print_r(array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to),1).'</pre>';
        }
    }
    public function send_emailnohtml($cp, $from, $from_name, $send_to, $subject, $message)
    {
        $from = 'patrickjeri.garcia@sdca.edu.ph';
        $this->webmailer_config();
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($send_to);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
            // echo  'Email has been sent to ' . $cp;
            // show_error($this->email->print_debugger());
            echo '<pre>'.print_r(array('status' => 'success', 'msg' => 'Email has been sent to ' . $send_to . ' (' . $cp . ')'),1).'</pre>';
        } else {
            show_error($this->email->print_debugger());
            // echo json_encode(array('error' => 'There was a problem sending an email'));
            // echo  "There was a problem with sending an email.";
            // echo  "<br><br>For any concers, proceed to our <a href'#' style'font-size:15px; color:#00F;'>Helpdesk</a> or the MIS Office.";
            echo '<pre>'.print_r(array('status' => 'error', 'msg' => 'Failed to send Email : ' . $send_to),1).'</pre>';
        }
    }
    
}
