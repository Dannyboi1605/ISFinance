<?php

namespace App\Traits;

trait SimulationTrait
{
    /**
     * Generate a mock Ethereum-style transaction hash.
     * Format: 0x + 64 hex characters
     *
     * @return string
     */
    protected function generateTxHash(): string
    {
        return '0x' . bin2hex(random_bytes(32));
    }

    /**
     * Generate a mock Ethereum block number.
     * Simulates a realistic block range for testing.
     *
     * @return int
     */
    protected function generateBlockNumber(): int
    {
        return rand(18000000, 19500000);
    }

    /**
     * Generate a mock smart contract address.
     * Format: 0x + 40 hex characters (20 bytes)
     *
     * @return string
     */
    protected function generateContractAddress(): string
    {
        return '0x' . bin2hex(random_bytes(20));
    }

    /**
     * Generate a mock Ethereum wallet address.
     * Format: 0x + 40 hex characters (20 bytes)
     *
     * @return string
     */
    protected function generateWalletAddress(): string
    {
        return '0x' . bin2hex(random_bytes(20));
    }

    /**
     * Simulate blockchain confirmation delay.
     * In production, this would wait for actual confirmations.
     *
     * @param int $confirmations Number of confirmations to simulate
     * @return array
     */
    protected function simulateConfirmation(int $confirmations = 12): array
    {
        return [
            'tx_hash' => $this->generateTxHash(),
            'block_number' => $this->generateBlockNumber(),
            'confirmations' => $confirmations,
            'status' => 'confirmed',
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
