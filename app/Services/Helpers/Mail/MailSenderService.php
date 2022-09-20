<?php

namespace App\Services\Helpers\Mail;


use App\Services\Helpers\Utils;
use Exception;
use Illuminate\Http\JsonResponse;

class MailSenderService
{
   private MailerPhpMailer $mailer;

    /**
     * @param MailerPhpMailer $mailer
     */
    public function __construct(MailerPhpMailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public  function sendPartnerCreated($dataSent =[]): JsonResponse|array|int|string
    {
        try {
                $data= array(
                    "subject"=>"Creation Compte Partenaire",
                    "title"=>"Bonjour " .  $dataSent['name'] ,
                    "name"=>$dataSent['name'] ,
                    "items"=> array(
                        "Votre compte a la plateforme INTECH API est crée."=>"",
                        "<b>Login</b>    : "=>$dataSent['email'],
                        "<b>Mot de passe</b>    : "=>$dataSent['password'],
                        "<a href=' ".env('ESPACE_ADMIN_PARTNER')."'>Se connecter</a>"=>''
                    )
                );

            $data['to'] = $dataSent['email'];
            $html = view('mail/mail')->with(['data' => $data]);
            $data['content'] = $html->render();
            return $this->mailer->genericSend($data);
        } catch (Exception $e) {
            return  Utils::respond('error',[
                $e->getMessage()
            ]);
        }
    }
    public  function versementPartenaire($dataSent ,$amount): JsonResponse|array|int|string
    {
        try {
                $data=[
                    "subject"=>"Versement Compte Partenaire",
                    "title"=>"Bonjour " .  $dataSent['name'] ,
                    "name"=>$dataSent['name'] ,
                    "items"=>[
                        "Un montant $amount FRCFA vient d'être placer dans votre compte INTECH API."=>"",
                        "Votre nouveau solde est de "=>$dataSent['solde'] .' FRCFA.',
                        "L'équipe Support Intech API."=>'',
                    ]
                ];

            $data['to'] = $dataSent['email'];
            $html = view('mail/mail')->with(['data' => $data]);
            $data['content'] = $html->render();
            return $this->mailer->genericSend($data);
        } catch (Exception $e) {
            return  Utils::respond('error',[
                $e->getMessage()
            ]);
        }
    }
    public  function appelFondPartenaire($dataSent ,$amount): JsonResponse|array|int|string
    {
        try {
                $data=[
                    "subject"=>"Appel de fonds Compte Partenaire",
                    "title"=>"Bonjour " .  $dataSent['name'] ,
                    "name"=>$dataSent['name'] ,
                    "items"=>[
                        "Un montant $amount FRCFA vient d'être retirer de votre compte INTECH API."=>"",
                        "Votre nouveau solde est de "=>$dataSent['solde'] .' FRCFA.',
                        "L'équipe Support Intech API."=>'',
                    ]
                ];

            $data['to'] = $dataSent['email'];
            $html = view('mail/mail')->with(['data' => $data]);
            $data['content'] = $html->render();
            return $this->mailer->genericSend($data);
        } catch (Exception $e) {
            return  Utils::respond('error',[
                $e->getMessage()
            ]);
        }
    }

    public  function sendUserBackofficeCreated($dataSent =[]): JsonResponse|array|int|string
    {
        try {
            $dataSent['fullName'] = $dataSent['f_name'] .' '. $dataSent['l_name'];
            $data= array(
                "subject"=>"Creation Compte backoffice INTECH API",
                "title"=>"Bonjour " .  $dataSent['fullName'] ,
                "name"=>$dataSent['fullName'] ,
                "items"=> array(
                    "Votre compte  a la plateforme INTECH API est crée."=>"",
                    "<b>Login</b>    : "=>$dataSent['email'],
                    "<b>Mot de passe</b>    : "=>$dataSent['password'],
                    "<a href=' ".env('PROXY_URL')."'>Se connecter</a>"=>''
                )
            );

            $data['to'] = $dataSent['email'];
            $html = view('mail/mail')->with(['data' => $data]);
            $data['content'] = $html->render();
            return $this->mailer->genericSend($data);
        } catch (Exception $e) {
            dd($e);
            return  Utils::respond('error',[
                $e->getMessage()
            ]);
        }
    }


}
