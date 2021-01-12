<?php 

namespace App\Form\DataTransformer;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\Form\DataTransformerInterface;
use function Symfony\Component\String\u;

class CustomerArrayToStringTransformer implements DataTransformerInterface
{
    private $customers;

    public function __construct(CustomerRepository $repo)
    {
        $this->customers = $repo;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($customers): string
    {
        /* @var Customer[] $customers */
        return implode(',', $customers);
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
        $customers = $this->customers->findBy([
            'name' => $names,
        ]);
        $newNames = array_diff($names, $customers);
        foreach ($newNames as $name) {
            $customer = new Customer();
            $customer->setName($name);
            $customers[] = $customer;

            // There's no need to persist these new tags because Doctrine does that automatically
            // thanks to the cascade={"persist"} option in the App\Entity\Post::$tags property.
        }

        // Return an array of tags to transform them back into a Doctrine Collection.
        // See Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer::reverseTransform()
        return $customers;
    }
}