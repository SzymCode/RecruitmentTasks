<?php

namespace App\Contracts;

interface TestResultContract
{
    public function getId(): int;

    public function getOrderId(): int;

    public function getTestName(): string;

    public function getTestValue(): string;

    public function getTestReference(): string;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;
}
