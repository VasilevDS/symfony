<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Service;


use App\DTO\User\UserDTOInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private UserRepository $repository;
    private EntityManagerInterface $manager;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(EntityManagerInterface $manager,
                                UserRepository $repository,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    public function createOrUpdate(UserDTOInterface $DTO, User $user = null): User
    {
        $user = $user ?? new User();
        $user->setName($DTO->getName())
            ->setEmail($DTO->getEmail())
            ->setRoles($DTO->getRoles())
            ->setPassword($this->encoder->encodePassword($user, $DTO->getPassword()));

        $this->manager->persist($user);
        return $user;
    }
}