<?php
    namespace AppBundle\Service;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    class MailjetMailer {
        private $content;
        private $emailFrom;
        private $nameFrom;
        private $privateKey;
        private $publicKey;
        private $recipients = array();
        private $subject;
        private $templateId;
        private $vars;
        /*
        *
        * GETTERS and SETTERS
        *
        */
        private $container;

        public function __construct($mailjetPublicKey, $mailjetPrivateKey, ContainerInterface $container) {
            $this->publicKey = $mailjetPublicKey;
            $this->privateKey = $mailjetPrivateKey;
            $this->container = $container;
        }
        public function getContent() {
            return $this->content;
        }
        public function getEmailFrom() {
            return $this->emailFrom;
        }
        public function getRecipients() {
            return $this->recipients;
        }
        public function getNameFrom() {
            return $this->nameFrom;
        }
        public function getSubject() {
            return $this->subject;
        }
        public function getTemplateId() {
            return $this->templateId;
        }
        public function getVars() {
            return $this->vars;
        }
        public function getAttachments() {
            return $this->attachments;
        }
        public function getInlineAttachments() {
            return $this->inlineAttachments;
        }
        public function getHtmlPart() {
            return $this->htmlPart;
        }
        public function addRecipient($recipient = null) {
            $this->recipients[] = array('Email' => $recipient);
            return $this;
        }
        public function addAttachments($attachments = null) {
            $this->attachments[] = $attachments;
            return $this;
        }
        public function addInlineAttachments($inlineAttachments = null) {
            $this->inlineAttachments[] = $inlineAttachments;
            return $this;
        }
        public function removeRecipients() {
            $this->recipients = [];
            return $this;
        }
        public function setContent($content = null) {
            $this->content = $content;
            return $this;
        }
        public function setEmailFrom($email = null) {
            $this->emailFrom = $email;
            return $this;
        }
        public function setId($id = null) {
            $this->id = $id;
            return $this;
        }
        public function setNameFrom($name = null) {
            $this->nameFrom = $name;
            return $this;
        }
        public function setSubject($subject = null) {
            $this->subject = $subject;
            return $this;
        }
        public function setTemplateId($templateId = null) {
            $this->templateId = $templateId;
            return $this;
        }
        public function setVars($vars = null) {
            $this->vars = $vars;
            return $this;
        }
        public function setAttachments($attachments = null) {
            $this->attachments = $attachments;
            return $this;
        }
        public function setInlineAttachment($inlineAttachments = null) {
            $this->inlineAttachments = $inlineAttachments;
            return $this;
        }
        public function setHtmlPart($htmlPart = null) {
            $this->htmlPart = $htmlPart;
            return $this;
        }
        public function send() {
            $headers = array("Content-Type: application/json");
            $postfields = array(
                'FromEmail' => $this->emailFrom,
                'FromName' => $this->nameFrom,
                'Recipients' => $this->recipients,
                'Subject' => $this->subject,
                'Text-part' => $this->content
            );
            if(!empty($this->htmlPart)) {
                $postfields['Html-part'] = $this->htmlPart;
            }
            if(!empty($this->templateId)) {
                $postfields['MJ-TemplateID'] = $this->templateId;
                $postfields['MJ-TemplateLanguage'] = true;
            }
            if(!empty($this->vars)) {
                $postfields['Vars'] = $this->vars;
            }
            if(!empty($this->attachments)) {
                $postfields['Attachments'] = $this->attachments;
            }
            if(!empty($this->inlineAttachments)) {
                $postfields['Inline_attachments'] = $this->inlineAttachments;
            }


            $curl = curl_init('https://api.mailjet.com/v3/send');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_COOKIESESSION, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_USERPWD, $this->publicKey.':'.$this->privateKey);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postfields));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $this->removeRecipients();
            return $response;
        }
    }