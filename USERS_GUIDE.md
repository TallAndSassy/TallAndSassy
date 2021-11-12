## Q: How to see anything?
A: Visit localhost:8000

You'll see the 'Tenants' page. It helps you find existing sites.

Q: Hey, I like 127.0.0.1 better - can I do that?

A: Well, no. 

## Q: How do I log in the very first time?
A: Try visiting hq.localhost:8000

(or, whetever the HQ subdomain was set in the .env file)

## Q: How can I see all clients?
A: Visit http://localhost:8000/tenants_directory

##Q: How access the `hq` domain?
A: go to http://hq.localhost:8000 (or your appropriate url and TASSY_TENANCY_HQSUBDOMAIN)
Your email will be whatever you specified in `.env` `TASSY_TENANCY_ADMINEMAIL`. The password is 
literally `password` in development, but you must do a `forgot password` reset on prod.

##Q: How can I log in as an admin for a tenant?
A: For the demos, a default admin account is created for each tenant.
    So, if you supplied a demo email of `bob@gmail.com`, and there is a demo tenant called
    `Middleburg ES` with a slug of `middleburg`. Then the email to log into this tenant would be 
    `bob+middleburg@gmail.com`.  gMail allows for this `+` style of aliasing.

The default password (for demos) is `password`. Literally. 

For example, to log into the 
subsite `http://johathanbury.localhost:8000/login` when your admin email is `bob@gmail.com`
you would enter `bob+johathanbury@gmail.com` and `password` as your password.

##Q: How can I add pages?
A: 