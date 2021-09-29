#bash!
# Now, let's get TallAndSassy working so we can see what a minimum installation looks like.
# Goal: Be able to run this multiple times, within the same Laravel installation.

## Init Tall & Sassy

# Add HQ (we need an HQ subdomain)

# delete if already there
sed -i".orig" '/HQ_SUBDOMAIN=.*$/d' .env
# set new HQ
sed -i".orig"  '1s/^/HQ_SUBDOMAIN=hq\n/' .env


# [ ] append to app/Http/Kernel.php' #WIP - was trying to get to autoregister
sed -i'.orig'  'a\/routeMiddleware/routeMiddlewareJJ/' app/Http/Kernel.php
echo "'tenancy' => Middleware\SubdomainTenancy::class " | sed -i'.orig'  's/inng/&^.*routeMiddleware/a\' app/Http/Kernel.php
#    protected $routeMiddleware = [...
#        'tenancy' => Middleware\SubdomainTenancy::class // <-- ADDs THIS
#
## Include TallAndSassy (dev)
#    # https://stackoverflow.com/a/19917033/93933
#    composer require tallandsassy/tallandsassy:dev-main

