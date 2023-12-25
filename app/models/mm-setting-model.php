<?php

/**
 * Autor: DerN3rd
 */
class MM_Setting_Model extends IG_Option_Model
{
    protected $table = 'mm_settings';

    public $noti_subject = '';
    public $noti_content = '';

    public $receipt_subject = "";
    public $receipt_content = "";

    public $enable_receipt = 1;
    public $user_receipt = 1;

    public $per_page = 10;

    public $signup_text = "Melde Dich an, um ein registriertes Mitglied der Webseite zu werden";

    public $plugins;

    public $inbox_page;

    public $allow_attachment = false;

    public function __construct()
    {
        $this->noti_subject = "Du hast eine neue Nachricht von FROM_NAME auf SITE_NAME erhalten";
        $this->noti_content = "FROM_NAME hat Dir eine Nachricht auf SITE_NAME gesendet<br/><br/>

        FROM_MESSAGE
        <br/><br/>
        Überprüfe Deine Nachrichten hier <a href='POST_LINK'>POST_LINK</a>
        ";

        $this->receipt_content = "Lieber FROM_NAME <br/><br/>
        Die Nachricht, die Du auf SITE_NAME an TO_NAME gesendet hast, wurde gelesen.";
        $this->receipt_subject = "SITE_NAME: Die Nachricht an TO_NAME, wurde gelesen.";
        parent::__construct();
    }
}