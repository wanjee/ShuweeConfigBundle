<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Wanjee\Shuwee\ConfigBundle\Entity\Parameter;

/**
 * Service to retrieve a parameter value.
 */
class ConfigManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = null;

    }

    public function get($machineName, $default = null)
    {
        /** @var Parameter $parameter */
        $parameter = $this->getRepository()->findOneBy(
            array(
                'machineName' => $machineName,
            )
        );

        if (is_null($parameter)) {
            return $default;
        }

        return $parameter->getValueInput();
    }

    public function all()
    {

    }

    /**
     * @return EntityRepository
     */
    private function getRepository()
    {
        if (is_null($this->repository)) {
            $this->repository = $this->entityManager->getRepository('ShuweeConfigBundle:Parameter');
        }

        return $this->repository;
    }
}