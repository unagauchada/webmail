<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/send", name="send_mail")
     */
    public function sendAction(Request $request, \Swift_Mailer $mailer)
    {
        $from = 'noreplay@unagauchada.github.io';
        $to = $request->get('to');
        $subject = $request->get('subject');
        $body = $request->get('body');

        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $this->renderView(
                    'default/mail.html.twig',
                    array(
                        'from' => $from,
                        'to' => $to,
                        'subject' => $subject,
                        'body' => $body
                    )
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

        return new JsonResponse(array(
            'status' => 'Sended',
            'mail' => array(
                'from' => $from,
                'to' => $to,
                'subject' => $subject,
                'body' => $body
            )
        ));
    }
}
