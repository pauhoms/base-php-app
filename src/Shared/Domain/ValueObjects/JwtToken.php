<?php
declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

use Firebase\JWT\JWT;
use InvalidArgumentException;
use UnexpectedValueException;
use Firebase\JWT\ExpiredException;
use Shared\Domain\Exceptions\InvalidToken;
use Firebase\JWT\SignatureInvalidException;

final class JwtToken extends StringValueObject
{
    private static string $secret_key = '67Zin<LVL2_fZft43OAcB}h-`DSwMWroHFSJj{HhCxWF<X]Qk4/Nrgz}EYURyEy';

    public function __construct(?string $value)
    {
        parent::__construct($value);
    }

    public static function create(array $data): self
    {
        $currentTime = time();
        $expireTime = $currentTime + (60 * 60);

        $token = [
            'current-time'  => $currentTime,
            'expire-time'  => $expireTime,
            'data' => $data
        ];

        return new JwtToken(JWT::encode($token, self::$secret_key));
    }

    public function decode(string $token): array
    {
        try {
            return json_decode(json_encode(
                JWT::decode($token, self::$secret_key, array('HS256'))
            ), true);
        } catch (
            SignatureInvalidException |
            InvalidArgumentException |
            UnexpectedValueException |
            ExpiredException $e
        ) {
            throw new InvalidToken($token);
        }
    }
}
