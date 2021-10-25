<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Subscribers</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>UserName</th>
                        <th>Plan</th>
                        <th>Price</th>
                        <th>Profit</th>
                        <th>Subscription Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $subscribers as $subscriber )
                        <tr>
                            <td>{{ $subscriber->fullname }}</td>
                            <td>{{ $subscriber->username }}</td>
                            <td>{{ SelarDevTestCore::readablePlan( $subscriber->plan_id ) }}</td>
                            <td id="{{ $identifier }}Subsciber{{ $subscriber->id }}Price">Loading...</td>
                            <td id="{{ $identifier }}Subsciber{{ $subscriber->id }}Profit">
                                loading...
                            </td>
                            <td>{{ $subscriber->activeSubscription->readableCreatedAt() }}</td>
                        </tr>
                        <script>
                            var  subsciberPrice = document.getElementById( "{{ $identifier }}Subsciber{{ $subscriber->id }}Price" );
                            subsciberPrice.textContent = currencyFormatter( '{{ $subscriber->activeSubscription->amount }}', '{{ $subscriber->activeSubscription->currency }}' );

                            var  selarProfitOnSubsciber = document.getElementById( "{{ $identifier }}Subsciber{{ $subscriber->id }}Profit" );
                            selarProfitOnSubsciber.textContent = currencyFormatter( '{{ $subscriber->selar_profit }}', '{{ $subscriber->activeSubscription->currency }}' );
                        </script> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>