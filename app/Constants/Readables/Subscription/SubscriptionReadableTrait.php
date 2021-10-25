<?php

namespace App\Constants\Readables\Subscription;

trait SubscriptionReadableTrait {

    /**
     * readableCreatedAt
     *
     * @return void
     */
    public function readableCreatedAt()
    {
        $cookiedTimezone = request()->cookie( config( 'app.timezone_index' ) );

        return $this->created_at->setTimezone( $cookiedTimezone ? $cookiedTimezone : config( 'app.timezone' ) )->isoFormat("D MMM OY, hh:mm A");
    }
}
