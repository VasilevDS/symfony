<?php


namespace App\Resolver;


use App\DTO\Request\Event\FreetimeCreateDTO;
use App\DTO\Request\Event\LessonCreateDTO;
use App\DTO\Request\ThemeCreateDTO;
use App\DTO\Request\User\StudentCreateDTO;
use App\DTO\Request\User\TeacherCreateDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DTOCreateResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    const TYPES = [
        StudentCreateDTO::class,
        TeacherCreateDTO::class,
        FreetimeCreateDTO::class,
        LessonCreateDTO::class,
        ThemeCreateDTO::class,
        ];
    private ?string $typeName;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        foreach (self::TYPES as $type) {
            if ($type === $argument->getType()) {
                $this->typeName = $type;
                return true;
            }
        }
        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $dto = $this->serializer->deserialize($request->getContent(), $this->typeName, 'json');

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new ValidatorException((string)$errors);
        }

        yield $dto;
    }
}