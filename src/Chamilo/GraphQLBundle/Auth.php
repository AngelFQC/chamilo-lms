<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle;

use Chamilo\UserBundle\Entity\User;
use Firebase\JWT\JWT;

/**
 * Class Auth
 *
 * @package Chamilo\GraphQLBundle
 */
class Auth
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return string
     * @throws \Exception
     */
    public static function validateUser($username, $password)
    {
        $secret = api_get_configuration_value('security_key');

        /** @var User $user */
        $user = \UserManager::getManager()->findUserByUsername($username);

        if (!$user) {
            throw new \Exception(get_lang('NoUser'));
        }

        $isValid = \UserManager::isPasswordValid(
            $user->getPassword(),
            $password,
            $user->getSalt()
        );

        if (!$isValid) {
            throw new \Exception(get_lang('InvalidId'));
        }

        $token = self::getToken($user->getId(), $secret);

        return $token;
    }

    /**
     * Generate a JSON Web Token
     *
     * @param string $userId
     *
     * @return string
     */
    public static function getToken($userId)
    {
        $secret = api_get_configuration_value('security_key');
        $time = time();

        $payload = [
            'iat' => $time,
            'exp' => $time + (60 * 60 * 24),
            'data' => [
                'user' => $userId,
            ],
        ];

        $token = JWT::encode($payload, $secret, 'HS384');

        return $token;
    }

    /**
     * @param string $token
     *
     * @return array
     * @throws \Exception
     */
    public static function getTokenData($token)
    {
        $secret = api_get_configuration_value('security_key');

        try {
            $jwt = JWT::decode($token, $secret, ['HS384']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $data = (array) $jwt->data;

        return $data;
    }
}
