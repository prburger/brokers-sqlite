<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEdited;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="notes", cascade={"persist"})
     */
    private $customers;

    /**
     * @ORM\ManyToMany(targetEntity=Broker::class, mappedBy="notes", cascade={"persist"})
     */
    private $brokers;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, mappedBy="notes", cascade={"persist"})
     */
    private $suppliers;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="notes", cascade={"persist"})
    */
    private $products;

    public function __construct()
    {
        $this->setId(1);
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->brokers=new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->products = new ArrayCollection();
    } 
  
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTimeInterface $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getDateEdited(): ?\DateTimeInterface
    {
        return $this->dateEdited;
    }

    public function setDateEdited(\DateTimeInterface $dateEdited): self
    {
        $this->dateEdited = $dateEdited;

        return $this;
    }

    /**
     * @return Collection|Broker[]
    */

    public function getBrokers(): Collection
    {
        return $this->brokers;
    }

    public function addBroker(Broker $broker): self
    {
        if (!$this->brokers->contains($broker)) {
            $this->brokers[] = $broker;
        }

        return $this;
    }

    public function removeBroker(Broker $broker): self
    {
        $this->brokers->removeElement($broker);
        return $this;
    }

    /**
     * @return Collection|Customer[]
    */

    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
        }
        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        $this->customers->removeElement($customer);
        return $this;
    }

    /**
     * @return Collection|Product[]
    */

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }
        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);
        return $this;
    }

    /**
     * @return Collection|Supplier[]
    */

    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
        }
        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        $this->suppliers->removeElement($supplier);
        return $this;
    }

}
