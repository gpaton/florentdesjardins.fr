<?php

namespace Florent\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Florent\Form\ContactType;

class DefaultController
{

    /**
     *
     * Fonction : indexAction
     *
     * Affichage de la page d'accueil
     *
     */

    public function indexAction(Request $request, Application $app)
    {
        // Age
        $age = date('Y', time() - strtotime('1987-04-01')) - 1970;

        // Template
        return $app['twig']->render('homepage.html', array(
            'title'       => $app['seo']['homepage']['title'],
            'description' => $app['seo']['homepage']['description'],
            'age'         => $age,
        ));
    }

    /**
     *
     * Fonction : skillsAction
     *
     * Affichage de la page compétences
     *
     */

    public function skillsAction(Request $request, Application $app)
    {
        // Template
        return $app['twig']->render('skills.html', array(
            'title'       => $app['seo']['skills']['title'],
            'description' => $app['seo']['skills']['description'],
        ));
    }

    /**
     *
     * Fonction : educationAction
     *
     * Affichage de la page formation
     *
     */

    public function educationAction(Request $request, Application $app)
    {
        // Template
        return $app['twig']->render('education.html', array(
            'title'       => $app['seo']['education']['title'],
            'description' => $app['seo']['education']['description'],
        ));
    }

    /**
     *
     * Fonction : experienceAction
     *
     * Affichage de la page expérience
     *
     */

    public function experienceAction(Request $request, Application $app)
    {
        // Template
        return $app['twig']->render('experience.html', array(
            'title'       => $app['seo']['experience']['title'],
            'description' => $app['seo']['experience']['description'],
        ));
    }

    /**
     *
     * Fonction : projectsAction
     *
     * Affichage de la page projects
     *
     */

    public function projectsAction(Request $request, Application $app)
    {
        // Template
        return $app['twig']->render('projects.html', array(
            'title'       => $app['seo']['projects']['title'],
            'description' => $app['seo']['projects']['description'],
        ));
    }

    /**
     *
     * Fonction : contactAction
     *
     * Affichage de la page contact
     *
     */

    public function contactAction(Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new ContactType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            // Traitement des données
            $body = $app['twig']->render('mail.html', array(
                'data' => $data
            ));

            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de contact')
                ->setFrom(array($data['email']))
                ->setTo(array($app['config']['swiftmailer']['username']))
                ->setBody($body);

            $app['mailer']->send($message);

            // Redirection vers la page de remerciement
            return $app->redirect($app['url_generator']->generate('contact_thanks'));
        }

        // Template
        return $app['twig']->render('contact.html', array(
            'title'       => $app['seo']['contact']['title'],
            'description' => $app['seo']['contact']['description'],
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * Fonction : contactThanksAction
     *
     * Affichage d'un remerciement après l'envoi d'un email de contact
     *
     */

    public function contactThanksAction(Request $request, Application $app)
    {
        // ajouter analytics

        // Template
        return $app['twig']->render('contact_thanks.html', array(
            'title'       => $app['seo']['contact_thanks']['title'],
            'description' => '',
        ));
    }
}
