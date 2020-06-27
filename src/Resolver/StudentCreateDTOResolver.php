<?php


namespace App\Resolver;


use App\DTO\Request\User\StudentCreateDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StudentCreateDTOResolver extends BaseDTOResolver
{
    const TYPE = StudentCreateDTO::class;
}