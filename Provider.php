<?php

namespace SocialiteProviders\Newestapps;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    public const IDENTIFIER = 'NEWESTAPPS';

    const ISSUER = 'https://oauth.newestapps.com.br';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [
//        'identify',
//        'email',
    ];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            env( 'NEWESTAPPS_OPENID_ISSUER', self::ISSUER) . '/oauth/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return env( 'NEWESTAPPS_OPENID_ISSUER', self::ISSUER) . '/oauth/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            env( 'NEWESTAPPS_OPENID_ISSUER', self::ISSUER) . '/api/v1/user',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param array $user
     *
     * @return string|null
     *
     * @see https://discord.com/developers/docs/reference#image-formatting-cdn-endpoints
     */
    protected function formatAvatar(array $user)
    {
        if (empty($user['avatar'])) {
            return null;
        }

        $isGif = preg_match('/a_.+/m', $user['avatar']) === 1;
        $extension = $this->getConfig('allow_gif_avatars', true) && $isGif ? 'gif' :
            $this->getConfig('avatar_default_extension', 'jpg');

        return sprintf('https://cdn.discordapp.com/avatars/%s/%s.%s', $user['id'], $user['avatar'], $extension);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        $user = $user['data'];

        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
//            'nickname' => sprintf('%s#%s', $user['username'], $user['discriminator']),
            'name'     => $user['name'],
            'email'    => $user['email'] ?? null,
//            'avatar'   => $this->formatAvatar($user),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

    public static function additionalConfigKeys()
    {
//        return ['allow_gif_avatars', 'avatar_default_extension'];
        return [];
    }
}
