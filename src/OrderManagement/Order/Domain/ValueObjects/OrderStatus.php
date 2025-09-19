<?php

namespace Src\OrderManagement\Order\Domain\ValueObjects;

final class OrderStatus
{
    private const ALLOWED_STATUSES = ['pending', 'processing', 'completed', 'declined'];
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if (!in_array($value, self::ALLOWED_STATUSES)) {
            throw new \InvalidArgumentException(
                sprintf('Status %s is not valid. Allowed statuses are: %s',
                    $value,
                    implode(', ', self::ALLOWED_STATUSES)
                )
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function getAllowedStatuses(): array
    {
        return self::ALLOWED_STATUSES;
    }

    public function isCompletedOrDeclined(): bool
    {
        return in_array($this->value, ['completed', 'declined']);
    }
}