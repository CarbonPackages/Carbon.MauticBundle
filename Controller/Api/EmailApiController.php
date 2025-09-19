<?php

namespace MauticPlugin\MauticCarbonBundle\Controller\Api;

use Mautic\ApiBundle\Controller\CommonApiController;
use Mautic\EmailBundle\Entity\Email;
use Mautic\EmailBundle\Model\EmailModel;
use Mautic\LeadBundle\Model\FieldModel;
use Mautic\LeadBundle\Model\LeadModel;
use MauticPlugin\MauticCarbonBundle\Entity\EmailConfig;
use MauticPlugin\MauticCarbonBundle\Model\EmailConfigModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailApiController extends CommonApiController
{
    const EXAMPLE_EMAIL_SUBJECT_PREFIX = '[TEST]';

    /**
     * Send example emails to recipients
     *
     * @param $id
     * @return Response
     */
    public function exampleAction(Request $request, $id): Response
    {
        if ('POST' == $request->getMethod()) {
            $recipients = is_string($request->get('recipients'))
                ? [$request->get('recipients')]
                : $request->get('recipients');
            $previewForContactId = $request->get('previewForContactId');

            // Note: copy from https://github.com/mautic/mautic/blob/34cb7061f10df17c919a32030480a8a781553776/app/bundles/EmailBundle/Controller/EmailController.php#L1363
            // Prepare a fake lead
            $model = $this->getModel('email');

            /** @var LeadModel $leadModel */
            $leadModel = $this->getModel('lead');

            /** @var FieldModel $fieldModel */
            $fieldModel = $this->getModel('lead.field');

            /** @var Email $entity */
            $entity = $model->getEntity($id);

            // We have to add prefix to example emails
            $subject = sprintf('%s %s', static::EXAMPLE_EMAIL_SUBJECT_PREFIX, $entity->getSubject());
            $entity->setSubject($subject);

            if ($previewForContactId) {
                // We have one from request parameter
                $fields = $leadModel->getRepository()->getLead($previewForContactId);
            }

            if (!isset($fields)) {
                // Prepare a fake lead
                $fields = $fieldModel->getFieldsProperties();
                array_walk($fields, function (&$field): void {
                    $field = "[$field]";
                });
                $fields['id'] = 0;
            }

            $errors = [];
            foreach ($recipients as $email) {
                if (!empty($email)) {
                    $users = [
                        [
                            // Setting the id to null as this is a unknown user
                            // Set firstname and lastname to Firstname and Lastname to test the Dynamic Web Content
                            'id' => '',
                            'firstname' => 'Firstname',
                            'lastname' => 'Lastname',
                            'email' => $email,
                        ],
                    ];

                    // Send to current user
                    $error = $model->sendSampleEmailToUser($entity, $users, $fields, [], [], false);
                    if (count($error)) {
                        array_push($errors, $error[0]);
                    }
                }
            }
        }

        if (0 != count($errors)) {
            $result = [
                'success' => 0,
                'recipients' => $recipients,
            ];
        } else {
            $result = [
                'success' => 1,
                'recipients' => $recipients,
            ];
        }

        $view = $this->view($result, Response::HTTP_OK);

        return $this->handleView($view);
    }

    public function updateSettingsAction(Request $request, $id): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode(['success' => 0]));

        if ('POST' == $request->getMethod()) {
            $payload = $request->getContent();

            /** @var EmailConfigModel $configModel */
            $configModel = $this->getModel('emailConfig');

            /** @var EmailModel $emailModel */
            $emailModel = $this->getModel('email');

            /** @var Email $email */
            $email = $emailModel->getEntity($id);

            if ($email) {
                /** @var EmailConfig $configEntity */
                $configEntity = $configModel->getEntityByEmail($email);
                $configEntity->setEmail($email);
                $configEntity->setConfig($payload);

                $emailModel->getRepository()->saveEntity($configEntity);
                $response->setContent(
                    json_encode([
                        'success' => 1,
                        'settings' => json_decode($payload),
                    ])
                );
            }
        }

        return $response;
    }

    public function getSettingsAction(Request $request, $id): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode(['success' => 0]));

        if ('GET' == $request->getMethod()) {
            /** @var EmailConfigModel $configModel */
            $configModel = $this->getModel('emailConfig');

            /** @var EmailModel $emailModel */
            $emailModel = $this->getModel('email');

            /** @var Email $email */
            $email = $emailModel->getEntity($id);

            if ($email) {
                /** @var EmailConfig $configEntity */
                $configEntity = $configModel->getEntityByEmail($email);
                $config = $configEntity->getConfig();
                $response->setContent(
                    json_encode([
                        'success' => $config ? 1 : 0,
                        'settings' => json_decode($configEntity->getConfig()),
                    ])
                );
            }
        }

        return $response;
    }
}
