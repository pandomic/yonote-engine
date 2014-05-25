<?php
class CApplicationMail extends CApplicationComponent
{
    public $settingsComponentId = 'settings';
    /**
     * Email receivers list
     * 
     * @var array 
     */
    private $_receivers = array();
    
    private $_errors = array();
    
    /**
     * Email subject
     * 
     * @var string 
     */
    private $_subject;
    
    /**
     * Default email charset
     * 
     * @var string 
     */
    private $_charset = 'utf-8';
    
    /**
     * List of attachments
     * 
     * @var array 
     */
    private $_attachments = array();
    
    /**
     * Email message
     * 
     * @var string 
     */
    private $_message;
    
    private $_smtp = false;
    private $_smtpUser;
    private $_smtpPassword;
    private $_smtpHost;
    private $_smtpPort;


    private $_alternative = null;
    private $_unsubscribe = null;
    private $_from = null;
    private $_replyTo = null;
    private $_sender = null;
    
    public function init()
    {
        $settings = Yii::app()->getComponent($this->settingsComponentId);
        $this->_smtp = $settings->get('system','smtp.enabled');
        $this->_smtpHost = $settings->get('system','smtp.host');
        $this->_smtpPort = $settings->get('system','smtp.port');
        $this->_smtpUser = $settings->get('system','smtp.user');
        $this->_smtpUser = $settings->get('system','smtp.password');
    }
    
    public function useSmtp($status)
    {
        $this->_smtp = $status;
    }


