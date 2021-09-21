<?php

namespace Casper\Model;

class Deploy
{
    /**
     * @var int[]
     */
    private array $hash;

    private DeployHeader $header;

    private DeployExecutable $payment;

    private DeployExecutable $session;

    /**
     * @var DeployApproval[]
     */
    private array $approvals;

    /**
     * @param int[] $hash
     * @param DeployHeader $header
     * @param DeployExecutable $payment
     * @param DeployExecutable $session
     * @param DeployApproval[] $approvals
     */
    public function __construct(
        array $hash,
        DeployHeader $header,
        DeployExecutable $payment,
        DeployExecutable $session,
        array $approvals
    )
    {
        $this->hash = $hash;
        $this->header = $header;
        $this->payment = $payment;
        $this->session = $session;
        $this->approvals = $approvals;
    }
}
