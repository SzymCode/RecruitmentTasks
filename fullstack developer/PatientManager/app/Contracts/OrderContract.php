<?php

namespace App\Contracts;

interface OrderContract
{
    public function getId(): int;

    public function getPatientId(): int;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;
}