    public function getInstance()
    {
        $instance = new self;
        $instance->init();
        return $instance;
    }

    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }
    
    public function setReplyTo($email)
    {
        $this->_replyTo = $email;
    }
    
    public function setFrom($email)
    {
        $this->_from = $email;
    }
    
    public function setUnsubscribe($url)
    {
        $this->_unsubscribe = $url;
    }
    
    public function setSender($sender)
    {
        $this->_sender = $sender;
    }

    /**
     * Set up charset
     * 
     * @param string $charset charset
     * @return void
     */
    public function setCharset($charset){
        $this->_charset = $charset;
    }
    
    public function setAlternative($message)
    {
        $this->_alternative = base64_encode($message);
    }
    
    /**
     * Set message content
     * 
     * @param string $message email message
     * @param int $flag message flag (set base64 encoding)
     * @return void
     */
    public function setMessage($message){
        $this->_message = base64_encode($message);
    }
    
    /**
     * Add email receiver
     * 
     * @param mixed $to list of emails, or string with email
     * @return void
     */
    public function addReceiver($to){
        if (is_array($to)){
            $this->_receivers = array_merge($this->_receivers,$to);
        } else {
            $this->_receivers[] = $to;
        }
    }
    
    /**
     * Attach files to email
     * 
     * @param string $fileCont file content (binary)
     * @param string $fileName filename
     * @return void
     */
    public function addAttachment($fileCont,$fileName){
        $this->_attachments[$fileName] = $fileCont;
    }
    
    /**
     * Send email
     * 
     * @return bool send status 
     * @throws YFENetworkException
     */
    public function send(){
        
        $boundary = md5(uniqid());
        $parts = array();
        $headers = array();

        if ($this->_alternative != null && empty($this->_attachments))
            $contentType = 'multipart/alternative';
        else if ($this->_alternative === null && !empty ($this->_attachments))
            $contentType = 'multipart/mixed';
        else
            $contentType = 'multipart/relative';
        
        if ($this->_from !== null)
            $headers[] = 'From: '.$this->_from;
        
        if ($this->_replyTo !== null)
            $headers[] = 'Reply-to:'.$this->_replyTo;
        
        if ($this->_sender !== null)
            $headers[] = 'Sender: '.$this->_sender;
        
        if ($this->_smtp)
            $headers[] = 'Subject: '.'=?'.$this->_charset.'?B?'.base64_encode($this->_subject).'?=';
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: '.$contentType.'; boundary='.$boundary.'';
        
        if ($this->_unsubscribe !== null)
            $headers[] = "List-Unsubscribe: <$this->_unsubscribe>";
        
        $headers[] = "";
        
        if ($this->_alternative !== null && empty($this->_attachments))
        {
            $parts[] = '';
            $parts[] = '--' . $boundary;
            $parts[] = "Content-Type: text/plain; charset={$this->_charset}";
            $parts[] = 'Content-Transfer-Encoding: base64';
            $parts[] = '';
            $parts[] = $this->_alternative;
        }

        $parts[] = '--' . $boundary;
        $parts[] = "Content-Type: text/html; charset={$this->_charset}";
        $parts[] = 'Content-Transfer-Encoding: base64';
        $parts[] = '';
        $parts[] = $this->_message;
        //$parts[] = '';

        foreach ($this->_attachments as $fileName => $fileCode){
            //$parts[] = '';
            $parts[] = '--' . $boundary;
            $parts[] = 'Content-Type: application/octet-stream; name="' . $fileName . '"';
            $parts[] = 'Content-Transfer-Encoding: base64';
            $parts[] = 'Content-Disposition: attachment; filename="' . $fileName . '"';
            $parts[] = "";
            $parts[] = base64_encode($fileCode);
        }

        $parts[] = '--' . $boundary . '--';
        $parts[] = '';
        
        if ($this->_smtp)
        {
            if (!($socket = fsockopen($this->_smtpHost,$this->_smtpPort))){
                $this->_errors[] = 'Could not open socket.';
                return false;
            }
            if (!$this->checkSmtpResponse($socket,220))
            {
                $this->_errors[] = 'Could not connect to the SMTP server.';
                return false;
            }
            fputs($socket,"HELO {$this->_smtpHost}\r\n");
            if (!$this->checkSmtpResponse($socket,250))
            {
                $this->_errors[] = 'Could not connect to SMTP server.';
                return false;
            }
            fputs($socket,"AUTH LOGIN\r\n");
            if (!$this->checkSmtpResponse($socket,334))
            {
                $this->_errors[] = 'Authentication request failed.';
                return false;
            }
            fputs($socket,base64_encode($this->_smtpUser)."\r\n");
            if (!$this->checkSmtpResponse($socket,334))
            {
                $this->_errors[] = 'Invalid username.';
                return false;
            }
            fputs($socket,base64_encode($this->_smtpPassword)."\r\n");
            if (!$this->checkSmtpResponse($socket,235))
            {
                $this->_errors[] = 'Invalid password.';
                return false;
            }
            foreach ($this->_receivers as $to)
            {
                fputs($socket,"MAIL FROM: <{$this->_from}>\r\n");
                if (!$this->checkSmtpResponse($socket,250))
                {
                    $this->_errors[] = 'Invalid sender.';
                    continue;
                }
                fputs($socket,"RCPT TO: <{$to}>\r\n");
                if (!$this->checkSmtpResponse($socket,250))
                {
                    $this->_errors[] = 'Invalid receiver.';
                    continue;
                }
                fputs($socket,"DATA\r\n");
                if (!$this->checkSmtpResponse($socket,354))
                {
                    $this->_errors[] = 'Data setup error.';
                    continue;
                }
                fputs($socket,implode("\r\n",array_merge($headers,$parts))."\r\n.\r\n");
                if (!$this->checkSmtpResponse($socket,250))
                {
                    $this->_errors[] = 'Cannot send message to receiver.';
                    continue;
                }
            }
            fputs($socket,"QUIT\r\n");
            fclose($socket);
        } else {
            $parts = implode("\r\n",$parts);
            $headers = implode("\r\n",$headers);
            foreach ($this->_receivers as $to)
            {
                if (!mail($to,'=?'.$this->_charset.'?B?'.base64_encode($this->_subject).'?=',$parts,$headers))
                    $this->_errors[] = 'Cannot send message to receiver.';
            }
        }
        return true;
    }
    
    public function getErrors()
    {
        return $this->_errors;
    }


    public function checkSmtpResponse($socket,$status)
    {
        if (!($response = fgets($socket)))
            return false;
        if ((int) substr($response,0,3) != $status)
            return false;
        return true;
    }
    
    public function setSmtpSettings($host,$port,$user = null,$password = null)
    {
        $this->_smtpHost = $host;
        $this->_smtpPort = $port;
        $this->_smtpUser = $user;
        $this->_smtpPassword = $password;
    }
}
?>