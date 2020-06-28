<?php


namespace App\Resolver;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseDTOResolver implements ArgumentValueResolverInterface
{
    const TYPE = BaseDTOResolver::class;
    protected SerializerInterface $serializer;
    protected ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {

        return static::TYPE === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $dto = $this->serializer->deserialize($request->getContent(), static::TYPE, 'json');

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new ValidatorException((string)$errors);
        }

        yield $dto;
    }
}