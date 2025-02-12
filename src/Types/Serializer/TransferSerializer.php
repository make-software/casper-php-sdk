<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;
use Casper\Types\InitiatorAddr;
use Casper\Types\TransactionHash;
use Casper\Types\Transfer;
use Casper\Types\TransferV1;

class TransferSerializer extends JsonSerializer
{
    /**
     * @param Transfer $transfer
     * @throws \Exception
     */
    public static function toJson($transfer): array
    {
        $json = array();
        $isTransferV1 = $transfer->getOriginalTransferV1();

        if ($isTransferV1) {
            $json['deploy_hash'] = $transfer->getTransactionHash()->getTransactionV1();
        }
        else {
            $json['transaction_hash'] = TransactionHashSerializer::toJson($transfer->getTransactionHash());
        }

        $json['from'] = InitiatorAddrSerializer::toJson($transfer->getFrom());
        $json['to'] = $transfer->getTo() ? $transfer->getTo()->parsedValue() : null;
        $json['source'] = $transfer->getSource()->parsedValue();
        $json['target'] = $transfer->getTarget()->parsedValue();
        $json['amount'] = (string) $transfer->getAmount();
        $json['gas'] = (string) $transfer->getGas();
        $json['id'] = $transfer->getId();

        return array(
            'Version' . ($isTransferV1 ? '1' : '2') => $json,
        );
    }

    /**
     * @throws \Exception
     * @return Transfer|string
     */
    public static function fromJson($json)
    {
        if (is_string($json)) {
            return $json;
        }

        if (isset($json['Version2'])) {
            $transferV2 = TransferV2Serializer::fromJson($json['Version2']);
            return new Transfer(
                $transferV2->getTransactionHash(), $transferV2->getFrom(), $transferV2->getTo(), $transferV2->getSource(),
                $transferV2->getTarget(), $transferV2->getAmount(), $transferV2->getGas(), $transferV2->getId(), null, $transferV2
            );
        }
        else if (isset($json['Version1'])) {
            $json = $json['Version1'];
            $transferV1 = new TransferV1(
                $json['deploy_hash'],
                CLAccountHash::fromString($json['from']),
                isset($json['to']) ? CLAccountHash::fromString($json['to']) : null,
                CLURef::fromString($json['source']),
                CLURef::fromString($json['target']),
                gmp_init($json['amount']),
                gmp_init($json['gas']),
                $json['id']
            );

            return new Transfer(
                new TransactionHash($transferV1->getDeployHash(), null),
                new InitiatorAddr(null, $transferV1->getFrom()),
                $transferV1->getTo(),
                $transferV1->getSource(),
                $transferV1->getTarget(),
                $transferV1->getAmount(),
                $transferV1->getGas(),
                $transferV1->getId(),
                $transferV1,
                null
            );
        }

        throw new \Exception('Unknown Transfer type');
    }
}
