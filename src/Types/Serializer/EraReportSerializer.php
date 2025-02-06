<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\EraReport;

class EraReportSerializer extends JsonSerializer
{
    /**
     * @param EraReport $eraReport
     */
    public static function toJson($eraReport): array
    {
        $equivocators = [];
        foreach ($eraReport->getEquivocators() as $equivocator) {
            $equivocators[] = $equivocator->toHex();
        }

        $inactiveValidators = [];
        foreach ($eraReport->getInactiveValidators() as $inactiveValidator) {
            $inactiveValidators[] = $inactiveValidator->toHex();
        }

        return array(
            'equivocators' => $equivocators,
            'inactive_validators' => $inactiveValidators,
            'rewards' => RewardSerializer::fromJsonArray($eraReport->getRewards()),
        );
    }

    public static function fromJson(array $json)
    {
        $equivocators = [];
        foreach ($json['equivocators'] as $equivocator) {
            $equivocators[] = CLPublicKey::fromHex($equivocator);
        }

        $inactiveValidators = [];
        foreach ($json['inactive_validators'] as $inactiveValidator) {
            $inactiveValidators[] = CLPublicKey::fromHex($inactiveValidator);
        }

        return new EraReport($equivocators, $inactiveValidators, RewardSerializer::fromJsonArray($json['rewards']));
    }
}
