<?php 

namespace App\Form\DataTransformer;

use App\Entity\Broker;
use App\Repository\BrokerRepository;
use Symfony\Component\Form\DataTransformerInterface;
use function Symfony\Component\String\u;

class BrokerArrayToStringTransformer implements DataTransformerInterface
{
    private $brokers;

    public function __construct(BrokerRepository $repo)
    {
        $this->brokers = $repo;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($brokers): string
    {
        /* @var Broker[] $brokers */
        return implode(',', $brokers);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string): array
    {
        if (null === $string || u($string)->isEmpty()) {
            return [];
        }

        $names = array_filter(array_unique(array_map('trim', u($string)->split(','))));

        // Get the current tags and find the new ones that should be created.
        $brokers = $this->brokers->findBy([
            'name' => $names,
        ]);
        $newNames = array_diff($names, $brokers);
        foreach ($newNames as $name) {
            $broker = new Broker();
            $broker->setName($name);
            $brokers[] = $broker;

            // There's no need to persist these new tags because Doctrine does that automatically
            // thanks to the cascade={"persist"} option in the App\Entity\Post::$tags property.
        }

        // Return an array of tags to transform them back into a Doctrine Collection.
        // See Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer::reverseTransform()
        return $brokers;
    }
}