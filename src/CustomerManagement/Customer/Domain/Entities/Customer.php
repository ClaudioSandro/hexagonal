<?php

namespace Src\CustomerManagement\Customer\Domain\Entities;

use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;
use Src\CustomerManagement\Customer\Domain\ValueObjects\UserId;

class Customer
{
    private int $id;
    private CustomerName $name;
    private CustomerEmail $email;
    private UserId $userId; // Usuario que lo creó
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        CustomerName $name,
        CustomerEmail $email,
        UserId $userId,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id ?? 0;
        $this->name = $name;
        $this->email = $email;
        $this->userId = $userId;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    // Getters
    public function id(): int { return $this->id; }
    public function name(): CustomerName { return $this->name; }
    public function email(): CustomerEmail { return $this->email; }
    public function userId(): UserId { return $this->userId; }
    public function createdAt(): \DateTimeImmutable { return $this->createdAt; }
    public function updatedAt(): \DateTimeImmutable { return $this->updatedAt; }

    // Setter para actualizar
    public function update(CustomerName $name, CustomerEmail $email): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
