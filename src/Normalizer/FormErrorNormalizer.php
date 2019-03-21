<?php

namespace App\Normalizer;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizes invalid Form instances.
 */
class FormErrorNormalizer implements NormalizerInterface 
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'code' => isset($context['status_code']) ? $context['status_code'] : null,
            'message' => 'Validation Failed',
            'errors' => $this->convertFormToArray($object),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FormInterface && $data->isSubmitted() && !$data->isValid();
    }

    /**
     * This code has been taken from JMSSerializer.
     */
    private function convertFormToArray(FormInterface $data)
    {
        $form = $data['errors'];
        $data['errors'] = [];
        
        foreach ($form->getErrors(true, true) as $error) {
            $path = $error->getCause()->getPropertyPath();
            $data['errors'][$path] = $error->getMessage();
        }

        // $form = $errors = [];

        // foreach ($data->getErrors() as $error) {
        //     $errors[] = $error->getMessage();
        // }

        // if ($errors) {
        //     $form['errors'] = $errors;
        // }

        // $children = [];
        // foreach ($data->all() as $child) {
        //     if ($child instanceof FormInterface) {
        //         $children[$child->getName()] = $this->convertFormToArray($child);
        //     }
        // }

        // if ($children) {
        //     $form['children'] = $children;
        // }

        return $form;
    }

    public static function normalizeErrors(FormInterface $form)
    {
        $form = $form['errors'] ?? $form;
        $data['errors'] = [];
        
        foreach ($form->getErrors(true, true) as $error) {
            $path = $error->getCause()->getPropertyPath();
            $data['errors'][$path] = $error->getMessage();
        }

        return $data['errors'];
    }

}