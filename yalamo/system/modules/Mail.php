<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Yalamo framework
 *
 * A fast,light, and constraint-free Php framework.
 *
 * @package		Yalamo
 * @author		Evance Soumaoro
 * @copyright           Copyright (c) 2009 - 2011, Evansofts.
 * @license		http://projects.evansofts.com/yalamof/license.html
 * @link		http://evansofts.com
 * @version		Version 0.1
 * @filesource          Mail.php
 */

/*
 * MAIL IMPLEMENTATION
 *
 * Define functionalities for sending mails
 */

//------------------------------------------------------------------------------
/**
 * Mail Class
 *
 * Implements the method to create and send a mail via php mail function
 */
final class Mail extends Object {
    const Html="HTML";
    const Text="TEXT";
    
    private $namesender;
    private $mailsender;
    private $type;
    private $recipients;
    private $destination;
    private $attachements;

    

    private $subject;
    private $body;
    private $headers;   

    public function __construct($namesender,$mailsender,$type=Mail::Text) {
        $this->namesender=$namesender ;
        $this->mailsender= $mailsender;
        $this->recipients=array();
        $this->type=$type;
     }
    public function __toString() {return "Object of Type: Mail"; }

    public function Recipients($mails){
        $validator=new Validator(Validator::Email);
        if(is_array($mails)){
            foreach ($mails as $mail) {
                if($validator->Validate($mail)){
                    $this->recipients[]=$mail;
                }
                else{
                    $this->Collect(Error::YE101);
                }
            }
            return;
        }
        if($validator->Validate($mails)){
            $this->recipients[]=$mails;
            return;
        }
        $this->Collect(Error::YE101);
    }
    public function Attachements($files){
        if(is_array($files)){
            foreach ($files as $file) {
                 $p=new Path($file);
                if($p->IsFile()){
                   $f=new File($file);
                   $attachement=new Attachement();
                   $attachement->FileName=$p->FileName().$p->Extension();
                   $attachement->FileMime=$f->FileMime();
                   $attachement->FileDate=chunk_split(base64_encode($f->Content()));
                   $this->attachements[]=  $attachement;
                }
                else{
                    $this->Collect(Error::YE101);
                }
            }
            return;
        }
        $p=new Path($files);
        if($p->IsFile()){
           $f=new File($files);
           $attachement=new Attachement();
           $attachement->FileName=$p->FileName().$p->Extension();
           $attachement->FileMime=$f->FileMime();
           $attachement->FileDate=chunk_split(base64_encode($f->Content()));
           $this->attachements[]=  $attachement;
           return;
        }
        $this->Collect(Error::YE101);
    }
    public function Subject($subject){
        $this->subject=$subject;
    }


    public function Send($content){
        $this->prepare($content);
        if(mail($this->recipients[0], $this->subject, $this->body, $this->headers)){
            return true ;
        }
        $this->Collect(Error::YE401);
        return false ;
      }   
    private function prepare($content){
        $this->destination=  $this->recipients[0];
        $Nbrcpt=count($this->recipients);
        if($Nbrcpt>1){
            $bcc="";
            for($i=1;$i<$Nbrcpt; $i++){
                $bcc .=",".$this->recipients[$i];
            }
        }

        $this->headers="
                        From: \"$this->namesender\" <$this->mailsender> \n
                        Reply-To: $this->mailsender \n
                        Bcc: $bcc \n";
        
        if(count($this->attachements)==0){
            Switch($this->type){
                case Mail::TEXT;
                        $this->headers .="Content-Type: text/plain; charset=\"iso-8859-1\" \n
                                          Content-Transfer-Encoding: 8bit";
                        $this->body=$content;
                break;
                case Mail::HTML:
                        $delimiter = md5(date('r', time()));
                        $this->headers .="Content-Type: multipart/alternative; boundary=\"$delimiter\" ";
                         $this->body=" --$delimiter
                                         Content-Type: text/plain; charset=\"iso-8859-1\" \n
                                         Content-Transfer-Encoding: 7bit

                                         $content
                                         --$delimiter
                                         Content-Type: text/html; charset=\"iso-8859-1\" \n
                                         Content-Transfer-Encoding: 7bit

                                         </p>$content</p>

                                        --$delimiter--
                                        ";
                break;
            }
        }
         else{
             $delimiter = md5(date('r', time()));
             $AttachementStr=Yalamo::Void;
             foreach($this->attachements as $attachement){
                $AttachementStr .=" --$delimiter
                                    Content-Type:$attachement->FileMime; name=\"$attachement->FileName\"
                                    Content-Transfer-Encoding: base64
                                    Content-Disposition: attachment

                                    $attachement->FileData
                                    ";
             }         
             $this->headers .="Content-Type: multipart/mixed; boundary=\"$delimiter\" ";
             $this->body=" --$delimiter
                         Content-Type: multipart/alternative; boundary=\"$delimiter\"

                        --$delimiter
                        Content-Type: text/plain; charset=\"iso-8859-1\" \n
                        Content-Transfer-Encoding: 7bit

                        $content

                        --$delimiter
                        Content-Type: text/html; charset=\"iso-8859-1\" \n
                        Content-Transfer-Encoding: 7bit

                        <p>$content</p>

                        --$delimiter--

                        --$delimiter
                        
                        $AttachementStr
                        --$delimiter--
                        ";
        }
        
          
    }

}

final class Attachement{

    public $FileName;
    public $FileMime;
    public $FileData;

}
