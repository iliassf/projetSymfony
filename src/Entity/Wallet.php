<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CreditCard>
     */
    #[ORM\OneToMany(targetEntity: CreditCard::class, cascade: ['persist', 'remove'], mappedBy: 'wallet', orphanRemoval: true)]
    private Collection $creditCards;

    public function __construct()
    {
        $this->creditCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CreditCard>
     */
    public function getCreditCards(): Collection
    {
        return $this->creditCards;
    }

    public function addCreditCard(CreditCard $creditCard): static
    {
        if (!$this->creditCards->contains($creditCard)) {
            $this->creditCards->add($creditCard);
            $creditCard->setWallet($this);
        }

        return $this;
    }

    public function removeCreditCard(CreditCard $creditCard): static
    {
        if ($this->creditCards->removeElement($creditCard)) {
            // set the owning side to null (unless already changed)
            if ($creditCard->getWallet() === $this) {
                $creditCard->setWallet(null);
            }
        }

        return $this;
    }
}
