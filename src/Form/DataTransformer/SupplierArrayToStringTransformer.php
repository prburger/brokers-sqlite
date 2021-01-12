<?php 

namespace App\Form\DataTransformer;

use App\Entity\Supplier;
use App\Repository\SupplierRepository;
use Symfony\Component\Form\DataTransformerInterface;
use function Symfony\Component\String\u;

class SupplierArrayToStringTransformer implements DataTransformerInterface
{
    private $suppliers;

    public function __construct(SupplierRepository $repo)
    {
        $this->suppliers = $repo;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($suppliers): string
    {
        /* @var Supplier[] $suppliers */
        return implode(',', $suppliers);
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
        $suppliers = $this->suppliers->findBy([
            'name' => $names,
        ]);
        $newNames = array_diff($names, $suppliers);
        foreach ($newNames as $name) {
            $supplier = new Supplier();
            $supplier->setName($name);
            $suppliers[] = $supplier;

            // There's no need to persist these new tags because Doctrine does that automatically
            // thanks to the cascade={"persist"} option in the App\Entity\Post::$tags property.
        }

        // Return an array of tags to transform them back into a Doctrine Collection.
        // See Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer::reverseTransform()
        return $suppliers;
    }
}