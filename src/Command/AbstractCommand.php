<?php
namespace Paymaxi\DoctrineEncryptBundle\Command;

use Paymaxi\DoctrineEncryptBundle\Services\PropertyFilter;
use Paymaxi\DoctrineEncryptBundle\Subscribers\DoctrineEncryptSubscriber;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Base command containing usefull base methods.
 *
 * @author Michael Feinbier <michael@feinbier.net>
 **/
abstract class AbstractCommand extends Command
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var DoctrineEncryptSubscriber */
    protected $subscriber;

    /** @var Reader */
    protected $annotationReader;

    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineEncryptSubscriber $doctrineEncryptSubscriber,
        Reader $annotationReader
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->subscriber = $doctrineEncryptSubscriber;
        $this->annotationReader = $annotationReader;
    }

    /**
     * Get an result iterator over the whole table of an entity.
     *
     * @param string $entityName
     *
     * @return \Doctrine\ORM\Internal\Hydration\IterableResult
     */
    protected function getEntityIterator($entityName): \Doctrine\ORM\Internal\Hydration\IterableResult
    {
        $query = $this->entityManager->createQuery(sprintf('SELECT o FROM %s o', $entityName));
        return $query->iterate();
    }

    /**
     * Get the number of rows in an entity-table
     *
     * @param string $entityName
     *
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function getTableCount($entityName): int
    {
        $query = $this->entityManager->createQuery(sprintf('SELECT COUNT(o) FROM %s o', $entityName));
        return (int) $query->getSingleScalarResult();
    }

    /**
     * Return an array of entity-metadata for all entities
     * that have at least one encrypted property.
     *
     * @return array
     */
    protected function getEncryptionableEntityMetaData(): array
    {
        $validMetaData = [];
        $metaDataArray = $this->entityManager->getMetadataFactory()->getAllMetadata();

        foreach ($metaDataArray as $entityMetaData) {
            if ($entityMetaData->isMappedSuperclass) {
                continue;
            }

            $properties = $this->getEncryptionableProperties($entityMetaData);
            if (\count($properties) == 0) {
                continue;
            }

            $validMetaData[] = $entityMetaData;
        }

        return $validMetaData;
    }

    /**
     * @param $entityMetaData
     *
     * @return \ReflectionProperty[]
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \ReflectionException
     */
    protected function getEncryptionableProperties($entityMetaData)
    {
        return PropertyFilter::filter($entityMetaData);
    }
}
