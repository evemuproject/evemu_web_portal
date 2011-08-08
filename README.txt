Before using the admin.php install script you should create a database.
Then you need to import the file sql/eveportal.sql to your server
and change the config.php according to your portal's database name,
host, user and password.

Also the gameserver database is required. You should also
change the config.php according to your server's database name,
host, user and password.

If you already have an evemu database and you have an admin user
you should not execute install script, as it only creates and admin account.