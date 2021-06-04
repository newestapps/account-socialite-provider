<?php

namespace SocialiteProviders\Newestapps;

use SocialiteProviders\Manager\SocialiteWasCalled;

class NewestappsExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('newestapps', Provider::class);
    }
}
